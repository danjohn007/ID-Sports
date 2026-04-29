<?php
class HomeController extends Controller {
    public function index() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $reservationModel = new ReservationModel();
        $promotionModel = new PromotionModel();
        $clubModel = new ClubModel();

        $activeReservations = $reservationModel->findByUser($userId, 'active');
        $promotions = $promotionModel->getActive();
        $allClubs      = $clubModel->getActiveClubs();
        $followedClubs = $allClubs;
        $nearbyClubs   = array_reverse($allClubs);

        // Spanish day/month name maps
        $dayNames   = ['Sun'=>'Dom','Mon'=>'Lun','Tue'=>'Mar','Wed'=>'Mié','Thu'=>'Jue','Fri'=>'Vie','Sat'=>'Sáb'];
        $monthNames = ['Jan'=>'Ene','Feb'=>'Feb','Mar'=>'Mar','Apr'=>'Abr','May'=>'May','Jun'=>'Jun',
                       'Jul'=>'Jul','Aug'=>'Ago','Sep'=>'Sep','Oct'=>'Oct','Nov'=>'Nov','Dec'=>'Dic'];

        // Build next 15 days
        $days = [];
        for ($i = 0; $i < 15; $i++) {
            $ts = strtotime("+$i days");
            $days[] = [
                'timestamp' => $ts,
                'date'      => date('Y-m-d', $ts),
                'day_num'   => date('d', $ts),
                'day_name'  => $dayNames[date('D', $ts)] ?? date('D', $ts),
                'month'     => $monthNames[date('M', $ts)] ?? date('M', $ts),
                'is_today'  => $i === 0,
            ];
        }

        // Sports list
        $sports = [
            ['icon' => '⚽', 'name' => 'Fútbol',      'sport' => 'football'],
            ['icon' => '🎾', 'name' => 'Pádel',       'sport' => 'padel'],
            ['icon' => '🎾', 'name' => 'Tenis',       'sport' => 'tennis'],
            ['icon' => '🏀', 'name' => 'Básquetbol',  'sport' => 'basketball'],
            ['icon' => '🏐', 'name' => 'Voleibol',    'sport' => 'volleyball'],
            ['icon' => '🏃', 'name' => 'Running',     'sport' => 'running'],
        ];

        $this->view('home/index', [
            'title'              => 'Inicio',
            'activeReservations' => $activeReservations,
            'promotions'         => $promotions,
            'followedClubs'      => $followedClubs,
            'nearbyClubs'        => $nearbyClubs,
            'days'               => $days,
            'sports'             => $sports,
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
        $this->view('home/index', [
            'title'              => 'Página no encontrada',
            'activeReservations' => [],
            'promotions'         => [],
            'followedClubs'      => [],
            'nearbyClubs'        => [],
            'days'               => [],
            'sports'             => [],
        ]);
    }
}
