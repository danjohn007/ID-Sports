<?php
class View {
    public static function render($viewPath, $data = [], $layout = 'main') {
        extract($data);
        $viewFile = ROOT . '/app/views/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
            die("View not found: $viewFile");
        }
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        if ($layout) {
            $layoutFile = ROOT . '/app/views/layouts/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }

    public static function renderPartial($viewPath, $data = []) {
        extract($data);
        $viewFile = ROOT . '/app/views/' . $viewPath . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        }
    }
}
