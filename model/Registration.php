<?php

require_once __DIR__ . '/../core/Database.php';

class Registration
{

    public static function isUserRegistered(int $userId, int $eventId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT 1 FROM registrations WHERE user_id = :user_id AND event_id = :event_id');
        $stmt->execute(['user_id' => $userId, 'event_id' => $eventId]);
        return (bool) $stmt->fetchColumn();
    }

    public static function createRegistration(int $eventId, int $userId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO registrations (event_id, user_id) VALUES (:event_id, :user_id)');
        return $stmt->execute(['event_id' => $eventId, 'user_id' => $userId]);
    }

    public static function deleteRegistration(int $eventId, int $userId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM registrations WHERE event_id = :event_id AND user_id = :user_id');
        return $stmt->execute(['event_id' => $eventId, 'user_id' => $userId]);
    }

    public static function deleteAllFutureForUser(int $userId): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            DELETE r 
            FROM registrations r
            JOIN events e ON r.event_id = e.id
            WHERE r.user_id = :user_id AND e.event_date > NOW()
        ');
        return $stmt->execute(['user_id' => $userId]);
    }
}