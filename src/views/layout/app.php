<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Influencer Marketplace'; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; }
        header { background: #f4f4f4; padding: 1rem; }
        nav a { margin: 0 10px; text-decoration: none; }
        main { padding: 1rem; }
        footer { background: #333; color: #fff; text-align: center; padding: 1rem; position: absolute; bottom: 0; width: 100%; }
        .container { max-width: 1200px; margin: auto; }
        form { display: flex; flex-direction: column; max-width: 400px; }
        form input, form select, form textarea { margin-bottom: 10px; padding: 8px; }
    </style>
</head>
<body>
    <header class="container">
        <nav>
            <a href="/">Home</a>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
            <a href="/campaigns">Browse Campaigns</a>
        </nav>
    </header>

    <main class="container">
        <?php echo $content; ?>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Influencer Marketplace</p>
    </footer>
</body>
</html>
