<?php
class ClubController extends Controller {
    private $clubModel;
    private $spaceModel;
    private $amenityModel;

    public function __construct() {
        $this->clubModel = new ClubModel();
        $this->spaceModel = new SpaceModel();
        $this->amenityModel = new AmenityModel();
    }

    public function index() {
        $this->requireAuth();
        $search = $this->get('q');
        $clubs = $this->clubModel->getActiveClubs($search);
        $this->view('clubs/index', ['title' => 'Clubes Deportivos', 'clubs' => $clubs, 'search' => $search]);
    }

    public function detail($clubId = null) {
        $this->requireAuth();
        if (!$clubId) $clubId = $this->get('id');
        $club = $this->clubModel->findById($clubId);
        if (!$club) {
            $this->setFlash('error', 'Club no encontrado.');
            $this->redirect('clubs');
        }
        $spaces = $this->spaceModel->findByClub($clubId);
        $amenities = $this->amenityModel->findByClub($clubId);
        $membershipModel = new ClubMembershipModel();
        $reviewModel = new ReviewModel();
        $isFollowing = $membershipModel->isMember($_SESSION['user_id'], $clubId);
        $reviews = $reviewModel->findByClub($clubId);

        $this->view('clubs/detail', [
            'title'       => $club['name'],
            'club'        => $club,
            'spaces'      => $spaces,
            'amenities'   => $amenities,
            'isFollowing' => $isFollowing,
            'reviews'     => $reviews,
        ]);
    }

    public function toggleFollow($clubId = null) {
        $this->requireAuth();
        if (!$clubId) $clubId = $this->get('id');
        header('Content-Type: application/json');
        $membershipModel = new ClubMembershipModel();
        $userId = $_SESSION['user_id'];
        if ($membershipModel->isMember($userId, $clubId)) {
            $membershipModel->leave($userId, $clubId);
            echo json_encode(['following' => false]);
        } else {
            $membershipModel->join($userId, $clubId);
            echo json_encode(['following' => true]);
        }
        exit;
    }
}
