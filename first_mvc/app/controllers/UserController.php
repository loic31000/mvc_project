<?php
class UserController {
    public function view(string $method, array $params = []) {
        try {
            call_user_func([$this, $method], $params);
        } catch (Error $e) {
            require_once(__DIR__ . '/../views/404.php');
        }
    }

    public function profile() {
        require_once(__DIR__ . '/../views/user-profile.php');
    }

    public function settings() {
        require_once(__DIR__ . '/../views/user-settings.php');
    }
}
