<?php
class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();
        $this->route($url);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    private function route($url) {
        $routes = [
            '' => ['HomeController', 'index'],
            'home' => ['HomeController', 'index'],
            'home/welcome' => ['HomeController', 'welcome'],
            'home/notifications' => ['HomeController', 'notifications'],
            'home/toggle-dark' => ['HomeController', 'toggleDark'],
            'home/save-location' => ['HomeController', 'saveLocation'],
            'home/available-days' => ['HomeController', 'availableDays'],
            'spaces/detail' => ['SpaceController', 'detail'],
            'spaces/slots' => ['SpaceController', 'slots'],
            'auth/onboarding' => ['AuthController', 'onboarding'],
            'auth/login' => ['AuthController', 'login'],
            'auth/register' => ['AuthController', 'register'],
            'auth/forgot' => ['AuthController', 'forgot'],
            'auth/reset' => ['AuthController', 'reset'],
            'auth/logout' => ['AuthController', 'logout'],
            'user/profile' => ['UserController', 'profile'],
            'user/upload-avatar' => ['UserController', 'uploadAvatar'],
            'user/settings' => ['UserController', 'settings'],
            'reservations/search' => ['ReservationController', 'search'],
            'reservations/create' => ['ReservationController', 'create'],
            'reservations/confirm' => ['ReservationController', 'confirm'],
            'reservations/history' => ['ReservationController', 'history'],
            'reservations/slots' => ['ReservationController', 'slots'],
            'clubs' => ['ClubController', 'index'],
            'clubs/detail' => ['ClubController', 'detail'],
            'clubs/toggle-follow' => ['ClubController', 'toggleFollow'],
            'admin/dashboard' => ['AdminController', 'dashboard'],
            'admin/spaces' => ['AdminController', 'spaces'],
            'admin/schedules' => ['AdminController', 'schedules'],
            'admin/amenities' => ['AdminController', 'amenities'],
            'admin/reservations' => ['AdminController', 'reservations'],
            'admin/incidents' => ['AdminController', 'incidents'],
            'superadmin/dashboard' => ['SuperAdminController', 'dashboard'],
            'superadmin/clubs' => ['SuperAdminController', 'clubs'],
            'superadmin/commissions' => ['SuperAdminController', 'commissions'],
            'superadmin/promotions' => ['SuperAdminController', 'promotions'],
            'superadmin/leads' => ['SuperAdminController', 'leads'],
            'config' => ['ConfigController', 'index'],
            'config/general' => ['ConfigController', 'general'],
            'config/email' => ['ConfigController', 'email'],
            'config/colors' => ['ConfigController', 'colors'],
            'config/onboarding' => ['ConfigController', 'onboarding'],
            'config/upload-logo'         => ['ConfigController', 'uploadLogo'],
            'config/remove-logo'         => ['ConfigController', 'removeLogo'],
            'config/upload-slide-image'  => ['ConfigController', 'uploadSlideImage'],
            'config/remove-slide-image'  => ['ConfigController', 'removeSlideImage'],
            'config/paypal' => ['ConfigController', 'paypal'],
            'config/qr' => ['ConfigController', 'qr'],
            'config/iot' => ['ConfigController', 'iot'],
            'config/logs' => ['ConfigController', 'logs'],
            'config/errors' => ['ConfigController', 'errors'],
            'config/chatbot' => ['ConfigController', 'chatbot'],
        ];

        $urlString = implode('/', $url);

        if (isset($routes[$urlString])) {
            [$this->controller, $this->method] = $routes[$urlString];
            $this->params = [];
        } elseif (count($url) >= 2) {
            $baseRoute = $url[0] . '/' . $url[1];
            if (isset($routes[$baseRoute])) {
                [$this->controller, $this->method] = $routes[$baseRoute];
                $this->params = array_slice($url, 2);
            } elseif (isset($routes[$url[0]])) {
                [$this->controller, $this->method] = $routes[$url[0]];
                $this->params = array_slice($url, 1);
            } else {
                $this->controller = 'HomeController';
                $this->method = 'index';
            }
        } elseif (count($url) === 1 && !empty($url[0])) {
            $key = $url[0];
            if (isset($routes[$key])) {
                [$this->controller, $this->method] = $routes[$key];
            } else {
                $this->controller = 'HomeController';
                $this->method = 'notFound';
            }
        }

        $controllerFile = ROOT . '/app/controllers/' . $this->controller . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $this->controller();
            if (method_exists($controller, $this->method)) {
                call_user_func_array([$controller, $this->method], $this->params);
            } else {
                $controller->index();
            }
        } else {
            http_response_code(404);
            echo "<!DOCTYPE html><html><head><title>404</title><meta charset='UTF-8'></head><body style='font-family:sans-serif;text-align:center;padding:80px'><h1 style='color:#0EA5E9'>404</h1><p>Página no encontrada</p><a href='" . BASE_URL . "'>Volver al inicio</a></body></html>";
        }
    }
}
