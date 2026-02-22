<?php
session_start();

if (!isset($_SESSION['inventory'])) {
    $_SESSION['inventory'] = [
        'milk' => 0,
        'soft_drink' => 0
    ];
}

$error = "";
$worker = isset($_SESSION['worker']) ? $_SESSION['worker'] : "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['worker_name'])) {
        $_SESSION['worker'] = $_POST['worker_name'];
        $worker = $_SESSION['worker'];
    }

    $product = $_POST['product'];
    $quantity = (int)$_POST['quantity'];

    if (isset($_POST['add'])) {
        $_SESSION['inventory'][$product] += $quantity;
    } elseif (isset($_POST['remove'])) {
        if ($quantity > $_SESSION['inventory'][$product]) {
            $error = "Error: No hay suficientes unidades de " . $product;
        } else {
            $_SESSION['inventory'][$product] -= $quantity;
        }
    } elseif (isset($_POST['reset'])) {
        header("Location: Exercise02.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<body>
    <h1>Supermarket management</h1>
    
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="post">
        <p>Worker name: <input type="text" name="worker_name" value="<?php echo $worker; ?>"></p>
        
        <h3>Choose product:</h3>
        <select name="product">
            <option value="milk">Milk</option>
            <option value="soft_drink">Soft Drink</option>
        </select>

        <h3>Product quantity:</h3>
        <input type="number" name="quantity" min="1">
        <br><br>
        
        <button type="submit" name="add">add</button>
        <button type="submit" name="remove">remove</button>
        <button type="submit" name="reset">reset</button>
    </form>

    <h2>Inventory:</h2>
    <p>worker: <?php echo $worker; ?></p>
    <p>units milk: <?php echo $_SESSION['inventory']['milk']; ?></p>
    <p>units soft drink: <?php echo $_SESSION['inventory']['soft_drink']; ?></p>
</body>
</html>