<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="index.php" method="post">
        <label for="email">E-Mail:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Passwort:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="login" value="Login">

        <p>noch keinen Account? <a href="register.php">registrieren</a></p>
    </form>
</body>
</html>

<?php



session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user by email
    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: homepage.php");

        } else {
            echo "❌ Wrong password";
        }
    } else {
        echo "❌ Email not found";
    }
}














/*

session_start();
include 'db.php'; 

    $_SESSION['user_id'] = rand(1000, 9999);

    $dummyName = "TestUser_" . $_SESSION['user_id'];
    $dummyEmail = "test" . $_SESSION['user_id'] . "@mail.com";
    $dummyPwHash = password_hash("123456", PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (id, username, email, password_hash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $_SESSION['user_id'], $dummyName, $dummyEmail, $dummyPwHash);
    $stmt->execute();

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['placeOrder'])) {
        $orderText = htmlspecialchars($_POST['order']);
        $orderHeader = htmlspecialchars($_POST['orderHeader']);

        $stmt = $conn->prepare("INSERT INTO orders (title, note, creator_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $orderHeader, $orderText, $user_id);
        $stmt->execute();

        echo "Bestellung wurde erstellt!";
    } */

?>









































