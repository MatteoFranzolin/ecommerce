<?php
?>

<html>
<head>
    <title>Sign up</title>
    <link rel="stylesheet" href="./styles/authentication_styles.css">
</head>

<body>
<div class="signup_container">
    <form action="../actions/action_signup.php" method="post">
        <h2>Sign Up</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password-confirmation" placeholder="Conferma Password" required>
        <input type="submit" value="Registrati">
        <p>Already have an account? <a href="./login.php">Log in</a></p>
    </form>
</div>
</body>
</html>