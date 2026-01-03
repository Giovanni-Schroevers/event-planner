<?php

require_once __DIR__ . '/../core/Controller.php';

class LogoutController extends Controller
{
    public function index()
    {
        $_SESSION = [];
        session_regenerate_id(true);
        $_SESSION['flash_success'] = 'U bent succesvol uitgelogd';
        $this->redirect('/');
    }
}