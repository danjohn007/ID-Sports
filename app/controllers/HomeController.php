<?php
class HomeController extends Controller {
    public function index() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        $reservationModel     = new ReservationModel();
        $promotionModel       = new PromotionModel();
        $spaceModel           = new SpaceModel();
        $clubModel            = new ClubModel();
        $notifModel           = new NotificationModel();
        $membershipModel      = new ClubMembershipModel();

        // Sport types from master list (RF2.4)
        $sportTypeMap = [];
        try {
            $sportTypeMap = (new SportTypeModel())->getMap();
        } catch (Exception $e) {
            // table may not exist yet (migration not run) — fall back gracefully
            $sportTypeMap = [];
        }

        // Today's reservations (RF2.2) — all of today's bookings for the ticket carousel
        $todayReservation  = $reservationModel->getTodayForUser($userId);   // legacy single (kept for compatibility)
        $todayReservations = $reservationModel->getTodayAllForUser($userId);

        // Active reservations (today + future, not cancelled/past)
        $activeReservations = $reservationModel->getActiveForUser($userId);

        // Last 3 reservations regardless of status (for recent history widget)
        $recentReservations = array_slice($reservationModel->findByUser($userId), 0, 3);

        // 15-day availability picker (RF2.3)
        $upcomingDays = [];
        for ($i = 0; $i < 15; $i++) {
            $ts   = strtotime("+$i days");
            $date = date('Y-m-d', $ts);
            $days_es = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
            $upcomingDays[] = [
                'date'      => $date,
                'label'     => $i === 0 ? 'Hoy' : $days_es[(int)date('w', $ts)],
                'day_num'   => date('j', $ts),
                'available' => $spaceModel->countAvailableByDate($date),
            ];
        }

        // Clubs followed by user (RF2.5 — "Clubes Seguidos")
        $followedClubs   = $membershipModel->getByUser($userId);
        $followedClubIds = array_column($followedClubs, 'club_id');
        $socialFeed      = [];

        // Nearby clubs (RF2.6) - lat/lng from session or defaults
        $lat = $_SESSION['user_lat'] ?? null;
        $lng = $_SESSION['user_lng'] ?? null;
        $nearbyClubs = $clubModel->getNearby($lat, $lng, 6);

        // Notifications count (RF2.1 bell)
        $unreadNotifications = $notifModel->countUnread($userId);

        $this->view('home/index', [
            'title'               => 'Inicio',
            'todayReservation'    => $todayReservation,
            'todayReservations'   => $todayReservations,
            'activeReservations'  => $activeReservations,
            'recentReservations'  => $recentReservations,
            'upcomingDays'        => $upcomingDays,
            'followedClubs'       => $followedClubs,
            'nearbyClubs'         => $nearbyClubs,
            'unreadNotifications' => $unreadNotifications,
            'sportTypeMap'        => $sportTypeMap,
        ]);
    }

    public function notifications() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $notifModel = new NotificationModel();

        if ($this->isPost() && $this->post('action') === 'mark_all_read') {
            $notifModel->markAllRead($userId);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }

        $notifications = $notifModel->getForUser($userId, 30);
        $notifModel->markAllRead($userId);

        header('Content-Type: application/json');
        echo json_encode(['notifications' => $notifications]);
        exit;
    }

    public function toggleDark() {
        $this->requireAuth();
        $userId  = $_SESSION['user_id'];
        $current = $_SESSION['dark_mode'] ?? 0;
        $new     = $current ? 0 : 1;
        try {
            (new UserModel())->update($userId, ['dark_mode' => $new]);
            $_SESSION['dark_mode'] = $new;
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['dark_mode' => $current, 'error' => 'Update failed']);
            exit;
        }
        header('Content-Type: application/json');
        echo json_encode(['dark_mode' => $new]);
        exit;
    }

    public function saveLocation() {
        $this->requireAuth();
        $lat = (float)($this->post('lat') ?? 0);
        $lng = (float)($this->post('lng') ?? 0);
        if ($lat && $lng) {
            $_SESSION['user_lat'] = $lat;
            $_SESSION['user_lng'] = $lng;
        }
        header('Content-Type: application/json');
        echo json_encode(['ok' => true]);
        exit;
    }

    public function availableDays() {
        $this->requireAuth();
        $sport = $this->get('sport', '');
        $spaceModel = new SpaceModel();
        $days = [];
        for ($i = 0; $i < 5; $i++) {
            $date = date('Y-m-d', strtotime("+$i days"));
            $days[] = [
                'date'      => $date,
                'available' => $spaceModel->countAvailableByDate($date, $sport),
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($days);
        exit;
    }

    public function welcome() {
        $this->requireAuth();
        if (($_SESSION['user_role'] ?? '') !== 'user') {
            $this->redirect('home');
        }
        View::render('home/welcome', ['title' => 'Bienvenido'], false);
    }

    public function notFound() {
        http_response_code(404);
        $this->view('home/index', [
            'title'               => 'Página no encontrada',
            'todayReservation'    => null,
            'activeReservations'  => [],
            'upcomingDays'        => [],
            'followedClubs'       => [],
            'nearbyClubs'         => [],
            'unreadNotifications' => 0,
            'sportTypeMap'        => [],
        ]);
    }
}
