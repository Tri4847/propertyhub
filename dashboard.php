<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <?php
    session_start();
    ?>
    <div id="dashboard">
        <h1>Property Listings</h1>
        <a href="logout.php" class="logout-button">Logout</a>
        <div id="properties" style="display:flex; flex-direction:row; flex-wrap:wrap;"></div>
    </div>
    <div id="wishlist">
        <h2>Your Wishlist</h2>
        <ul id="wishlist-items"></ul>
    </div>
    <div id="property-popup">
        <div class="popup-content" id="popup-details"></div>
    </div>
    <script src="script.js"></script>
</body>
</html>
