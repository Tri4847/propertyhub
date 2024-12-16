<?php
include('db.php'); // Include database connection
session_start();

$property_id = $_GET['id'] ?? null;

if (!$property_id) {
    echo "<p>Property not found.</p>";
    exit();
}

try {
    // Fetch property details
    $sql = "SELECT * FROM properties WHERE id = :property_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['property_id' => $property_id]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$property) {
        echo "<p>Property not found.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error fetching property details: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit();
}
?>
<div class="property-details">
    <img src="<?php echo htmlspecialchars($property['image_url']); ?>" alt="Property Image" style="width:100%;border-radius:8px;">
    <h2><?php echo htmlspecialchars($property['location']); ?></h2>
    <p>Price: $<?php echo htmlspecialchars($property['price']); ?> | Bedrooms: <?php echo htmlspecialchars($property['bedrooms']); ?> | Baths: <?php echo htmlspecialchars($property['baths']); ?></p>
    <p>About: 
        <br><?php echo htmlspecialchars($property['details']); ?></p>
</div>
