<?php

class EventDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $location,
        public readonly string $eventDate,
        public readonly string $registrationDeadline,
        public readonly float $price,
        public readonly ?int $maxParticipants,
        public readonly int $createdBy,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly int $participantCount,
    ) {
    }

    public function getFormattedDate(): string
    {
        if (class_exists('IntlDateFormatter')) {
            $date = date_create($this->eventDate);
            $formatter = new IntlDateFormatter(
                'nl_NL',
                IntlDateFormatter::LONG,
                IntlDateFormatter::SHORT
            );
            return $formatter->format($date);
        }

        return date('d-m-Y H:i', strtotime($this->eventDate));
    }

    public function getFormattedRegistrationDeadline(): string
    {
        if (class_exists('IntlDateFormatter')) {
            $date = date_create($this->registrationDeadline);
            $formatter = new IntlDateFormatter(
                'nl_NL',
                IntlDateFormatter::LONG,
                IntlDateFormatter::SHORT
            );
            return $formatter->format($date);
        }

        return date('d-m-Y H:i', strtotime($this->registrationDeadline));
    }

    public function getFormattedPrice(): string
    {
        if ($this->price == floor($this->price)) {
            return '€ ' . number_format($this->price, 0, ',', '.') . ',-';
        }
        return '€ ' . number_format($this->price, 2, ',', '.');
    }

    public function isRegistrationOpen(): bool
    {
        return strtotime($this->registrationDeadline) >= time();
    }

    public function isFull(): bool
    {
        return $this->maxParticipants !== null && $this->participantCount >= $this->maxParticipants;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: $data['name'],
            description: $data['description'] ?? null,
            location: $data['location'] ?? null,
            eventDate: $data['event_date'],
            registrationDeadline: $data['registration_deadline'],
            price: (float) $data['price'],
            maxParticipants: isset($data['max_participants']) ? (int) $data['max_participants'] : null,
            createdBy: (int) $data['created_by'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            participantCount: (int) ($data['participant_count'] ?? 0),
        );
    }
}
