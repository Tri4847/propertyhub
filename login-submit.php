<body>
    <?php
    session_start();
    require 'db.php';

    $username = $_POST['Username'];
    $password = $_POST['Password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['player'] = $user['username'];
        header('Location: dashboard.php');//change location to actual page
    } else {
        $_SESSION['errorMessage'] = 'Invalid username or password.';
        header('Location: login.php');
    }
    ?>
    </body>