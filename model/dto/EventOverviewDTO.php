<?php

class EventOverviewDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $eventDate,
        public readonly ?string $location,
        public readonly float $price,
        public readonly int $participantCount,
        public readonly ?int $maxParticipants,
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

    public function getFormattedPrice(): string
    {
        if ($this->price == floor($this->price)) {
            return '€ ' . number_format($this->price, 0, ',', '.') . ',-';
        }
        return '€ ' . number_format($this->price, 2, ',', '.');
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
            eventDate: $data['event_date'],
            location: $data['location'] ?? null,
            price: (float) $data['price'],
            participantCount: (int) ($data['participant_count'] ?? 0),
            maxParticipants: isset($data['max_participants']) ? (int) $data['max_participants'] : null,
        );
    }
}
