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
<form action = "register-submit.php" method = "POST">
    <fieldset>
        <h1>Register</h1>
        <label for="first_name"><strong>First Name:</strong></label>
        <input type="text" name="first_name" placeholder="First Name" required><br>

        <label for="last_name"><strong>Last Name:</strong></label>
        <input type="text" name="last_name" placeholder="Last Name" required><br>

        <label for="email"><strong>Email Address:</strong></label>
        <input type="email" name="email" placeholder="Email" required><br>

        <label for="username"><strong>Username:</strong></label>
        <input type="text" name="username" placeholder="Username" required><br>

        <label for="password"><strong>Password:</strong></label>
        <input type="password" name="password" placeholder="Password" required><br>

        <label for="role"><strong>Role:</strong></label>
        <select name="role" required>
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
            <option value="admin">Admin</option>
        </select><br>

        <input type="submit" name="Submit" value="Register">
        <p>Already have an account? <a href="login.php">Log in Now!</a></p>
    </fieldset>  
</form>

</body>
</html>