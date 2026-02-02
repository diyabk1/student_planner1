
function searchTasks() {
    const input = document.getElementById('searchInput').value;
    const list = document.getElementById('taskList');

    fetch('search.php?q=' + encodeURIComponent(input))
        .then(response => response.text())
        .then(data => list.innerHTML = data)
        .catch(error => console.error('Search error:', error));
}


function filterTasks(status) {
    const taskCards = document.querySelectorAll('.task-card');
    const filterButtons = document.querySelectorAll('.filter-btn');

    // Update active button
    filterButtons.forEach(btn => {
        btn.classList.toggle('active', btn.dataset.filter === status);
    });

    // Filter cards
    taskCards.forEach(card => {
        const statusText = card.querySelector('strong');
        const cardStatus = statusText ? statusText.textContent.toLowerCase() : '';

        if (status === 'all') {
            card.style.display = 'block';
        } else if (status === 'completed' && cardStatus.includes('completed')) {
            card.style.display = 'block';
        } else if (status === 'pending' && cardStatus.includes('pending')) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}