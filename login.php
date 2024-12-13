<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> 
</head>
<body>

<?php
    session_start();
?>
<form action = "login-submit.php" method = "POST">
    <fieldset>
        <h1>Login</h1>
        <label for = "username"><strong>Username:</strong></label>
        <input type = "text" placeholder="Username" size = "20" name = "Username" required></br>
        <label for = "password"><strong>Password:</strong></label>
        <input type = "password" placeholder="Password" size = "20" name = "Password" required></br>
        <input type = "submit" name="Submit" value = "Login"/>
        <p>Don't have an account? <a href = "register.php">Register here!</a></p>
    </fieldset>
            
</form>

<?php
if (isset($_SESSION['errorMessage'])) {
    echo '<div class="error-message">' . $_SESSION['errorMessage'] . '</div>';
    unset($_SESSION['errorMessage']); 
}
?>
</html>
</body>
</html>