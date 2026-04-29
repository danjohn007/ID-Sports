<?php
class SpaceController extends Controller {
    private $spaceModel;
    private $reviewModel;
    private $amenityModel;

    public function __construct() {
        $this->spaceModel  = new SpaceModel();
        $this->reviewModel = new ReviewModel();
        $this->amenityModel = new AmenityModel();
    }

    public function detail($spaceId = null) {
        $this->requireAuth();
        if (!$spaceId) {
            $spaceId = $this->get('id');
        }
        $space = $this->spaceModel->findById($spaceId);
        if (!$space) {
            $this->setFlash('error', 'Espacio no encontrado.');
            $this->redirect('reservations/search');
        }

        $schedules  = $this->spaceModel->getSchedules($spaceId);
        $amenities  = $this->amenityModel->findBySpace($spaceId);
        $reviews    = $this->reviewModel->findBySpace($spaceId);
        $avgRating  = count($reviews)
            ? round(array_sum(array_column($reviews, 'rating')) / count($reviews), 1)
            : 0;

        // Is the current user following the club?
        $isFollowing = false;
        if (!empty($space['club_id'])) {
            $membershipModel = new ClubMembershipModel();
            $isFollowing = $membershipModel->isMember($_SESSION['user_id'], $space['club_id']);
        }

        $this->view('spaces/detail', [
            'title'       => $space['name'],
            'space'       => $space,
            'schedules'   => $schedules,
            'amenities'   => $amenities,
            'reviews'     => $reviews,
            'avgRating'   => $avgRating,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function slots($spaceId = null) {
        $this->requireAuth();
        if (!$spaceId) $spaceId = $this->get('id');
        $date = $this->get('date', date('Y-m-d'));
        $slots = $this->spaceModel->getAvailableSlots($spaceId, $date);
        header('Content-Type: application/json');
        echo json_encode($slots);
        exit;
    }
}
