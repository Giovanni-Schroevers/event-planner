<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Registration.php';

class AccountController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return;
        }

        $user = User::findById($_SESSION['user']->id);

        $this->render('account', [
            'title' => 'Mijn Account',
            'user' => $user
        ]);
    }

    public function update(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return;
        }

        if (empty($_POST['email']) || empty($_POST['firstname']) || empty($_POST['lastname'])) {
            $_SESSION['flash_error'] = 'Vul alle verplichte velden in.';
            $this->redirect('/account');
            return;
        }

        $data = [
            'firstname' => $_POST['firstname'],
            'middle_name' => $_POST['middle_name'] ?? null,
            'lastname' => $_POST['lastname'],
            'phone' => $_POST['phone'] ?? null,
        ];

        if (User::update($_SESSION['user']->id, $data)) {
            $updatedUser = User::findById($_SESSION['user']->id);
            $_SESSION['user'] = UserSessionDTO::fromArray([
                'id' => $updatedUser->id,
                'email' => $updatedUser->email,
                'firstname' => $updatedUser->firstname,
                'middle_name' => $updatedUser->middleName,
                'lastname' => $updatedUser->lastname,
                'role' => $updatedUser->role,
            ]);
            $_SESSION['flash_success'] = 'Accountgegevens succesvol bijgewerkt.';
        } else {
            $_SESSION['flash_error'] = 'Er is iets misgegaan bij het bijwerken.';
        }

        $this->redirect('/account');
    }

    public function delete(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return;
        }

        $userId = $_SESSION['user']->id;

        Registration::deleteAllFutureForUser($userId);

        if (User::deactivate($userId)) {
            session_destroy();
            session_start();
            $_SESSION['flash_success'] = 'Je account is verwijderd en al je toekomstige inschrijvingen zijn geannuleerd.';
            $this->redirect('/');
        } else {
            $_SESSION['flash_error'] = 'Kon account niet verwijderen.';
            $this->redirect('/account');
        }
    }
}
