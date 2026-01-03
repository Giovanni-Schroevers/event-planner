<?php
    $menu = [
        'Events' => '/events',
        'Login' => '/login',
        'Registration' => '/register',
        'Account' => '/account'
    ];
?>

<!doctype html>
<html lang='nl'>

<head>
    <link rel="stylesheet" href="/styles/normalize.css">
    <link rel="stylesheet" href="/styles/base.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preload" href="/static/logo.png" as="image" type="image/png" />
    <title>
        <?= $title ?? 'Event Planner' ?>
    </title>
    <meta charset="UTF-8">
    <meta name="robots" content="INDEX, FOLLOW">
</head>

<body>
    <header>
        <nav>
            <a href="/" class="logo">
                <img src="/static/logo.png" alt="Logo" width="96" height="48">
            </a>
            <ul class="menu">
                <?php foreach ($menu as $menu_item => $page_link): ?>
                    <li class="menu-item">
                        <a href="<?= $page_link ?>" class="menu-link">
                            <?= $menu_item ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer>
        2025 - copyright Giovanni Schroevers
    </footer>
</body>
</html>

