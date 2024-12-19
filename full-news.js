document.addEventListener("DOMContentLoaded", () => {
    // Sample News Data
    const allNewsData = [
        {
            id: 1,
            title: "Ashknights Win the Finals in Thrilling Fashion",
            date: "17/12/2024, 14:32",
            author: "Admin",
            image: "placeholder.jpg",
            content: `
                <p>The Ashknights pulled off a spectacular victory in the finals, beating their long-time rivals
                in front of a packed stadium. The win marked the culmination of months of hard work, determination,
                and team effort.</p>
                <p>Star player Kwaku Asare dominated the court with an impressive performance, scoring 30 points
                and securing his MVP title.</p>
            `
        },
        {
            id: 2,
            title: "Kwaku Asare Named Player of the Month",
            date: "01/01/2025, 10:15",
            author: "Coach",
            image: "player-month.jpg",
            content: `
                <p>After a stellar performance in the recent matches, Kwaku Asare has been named the Player of the Month.
                His leadership and determination on the court have inspired the entire team.</p>
                <p>"I'm honored to receive this award and will continue to give my best for the team," Asare commented.</p>
            `
        },
        {
            id: 3,
            title: "Ashknights Reveal New Jerseys for the Upcoming Season",
            date: "15/01/2025, 12:00",
            author: "Admin",
            image: "new-jersey.jpg",
            content: `
                <p>The Ashknights have revealed their new jerseys for the upcoming season. The design features a sleek
                black and white finish with modern elements to reflect the team's spirit.</p>
                <p>Fans can purchase the new jerseys online starting next week!</p>
            `
        },
        {
            id: 4,
            title: "Upcoming Tournament: Ashknights Set to Face Top Rivals",
            date: "20/01/2025, 09:00",
            author: "Sports Analyst",
            image: "tournament.jpg",
            content: `
                <p>The Ashknights are gearing up for their next big challenge as they face their top rivals in the 
                upcoming regional tournament. Fans are eagerly anticipating the showdown.</p>
                <p>Tickets for the tournament are selling fast. Don't miss out!</p>
            `
        }
    ];

    // Get News ID from URL
    const params = new URLSearchParams(window.location.search);
    const newsId = parseInt(params.get("id")) || 1; // Default to ID 1 if not provided

    // Find the selected news article
    const newsData = allNewsData.find(news => news.id === newsId);

    // Populate News Content
    if (newsData) {
        document.getElementById("news-title").textContent = newsData.title;
        document.getElementById("news-date").textContent = newsData.date;
        document.getElementById("news-author").textContent = newsData.author;
        document.getElementById("news-image").src = newsData.image;
        document.getElementById("news-content").innerHTML = newsData.content;
    } else {
        document.querySelector("main").innerHTML = "<p>News not found!</p>";
    }

    // Feedback Functionality
    const feedbackInput = document.getElementById("feedback-input");
    const feedbackContainer = document.getElementById("feedback-container");
    const submitFeedbackBtn = document.getElementById("submit-feedback");

    submitFeedbackBtn.addEventListener("click", () => {
        const feedbackText = feedbackInput.value.trim();

        if (feedbackText) {
            const feedbackItem = document.createElement("div");
            feedbackItem.classList.add("feedback-item");
            feedbackItem.innerHTML = `
                <p>${feedbackText}</p>
                <div class="menu">
                    <span class="menu-icon">⋮</span>
                    <div class="menu-options" style="display: none;">
                        <button class="btn edit-feedback">Edit</button>
                        <button class="btn delete-feedback">Delete</button>
                    </div>
                </div>
            `;

            // Toggle Menu
            const menuIcon = feedbackItem.querySelector(".menu-icon");
            menuIcon.addEventListener("click", () => {
                const options = feedbackItem.querySelector(".menu-options");
                options.style.display = options.style.display === "block" ? "none" : "block";
            });

            // Edit Feedback
            feedbackItem.querySelector(".edit-feedback").addEventListener("click", () => {
                const updatedFeedback = prompt("Edit your feedback:", feedbackText);
                if (updatedFeedback) feedbackItem.querySelector("p").textContent = updatedFeedback;
            });

            // Delete Feedback
            feedbackItem.querySelector(".delete-feedback").addEventListener("click", () => {
                feedbackItem.remove();
            });

            feedbackContainer.appendChild(feedbackItem);
            feedbackInput.value = "";
        } else {
            alert("Please enter feedback before submitting.");
        }
    });
});
