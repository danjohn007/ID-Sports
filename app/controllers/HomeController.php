<?php
class HomeController extends Controller {
    public function index() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $reservationModel = new ReservationModel();
        $promotionModel = new PromotionModel();

        $activeReservations = $reservationModel->findByUser($userId, 'active');
        $promotions = $promotionModel->getActive();

        $this->view('home/index', [
            'title' => 'Inicio',
            'activeReservations' => $activeReservations,
            'promotions' => $promotions,
        ]);
    }

    public function welcome() {
        $this->requireAuth();
        // Only for users with role 'user'; others go straight to home
        if (($_SESSION['user_role'] ?? '') !== 'user') {
            $this->redirect('home');
        }
        // Render the welcome/intro screen (standalone layout, no sidebar)
        View::render('home/welcome', ['title' => 'Bienvenido'], false);
    }

    public function notFound() {
        http_response_code(404);
        $this->view('home/index', ['title' => 'Página no encontrada', 'activeReservations' => [], 'promotions' => []]);
    }
}
