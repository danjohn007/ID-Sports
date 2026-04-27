<?php
class AdminController extends Controller {
    private $clubModel;
    private $spaceModel;
    private $amenityModel;
    private $reservationModel;
    private $incidentModel;

    public function __construct() {
        $this->clubModel = new ClubModel();
        $this->spaceModel = new SpaceModel();
        $this->amenityModel = new AmenityModel();
        $this->reservationModel = new ReservationModel();
        $this->incidentModel = new IncidentModel();
    }

    private function getClub() {
        $this->requireAuth(['club_admin', 'super_admin']);
        $club = $this->clubModel->findByOwnerId($_SESSION['user_id']);
        if (!$club && $_SESSION['user_role'] !== 'super_admin') {
            $this->setFlash('error', 'No tienes un club asignado.');
            $this->redirect('home');
        }
        return $club;
    }

    public function dashboard() {
        $club = $this->getClub();
        $clubId = $club['id'];
        $todayReservations = $this->reservationModel->getTodayForClub($clubId);
        $revenue = $this->reservationModel->revenueByClub($clubId);
        $spaces = $this->spaceModel->findByClub($clubId);
        $incidents = $this->incidentModel->countByClub($clubId, 'open');

        $this->view('admin/dashboard', [
            'title' => 'Panel de Administración',
            'club' => $club,
            'todayReservations' => $todayReservations,
            'totalToday' => count($todayReservations),
            'revenue' => $revenue,
            'activeSpaces' => count($spaces),
            'openIncidents' => $incidents,
        ], 'admin');
    }

    public function spaces() {
        $club = $this->getClub();
        $clubId = $club['id'];

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'create') {
                $this->spaceModel->create([
                    'club_id' => $clubId,
                    'name' => $this->post('name'),
                    'sport_type' => $this->post('sport_type'),
                    'description' => $this->post('description'),
                    'capacity' => $this->post('capacity'),
                    'price_per_hour' => $this->post('price_per_hour'),
                ]);
                $this->setFlash('success', 'Espacio creado correctamente.');
            } elseif ($action === 'update') {
                $this->spaceModel->update($this->post('id'), [
                    'name' => $this->post('name'),
                    'sport_type' => $this->post('sport_type'),
                    'description' => $this->post('description'),
                    'capacity' => $this->post('capacity'),
                    'price_per_hour' => $this->post('price_per_hour'),
                ]);
                $this->setFlash('success', 'Espacio actualizado.');
            } elseif ($action === 'delete') {
                $this->spaceModel->delete($this->post('id'));
                $this->setFlash('success', 'Espacio eliminado.');
            }
            $this->redirect('admin/spaces');
        }

        $spaces = $this->spaceModel->findByClub($clubId);
        $this->view('admin/spaces', ['title' => 'Gestión de Espacios', 'club' => $club, 'spaces' => $spaces], 'admin');
    }

    public function schedules() {
        $club = $this->getClub();
        $clubId = $club['id'];
        $spaces = $this->spaceModel->findByClub($clubId);

        if ($this->isPost()) {
            $spaceId   = (int) $this->post('space_id');
            $dayOfWeek = (int) $this->post('day_of_week');
            $openTime  = $this->post('open_time');
            $closeTime = $this->post('close_time');

            // Validate the space actually belongs to this club
            $validSpace = false;
            foreach ($spaces as $sp) {
                if ((int)$sp['id'] === $spaceId) { $validSpace = true; break; }
            }

            if ($validSpace && $openTime && $closeTime && $openTime < $closeTime) {
                $this->spaceModel->upsertSchedule($spaceId, $dayOfWeek, $openTime, $closeTime);
                $this->setFlash('success', 'Horario guardado correctamente.');
            } else {
                $this->setFlash('error', 'Datos de horario inválidos.');
            }
            $this->redirect('admin/schedules');
        }

        $schedulesBySpace = [];
        foreach ($spaces as $space) {
            $schedulesBySpace[$space['id']] = $this->spaceModel->getSchedules($space['id']);
        }

        $this->view('admin/schedules', [
            'title' => 'Horarios',
            'club' => $club,
            'spaces' => $spaces,
            'schedulesBySpace' => $schedulesBySpace,
        ], 'admin');
    }

    public function amenities() {
        $club = $this->getClub();
        $clubId = $club['id'];

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'create') {
                $this->amenityModel->create([
                    'club_id' => $clubId,
                    'name' => $this->post('name'),
                    'description' => $this->post('description'),
                    'price' => $this->post('price'),
                    'stock' => $this->post('stock'),
                ]);
                $this->setFlash('success', 'Amenidad creada.');
            } elseif ($action === 'update') {
                $this->amenityModel->update($this->post('id'), [
                    'name' => $this->post('name'),
                    'description' => $this->post('description'),
                    'price' => $this->post('price'),
                    'stock' => $this->post('stock'),
                ]);
                $this->setFlash('success', 'Amenidad actualizada.');
            } elseif ($action === 'delete') {
                $this->amenityModel->delete($this->post('id'));
                $this->setFlash('success', 'Amenidad eliminada.');
            }
            $this->redirect('admin/amenities');
        }

        $amenities = $this->amenityModel->findByClub($clubId);
        $this->view('admin/amenities', ['title' => 'Amenidades', 'club' => $club, 'amenities' => $amenities], 'admin');
    }

    public function reservations() {
        $club = $this->getClub();
        $clubId = $club['id'];
        $date = $this->get('date', date('Y-m-d'));
        $status = $this->get('status');
        $page = max(1, (int)$this->get('page', 1));

        if ($this->isPost() && $this->post('action') === 'update_status') {
            $this->reservationModel->updateStatus($this->post('reservation_id'), $this->post('status'));
            $this->setFlash('success', 'Estado actualizado.');
            $this->redirect('admin/reservations');
        }

        $reservations = $this->reservationModel->findByClub($clubId, $date ?: null, $status ?: null, $page);
        $this->view('admin/reservations', [
            'title' => 'Reservaciones',
            'club' => $club,
            'reservations' => $reservations,
            'filterDate' => $date,
            'filterStatus' => $status,
        ], 'admin');
    }

    public function incidents() {
        $club = $this->getClub();
        $clubId = $club['id'];
        $status = $this->get('status');

        if ($this->isPost()) {
            $this->incidentModel->updateStatus($this->post('incident_id'), $this->post('status'));
            $this->setFlash('success', 'Incidente actualizado.');
            $this->redirect('admin/incidents');
        }

        $incidents = $this->incidentModel->findByClub($clubId, $status ?: null);
        $this->view('admin/incidents', [
            'title' => 'Incidentes',
            'club' => $club,
            'incidents' => $incidents,
            'filterStatus' => $status,
        ], 'admin');
    }
}
