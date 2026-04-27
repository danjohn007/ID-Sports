<?php
class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            $this->redirectByRole($_SESSION['user_role']);
        }

        $error = '';
        if ($this->isPost()) {
            $email = $this->post('email');
            $password = $this->post('password');

            if (empty($email) || empty($password)) {
                $error = 'Por favor completa todos los campos.';
            } else {
                $user = $this->userModel->findByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    if ($user['status'] !== 'active') {
                        $error = 'Tu cuenta está suspendida o inactiva.';
                    } else {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_name'] = $user['name'];
                        $_SESSION['user_email'] = $user['email'];
                        $_SESSION['user_role'] = $user['role'];
                        $_SESSION['user_avatar'] = $user['avatar'];
                        $_SESSION['dark_mode'] = $user['dark_mode'];
                        $this->setFlash('success', '¡Bienvenido, ' . $user['name'] . '!');
                        $this->redirectByRole($user['role']);
                    }
                } else {
                    $error = 'Credenciales inválidas. Verifica tu email y contraseña.';
                }
            }
        }

        $this->view('auth/login', ['error' => $error, 'title' => 'Iniciar Sesión'], 'auth');
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home');
        }

        $error = '';
        if ($this->isPost()) {
            $name = $this->post('name');
            $email = $this->post('email');
            $password = $this->post('password');
            $password_confirm = $this->post('password_confirm');
            $whatsapp = $this->post('whatsapp');

            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Por favor completa todos los campos requeridos.';
            } elseif ($password !== $password_confirm) {
                $error = 'Las contraseñas no coinciden.';
            } elseif (strlen($password) < 6) {
                $error = 'La contraseña debe tener al menos 6 caracteres.';
            } elseif ($this->userModel->findByEmail($email)) {
                $error = 'Este email ya está registrado.';
            } else {
                $this->userModel->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'whatsapp' => $whatsapp,
                ]);
                $this->setFlash('success', 'Cuenta creada exitosamente. ¡Inicia sesión!');
                $this->redirect('auth/login');
            }
        }

        $this->view('auth/register', ['error' => $error, 'title' => 'Crear Cuenta'], 'auth');
    }

    public function forgot() {
        $error = '';
        $success = '';
        if ($this->isPost()) {
            $email = $this->post('email');
            $user = $this->userModel->findByEmail($email);
            if (!$user) {
                $error = 'No encontramos una cuenta con ese email.';
            } else {
                $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $this->userModel->createOtp($user['id'], $email, $code);
                $_SESSION['otp_email'] = $email;
                // In production, send $code via email/WhatsApp here
                $success = 'Código OTP enviado. Revisa tu correo o WhatsApp para continuar.';
            }
        }
        $this->view('auth/forgot', ['error' => $error, 'success' => $success, 'title' => 'Recuperar Contraseña'], 'auth');
    }

    public function reset() {
        $error = '';
        if ($this->isPost()) {
            $email = $_SESSION['otp_email'] ?? $this->post('email');
            $code = $this->post('code');
            $password = $this->post('password');
            $password_confirm = $this->post('password_confirm');

            if ($password !== $password_confirm) {
                $error = 'Las contraseñas no coinciden.';
            } else {
                $otp = $this->userModel->verifyOtp($email, $code);
                if (!$otp) {
                    $error = 'Código inválido o expirado.';
                } else {
                    $this->userModel->update($otp['user_id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
                    $this->userModel->markOtpUsed($otp['id']);
                    unset($_SESSION['otp_email']);
                    $this->setFlash('success', 'Contraseña actualizada. ¡Inicia sesión!');
                    $this->redirect('auth/login');
                }
            }
        }
        $email = $_SESSION['otp_email'] ?? '';
        $this->view('auth/reset', ['error' => $error, 'email' => $email, 'title' => 'Restablecer Contraseña'], 'auth');
    }

    public function logout() {
        session_destroy();
        session_name(SESSION_NAME);
        session_start();
        $this->setFlash('success', 'Has cerrado sesión correctamente.');
        $this->redirect('auth/login');
    }

    private function redirectByRole($role) {
        switch ($role) {
            case 'super_admin': $this->redirect('superadmin/dashboard'); break;
            case 'club_admin': $this->redirect('admin/dashboard'); break;
            default: $this->redirect('home'); break;
        }
    }
}
