<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../model/User.php';

class RegisterController extends Controller
{
    public function index(): void
    {
        $this->render('register', [
            'title' => 'Registreren - Event Planner'
        ]);
    }

    public function register(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $firstname = $_POST['firstname'] ?? '';
        $middleName = $_POST['middle_name'] ?? null;
        $lastname = $_POST['lastname'] ?? '';
        $phone = $_POST['phone'] ?? null;
        $membershipNumber = $_POST['membership_number'] ?? null;
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        if (empty($email) || empty($password) || empty($firstname) || empty($lastname) || empty($membershipNumber)) {
            $_SESSION['flash_error'] = 'Vul alstublieft alle verplichte velden in.';
            $this->redirect('/register');
            return;
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['flash_error'] = 'Wachtwoorden komen niet overeen.';
            $this->redirect('/register');
            return;
        }

        if (User::findByEmail($email)) {
            $_SESSION['flash_error'] = 'E-mailadres is al geregistreerd.';
            $this->redirect('/register');
            return;
        }

        if (User::findByMembershipNumber($membershipNumber)) {
            $_SESSION['flash_error'] = 'Lidmaatschapsnummer is al gebruikt.';
            $this->redirect('/register');
            return;
        }

        try {
            if (User::create($email, $password, $firstname, $middleName, $lastname, $phone, $membershipNumber)) {
                $_SESSION['flash_success'] = 'Registratie succesvol! U kunt nu inloggen';
                $this->redirect('/login');
            } else {
                $_SESSION['flash_error'] = 'Registratie mislukt. Probeer het opnieuw.';
                $this->redirect('/register');
            }
        } catch (PDOException $e) {
            $_SESSION['flash_error'] = 'Er is een fout opgetreden. Probeer het opnieuw.';
            $this->redirect('/register');
        }
    }
}
