<?php
require '../../models/User.php';

session_start();
if (!isset($_SESSION['current_user']) || $_SESSION['current_user']->getRoleId() == 1) {
    header("HTTP/1.1 401 Unauthorized");
    exit("Not Authorized");
}
?>

<html>
<head>
    <title>Aggiungi prodotto</title>
    <link rel="stylesheet" href="../styles/index_styles.css">
</head>
<body>
<?php include '../partial/navbar.php'; ?>
<div class="products" style="height: 50%; align-content: center">
    <div class="product-item" style="  margin: 0 auto">
        <form action="../../actions/action_add_product.php" method="POST">
            <ul style="display: grid">
                <li>
                    <br>Marca:
                    <input type="text" name="marca" placeholder="Marca" required>
                </li>
                <li>
                    <br>Nome:
                    <input type="text" name="nome" placeholder="Nome" required>
                </li>
                <li>
                    <br>Prezzo:
                    <input type="number" name="prezzo" placeholder="Prezzo" step="0.01" min="0" required>
                </li>
                <li>
                    <input type="submit" value="Aggiungi">
                </li>
            </ul>
        </form>
    </div>
</div>