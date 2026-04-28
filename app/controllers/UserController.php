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

    /* ── Avatar upload ──────────────────────────────────────── */
    public function uploadAvatar() {
        $this->requireAuth();

        if (!$this->isPost()) {
            $this->redirect('user/profile');
            return;
        }

        if (empty($_FILES['avatar_file']['name']) || $_FILES['avatar_file']['error'] !== UPLOAD_ERR_OK) {
            $this->setFlash('error', 'No se seleccionó archivo o hubo un error de subida.');
            $this->redirect('user/profile');
            return;
        }

        $file = $_FILES['avatar_file'];

        // Validate MIME via finfo
        if (!class_exists('finfo')) {
            $this->setFlash('error', 'La extensión PHP "fileinfo" es requerida. Contacta al administrador.');
            $this->redirect('user/profile');
            return;
        }

        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        $allowed  = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

        if (!array_key_exists($mimeType, $allowed)) {
            $this->setFlash('error', 'Solo se permiten imágenes JPG, PNG o WEBP.');
            $this->redirect('user/profile');
            return;
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            $this->setFlash('error', 'La imagen supera el límite de 2 MB.');
            $this->redirect('user/profile');
            return;
        }

        $userId  = $_SESSION['user_id'];
        $ext     = $allowed[$mimeType];
        $filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
        $destDir  = ROOT . '/public/assets/avatars/';
        $destPath = $destDir . $filename;

        if (!is_dir($destDir) || !is_writable($destDir)) {
            $this->setFlash('error', 'El directorio de avatares no es escribible. Contacta al administrador.');
            $this->redirect('user/profile');
            return;
        }

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            // Remove previous avatar file if it was stored in our avatars directory
            $prev = $this->userModel->findById($userId)['avatar'] ?? '';
            $avatarDir = 'public/assets/avatars/';
            if ($prev && strpos($prev, $avatarDir) === 0) {
                $prevPath = ROOT . '/' . $prev;
                if (file_exists($prevPath)) { @unlink($prevPath); }
            }
            $this->userModel->update($userId, ['avatar' => 'public/assets/avatars/' . $filename]);
            $this->setFlash('success', '✅ Foto de perfil actualizada correctamente.');
        } else {
            $this->setFlash('error', 'No se pudo guardar la imagen. Verifica los permisos del servidor.');
        }

        $this->redirect('user/profile');
    }
}
