<?php
$pageTitle = 'Create Campaign';
ob_start();
?>

<h1>Create a New Campaign</h1>
<form id="createCampaignForm">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="target_audience">Target Audience:</label>
    <input type="text" id="target_audience" name="target_audience">

    <label for="budget">Budget ($):</label>
    <input type="number" id="budget" name="budget" required>

    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" required>

    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" required>

    <button type="submit">Create Campaign</button>
</form>
<div id="message"></div>

<script>
    document.getElementById('createCampaignForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const messageDiv = document.getElementById('message');

        // In a real app, the auth token would be sent to verify the user
        const response = await fetch('/campaigns/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            messageDiv.style.color = 'green';
            messageDiv.textContent = result.message;
            form.reset();
        } else {
            messageDiv.style.color = 'red';
            messageDiv.textContent = 'Error: ' .concat(result.message);
        }
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout/app.php';
?>
