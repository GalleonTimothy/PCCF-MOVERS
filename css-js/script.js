document.getElementById('toggle-btn').addEventListener('click', function() {
    const sideBar = document.querySelector('.side-bar');
    const container = document.querySelector('.container');

    // Toggle sidebar visibility
    sideBar.classList.toggle('closed');
    container.classList.toggle('shifted');
});
