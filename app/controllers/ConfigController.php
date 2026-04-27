<?php
class ConfigController extends Controller {
    private $configModel;

    public function __construct() {
        $this->requireAuth('super_admin');
        $this->configModel = new ConfigModel();
    }

    public function index() {
        $this->view('config/index', ['title' => 'Configuración del Sistema'], 'admin');
    }

    public function general() {
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                if ($key !== 'submit') {
                    $this->configModel->set($key, $value, 'general');
                }
            }
            $this->setFlash('success', 'Configuración general guardada.');
            $this->redirect('config/general');
        }
        $config = $this->configModel->getGroup('general');
        $this->view('config/general', ['title' => 'Configuración General', 'config' => $config], 'admin');
    }

    public function email() {
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                if ($key !== 'submit') $this->configModel->set($key, $value, 'email');
            }
            $this->setFlash('success', 'Configuración de email guardada.');
            $this->redirect('config/email');
        }
        $config = $this->configModel->getGroup('email');
        $this->view('config/email', ['title' => 'Configuración Email', 'config' => $config], 'admin');
    }

    public function colors() {
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                if ($key !== 'submit') $this->configModel->set($key, $value, 'colors');
            }
            $this->setFlash('success', 'Colores guardados.');
            $this->redirect('config/colors');
        }
        $config = $this->configModel->getGroup('colors');
        $this->view('config/colors', ['title' => 'Colores del Sistema', 'config' => $config], 'admin');
    }

    public function paypal() {
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                if ($key !== 'submit') $this->configModel->set($key, $value, 'paypal');
            }
            $this->setFlash('success', 'Configuración PayPal guardada.');
            $this->redirect('config/paypal');
        }
        $config = $this->configModel->getGroup('paypal');
        $this->view('config/paypal', ['title' => 'Configuración PayPal', 'config' => $config], 'admin');
    }

    public function qr() {
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                if ($key !== 'submit') $this->configModel->set($key, $value, 'qr');
            }
            $this->setFlash('success', 'Configuración QR guardada.');
            $this->redirect('config/qr');
        }
        $config = $this->configModel->getGroup('qr');
        $this->view('config/qr', ['title' => 'API QR', 'config' => $config], 'admin');
    }

    public function iot() {
        $clubModel = new ClubModel();
        $clubs = $clubModel->getActiveClubs();

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'create') {
                $this->configModel->addIotDevice([
                    'club_id' => $this->post('club_id'),
                    'name' => $this->post('name'),
                    'device_type' => $this->post('device_type'),
                    'ip_address' => $this->post('ip_address'),
                    'port' => $this->post('port') ?: 80,
                    'username' => $this->post('username'),
                    'password' => $this->post('password'),
                    'channel' => $this->post('channel') ?: 1,
                ]);
                $this->setFlash('success', 'Dispositivo IoT agregado.');
            } elseif ($action === 'update') {
                $this->configModel->updateIotDevice($this->post('id'), [
                    'name' => $this->post('name'),
                    'ip_address' => $this->post('ip_address'),
                    'port' => $this->post('port') ?: 80,
                    'username' => $this->post('username'),
                    'channel' => $this->post('channel') ?: 1,
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

    public function logs() {
        $page = max(1, (int)$this->get('page', 1));
        $logs = $this->configModel->getLogs($page);
        $this->view('config/logs', ['title' => 'Bitácora de Acciones', 'logs' => $logs, 'page' => $page], 'admin');
    }

    public function errors() {
        $page = max(1, (int)$this->get('page', 1));
        $errors = $this->configModel->getErrorLogs($page);
        $this->view('config/errors', ['title' => 'Monitor de Errores', 'errors' => $errors, 'page' => $page], 'admin');
    }

    public function chatbot() {
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                if ($key !== 'submit') $this->configModel->set($key, $value, 'chatbot');
            }
            $this->setFlash('success', 'Configuración del chatbot guardada.');
            $this->redirect('config/chatbot');
        }
        $config = $this->configModel->getGroup('chatbot');
        $this->view('config/chatbot', ['title' => 'Chatbot WhatsApp', 'config' => $config], 'admin');
    }
}
