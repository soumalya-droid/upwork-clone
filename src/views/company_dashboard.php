<?php
$pageTitle = 'Company Dashboard';
ob_start();
?>

<h1>Company Dashboard</h1>
<p>Welcome! Here you can manage your campaigns.</p>
<a href="/campaigns/create">Create New Campaign</a>

<?php
// Logic to list campaigns created by this company would go here
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/app.php';
?>
