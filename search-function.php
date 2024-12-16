<?php
include('db.php'); // Connect to database
header('Content-Type: application/json');

try {
    // Retrieve user inputs from AJAX
    $query = $_GET['query'] ?? '';
    $min_price = $_GET['min_price'] ?? 0;
    $max_price = $_GET['max_price'] ?? PHP_INT_MAX;

    // Build the base SQL query
    $sql = "SELECT * FROM properties WHERE 1=1";

    // Add filters dynamically
    if (!empty($query)) {
        $sql .= " AND (location LIKE :query OR details LIKE :query)";
    }
    if (!empty($min_price)) {
        $sql .= " AND price >= :min_price";
    }
    if (!empty($max_price)) {
        $sql .= " AND price <= :max_price";
    }

    // Prepare the query
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    if (!empty($query)) {
        $stmt->bindValue(':query', "%$query%");
    }
    if (!empty($min_price)) {
        $stmt->bindValue(':min_price', $min_price, PDO::PARAM_INT);
    }
    if (!empty($max_price)) {
        $stmt->bindValue(':max_price', $max_price, PDO::PARAM_INT);
    }

    // Execute the query
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return results as JSON
    echo json_encode(['properties' => $results]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
