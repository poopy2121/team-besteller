<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>registrieren</h1>

    <form action="register.php" method="post">
        <label for="username">username</label>
        <input type="text" name="username">
        <label for="email">email</label>
        <input type="email" name="email" id="">
        <label for="password">password</label>
        <input type="password" name="password" id="">
        <input type="submit" value="register" name="register">

        <p>hast einen account? <a href="index.php">anmelden</a></p>
    </form>


    <?php
    include 'db.php';

    if (isset($_POST['register'])) {

    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
   
        if (empty($username) || empty($email) || empty($password)) {
            echo "bitte fülle alles aus";
        }
else {



    $query = "INSERT INTO users (username, email, password_hash) VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $username, $email, $hashed_password);
    $stmt->execute();
    header('Location: index.php');
    exit;
 };
};
    ?>
    
</body>
</html>