<?php
class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showLogin($errors = []) {
        require __DIR__ . '/../views/auth/login.php';
    }

    public function showRegister($errors = []) {
        require __DIR__ . '/../views/auth/register.php';
    }

    public function login($data) {
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';
        $errors = [];

        if (!$username) $errors[] = "Username required";
        if (!$password) $errors[] = "Password required";

        if ($errors) {
            $this->showLogin($errors);
            return;
        }

        $user = $this->userModel->findByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            $this->showLogin(["Invalid username or password"]);
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: index.php?page=products");
        exit;
    }

    public function register($data) {
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';
        $password_confirm = $data['password_confirm'] ?? '';
        $errors = [];

        if (!$username) $errors[] = "Username required";
        if (!$password) $errors[] = "Password required";
        if ($password !== $password_confirm) $errors[] = "Passwords do not match";

        if ($this->userModel->findByUsername($username)) {
            $errors[] = "Username already taken";
        }

        if ($errors) {
            $this->showRegister($errors);
            return;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->create($username, $password_hash);

        // Auto-login after register
        $user = $this->userModel->findByUsername($username);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: index.php?page=products");
        exit;
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
