<?php

class ParticipantDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $firstname,
        public readonly ?string $middleName,
        public readonly string $lastname,
        public readonly ?string $membershipNumber,
        public readonly string $registeredAt
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            email: $data['email'],
            firstname: $data['firstname'],
            middleName: $data['middle_name'] ?? null,
            lastname: $data['lastname'],
            membershipNumber: $data['membership_number'] ?? null,
            registeredAt: $data['registered_at']
        );
    }

    public function getFullName(): string
    {
        $parts = [$this->firstname];
        if ($this->middleName) {
            $parts[] = $this->middleName;
        }
        $parts[] = $this->lastname;
        return implode(' ', $parts);
    }

    public function getFormattedRegistrationDate(): string
    {
        return date('d-m-Y H:i', strtotime($this->registeredAt));
    }
}
