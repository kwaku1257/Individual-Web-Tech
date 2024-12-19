document.addEventListener("DOMContentLoaded", () => {
    const addMatchBtn = document.getElementById("add-match-btn");
    const matchesContainer = document.getElementById("matches-container");

    let editMode = null; // Track the card currently being edited

    // Handle Adding or Updating Matches
    addMatchBtn.addEventListener("click", () => {
        const matchImage = document.getElementById("match-image").files[0];
        const matchTitle = document.getElementById("match-title").value.trim();
        const matchCourt = document.getElementById("match-court").value.trim();
        const matchTime = document.getElementById("match-time").value;

        if (matchTitle && matchCourt && matchTime) {
            if (editMode) {
                // Update existing match card
                editMode.querySelector("h3").textContent = matchTitle;
                editMode.querySelector(".match-court").textContent = `Court: ${matchCourt}`;
                editMode.querySelector(".match-time").textContent = `Time: ${new Date(matchTime).toLocaleString()}`;

                if (matchImage) {
                    const newMatchURL = URL.createObjectURL(matchImage);
                    editMode.querySelector("img").src = newMatchURL;
                }
                editMode = null; // Exit edit mode
                addMatchBtn.textContent = "Add Match";
            } else {
                // Create a new match card
                const matchURL = matchImage ? URL.createObjectURL(matchImage) : "placeholder.jpg";

                const matchCard = document.createElement("div");
                matchCard.classList.add("match-card");
                matchCard.innerHTML = `
                    <img src="${matchURL}" alt="Match Image">
                    <h3>${matchTitle}</h3>
                    <p class="match-court"><strong>Court:</strong> ${matchCourt}</p>
                    <p class="match-time"><strong>Time:</strong> ${new Date(matchTime).toLocaleString()}</p>
                    <button class="options-btn">⋮</button>
                    <div class="options-menu" style="display: none;">
                        <button class="btn edit-match">Edit</button>
                        <button class="btn delete-match">Delete</button>
                    </div>
                `;
                matchesContainer.appendChild(matchCard);
                attachEventsToMatchCard(matchCard);
            }

            // Clear input fields
            resetForm();
        } else {
            alert("Please fill in all fields.");
        }
    });

    // Attach Edit and Delete Events to Match Card
    function attachEventsToMatchCard(card) {
        const optionsBtn = card.querySelector(".options-btn");
        const optionsMenu = card.querySelector(".options-menu");
        const editBtn = card.querySelector(".edit-match");
        const deleteBtn = card.querySelector(".delete-match");

        // Toggle Options Menu
        optionsBtn.addEventListener("click", () => {
            optionsMenu.style.display = optionsMenu.style.display === "block" ? "none" : "block";
        });

        // Edit Match
        editBtn.addEventListener("click", () => {
            const title = card.querySelector("h3").textContent;
            const court = card.querySelector(".match-court").textContent.replace("Court: ", "").trim();
            const time = new Date(card.querySelector(".match-time").textContent.replace("Time: ", "")).toISOString().slice(0, 16);

            document.getElementById("match-title").value = title;
            document.getElementById("match-court").value = court;
            document.getElementById("match-time").value = time;

            editMode = card;
            addMatchBtn.textContent = "Update Match";
        });

        // Delete Match
        deleteBtn.addEventListener("click", () => {
            card.remove();
        });
    }

    // Reset Input Fields
    function resetForm() {
        document.getElementById("match-image").value = "";
        document.getElementById("match-title").value = "";
        document.getElementById("match-court").value = "";
        document.getElementById("match-time").value = "";
    }
});
