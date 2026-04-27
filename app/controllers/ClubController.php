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

        if ($this->isPost() && isset($_POST['join_request'])) {
            $this->setFlash('success', 'Solicitud enviada. Te notificaremos cuando sea aprobada.');
            $this->redirect('clubs/detail/' . $clubId);
        }

        $this->view('clubs/detail', [
            'title' => $club['name'],
            'club' => $club,
            'spaces' => $spaces,
            'amenities' => $amenities,
        ]);
    }
}
