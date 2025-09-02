<?php
$pageTitle = 'Register';

ob_start();
?>

<h1>Register</h1>
<form id="registerForm">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="role">I am a:</label>
    <select id="role" name="role">
        <option value="influencer">Influencer</option>
        <option value="company">Company</option>
    </select>

    <button type="submit">Register</button>
</form>
<div id="message"></div>

<script>
    document.getElementById('registerForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        const messageDiv = document.getElementById('message');

        const response = await fetch('/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            messageDiv.style.color = 'green';
            messageDiv.textContent = result.message + ' You can now login.';
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
