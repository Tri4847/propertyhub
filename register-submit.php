<body>
<?php
session_start();
require 'db.php';

// Retrieve form inputs
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$role = $_POST['role'];

try {
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, username, password, role) 
                           VALUES (:first_name, :last_name, :email, :username, :password, :role)");
    $stmt->execute([
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'username' => $username, 
        'password' => $password,
        'role' => $role
    ]);
    header('Location: login.php');
} catch (PDOException $e) {
    if ($e->getCode() === '23000') { // Handle duplicate entry
        $_SESSION['errorMessage'] = 'Username or email already taken.';
        header('Location: register.php');
    } else {
        die("Error: " . $e->getMessage());
    }
}
?>
</body>