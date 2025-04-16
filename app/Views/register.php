<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>

    <h2>Register</h2>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="/register-post" method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="/login">Login here</a></p>

</body>
</html>
