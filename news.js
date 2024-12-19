const newsForm = document.getElementById("news-form");
const newsContainer = document.getElementById("news-container");
let editMode = null;

// Handle News Submission
newsForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const title = document.getElementById("news-title").value.trim();
    const description = document.getElementById("news-description").value.trim();
    const imageFile = document.getElementById("news-image").files[0];

    if (editMode) {
        editMode.querySelector("h2").textContent = title;
        editMode.querySelector("p").textContent = description;
        if (imageFile) {
            const newImageURL = URL.createObjectURL(imageFile);
            editMode.querySelector("img").src = newImageURL;
        }
        editMode = null; // Exit edit mode
    } else {
        const newsCard = document.createElement("div");
        newsCard.classList.add("news-card");

        const imageURL = imageFile ? URL.createObjectURL(imageFile) : "placeholder.jpg";
        newsCard.innerHTML = `
            <div class="news-image">
                <img src="${imageURL}" alt="${title}">
            </div>
            <div class="news-content">
                <h2>${title}</h2>
                <p>${description}</p>
                <a href="full-news.html" class="btn read-more">Read More</a>
                <button class="btn edit-news">Edit</button>
                <button class="btn delete-news">Delete</button>
            </div>
        `;

        attachEvents(newsCard);
        newsContainer.appendChild(newsCard);
    }

    newsForm.reset();
});

function attachEvents(card) {
    card.querySelector(".delete-news").addEventListener("click", () => card.remove());

    card.querySelector(".edit-news").addEventListener("click", () => {
        editMode = card;
        document.getElementById("news-title").value = card.querySelector("h2").textContent;
        document.getElementById("news-description").value = card.querySelector("p").textContent;
    });
}

// Attach events to existing cards
document.querySelectorAll(".news-card").forEach(attachEvents);


