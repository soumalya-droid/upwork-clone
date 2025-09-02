<?php
$pageTitle = 'Influencer Dashboard';
ob_start();
?>

<h1>Influencer Dashboard</h1>
<p>Welcome! Here you can browse campaigns and manage your bids.</p>

<?php
// Logic to list campaigns the influencer has bid on would go here
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/app.php';
?>
