<?php
class ConfigController extends Controller {
    private $configModel;

    // Allowed config keys per section (prevents arbitrary key injection)
    private static $allowedKeys = [
        'general'    => ['app_name', 'app_tagline', 'app_description', 'timezone', 'currency', 'currency_symbol', 'contact_email', 'contact_phone', 'contact_address', 'maintenance_mode'],
        'email'      => ['smtp_host', 'smtp_port', 'smtp_user', 'smtp_pass', 'smtp_from_name', 'smtp_from_email', 'smtp_encryption'],
        'colors'     => ['color_primary', 'color_secondary', 'color_accent', 'color_primary_hex', 'color_secondary_hex', 'color_accent_hex', 'color_login_button', 'color_login_button_hex', 'color_login_link', 'color_login_link_hex', 'color_login_logo_bg', 'color_login_logo_bg_hex', 'auth_bg_image'],
        'onboarding' => ['onboarding_slide1_title', 'onboarding_slide1_desc', 'onboarding_slide1_image', 'onboarding_slide2_title', 'onboarding_slide2_desc', 'onboarding_slide2_image', 'onboarding_slide3_title', 'onboarding_slide3_desc', 'onboarding_slide3_image'],
        'paypal'     => ['paypal_client_id', 'paypal_client_secret', 'paypal_mode'],
        'qr'         => ['qr_enabled', 'qr_expiry_minutes', 'qr_secret'],
        'chatbot'    => ['chatbot_enabled', 'chatbot_provider', 'chatbot_api_key', 'chatbot_welcome', 'chatbot_system_prompt'],
    ];

    public function __construct() {
        $this->requireAuth('super_admin');
        $this->configModel = new ConfigModel();
    }

    private function saveSection($section) {
        $allowed = self::$allowedKeys[$section] ?? [];
        foreach ($allowed as $key) {
            if (isset($_POST[$key])) {
                $this->configModel->set($key, $_POST[$key]);
            }
        }
    }

    public function index() {
        $this->view('config/index', ['title' => 'Configuración del Sistema'], 'admin');
    }

    public function general() {
        if ($this->isPost()) {
            $this->saveSection('general');
            $this->setFlash('success', 'Configuración general guardada.');
            $this->redirect('config/general');
        }
        $config = $this->configModel->getAll();
        $this->view('config/general', ['title' => 'Configuración General', 'config' => $config], 'admin');
    }

    public function email() {
        if ($this->isPost()) {
            $this->saveSection('email');
            $this->setFlash('success', 'Configuración de email guardada.');
            $this->redirect('config/email');
        }
        $config = $this->configModel->getAll();
        $this->view('config/email', ['title' => 'Configuración Email', 'config' => $config], 'admin');
    }

    public function colors() {
        if ($this->isPost()) {
            $this->saveSection('colors');
            $this->setFlash('success', 'Colores guardados.');
            $this->redirect('config/colors');
        }
        $config = $this->configModel->getAll();
        $this->view('config/colors', ['title' => 'Colores del Sistema', 'config' => $config], 'admin');
    }

    public function paypal() {
        if ($this->isPost()) {
            $this->saveSection('paypal');
            $this->setFlash('success', 'Configuración PayPal guardada.');
            $this->redirect('config/paypal');
        }
        $config = $this->configModel->getAll();
        $this->view('config/paypal', ['title' => 'Configuración PayPal', 'config' => $config], 'admin');
    }

    public function qr() {
        if ($this->isPost()) {
            $this->saveSection('qr');
            $this->setFlash('success', 'Configuración QR guardada.');
            $this->redirect('config/qr');
        }
        $config = $this->configModel->getAll();
        $this->view('config/qr', ['title' => 'API QR', 'config' => $config], 'admin');
    }

    public function iot() {
        $clubModel = new ClubModel();
        $clubs = $clubModel->getActiveClubs();

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'create') {
                $this->configModel->addIotDevice([
                    'club_id'     => $this->post('club_id') ?: null,
                    'name'        => $this->post('name'),
                    'device_type' => $this->post('device_type'),
                    'ip_address'  => $this->post('ip_address'),
                    'username'    => $this->post('username'),
                    'password'    => $this->post('password'),
                ]);
                $this->setFlash('success', 'Dispositivo IoT agregado.');
            } elseif ($action === 'update') {
                $this->configModel->updateIotDevice($this->post('id'), [
                    'name'       => $this->post('name'),
                    'ip_address' => $this->post('ip_address'),
                    'username'   => $this->post('username'),
                ]);
                $this->setFlash('success', 'Dispositivo actualizado.');
            } elseif ($action === 'delete') {
                $this->configModel->deleteIotDevice($this->post('id'));
                $this->setFlash('success', 'Dispositivo eliminado.');
            }
            $this->redirect('config/iot');
        }

        $devices = $this->configModel->getIotDevices();
        $this->view('config/iot', ['title' => 'Dispositivos IoT', 'devices' => $devices, 'clubs' => $clubs], 'admin');
    }

    public function storeIot() {
        $this->configModel->addIotDevice([
            'club_id'     => $this->post('club_id') ?: null,
            'name'        => $this->post('name'),
            'device_type' => $this->post('device_type'),
            'ip_address'  => $this->post('ip_address'),
            'username'    => $this->post('username'),
            'password'    => $this->post('password'),
        ]);
        $this->setFlash('success', 'Dispositivo IoT agregado.');
        $this->redirect('config/iot');
    }

    public function deleteIot() {
        $this->configModel->deleteIotDevice($this->post('id'));
        $this->setFlash('success', 'Dispositivo eliminado.');
        $this->redirect('config/iot');
    }

    public function logs() {
        $page = max(1, (int)$this->get('page', 1));
        $logs = $this->configModel->getLogs($page);
        $this->view('config/logs', ['title' => 'Bitácora de Acciones', 'logs' => $logs, 'page' => $page], 'admin');
    }

    public function clearLogs() {
        $this->configModel->clearLogs();
        $this->setFlash('success', 'Bitácora limpiada.');
        $this->redirect('config/logs');
    }

    public function errors() {
        $page = max(1, (int)$this->get('page', 1));
        $errors = $this->configModel->getErrorLogs($page);
        $this->view('config/errors', ['title' => 'Monitor de Errores', 'errors' => $errors, 'page' => $page], 'admin');
    }

    public function clearErrors() {
        $this->configModel->clearErrors();
        $this->setFlash('success', 'Log de errores limpiado.');
        $this->redirect('config/errors');
    }

    public function chatbot() {
        if ($this->isPost()) {
            $this->saveSection('chatbot');
            $this->setFlash('success', 'Configuración del chatbot guardada.');
            $this->redirect('config/chatbot');
        }
        $config = $this->configModel->getAll();
        $this->view('config/chatbot', ['title' => 'Chatbot WhatsApp', 'config' => $config], 'admin');
    }

    public function onboarding() {
        if ($this->isPost()) {
            $this->saveSection('onboarding');
            $this->setFlash('success', 'Configuración del onboarding guardada.');
            $this->redirect('config/onboarding');
        }
        $config = $this->configModel->getAll();
        $this->view('config/onboarding', ['title' => 'Pantallas de Onboarding', 'config' => $config], 'admin');
    }
}
