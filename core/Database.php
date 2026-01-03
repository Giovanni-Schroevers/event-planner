<?php

class Database
{
    private static ?PDO $connection = null;

    private const HOST = 'localhost';
    private const PORT = 3306;
    private const DATABASE = 'event_planner';
    private const USERNAME = 'dev';
    private const PASSWORD = 'dev';

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                self::HOST,
                self::PORT,
                self::DATABASE
            );

            self::$connection = new PDO($dsn, self::USERNAME, self::PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return self::$connection;
    }
}