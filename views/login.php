<?php
?>

<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="styles/authentication_styles.css">
</head>

<body>
<div id="login_container">
    <form action="../actions/action_login.php" method="post">
        <h2>Login</h2>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Entra">
        <a href="./signup.php">Sign up</a>
    </form>
    <a href="products/index.php">
        <button type="button">Continua senza autenticazione</button>
    </a>
</div>
</body>

</html>