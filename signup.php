<?php
require "connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">

        <form action="signup.php" method="post" class="">
            <?php
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $repassword = $_POST["repassword"];
            $passwordhash = password_hash($password,PASSWORD_DEFAULT);
            $errs = [];
            if(isset($_POST["submit"])){
                if(empty($fullname) || empty($password) || empty($password) || empty($repassword)) {
                    array_push($errs,"All feilds is required");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errs,"Email is invalid");
                }
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = $conn->query($sql);
                $row = $result->fetch(PDO::FETCH_ASSOC);

                if($email == $row["email"]){
                    array_push($errs,"Email already exists");
                }
                if(strlen($password)<7){
                    array_push($errs,"Password must contain at least 8 characters");
                }
                if($password !== $repassword){
                    array_push($errs,"Password does not match");
                }
                if(count($errs)>0){
                    foreach($errs as $err){
                        echo "<div class = 'alert alert-danger'>$err</div>";
                    }
                    
                }
                else{
                    $sql = "INSERT INTO users(fullname,email,password) VALUES(?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(1,$fullname);
                    $stmt->bindParam(2,$email);
                    $stmt->bindParam(3,$passwordhash);
                    $stmt->execute();
                    echo "<div class = 'alert alert-success'>Sign up successfully</div>";
                }
            }
            
            ?>
            <h2 class="text-center mt-3">Sign Up</h2>
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
            <label class="form-label">Repeat Password</label>
            <input type="password" name="repassword" class="form-control">
            <input type="submit" value="Sign Up" class="btn btn-primary mt-2" name="submit">
            <div class="mt-2">
                <p>Already signed up <a href="login.php">Login here</a></p>
            </div>
        </form>
    </div>
</body>

</html>