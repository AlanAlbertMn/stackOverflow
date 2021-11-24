<?php

require_once 'database.php';
if ($_POST) {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "stackOverflow";
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conn = mysqli_connect($host, $user, $pass, $db);
    $query = "SELECT * FROM User where name='$username' and password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        session_start();
        $_SESSION['auth'] = 'true';
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['idUser'] = $row["idUser"];
        header('location:index.php');
    } else {
        echo 'Wrong username or password';
    }

    Database::disconnect();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="css/customStyles.css"></script>
</head>

<body>
    <div class="container">
        <h3 class="display-4">Login</h3>
        <form method="POST">
            <p>Username</p>
            <input  type="text" placeholder="Username" name="username">
            <p>Password</p>
            <input type="password" placeholder="Password" name="password"> <br>
            <input class="btn btn-success" type="submit" value="Login">
        </form>
    </div>
</body>

</html>