document.addEventListener("DOMContentLoaded", () => {
    const propertiesContainer = document.getElementById("properties");
    const wishlistContainer = document.getElementById("wishlist-items");
    const modal = document.getElementById("property-modal");
    const modalDetails = document.getElementById("modal-details");

    // Load initial data
    fetch("fetch-data.php")
        .then(response => response.json())
        .then(data => {
            renderProperties(data.properties, data.wishlist || []);
            renderWishlist(data.wishlist || []);
        })
        .catch(error => console.error("Error fetching data:", error));

    function renderProperties(properties) {
        propertiesContainer.innerHTML = "";
        if (properties.length === 0) {
            propertiesContainer.innerHTML = "<p>No properties found.</p>";
            return;
        }

        properties.forEach(property => {
            const card = document.createElement("div");
            card.classList.add("property-card");

            // Dynamically create card content
            card.innerHTML = `
                <img src="${property.image_url}" alt="Property Image" style="width:100%; border-radius:8px;">
                <h3>${property.location}</h3>
                <p>Price: $${property.price}</p>
                <p>${property.details}</p>
                <button data-id="${property.id}" class="wishlist-btn">Add to Wishlist</button>
                <button class="details-btn" data-id="${property.id}">View Details</button>
            `;

            propertiesContainer.appendChild(card);
        });

        addWishlistListeners();
        addDetailsListeners();
    }

    function renderWishlist(wishlist) {
        wishlistContainer.innerHTML = "";
        if (wishlist.length === 0) {
            wishlistContainer.innerHTML = "<p>No items in your wishlist.</p>";
            return;
        }
    
        wishlist.forEach(item => {
            const li = document.createElement("li");
            li.classList.add("wishlist-item");
    
            // Render wishlist item with a remove button
            li.innerHTML = `
                <span>Property ID: ${item}</span>
                <button class="remove-wishlist-btn" data-id="${item}">X</button>
            `;
    
            wishlistContainer.appendChild(li);
        });
    
        addRemoveWishlistListeners(); // Add event listeners to the remove buttons
    }

    function addRemoveWishlistListeners() {
        document.querySelectorAll(".remove-wishlist-btn").forEach(button => {
            button.addEventListener("click", () => {
                const propertyId = button.dataset.id;
    
                // Send a "remove" request to the wishlist-handler
                fetch("wishlist-handler.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    credentials: "include",
                    body: JSON.stringify({ propertyId, action: "remove" })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reload wishlist dynamically
                            fetch("fetch-data.php", {
                                credentials: "include"
                            })
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
                        modalDetails.innerHTML = data;
                        modal.style.display = "flex";
                    })
                    .catch(error => console.error("Error fetching property details:", error));
            });
        });
    }

    // Close modal on clicking outside
    modal.addEventListener("click", () => {
        modal.style.display = "none";
    });
});
