<?php
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/views/styles/index_styles.css">
</head>
<body>
<div class="navbar">
    <a class="navbut" href="../products/index.php">Home</a>
    <?php
    if (!empty($_SESSION['current_user'])) { ?>
        <a class="navbut" href="../../actions/logout.php">Logout</a>
        <label style="
            color: #333;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            display: inline-block;
            float: right"><?php echo "Utente: " . $_SESSION['current_user']->getEmail(); ?></label>
        <a class="navbut" href="../cart/view_cart.php">Vai al carrello</a>
        <?php
        if ($_SESSION['current_user']->getRoleId() == 2) {
            ?> <a class="navbut" href="../admin/index.php">Admin</a>
            <?php
        }
    } else { ?>
        <a class="navbut" href="../login.php">Login</a>
    <?php } ?>

</div>
</body>
</html>