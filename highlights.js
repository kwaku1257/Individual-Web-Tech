document.addEventListener("DOMContentLoaded", () => {
    const uploadBtn = document.getElementById("upload-btn");
    const highlightsContainer = document.getElementById("highlights-container");
    let editMode = null; // Tracks the highlight being edited

    // Handle Uploading and Editing Highlights
    uploadBtn.addEventListener("click", () => {
        const videoFile = document.getElementById("video-upload").files[0];
        const title = document.getElementById("video-title").value.trim();
        const description = document.getElementById("video-description").value.trim();

        if (!title || !description) {
            alert("Please enter both a title and a description.");
            return;
        }

        if (editMode) {
            // Update Existing Highlight
            editMode.querySelector("h2").textContent = title;
            editMode.querySelector("p").textContent = description;
            if (videoFile) {
                const videoURL = URL.createObjectURL(videoFile);
                editMode.querySelector("source").src = videoURL;
                editMode.querySelector("video").load();
            }
            editMode = null; // Exit edit mode
            uploadBtn.textContent = "Upload";
        } else if (videoFile) {
            const videoURL = URL.createObjectURL(videoFile);

            // Create New Highlight Card
            const card = document.createElement("div");
            card.classList.add("highlight-card");
            card.innerHTML = `
                <video controls>
                    <source src="${videoURL}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <h2>${title}</h2>
                <p>${description}</p>
                <button class="options-btn">⋮</button>
                <div class="options-menu" style="display: none;">
                    <button class="btn edit-highlight">Edit</button>
                    <button class="btn delete-highlight">Delete</button>
                </div>
                <!-- Comment Section -->
                <div class="comments-section">
                    <h3>Comments</h3>
                    <div class="comments-container"></div>
                    <textarea class="comment-input" placeholder="Add a comment..." rows="2"></textarea>
                    <button class="btn add-comment">Submit</button>
                </div>
            `;

            highlightsContainer.appendChild(card);
            attachCardEvents(card);
        } else {
            alert("Please upload a video file.");
        }

        // Reset input fields
        document.getElementById("video-upload").value = "";
        document.getElementById("video-title").value = "";
        document.getElementById("video-description").value = "";
    });

    // Attach Events to Highlight Card (Edit, Delete, and Comment)
    function attachCardEvents(card) {
        const optionsBtn = card.querySelector(".options-btn");
        const optionsMenu = card.querySelector(".options-menu");
        const editBtn = card.querySelector(".edit-highlight");
        const deleteBtn = card.querySelector(".delete-highlight");

        // Toggle Options Menu
        optionsBtn.addEventListener("click", () => {
            optionsMenu.style.display = optionsMenu.style.display === "block" ? "none" : "block";
        });

        // Edit Highlight
        editBtn.addEventListener("click", () => {
            document.getElementById("video-title").value = card.querySelector("h2").textContent;
            document.getElementById("video-description").value = card.querySelector("p").textContent;
            editMode = card;
            document.getElementById("upload-btn").textContent = "Update";
        });

        // Delete Highlight
        deleteBtn.addEventListener("click", () => {
            card.remove();
        });

        // Comment Functionality
        addCommentFunctionality(card);
    }

    // Add Comment Functionality
    function addCommentFunctionality(card) {
        const addCommentBtn = card.querySelector(".add-comment");
        const commentInput = card.querySelector(".comment-input");
        const commentsContainer = card.querySelector(".comments-container");

        addCommentBtn.addEventListener("click", () => {
            const commentText = commentInput.value.trim();
            if (commentText) {
                const comment = document.createElement("div");
                comment.classList.add("comment");
                comment.innerHTML = `
                    <p>${commentText}</p>
                    <button class="options-btn">⋮</button>
                    <div class="options-menu" style="display: none;">
                        <button class="btn delete-comment">Delete</button>
                    </div>
                `;

                const optionsBtn = comment.querySelector(".options-btn");
                const optionsMenu = comment.querySelector(".options-menu");
                optionsBtn.addEventListener("click", () => {
                    optionsMenu.style.display = optionsMenu.style.display === "block" ? "none" : "block";
                });

                comment.querySelector(".delete-comment").addEventListener("click", () => {
                    comment.remove();
                });

                commentsContainer.appendChild(comment);
                commentInput.value = "";
            } else {
                alert("Please enter a comment.");
            }
        });
    }
});
