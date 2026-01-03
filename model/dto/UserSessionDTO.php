<?php

/**
 * Lightweight User Session Data Transfer Object
 * Used for session storage after login - contains only essential fields
 */
class UserSessionDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $firstname,
        public readonly ?string $middleName,
        public readonly string $lastname,
        public readonly string $role,
    ) {}

    /**
     * Create a UserSessionDTO from a database row
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            email: $data['email'],
            firstname: $data['firstname'],
            middleName: $data['middle_name'] ?? null,
            lastname: $data['lastname'],
            role: $data['role'],
        );
    }

    /**
     * Get display name for UI
     */
    public function getDisplayName(): string
    {
        $parts = [$this->firstname];
        if ($this->middleName) {
            $parts[] = $this->middleName;
        }
        $parts[] = $this->lastname;
        return implode(' ', $parts);
    }

    /**
     * Check if user is an employee
     */
    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }
}
