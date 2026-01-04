<div class="event-details">
    <header class="event-header">
        <h1>
            <?= $event->name; ?>
        </h1>
        <p class="event-meta">
            <strong>Datum:</strong>
            <?= $event->getFormattedDate(); ?> |
            <strong>Locatie:</strong>
            <?= $event->location; ?>
        </p>
    </header>

    <div class="event-content">
        <section class="event-description">
            <h3>Over dit evenement</h3>
            <p>
                <?= nl2br($event->description ?: 'Geen beschrijving beschikbaar.'); ?>
            </p>
        </section>

        <section class="event-info">
            <div class="info-card">
                <h3>Informatie</h3>
                <ul>
                    <li><strong>Prijs:</strong>
                        <?= $event->getFormattedPrice(); ?>
                    </li>
                    <li><strong>Deelnemers:</strong>
                        <?= $event->participantCount; ?>
                        <?php if ($event->maxParticipants): ?>
                            / <?= $event->maxParticipants ?>
                        <?php endif; ?>
                    </li>
                    <li><strong>Deadline inschrijving:</strong>
                        <?= $event->getFormattedRegistrationDeadline(); ?>
                    </li>
                </ul>

                <?php if ($isRegistered): ?>
                    <?php if ($event->isRegistrationOpen()): ?>
                        <form action="/events/<?= $event->id; ?>/deregister" method="POST">
                            <button type="submit" class="btn btn-secondary">Uitschrijven</button>
                        </form>
                    <?php else: ?>
                        <p class="status-message info">Je bent ingeschreven voor dit evenement.</p>
                    <?php endif; ?>
                <?php elseif (!$event->isRegistrationOpen()): ?>
                    <p class="status-message error">De inschrijving voor dit evenement is gesloten.</p>
                <?php elseif ($event->isFull()): ?>
                    <p class="status-message error">Dit evenement is vol.</p>
                <?php elseif (isset($_SESSION['user'])): ?>
                    <form action="/events/<?= $event->id; ?>/register" method="POST">
                        <button type="submit" class="btn btn-primary">Nu Inschrijven</button>
                    </form>
                <?php else: ?>
                    <a href="/login" class="btn btn-secondary">Log in om in te schrijven</a>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <div class="back-link">
        <a href="/events">Terug naar overzicht</a>
    </div>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']->isEmployee()): ?>
        <a href="/events/<?= $event->id; ?>/edit" class="btn btn-primary edit-btn">Bewerken</a>
    <?php endif; ?>

    <?php if (isset($participants) && !empty($participants)): ?>
        <h3>Deelnemers</h3>
        <div class="table registrations-list">
            <div class="table-header">
                <h4>Naam</h4>
                <h4>Email</h4>
                <h4>Lidnummer</h4>
                <h4>Inschrijfdatum</h4>
            </div>
            <div class="table-body">
                <?php foreach ($participants as $participant): ?>
                    <div class="row">
                        <p><?= $participant->getFullName(); ?></p>
                        <p><?= $participant->email; ?></p>
                        <p><?= $participant->membershipNumber ?? '-'; ?></p>
                        <p><?= $participant->getFormattedRegistrationDate(); ?></p>
                        <div>
                            <?php if (strtotime($event->eventDate) > time()): ?>
                                <form action="/events/<?= $event->id; ?>/participants/<?= $participant->id; ?>/remove" method="POST"
                                    onsubmit="return confirm('Weet je zeker dat je deze deelnemer wilt verwijderen?');">
                                    <button type="submit" class="btn btn-danger"
                                        style="padding: 5px 10px; font-size: 0.8rem;">Verwijderen</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>