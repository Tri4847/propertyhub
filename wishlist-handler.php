<?php
include('db.php'); // Include database connection
session_start();

header('Content-Type: application/json'); // Respond with JSON

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$property_id = $data['propertyId'] ?? null;
$action = $data['action'] ?? null;

if (!$property_id || !in_array($action, ['add', 'remove'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
    exit();
}

try {
    if ($action === 'add') {
        // Add property to wishlist
        $sql = "INSERT INTO wishlist (user_id, property_id) VALUES (:user_id, :property_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'property_id' => $property_id]);
        echo json_encode(['success' => true, 'message' => 'Property added to wishlist.']);
    } elseif ($action === 'remove') {
        // Remove property from wishlist
        $sql = "DELETE FROM wishlist WHERE user_id = :user_id AND property_id = :property_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'property_id' => $property_id]);
        echo json_encode(['success' => true, 'message' => 'Property removed from wishlist.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
