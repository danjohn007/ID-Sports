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
        $query = $this->get('q');
        $sportType = $this->get('sport');
        $spaces = $this->spaceModel->search($query, $sportType);
        $this->view('reservations/search', [
            'title' => 'Buscar Espacios',
            'spaces' => $spaces,
            'query' => $query,
            'sportType' => $sportType,
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
        $amenities = $this->amenityModel->findByClub($space['club_id'] ?? 0);
        $schedules = $this->spaceModel->getSchedules($spaceId);

        $this->view('reservations/create', [
            'title' => 'Nueva Reservación',
            'space' => $space,
            'amenities' => $amenities,
            'schedules' => $schedules,
        ]);
    }

    public function confirm() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        if ($this->isPost()) {
            $spaceId = $this->post('space_id');
            $date = $this->post('date');
            $start_time = $this->post('start_time');
            $end_time = $this->post('end_time');
            $num_people = (int)$this->post('num_people', 1);
            $coupon = $this->post('coupon');
            $amenityIds = $_POST['amenities'] ?? [];

            $space = $this->spaceModel->findById($spaceId);
            if (!$space) {
                $this->setFlash('error', 'Espacio no válido.');
                $this->redirect('reservations/search');
            }

            $startTs = strtotime($start_time);
            $endTs = strtotime($end_time);
            $hours = max(1, ($endTs - $startTs) / 3600);
            $subtotal = $space['price_per_hour'] * $hours;
            $serviceFee = round($subtotal * 0.05, 2);
            $amenitiesTotal = 0;

            if (!empty($amenityIds)) {
                foreach ($amenityIds as $aid) {
                    $amenity = $this->amenityModel->findById($aid);
                    if ($amenity) $amenitiesTotal += $amenity['price'];
                }
            }

            $discount = 0;
            if ($coupon) {
                $promo = $this->promotionModel->verifyCoupon($coupon);
                if ($promo) $discount = round($subtotal * $promo['discount_percent'] / 100, 2);
            }

            $total = $subtotal + $serviceFee + $amenitiesTotal - $discount;

            $reservationId = $this->reservationModel->create([
                'user_id' => $userId,
                'space_id' => $spaceId,
                'date' => $date,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'num_people' => $num_people,
                'subtotal' => $subtotal,
                'service_fee' => $serviceFee,
                'amenities_total' => $amenitiesTotal,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $this->post('payment_method', 'pending'),
                'payment_status' => 'paid',
            ]);

            $reservation = $this->reservationModel->findById($reservationId);
            $this->view('reservations/confirm', [
                'title' => 'Reservación Confirmada',
                'reservation' => $reservation,
            ]);
        } else {
            $this->redirect('reservations/search');
        }
    }

    public function history() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $reservations = $this->reservationModel->findByUser($userId);
        $monthlyStats = $this->reservationModel->getMonthlyStats($userId);
        $this->view('reservations/history', [
            'title' => 'Mi Historial',
            'reservations' => $reservations,
            'monthlyStats' => $monthlyStats,
        ]);
    }
}
