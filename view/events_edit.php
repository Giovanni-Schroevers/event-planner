<div class="form-wrapper">
    <h1>
        Evenement Bewerken: <?= $event->name; ?>
    </h1>

    <div class="form-container">
        <form action="/events/<?= $event->id; ?>/edit" method="POST" class="form">
            <div class="form-group">
                <label for="name">Naam *</label>
                <input type="text" id="name" name="name" required class="form-control" value="<?= $event->name; ?>">
            </div>

            <div class="form-group">
                <label for="location">Locatie</label>
                <input type="text" id="location" name="location" class="form-control" value="<?= $event->location; ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="event_date">Datum & Tijd *</label>
                    <input type="datetime-local" id="event_date" name="event_date" required class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($event->eventDate)); ?>">
                </div>

                <div class="form-group">
                    <label for="registration_deadline">Deadline Inschrijving *</label>
                    <input type="datetime-local" id="registration_deadline" name="registration_deadline" required
                        class="form-control"
                        value="<?= date('Y-m-d\TH:i', strtotime($event->registrationDeadline)); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Prijs (€)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" class="form-control"
                        value="<?= $event->price; ?>">
                </div>

                <div class="form-group">
                    <label for="max_participants">Max. Deelnemers</label>
                    <input type="number" id="max_participants" name="max_participants" min="1" class="form-control"
                        value="<?= $event->maxParticipants; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Beschrijving</label>
                <textarea id="description" name="description" rows="5"
                    class="form-control"><?= $event->description; ?></textarea>
            </div>

            <div class="form-actions">
                <a href="/events/<?= $event->id; ?>" class="btn btn-secondary">Annuleren</a>
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </div>
        </form>
    </div>
</div>