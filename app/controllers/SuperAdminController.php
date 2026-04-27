<?php
class SuperAdminController extends Controller {
    public function __construct() {
        $this->requireAuth('super_admin');
    }

    public function dashboard() {
        $clubModel = new ClubModel();
        $userModel = new UserModel();
        $reservationModel = new ReservationModel();

        $stats = $reservationModel->getSystemStats();
        $totalClubs = $clubModel->countByStatus();
        $totalUsers = $userModel->countUsers();

        $this->view('superadmin/dashboard', [
            'title' => 'Panel SuperAdmin',
            'totalClubs' => $totalClubs,
            'totalUsers' => $totalUsers,
            'stats' => $stats,
        ], 'admin');
    }

    public function clubs() {
        $clubModel = new ClubModel();

        if ($this->isPost()) {
            $action = $this->post('action');
            $clubId = $this->post('club_id');
            $statusMap = ['approve' => 'active', 'reject' => 'rejected', 'suspend' => 'suspended'];
            if (isset($statusMap[$action])) {
                $clubModel->update($clubId, ['status' => $statusMap[$action]]);
                $this->setFlash('success', 'Club actualizado.');
            }
            $this->redirect('superadmin/clubs');
        }

        $clubs = $clubModel->findAll('', [], 1, 100);
        $this->view('superadmin/clubs', ['title' => 'Gestión de Clubes', 'clubs' => $clubs], 'admin');
    }

    public function commissions() {
        $clubModel = new ClubModel();

        if ($this->isPost()) {
            $clubId = $this->post('club_id');
            $rate = $this->post('commission_rate');
            $clubModel->update($clubId, ['commission_pct' => $rate]);
            $this->setFlash('success', 'Comisión actualizada.');
            $this->redirect('superadmin/commissions');
        }

        $clubs = $clubModel->findAll('status = ?', ['active'], 1, 100);
        $this->view('superadmin/commissions', ['title' => 'Comisiones', 'clubs' => $clubs], 'admin');
    }

    public function promotions() {
        $promotionModel = new PromotionModel();

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'create') {
                $promotionModel->create([
                    'title' => $this->post('title'),
                    'description' => $this->post('description'),
                    'type' => $this->post('type'),
                    'discount_percent' => $this->post('discount_percent') ?: 0,
                    'coupon_code' => $this->post('coupon_code') ?: null,
                    'valid_from' => $this->post('valid_from') ?: null,
                    'valid_until' => $this->post('valid_until') ?: null,
                    'status' => 'active',
                ]);
                $this->setFlash('success', 'Promoción creada.');
            } elseif ($action === 'toggle') {
                $promo = $promotionModel->findById($this->post('id'));
                $newStatus = $promo['status'] === 'active' ? 'inactive' : 'active';
                $promotionModel->update($this->post('id'), ['status' => $newStatus]);
                $this->setFlash('success', 'Promoción actualizada.');
            } elseif ($action === 'delete') {
                $promotionModel->delete($this->post('id'));
                $this->setFlash('success', 'Promoción eliminada.');
            }
            $this->redirect('superadmin/promotions');
        }

        $promotions = $promotionModel->findAll();
        $this->view('superadmin/promotions', ['title' => 'Promociones y Noticias', 'promotions' => $promotions], 'admin');
    }

    public function leads() {
        $leadModel = new LeadModel();

        if ($this->isPost()) {
            $leadModel->updateStatus($this->post('lead_id'), $this->post('status'));
            $this->setFlash('success', 'Lead actualizado.');
            $this->redirect('superadmin/leads');
        }

        $leads = $leadModel->findAll();
        $this->view('superadmin/leads', ['title' => 'Leads', 'leads' => $leads], 'admin');
    }
}
