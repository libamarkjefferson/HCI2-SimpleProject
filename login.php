<?php
session_start();

$demo_email = "user@example.com";
$demo_password = "123456";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($email === $demo_email && $password === $demo_password){

        $_SESSION['user'] = $email;

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login | Organic Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <p class="subtitle">Enter your credentials to access your account</p>

    <?php if(!empty($error)) { echo "<p style='color:red; text-align:center;'>$error</p>"; } ?>

        <form action="#" method="post">
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">Login</button>
        </form>

    </div>

</body>
</html>
