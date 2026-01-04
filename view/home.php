<h1>Event Planner</h1>
<p>Welcome to Event Planner. Manage your events with ease.</p>

<?php if (isset($_SESSION['user'])): ?>
    <div>
        <p>Welkom terug
            <?= $_SESSION['user']->getDisplayName(); ?>
        </p>
    </div>

    <?php if (!empty($upcomingEvents)): ?>
        <div class="events">
            <h2>Mijn aankomende evenementen</h2>
            <div class="event-list table">
                <div class="table-header">
                    <h4>Naam</h4>
                    <h4>Locatie</h4>
                    <h4>Datum</h4>
                    <h4>Prijs</h4>
                    <h4>Deelnemers</h4>
                </div>
                <div class="table-body">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="row">
                            <h4><?= $event->name; ?></h4>
                            <p><?= $event->location; ?></p>
                            <p><?= $event->getFormattedDate(); ?></p>
                            <p><?= $event->getFormattedPrice(); ?></p>
                            <p>
                                <?= $event->participantCount; ?>
                                <?php if ($event->maxParticipants): ?> / <?= $event->maxParticipants ?><?php endif; ?>
                            </p>
                            <a href="/events/<?= $event->id; ?>">Bewerken</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>Je bent nog niet ingeschreven voor aankomende evenementen.</p>
    <?php endif; ?>
<?php endif; ?>