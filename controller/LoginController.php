<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../model/User.php';

class LoginController extends Controller
{
    public function index(): void
    {
        $this->render('login', [
            'title' => 'Login - Event Planner'
        ]);
    }

    public function authenticate(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::verifyPassword($email, $password);

        if ($user === null) {
            $_SESSION['flash_error'] = 'Email of wachtwoord is onjuist';
            $this->redirect('/login');
            return;
        }

        $_SESSION['user'] = $user;
        unset($_SESSION['flash_error']);
        $this->redirect('/');
    }
}
