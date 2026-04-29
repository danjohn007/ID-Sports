<?php
class ReviewController extends Controller {
    private $reviewModel;
    private $reservationModel;

    public function __construct() {
        $this->reviewModel     = new ReviewModel();
        $this->reservationModel = new ReservationModel();
    }

    public function create() {
        $this->requireAuth();
        header('Content-Type: application/json');

        $userId        = (int)$_SESSION['user_id'];
        $reservationId = (int)($_POST['reservation_id'] ?? 0);
        $spaceId       = (int)($_POST['space_id']       ?? 0);
        $rating        = (int)($_POST['rating']          ?? 0);
        $comment       = trim($_POST['comment']          ?? '');

        if (!$reservationId || !$spaceId || $rating < 1 || $rating > 5) {
            echo json_encode(['success' => false, 'error' => 'Datos inválidos.']);
            exit;
        }

        // Verify the reservation belongs to this user
        $reservation = $this->reservationModel->findById($reservationId);
        if (!$reservation || (int)$reservation['user_id'] !== $userId) {
            echo json_encode(['success' => false, 'error' => 'Reservación no encontrada.']);
            exit;
        }

        // Check if review already exists for this reservation
        $existing = $this->reviewModel->findByReservation($reservationId, $userId);
        if ($existing) {
            echo json_encode(['success' => false, 'error' => 'Ya enviaste una reseña para esta reservación.']);
            exit;
        }

        $this->reviewModel->create([
            'user_id'        => $userId,
            'reservation_id' => $reservationId,
            'space_id'       => $spaceId,
            'rating'         => $rating,
            'comment'        => $comment,
        ]);

        echo json_encode(['success' => true]);
        exit;
    }
}
