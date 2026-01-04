<?php

require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/dto/UserSessionDTO.php';
class User
{
    public static function findByEmail(string $email): ?UserSessionDTO
    {
        $connection = Database::getConnection();
        $stmt = $connection->prepare('SELECT id, email, firstname, middle_name, lastname, role FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ? UserSessionDTO::fromArray($result) : null;
    }

    public static function findByMembershipNumber(string $membershipNumber): ?UserSessionDTO
    {
        $connection = Database::getConnection();
        $stmt = $connection->prepare('SELECT id, email, firstname, middle_name, lastname, role FROM users WHERE membership_number = :membership_number');
        $stmt->execute(['membership_number' => $membershipNumber]);
        $result = $stmt->fetch();
        return $result ? UserSessionDTO::fromArray($result) : null;
    }

    public static function verifyPassword(string $email, string $password): ?UserSessionDTO
    {
        $user = self::findByEmail($email);

        if ($user === null) {
            return null;
        }

        $connection = Database::getConnection();
        $stmt = $connection->prepare('SELECT password FROM users WHERE id = :id');
        $stmt->execute(['id' => $user->id]);
        $hash = $stmt->fetchColumn();
        return password_verify($password, $hash) ? $user : null;
    }
    public static function create(string $email, string $password, string $firstname, ?string $middleName, string $lastname, ?string $phone, string $membershipNumber): bool
    {
        $connection = Database::getConnection();
        $stmt = $connection->prepare('INSERT INTO users (email, password, firstname, middle_name, lastname, phone, membership_number) VALUES (:email, :password, :firstname, :middle_name, :lastname, :phone, :membership_number)');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            'email' => $email,
            'password' => $hashedPassword,
            'firstname' => $firstname,
            'middle_name' => $middleName,
            'lastname' => $lastname,
            'phone' => $phone,
            'membership_number' => $membershipNumber
        ]);
    }

    public static function findById(int $id): ?UserDTO
    {
        $connection = Database::getConnection();
        $stmt = $connection->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        require_once __DIR__ . '/dto/UserDTO.php';
        return $result ? UserDTO::fromArray($result) : null;
    }

    public static function update(int $id, array $data): bool
    {
        $connection = Database::getConnection();
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['firstname'])) {
            $fields[] = 'firstname = :firstname';
            $params['firstname'] = $data['firstname'];
        }
        if (isset($data['middle_name'])) {
            $fields[] = 'middle_name = :middle_name';
            $params['middle_name'] = $data['middle_name'];
        }
        if (isset($data['lastname'])) {
            $fields[] = 'lastname = :lastname';
            $params['lastname'] = $data['lastname'];
        }
        if (isset($data['phone'])) {
            $fields[] = 'phone = :phone';
            $params['phone'] = $data['phone'];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $connection->prepare($sql);
        return $stmt->execute($params);
    }

    public static function deactivate(int $id): bool
    {
        $connection = Database::getConnection();
        $stmt = $connection->prepare('UPDATE users SET is_active = 0 WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public static function getByEventId(int $eventId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare('
            SELECT u.id, u.firstname, u.middle_name, u.lastname, u.email, u.membership_number, r.registered_at 
            FROM users u 
            JOIN registrations r ON u.id = r.user_id 
            WHERE r.event_id = :event_id 
            ORDER BY r.registered_at
        ');
        $stmt->execute(['event_id' => $eventId]);
        $results = $stmt->fetchAll();

        require_once __DIR__ . '/dto/ParticipantDTO.php';
        return array_map(fn($row) => ParticipantDTO::fromArray($row), $results);
    }
}