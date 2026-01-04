<?php

require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $upcomingEvents = [];
        if (isset($_SESSION['user'])) {
            require_once __DIR__ . '/../model/Event.php';
            $upcomingEvents = Event::getUpcomingRegisteredEvents($_SESSION['user']->id);
        }

        $this->render('home', [
            'title' => 'Event Planner',
            'upcomingEvents' => $upcomingEvents
        ]);
    }
}
