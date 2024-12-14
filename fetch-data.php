<?php
include('db.php'); // Include database connection using PDO
session_start();

$user_id = $_SESSION['user_id']?? null;

try {
    // Fetch properties
    $properties_sql = "SELECT * FROM properties";
    $stmt = $pdo->query($properties_sql);
    $properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch wishlist for the logged-in user
    $wishlist_sql = "SELECT property_id FROM wishlist WHERE user_id = :user_id";
    $stmt = $pdo->prepare($wishlist_sql);
    $stmt->execute(['user_id' => $user_id]);
    $wishlist = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode(['properties' => $properties, 'wishlist' => $wishlist]);
} catch (PDOException $e) {
    // Handle any errors and return a JSON response
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}
?>
