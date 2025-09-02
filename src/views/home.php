<?php
$pageTitle = 'Welcome';

ob_start();
?>

<h1>Welcome to the Influencer Marketplace!</h1>
<p>Find the best influencers for your campaigns, or find campaigns that match your profile.</p>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/app.php';
?>
