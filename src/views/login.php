<?php
$pageTitle = 'Login';

ob_start();
?>

<h1>Login</h1>
<form id="loginForm">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
</form>
<div id="message"></div>

<script>
    document.getElementById('loginForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const messageDiv = document.getElementById('message');

        const response = await fetch('/login', {
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
            // Redirect to a dashboard page after successful login
            window.location.href = '/'; // Or a dashboard page
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
