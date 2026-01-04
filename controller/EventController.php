<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../model/Event.php';
require_once __DIR__ . '/../model/Registration.php';

class EventController extends Controller
{
    public function index(): void
    {
        $events = (isset($_SESSION['user']) && $_SESSION['user']->isEmployee())
            ? Event::getAllEvents()
            : Event::getAllFutureEvents();

        $this->render('events', [
            'title' => 'Evenementen',
            'events' => $events
        ]);
    }

    public function create(): void
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->isEmployee()) {
            $this->redirect('/events');
            return;
        }

        $this->render('events_create', [
            'title' => 'Nieuw Evenement'
        ]);
    }

    public function store(): void
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->isEmployee()) {
            $this->redirect('/events');
            return;
        }

        if (empty($_POST['name']) || empty($_POST['event_date']) || empty($_POST['registration_deadline'])) {
            $_SESSION['flash_error'] = 'Vul alle verplichte velden in.';
            $this->render('events_create', ['title' => 'Nieuw Evenement']);
            return;
        }

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'] ?? null,
            'location' => $_POST['location'] ?? null,
            'event_date' => $_POST['event_date'],
            'registration_deadline' => $_POST['registration_deadline'],
            'price' => (float) ($_POST['price'] ?? 0),
            'max_participants' => !empty($_POST['max_participants']) ? (int) $_POST['max_participants'] : null,
            'created_by' => $_SESSION['user']->id
        ];

        if (Event::create($data)) {
            $_SESSION['flash_success'] = 'Evenement succesvol aangemaakt.';
            $this->redirect('/events');
        } else {
            $_SESSION['flash_error'] = 'Er is iets misgegaan bij het aanmaken.';
            $this->render('events_create', ['title' => 'Nieuw Evenement']);
        }
    }

    public function show(int $id): void
    {
        $event = Event::findById($id);

        if (!$event) {
            $this->redirect('/events');
            return;
        }

        $isRegistered = false;
        if (isset($_SESSION['user'])) {
            $isRegistered = Registration::isUserRegistered($_SESSION['user']->id, $id);
        }

        $participants = [];
        if (isset($_SESSION['user']) && $_SESSION['user']->isEmployee()) {
            require_once __DIR__ . '/../model/User.php';
            $participants = User::getByEventId($id);
        }

        $this->render('event_details', [
            'title' => $event->name,
            'event' => $event,
            'isRegistered' => $isRegistered,
            'participants' => $participants
        ]);
    }

    public function register(int $id): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return;
        }

        $event = Event::findById($id);

        if (!$event) {
            $_SESSION['flash_error'] = 'Evenement niet gevonden.';
            $this->redirect('/events');
            return;
        }

        if (!$event->isRegistrationOpen()) {
            $_SESSION['flash_error'] = 'De inschrijving voor dit evenement is gesloten.';
            $this->redirect('/events/' . $id);
            return;
        }

        if ($event->isFull()) {
            $_SESSION['flash_error'] = 'Dit evenement is vol.';
            $this->redirect('/events/' . $id);
            return;
        }

        $userId = $_SESSION['user']->id;

        if (Registration::isUserRegistered($userId, $id)) {
            $_SESSION['flash_info'] = 'Je bent al ingeschreven voor dit evenement.';
            $this->redirect('/events/' . $id);
            return;
        }

        if (Registration::createRegistration($id, $userId)) {
            $_SESSION['flash_success'] = 'Je bent succesvol ingeschreven!';
        } else {
            $_SESSION['flash_error'] = 'Er is iets misgegaan bij het inschrijven. Probeer het opnieuw.';
        }

        $this->redirect('/events/' . $id);
    }

    public function deregister(int $id): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
            return;
        }

        $event = Event::findById($id);

        if (!$event) {
            $_SESSION['flash_error'] = 'Evenement niet gevonden.';
            $this->redirect('/events');
            return;
        }

        if (!$event->isRegistrationOpen()) {
            $_SESSION['flash_error'] = 'Je kunt je niet meer uitschrijven voor dit evenement.';
            $this->redirect('/events/' . $id);
            return;
        }

        $userId = $_SESSION['user']->id;

        if (!Registration::isUserRegistered($userId, $id)) {
            $_SESSION['flash_error'] = 'Je was niet ingeschreven voor dit evenement.';
            $this->redirect('/events/' . $id);
            return;
        }

        if (Registration::deleteRegistration($id, $userId)) {
            $_SESSION['flash_success'] = 'Je bent succesvol uitgeschreven.';
        } else {
            $_SESSION['flash_error'] = 'Er is iets misgegaan bij het uitschrijven. Probeer het opnieuw.';
        }

        $this->redirect('/events/' . $id);
    }

    public function edit(int $id): void
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->isEmployee()) {
            $this->redirect('/events/' . $id);
            return;
        }

        $event = Event::findById($id);

        if (!$event) {
            $this->redirect('/events');
            return;
        }

        $this->render('events_edit', [
            'title' => 'Evenement Bewerken',
            'event' => $event
        ]);
    }

    public function update(int $id): void
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->isEmployee()) {
            $this->redirect('/events/' . $id);
            return;
        }

        if (empty($_POST['name']) || empty($_POST['event_date']) || empty($_POST['registration_deadline'])) {
            $_SESSION['flash_error'] = 'Vul alle verplichte velden in.';
            $this->redirect('/events/' . $id . '/edit');
            return;
        }

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'] ?? null,
            'location' => $_POST['location'] ?? null,
            'event_date' => $_POST['event_date'],
            'registration_deadline' => $_POST['registration_deadline'],
            'price' => (float) ($_POST['price'] ?? 0),
            'max_participants' => !empty($_POST['max_participants']) ? (int) $_POST['max_participants'] : null
        ];

        if (Event::update($id, $data)) {
            $_SESSION['flash_success'] = 'Evenement succesvol bijgewerkt.';
            $this->redirect('/events/' . $id);
        } else {
            $_SESSION['flash_error'] = 'Er is iets misgegaan bij het bijwerken.';
            $this->redirect('/events/' . $id . '/edit');
        }
    }

    public function removeParticipant(int $id, int $userId): void
    {
        if (!isset($_SESSION['user']) || !$_SESSION['user']->isEmployee()) {
            $this->redirect('/events/' . $id);
            return;
        }

        $event = Event::findById($id);
        if (!$event) {
            $this->redirect('/events');
            return;
        }

        if (strtotime($event->eventDate) <= time()) {
            $_SESSION['flash_error'] = 'Evenement is al begonnen/voorbij. Deelnemers kunnen niet meer worden verwijderd.';
            $this->redirect('/events/' . $id);
            return;
        }

        if (Registration::deleteRegistration($id, $userId)) {
            $_SESSION['flash_success'] = 'Deelnemer succesvol verwijderd.';
        } else {
            $_SESSION['flash_error'] = 'Kon deelnemer niet verwijderen.';
        }

        $this->redirect('/events/' . $id);
    }
}