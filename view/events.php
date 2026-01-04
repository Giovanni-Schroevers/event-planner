<div class="events">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Evenementen</h1>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']->isEmployee()): ?>
            <a href="/events/create" class="btn btn-primary">Nieuw Evenement</a>
        <?php endif; ?>
    </div>
    <div class="event-list table">
        <div class="table-header">
            <h4>Naam</h4>
            <h4>Locatie</h4>
            <h4>Datum</h4>
            <h4>Prijs</h4>
            <h4>Deelnemers</h4>
        </div>
        <div class="table-body">
            <?php foreach ($events as $event): ?>
                <div class="row">
                    <h4>
                        <?= $event->name; ?>
                    </h4>
                    <p>
                        <?= $event->location; ?>
                    </p>
                    <p>
                        <?= $event->getFormattedDate(); ?>
                    </p>
                    <p>
                        <?= $event->getFormattedPrice(); ?>
                    </p>
                    <p>
                        <?= $event->participantCount; ?>
                        <?php if ($event->maxParticipants): ?> / <?= $event->maxParticipants ?><?php endif; ?>
                    </p>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']->isEmployee()): ?>
                        <a href="/events/<?= $event->id; ?>/edit">Bewerken</a>
                    <?php elseif ($event->isFull()): ?>
                        <span style="color: red; font-weight: bold;">Vol</span>
                    <?php else: ?>
                        <a href="/events/<?= $event->id; ?>">Inschrijven</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>