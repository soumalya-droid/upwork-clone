<?php
$pageTitle = 'Campaign Details';
ob_start();
?>

<h1>Campaign Details</h1>
<p>This page will show the details of a specific campaign.</p>

<?php
// Logic to fetch and display campaign details would go here
// Logic to display bids for the campaign would go here
// A form for influencers to submit a bid would go here
?>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/app.php';
?>
