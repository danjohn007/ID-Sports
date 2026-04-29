<?php
class ReservationController extends Controller {
    private $reservationModel;
    private $spaceModel;
    private $amenityModel;
    private $promotionModel;

    public function __construct() {
        $this->reservationModel = new ReservationModel();
        $this->spaceModel = new SpaceModel();
        $this->amenityModel = new AmenityModel();
        $this->promotionModel = new PromotionModel();
    }

    public function search() {
        $this->requireAuth();
        $query     = $this->get('q');
        $sportType = $this->get('sport');
        $date      = $this->get('date');

        // Only run filtered search if params given, otherwise pass empty array (view shows all)
        if ($query || $sportType || $date) {
            $spaces = $this->spaceModel->search($query, $sportType);
        } else {
            $spaces = [];
        }

        $this->view('reservations/search', [
            'title'     => 'Buscar Canchas',
            'spaces'    => $spaces,
            'query'     => $query,
            'sportType' => $sportType,
            'date'      => $date,
        ]);
    }

    public function create($spaceId = null) {
        $this->requireAuth();
        if (!$spaceId) {
            $spaceId = $this->get('id');
        }
        $space = $this->spaceModel->findById($spaceId);
        if (!$space) {
            $this->setFlash('error', 'Espacio no encontrado.');
            $this->redirect('reservations/search');
        }
        $amenities  = $this->amenityModel->findBySpace($spaceId);
        $schedules  = $this->spaceModel->getSchedules($spaceId);
        $closedDays = $this->spaceModel->getClosedDays($spaceId);
        $preDate    = $this->get('date', date('Y-m-d'));

        $this->view('reservations/create', [
            'title'      => 'Nueva Reservación',
            'space'      => $space,
            'amenities'  => $amenities,
            'schedules'  => $schedules,
            'closedDays' => $closedDays,
            'preDate'    => $preDate,
        ]);
    }

    /** AJAX: returns available 30-min slots for a space+date */
    public function slots() {
        $this->requireAuth();
        $spaceId = $this->get('space_id');
        $date    = $this->get('date', date('Y-m-d'));
        header('Content-Type: application/json');
        if (!$spaceId) { echo json_encode([]); exit; }
        $slots = $this->spaceModel->getAvailableSlots($spaceId, $date);
        echo json_encode($slots);
        exit;
    }

    /** AJAX: returns closed day-of-week integers for a space */
    public function availableDates() {
        $this->requireAuth();
        $spaceId = $this->get('space_id');
        header('Content-Type: application/json');
        if (!$spaceId) { echo json_encode(['closed_days' => []]); exit; }
        $closedDays = $this->spaceModel->getClosedDays($spaceId);
        echo json_encode(['closed_days' => $closedDays]);
        exit;
    }

    /** AJAX: simulate payment and create reservation */
    public function pay() {
        $this->requireAuth();
        header('Content-Type: application/json');
        $userId = $_SESSION['user_id'];

        if (!$this->isPost()) {
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            exit;
        }

        $spaceId    = (int)$this->post('space_id');
        $date       = $this->post('date');
        $startTime  = $this->post('start_time');
        $endTime    = $this->post('end_time');
        $coupon     = $this->post('coupon', '');
        $amenitiesRaw = $_POST['amenities'] ?? '[]';
        $selectedAmenities = is_array($amenitiesRaw)
            ? $amenitiesRaw
            : (json_decode($amenitiesRaw, true) ?: []);
        if (!is_array($selectedAmenities)) $selectedAmenities = [];

        // Basic validation
        if (!$spaceId || !$date || !$startTime || !$endTime) {
            http_response_code(422);
            echo json_encode(['error' => 'Datos incompletos.']);
            exit;
        }

        $space = $this->spaceModel->findById($spaceId);
        if (!$space) {
            http_response_code(404);
            echo json_encode(['error' => 'Espacio no encontrado.']);
            exit;
        }

        // Calculate costs
        $startTs   = strtotime("2000-01-01 $startTime");
        $endTs     = strtotime("2000-01-01 $endTime");
        $hours     = max(0.5, ($endTs - $startTs) / 3600);
        $subtotal  = round($space['price_per_hour'] * $hours, 2);
        $serviceFee = round($subtotal * 0.05, 2);

        $amenitiesTotal = 0;
        $amenityRows    = [];
        foreach ($selectedAmenities as $a) {
            $aid = (int)($a['id'] ?? 0);
            $qty = max(1, (int)($a['qty'] ?? 1));
            if (!$aid) continue;
            $amenity = $this->amenityModel->findById($aid);
            if (!$amenity) continue;
            // Validate stock
            if ($amenity['stock'] < $qty) {
                http_response_code(422);
                echo json_encode(['error' => 'Stock insuficiente para: ' . $amenity['name']]);
                exit;
            }
            $linePrice = round($amenity['price'] * $qty, 2);
            $amenitiesTotal += $linePrice;
            $amenityRows[] = ['id' => $aid, 'qty' => $qty, 'price' => $linePrice];
        }

        $discount = 0;
        if ($coupon) {
            $promo = $this->promotionModel->verifyCoupon($coupon);
            if ($promo) $discount = round($subtotal * $promo['discount_percent'] / 100, 2);
        }

        $total = $subtotal + $serviceFee + $amenitiesTotal - $discount;

        // Create reservation
        $reservationId = $this->reservationModel->create([
            'user_id'         => $userId,
            'space_id'        => $spaceId,
            'date'            => $date,
            'start_time'      => $startTime,
            'end_time'        => $endTime,
            'subtotal'        => $subtotal,
            'service_fee'     => $serviceFee,
            'amenities_total' => $amenitiesTotal,
            'discount'        => $discount,
            'total'           => $total,
            'status'          => 'confirmed',
            'payment_ref'     => 'SIM-' . strtoupper(bin2hex(random_bytes(4))),
        ]);

        // Save amenities and decrement stock
        if (!empty($amenityRows)) {
            $this->reservationModel->saveAmenities($reservationId, $amenityRows);
            foreach ($amenityRows as $ar) {
                $this->amenityModel->decrementStock($ar['id'], $ar['qty']);
            }
        }

        // Generate QR token
        $token   = bin2hex(random_bytes(16));
        $qrCode  = 'IDSPORTS-RES-' . $reservationId . '-' . strtoupper($token);
        $this->reservationModel->updateQrCode($reservationId, $qrCode);

        // Notification
        try {
            $notifModel = new NotificationModel();
            $notifModel->create(
                $userId,
                '¡Reservación confirmada!',
                'Tu cancha ' . $space['name'] . ' está lista para el ' . date('d/m/Y', strtotime($date)) . ' a las ' . substr($startTime, 0, 5) . '.',
                'reservation',
                $reservationId
            );
        } catch (Exception $e) {}

        $reservation = $this->reservationModel->findById($reservationId);
        $reservedAmenities = $this->reservationModel->getAmenities($reservationId);

        echo json_encode([
            'success'    => true,
            'reservation' => $reservation,
            'amenities'  => $reservedAmenities,
            'qr_code'    => $qrCode,
        ]);
        exit;
    }

    /** Admin endpoint: scan QR → set status to in_progress */
    public function scanQr() {
        $this->requireAuth(['club_admin', 'super_admin']);
        header('Content-Type: application/json');

        $earlyWindowSec = 900; // 15-minute early check-in window

        $qrCode = $this->isPost() ? $this->post('qr_code') : $this->get('qr_code');
        if (!$qrCode) {
            echo json_encode(['error' => 'QR code requerido.']);
            exit;
        }

        $reservation = $this->reservationModel->findByQrCode($qrCode);
        if (!$reservation) {
            http_response_code(404);
            echo json_encode(['error' => 'Reservación no encontrada.']);
            exit;
        }

        if ($reservation['status'] === 'confirmed') {
            // Validate that current time is within the reservation window
            $now        = time();
            $resDate    = $reservation['date'];
            $windowStart = strtotime($resDate . ' ' . $reservation['start_time']) - $earlyWindowSec;
            $windowEnd   = strtotime($resDate . ' ' . $reservation['end_time']);

            if ($now < $windowStart) {
                $minutesLeft = (int)ceil(($windowStart - $now) / 60);
                http_response_code(409);
                echo json_encode(['error' => "La reservación aún no está activa. Inicia en aprox. {$minutesLeft} min."]);
                exit;
            }
            if ($now >= $windowEnd) {
                http_response_code(409);
                echo json_encode(['error' => 'El tiempo de la reservación ya expiró.']);
                exit;
            }

            $this->reservationModel->checkIn($reservation['id']);
            $reservation['status'] = 'in_progress';
            echo json_encode(['success' => true, 'reservation' => $reservation, 'message' => 'Check-in exitoso. Sesión iniciada.']);
        } elseif ($reservation['status'] === 'in_progress') {
            echo json_encode(['success' => true, 'reservation' => $reservation, 'message' => 'Sesión ya en progreso.']);
        } else {
            http_response_code(409);
            echo json_encode(['error' => 'La reservación no puede hacer check-in en estado: ' . $reservation['status']]);
        }
        exit;
    }

    /** Admin: mark reservation as completed, restoring amenity stock */
    public function complete() {
        $this->requireAuth(['club_admin', 'super_admin']);
        header('Content-Type: application/json');

        $id = (int)($this->isPost() ? $this->post('id') : $this->get('id'));
        if (!$id) {
            http_response_code(422);
            echo json_encode(['error' => 'ID de reservación requerido.']);
            exit;
        }

        $reservation = $this->reservationModel->findById($id);
        if (!$reservation) {
            http_response_code(404);
            echo json_encode(['error' => 'Reservación no encontrada.']);
            exit;
        }

        if (!in_array($reservation['status'], ['confirmed', 'in_progress'])) {
            http_response_code(409);
            echo json_encode(['error' => 'Solo se pueden completar reservaciones confirmadas o en progreso.']);
            exit;
        }

        $this->reservationModel->complete($id);
        echo json_encode(['success' => true, 'message' => 'Reservación completada y stock de amenidades restaurado.']);
        exit;
    }

    /** User cancel reservation */
    public function cancel() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $id     = (int)($this->isPost() ? $this->post('id') : $this->get('id'));
        if ($id) {
            $res = $this->reservationModel->findById($id);
            if ($res && $res['user_id'] == $userId && in_array($res['status'], ['pending','confirmed'])) {
                $this->reservationModel->updateStatus($id, 'cancelled');
                // Restore amenity stock
                $this->reservationModel->restoreAmenityStock($id);
                $this->setFlash('success', 'Reservación cancelada.');
            } else {
                $this->setFlash('error', 'No se puede cancelar esta reservación.');
            }
        }
        $this->redirect('reservations/history');
    }

    /** Ticket view for a confirmed/in_progress reservation */
    public function confirm() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $id     = (int)$this->get('id');
        if (!$id) { $this->redirect('reservations/history'); }
        $reservation = $this->reservationModel->findById($id);
        if (!$reservation || $reservation['user_id'] != $userId) {
            $this->setFlash('error', 'Reservación no encontrada.');
            $this->redirect('reservations/history');
        }
        $amenities = $this->reservationModel->getAmenities($id);
        $this->view('reservations/confirm', [
            'title'       => 'Ticket de Reserva',
            'reservation' => $reservation,
            'amenities'   => $amenities,
        ]);
    }

    public function history() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $reservations = $this->reservationModel->findByUser($userId);
        $monthlyStats = $this->reservationModel->getMonthlyStats($userId);
        $this->view('reservations/history', [
            'title'        => 'Mi Historial',
            'reservations' => $reservations,
            'monthlyStats' => $monthlyStats,
        ]);
    }
}
