document.addEventListener("DOMContentLoaded", () => {
    const highlightsContainer = document.getElementById("highlights-container");
    const matchesContainer = document.getElementById("matches-container");

    let editHighlightMode = null;
    let editMatchMode = null;

    // Add Highlight
    document.getElementById("add-highlight-btn").addEventListener("click", () => {
        const imageInput = document.getElementById("highlight-image").files[0];
        const title = document.getElementById("highlight-title").value.trim();
        const description = document.getElementById("highlight-description").value.trim();

        if (imageInput && title && description) {
            const imageURL = URL.createObjectURL(imageInput);

            if (editHighlightMode) {
                // Update existing highlight
                editHighlightMode.querySelector(".video-thumbnail img").src = imageURL;
                editHighlightMode.querySelector(".video-details h3").textContent = title;
                editHighlightMode.querySelector(".video-details p").textContent = description;
                editHighlightMode = null;
            } else {
                // Add new highlight
                const card = createCard("highlight", imageURL, title, description);
                highlightsContainer.appendChild(card);
                attachEvents(card, "highlight");
            }

            clearInputs("highlight");
        } else {
            alert("Please provide all highlight details.");
        }
    });

    // Add Match
    document.getElementById("add-match-btn").addEventListener("click", () => {
        const imageInput = document.getElementById("match-image").files[0];
        const title = document.getElementById("match-title").value.trim();
        const description = document.getElementById("match-description").value.trim();
        const date = document.getElementById("match-date").value;

        if (imageInput && title && description && date) {
            const imageURL = URL.createObjectURL(imageInput);

            if (editMatchMode) {
                // Update existing match
                editMatchMode.querySelector(".placeholder-image img").src = imageURL;
                editMatchMode.querySelector("h3").textContent = title;
                editMatchMode.querySelector(".match-description").textContent = description;
                editMatchMode.querySelector(".match-date").textContent = `Date: ${new Date(date).toLocaleString()}`;
                editMatchMode = null;
            } else {
                // Add new match
                const card = createCard("match", imageURL, title, description, date);
                matchesContainer.appendChild(card);
                attachEvents(card, "match");
            }

            clearInputs("match");
        } else {
            alert("Please provide all match details.");
        }
    });

    // Create Card Function
    function createCard(type, image, title, description, date = "") {
        const card = document.createElement("div");
        card.classList.add(type === "highlight" ? "video-card" : "card");
        card.innerHTML = type === "highlight" ? `
            <div class="video-thumbnail">
                <img src="${image}" alt="${title}">
            </div>
            <div class="video-details">
                <h3>${title}</h3>
                <p>${description}</p>
                <button class="btn edit-btn">Edit</button>
                <button class="btn delete-btn">Delete</button>
            </div>
        ` : `
            <div class="placeholder-image">
                <img src="${image}" alt="${title}">
            </div>
            <h3>${title}</h3>
            <p class="match-description">${description}</p>
            <p class="match-date">Date: ${new Date(date).toLocaleString()}</p>
            <button class="btn edit-btn">Edit</button>
            <button class="btn delete-btn">Delete</button>
        `;
        return card;
    }

    // Attach Edit and Delete Events
    function attachEvents(card, type) {
        card.querySelector(".edit-btn").addEventListener("click", () => {
            if (type === "highlight") {
                document.getElementById("highlight-title").value = card.querySelector("h3").textContent;
                document.getElementById("highlight-description").value = card.querySelector("p").textContent;
                editHighlightMode = card;
            } else {
                document.getElementById("match-title").value = card.querySelector("h3").textContent;
                document.getElementById("match-description").value = card.querySelector(".match-description").textContent;
                editMatchMode = card;
            }
        });

        card.querySelector(".delete-btn").addEventListener("click", () => card.remove());
    }

    // Clear Input Fields
    function clearInputs(type) {
        document.getElementById(`${type}-image`).value = "";
        document.getElementById(`${type}-title`).value = "";
        document.getElementById(`${type}-description`).value = "";
        if (type === "match") document.getElementById("match-date").value = "";
    }
});
