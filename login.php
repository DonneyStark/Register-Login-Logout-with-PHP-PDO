<?php
require "connect.php";
session_start();

// Check if the user is already logged in
if (isset($_SESSION["user_id"])) {
    header("location: index.php");
    exit();
}

// Process login form if submitted
if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row["password"])) {
        // Store user ID in session
        $_SESSION["user_id"] = $row["id"];
        header("location: index.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Invalid email or password</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <form action="login.php" method="post">
            <h2 class="text-center">Login</h2>
            <input type="email" name="email" placeholder="Email" class="form-control mb-2">
            <input type="password" name="password" placeholder="Password" class="form-control mb-2">
            <input type="submit" value="Login" class="btn btn-primary mb-2" name="submit">
            <p>Not registered yet <a href="signup.php">sign up</a></p>
        </form>
    </div>
</body>

</html>
