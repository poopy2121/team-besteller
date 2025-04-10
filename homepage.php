<?php 
include 'db.php';
session_start();

    if (!isset($_SESSION['username'])) {
        
        session_destroy();
        header("Location: index.php");
        exit;
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        # code
    }




    if (isset($_POST['createOrder'])) {

    $order_title = $_POST['order_title'];
    $order_message = $_POST['order_message'];
    $closed_at = $_POST['closed_at'];
    $creator_id = $_SESSION['user_id']; // vom eingeloggten Nutzer

$query = "INSERT INTO orders (order_title, order_message, closed_at, created_by) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('sssi', $order_title, $order_message, $closed_at, $creator_id);
$stmt->execute();

// verhindert nachfrage nach "seite reloaden?"
   header("Location: " . $_SERVER['PHP_SELF']);
    exit;

    }
    if ($_SESSION['username']) {
        $showQuery = 'SELECT * from orders';
        $stmt = $conn->prepare($showQuery);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    
    $user_wish = $_POST['user_wish'];
    $price = $_POST['price'];

    if (isset($_POST['add_wish'])) {

        $wishQuery = "INSERT into order_wishes (ordered_by, meal, price) Values (?,?,?)";
        $stmt = $conn->prepare($wishQuery);
        $stmt->bind_param('ssi', $_SESSION['user_id'], $user_wish, $price);
        $stmt->execute();

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>Hi, <?= htmlspecialchars($_SESSION['username']) ?></h1>
    <h4>bestellung aufgeben</h4>
    <form action="" method="post">
        <label for="order">Titel</label> <br>
        <input type="text" name="order_title"> <br>
        <label for="order_message">Nachricht</label> <br>
        <textarea name="order_message" id=""></textarea> <br>
        <label for="">Wann Bestellung schließen? </label> <br>
        <input type="time" name="closed_at" id=""> <br>
        <input type="submit" value="erstellen" name="createOrder"> <br>
        <input type="submit" value="logout" name="logout">
    </form>
    
    <?php while ($row = $result->fetch_assoc()): ?>
    <h2><?= ($row['order_title']) ?></h2> 
        <p><?= ($row['order_title']) ?></h2> 
        <p>Schließt um:<?= ($row['closed_at']) ?></p>
        
        <form action="homepage.php" method="post">
        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
        <input type="text" name="user_wish" id="" placeholder="was willst du essen">
        <input type="number" name="price" id="" placeholder="preis in eur">
        <input type="submit" value="kommentieren" name="add_wish">
    </form>
    <?php endwhile; ?>


  



</body>
</html>



