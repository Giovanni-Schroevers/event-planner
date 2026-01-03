<?php

/**
 * Full User Data Transfer Object
 * Used for profile pages, admin views, and complete user data
 */
class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $firstname,
        public readonly ?string $middleName,
        public readonly string $lastname,
        public readonly string $role,
        public readonly ?string $membershipNumber,
        public readonly ?string $phone,
        public readonly bool $isActive,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?string $lastLoginAt,
    ) {}

    /**
     * Create a UserDTO from a database row
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
            membershipNumber: $data['membership_number'] ?? null,
            phone: $data['phone'] ?? null,
            isActive: (bool) $data['is_active'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            lastLoginAt: $data['last_login_at'] ?? null,
        );
    }

    /**
     * Get full name including middle name if present
     */
    public function getFullName(): string
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
