document.addEventListener("DOMContentLoaded", () => {
    const propertiesContainer = document.getElementById("properties");
    const wishlistContainer = document.getElementById("wishlist-items");
    const popup = document.getElementById("property-popup");
    const popupDetails = document.getElementById("popup-details");
    const searchForm = document.getElementById("search-form"); // Reference to the search form

    // Load initial data
    fetch("fetch-data.php")
        .then(response => response.json())
        .then(data => {
            renderProperties(data.properties, data.wishlist || []);
            renderWishlist(data.wishlist || []);
        })
        .catch(error => console.error("Error fetching data:", error));

    // Render property cards
    function renderProperties(properties) {
        propertiesContainer.innerHTML = "";

        if (properties.length === 0) {
            propertiesContainer.innerHTML = "<p>No properties found.</p>";
            return;
        }

        properties.forEach(property => {
            const card = document.createElement("div");
            card.classList.add("property-card");
            card.innerHTML = `
                <img src="${property.image_url}" alt="Property Image" style="width:100%; border-radius:8px;">
                <h3>${property.location}</h3>
                <button data-id="${property.id}" class="wishlist-btn">Add to Wishlist</button>
                <button class="details-btn" data-id="${property.id}">View Details</button>
            `;

            propertiesContainer.appendChild(card);
        });

        addWishlistListeners();
        addDetailsListeners();
    }

    // Render wishlist
    function renderWishlist(wishlist) {
        wishlistContainer.innerHTML = "";
        if (wishlist.length === 0) {
            wishlistContainer.innerHTML = "<p>No items in your wishlist.</p>";
            return;
        }

        wishlist.forEach(item => {
            const li = document.createElement("li");
            li.classList.add("wishlist-item");

            li.innerHTML = `
                <span>${item.location}</span>
                <button class="remove-wishlist-btn" data-id="${item.property_id}">X</button>
            `;
            wishlistContainer.appendChild(li);
        });
        addRemoveWishlistListeners();
    }

    // Add event listeners for search form
    searchForm.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent page reload
        console.log("Search button clicked!");

        // Get search and filter values
        const query = document.getElementById("search-input").value.trim();
        const bedrooms = document.getElementById("bedrooms-filter").value;
        const baths = document.getElementById("baths-filter").value;
        const minPrice = document.getElementById("min-price").value;
        const maxPrice = document.getElementById("max-price").value;

        // Build query string
        const params = new URLSearchParams({
            query,
            location,
            bedrooms,
            baths,
            min_price: minPrice || 0,
            max_price: maxPrice || Number.MAX_SAFE_INTEGER,
        });

        // Fetch filtered properties from the server
        fetch(`search-function.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                } else {
                    renderProperties(data.properties); // Update property cards
                }
            })
            .catch(error => console.error("Error fetching filtered properties:", error));
    });

    function addRemoveWishlistListeners() {
        document.querySelectorAll(".remove-wishlist-btn").forEach(button => {
            button.addEventListener("click", () => {
                const propertyId = button.dataset.id;

                // Remove request to the wishlist-handler
                fetch("wishlist-handler.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ propertyId, action: "remove" })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload wishlist 
                            fetch("fetch-data.php")
                                .then(response => response.json())
                                .then(data => {
                                    renderProperties(data.properties, data.wishlist || []);
                                    renderWishlist(data.wishlist || []);
                                });
                        } else {
                            console.error("Error removing from wishlist:", data.message);
                        }
                    })
                    .catch(error => console.error("Error removing from wishlist:", error));
            });
        });
    }

    function addWishlistListeners() {
        document.querySelectorAll(".wishlist-btn").forEach(button => {
            button.addEventListener("click", () => {
                const propertyId = button.dataset.id;
                // Add request to wishlist-handler
                fetch("wishlist-handler.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ propertyId, action: "add" })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload properties and wishlist dynamically
                            fetch("fetch-data.php")
                                .then(response => response.json())
                                .then(data => {
                                    renderProperties(data.properties, data.wishlist || []);
                                    renderWishlist(data.wishlist || []);
                                });
                        } else {
                            console.error("Error updating wishlist:", data.message);
                        }
                    })
                    .catch(error => console.error("Error updating wishlist:", error));
            });
        });
    }

    function addDetailsListeners() {
        document.querySelectorAll(".details-btn").forEach(button => {
            button.addEventListener("click", () => {
                const propertyId = button.dataset.id;

                fetch(`property-details.php?id=${propertyId}`)
                    .then(response => response.text())
                    .then(data => {
                        popupDetails.innerHTML = data;
                        popup.style.display = "flex";
                    })
                    .catch(error => console.error("Error fetching property details:", error));
            });
        });
    }

    // Close popup on clicking outside
    popup.addEventListener("click", (event) => {
        if (event.target === popup) {
            popup.style.display = "none";
        }
    });
});
