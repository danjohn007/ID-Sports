<?php
class Controller {
    protected function view($viewPath, $data = [], $layout = 'main') {
        View::render($viewPath, $data, $layout);
    }

    protected function redirect($path) {
        header('Location: ' . BASE_URL . ltrim($path, '/'));
        exit;
    }

    protected function requireAuth($role = null) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Debes iniciar sesión para acceder.'];
            $this->redirect('auth/login');
        }
        if ($role !== null) {
            $userRole = $_SESSION['user_role'] ?? '';
            if (is_array($role)) {
                if (!in_array($userRole, $role)) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => 'No tienes permisos para acceder a esta sección.'];
                    $this->redirect('home');
                }
            } else {
                if ($userRole !== $role) {
                    $_SESSION['flash'] = ['type' => 'error', 'message' => 'No tienes permisos para acceder a esta sección.'];
                    $this->redirect('home');
                }
            }
        }
    }

    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function post($key, $default = '') {
        return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
    }

    protected function get($key, $default = '') {
        return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
    }

    protected function setFlash($type, $message) {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
