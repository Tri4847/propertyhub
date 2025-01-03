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
        <div id="search-bar">
            <form id="search-form">
                <input type="text" id="search-input" name="query" placeholder="Search by city, state, or zip code">
                <select id="bedrooms-filter" name="bedrooms">
                    <option value="">Any Bedrooms</option>
                    <option value="1">1 Bedroom</option>
                    <option value="2">2 Bedrooms</option>
                    <option value="3">3 Bedrooms</option>
                    <option value="4">4 Bedrooms</option>
                    <option value="5">5 Bedrooms</option>
                    <option value="6">6 Bedrooms</option>
                </select>
                <select id="baths-filter" name="baths">
                    <option value="">Any Baths</option>
                    <option value="1">1 Bath</option>
                    <option value="2">2 Baths</option>
                    <option value="3">3 Baths</option>
                    <option value="4">4 Baths</option>
                    <option value="5">5 Baths</option>
                    <option value="6">6 Baths</option>
                </select>
                <input type="number" id="min-price" name="min_price" placeholder="Min Price">
                <input type="number" id="max-price" name="max_price" placeholder="Max Price">
                <button type="submit" id="search-button">Search</button>
            </form>
        </div>
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
