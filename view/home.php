<h1>Event Planner</h1>
<p>Welcome to Event Planner. Manage your events with ease.</p>

<?php if (isset($_SESSION['user'])): ?>
    <div>
        <p>Welkom terug
            <?= $_SESSION['user']->getDisplayName(); ?>
        </p>
    </div>
<?php endif; ?>