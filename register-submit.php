<body>
<?php
session_start();
require 'db.php';

$username = $_POST['Username'];
$password = password_hash($_POST['Password'], PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->execute(['username' => $username, 'password' => $password]);
    header('Location: login.php');
} catch (PDOException $e) {
    if ($e->getCode() === '23000') { // Duplicate entry
        $_SESSION['errorMessage'] = 'Username already taken.';
        header('Location: register.php');
    } else {
        die("Error: " . $e->getMessage());
    }
}
?>
</body>