<?php

require_once __DIR__ . '/../core/Controller.php';

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

        $this->redirect('/login');
    }
}
