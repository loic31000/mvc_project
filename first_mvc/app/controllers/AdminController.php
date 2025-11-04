<?php
class AdminController {
    public function view(string $method, array $params = []) {
        try {
            call_user_func([$this, $method], $params);
        } catch (Error $e) {
            require_once(__DIR__ . '/../views/404.php');
        }
    }

    public function dashboard() {
        require_once(__DIR__ . '/../views/admin-dashboard.php');
    }

    public function users() {
        require_once(__DIR__ . '/../views/admin-users.php');
    }
}
