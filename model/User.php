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
}