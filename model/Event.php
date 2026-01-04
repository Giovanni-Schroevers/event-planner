<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/dto/EventOverviewDTO.php';
require_once __DIR__ . '/dto/EventDTO.php';

class Event
{
    public static function findById(int $id): ?EventDTO
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            SELECT 
                e.*,
                COUNT(r.user_id) as participant_count
            FROM events e
            LEFT JOIN registrations r ON e.id = r.event_id
            WHERE e.id = :id
            GROUP BY e.id
        ');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result ? EventDTO::fromArray($result) : null;
    }

    public static function getAllEvents(): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            SELECT 
                e.id, 
                e.name, 
                e.event_date, 
                e.location, 
                e.price, 
                e.max_participants,
                COUNT(r.user_id) as participant_count
            FROM events e
            LEFT JOIN registrations r ON e.id = r.event_id
            WHERE e.event_date >= DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH)
            GROUP BY e.id
            ORDER BY e.event_date ASC
        ');
        $stmt->execute();
        $results = $stmt->fetchAll();

        return array_map(fn($row) => EventOverviewDTO::fromArray($row), $results);
    }
    public static function getAllFutureEvents(): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            SELECT 
                e.id, 
                e.name, 
                e.event_date,
                e.registration_deadline,
                e.location, 
                e.price, 
                e.max_participants,
                COUNT(r.user_id) as participant_count
            FROM events e
            LEFT JOIN registrations r ON e.id = r.event_id
            WHERE e.registration_deadline >= CURRENT_DATE
            GROUP BY e.id
            ORDER BY e.event_date ASC
        ');
        $stmt->execute();
        $results = $stmt->fetchAll();

        return array_map(fn($row) => EventOverviewDTO::fromArray($row), $results);
    }

    public static function getUpcomingRegisteredEvents(int $userId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            SELECT 
                e.id, 
                e.name, 
                e.event_date,
                e.registration_deadline, 
                e.location, 
                e.price, 
                e.max_participants,
                COUNT(r2.user_id) as participant_count
            FROM events e
            JOIN registrations r ON e.id = r.event_id
            LEFT JOIN registrations r2 ON e.id = r2.event_id
            WHERE r.user_id = :user_id 
            AND e.event_date >= CURRENT_DATE
            GROUP BY e.id
            ORDER BY e.event_date ASC
        ');
        $stmt->execute(['user_id' => $userId]);
        $results = $stmt->fetchAll();

        return array_map(fn($row) => EventOverviewDTO::fromArray($row), $results);
    }

    public static function create(array $data): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            INSERT INTO events (
                name, description, location, event_date, registration_deadline, 
                price, max_participants, created_by
            ) VALUES (
                :name, :description, :location, :event_date, :registration_deadline, 
                :price, :max_participants, :created_by
            )
        ');
        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'location' => $data['location'],
            'event_date' => $data['event_date'],
            'registration_deadline' => $data['registration_deadline'],
            'price' => $data['price'],
            'max_participants' => $data['max_participants'],
            'created_by' => $data['created_by']
        ]);
    }

    public static function update(int $id, array $data): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            UPDATE events SET
                name = :name,
                description = :description,
                location = :location,
                event_date = :event_date,
                registration_deadline = :registration_deadline,
                price = :price,
                max_participants = :max_participants
            WHERE id = :id
        ');
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'location' => $data['location'],
            'event_date' => $data['event_date'],
            'registration_deadline' => $data['registration_deadline'],
            'price' => $data['price'],
            'max_participants' => $data['max_participants']
        ]);
    }
}