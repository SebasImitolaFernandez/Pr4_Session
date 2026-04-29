<?php
session_start();

if (!isset($_SESSION['numbers'])) {
    $_SESSION['numbers'] = [10, 20, 30];
}

$average = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modify'])) {
        $pos = $_POST['position'];
        $val = (int)$_POST['new_value'];
        $_SESSION['numbers'][$pos] = $val;
    } elseif (isset($_POST['average'])) {
        $average = array_sum($_SESSION['numbers']) / count($_SESSION['numbers']);
    } elseif (isset($_POST['reset'])) {
        
        header("Location: Exercise01.php");
        exit;
    }
}
?>

// Test Charge
//TEST ISSIUE 1

<!DOCTYPE html>
<html lang="es">
<body>
    <h1>Modify array saved in session</h1>
    <form method="post">
        <p>Position to modify: 
            <select name="position">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </p>
        <p>New value: <input type="number" name="new_value"></p>
        
        <button type="submit" name="modify">Modify</button>
        <button type="submit" name="average">Average</button>
        <button type="submit" name="reset">Reset</button>
    </form>

    <p>Current array: <?php echo implode(", ", $_SESSION['numbers']); ?></p>

    <?php if ($average !== null): ?>
        <p>Average: <?php echo number_format($average, 2); ?></p>
    <?php endif; ?>
</body>
</html>