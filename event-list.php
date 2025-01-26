<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <link rel="stylesheet" href="css-js/main.css">
    <link rel="stylesheet" href="css-js/event-list.css">
</head>

<body>
    <?php include 'partials/header.php' ?>
    <?php include 'partials/side-bar.php' ?>

    <div class="container">
        <div class="contain">
            <div class="event-option">
                <div class="option-box">
                    <button class="option" data-page="ongoing-events">Ongoing Events</button>
                    <button class="option" data-page="upcoming-events">Upcoming Events</button>
                    <button class="option" data-page="past-events">Past Events</button>
                </div>
            </div>
            <div id="event-container">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'ongoing-events';
                include "partials/{$page}.php";
                ?>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        const buttons = document.querySelectorAll(".option");
        const eventContainer = document.getElementById("event-container");

        // Function to set the active button based on the current page
        const setActiveButton = (page) => {
            buttons.forEach(button => {
                button.classList.remove("active");
                if (button.getAttribute("data-page") === page) {
                    button.classList.add("active");
                }
            });
        };

        // Function to load content dynamically
        const loadPageContent = (page) => {
            fetch(`?page=${page}`)
                .then(response => response.text())
                .then(data => {
                    // Extract content from the container for faster replacement
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, "text/html");
                    const newContent = doc.querySelector("#event-container").innerHTML;

                    // Replace the current content with the new content
                    eventContainer.innerHTML = newContent;

                    // Update active button styling
                    setActiveButton(page);
                })
                .catch(error => console.error("Error loading content:", error));
        };

        // Add event listeners to buttons
        buttons.forEach(button => {
            button.addEventListener("click", function () {
                const page = this.getAttribute("data-page");

                // Update the URL without reloading the page
                history.pushState(null, "", `?page=${page}`);

                // Load the new page content
                loadPageContent(page);
            });
        });

        // Set the active button based on the current URL query parameter
        const params = new URLSearchParams(window.location.search);
        const currentPage = params.get("page") || "ongoing-events";
        setActiveButton(currentPage);

        // Handle browser navigation (back/forward buttons)
        window.addEventListener("popstate", () => {
            const params = new URLSearchParams(window.location.search);
            const page = params.get("page") || "ongoing-events";

            loadPageContent(page);
        });
    </script>

</body>

</html>