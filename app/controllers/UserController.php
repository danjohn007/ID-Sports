<?php
class UserController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function profile() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];
        $error = '';
        $success = '';

        if ($this->isPost()) {
            $name = $this->post('name');
            $whatsapp = $this->post('whatsapp');
            $birth_date = $this->post('birth_date');
            $new_password = $this->post('new_password');
            $current_password = $this->post('current_password');

            $data = ['name' => $name, 'whatsapp' => $whatsapp, 'birth_date' => $birth_date ?: null];

            if (!empty($new_password)) {
                $user = $this->userModel->findById($userId);
                if (!password_verify($current_password, $user['password'])) {
                    $error = 'La contraseña actual es incorrecta.';
                } else {
                    $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                }
            }

            if (!$error) {
                $this->userModel->update($userId, $data);
                $_SESSION['user_name'] = $name;
                $success = 'Perfil actualizado correctamente.';
            }
        }

        $user = $this->userModel->findById($userId);
        $this->view('user/profile', ['title' => 'Mi Perfil', 'user' => $user, 'error' => $error, 'success' => $success]);
    }

    public function settings() {
        $this->requireAuth();
        $userId = $_SESSION['user_id'];

        if ($this->isPost()) {
            $dark_mode = isset($_POST['dark_mode']) ? 1 : 0;
            $this->userModel->update($userId, ['dark_mode' => $dark_mode]);
            $_SESSION['dark_mode'] = $dark_mode;
            $this->setFlash('success', 'Configuración guardada.');
            $this->redirect('user/settings');
        }

        $user = $this->userModel->findById($userId);
        $this->view('user/settings', ['title' => 'Configuración', 'user' => $user]);
    }
}
