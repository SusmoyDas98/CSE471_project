// ⭐ STAR RATING LOGIC
const stars = document.querySelectorAll('#starRating .star');
const ratingInput = document.getElementById('ratingValue');
let currentRating = 0;

function highlightStars(rating) {
    stars.forEach((s, i) => s.classList.toggle('active', i < rating));
}

stars.forEach(star => {
    star.addEventListener('mouseover', () => highlightStars(parseInt(star.dataset.rating)));
    star.addEventListener('click', () => {
        currentRating = parseInt(star.dataset.rating);
        ratingInput.value = currentRating;
        highlightStars(currentRating);
    });
    star.addEventListener('mouseleave', () => highlightStars(currentRating));
});

// ⭐ CHARACTER COUNT TRACKER
const reviewText = document.getElementById('reviewText');
const charCount = document.getElementById('charCount');

reviewText.addEventListener('input', () => {
    charCount.textContent = reviewText.value.length;
});

// ⭐ FORM SUBMISSION (NO PREVENT DEFAULT → LARAVEL WILL SUBMIT)
const form = document.getElementById('reviewForm');

form.addEventListener('submit', function () {
    const rating = parseInt(ratingInput.value);
    const title = document.getElementById('reviewTitle').value.trim();
    const text = reviewText.value.trim();

    if (!rating) {
        alert('Please select a rating');
        event.preventDefault();
        return;
    }

    if (!title) {
        alert('Please provide a title');
        event.preventDefault();
        return;
    }

    if (!text) {
        alert('Please write your feedback');
        event.preventDefault();
        return;
    }

    // ⭐ Do NOT reset the form — let Laravel handle it
});

// ⭐ SANITIZATION
function escapeHtml(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// ⭐ FILTER TABS
const filterTabs = document.querySelectorAll('.filter-tab');
filterTabs.forEach(tab => tab.addEventListener('click', () => {
    filterTabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    const filter = tab.dataset.filter;
    document.querySelectorAll('.review-card').forEach(card => {
        const r = parseInt(card.dataset.rating);
        card.style.display = (filter === 'all' || filter === r.toString()) ? 'block' : 'none';
    });
}));

// ⭐ LOAD MORE BUTTON
document.getElementById('btnLoadMore').addEventListener('click', function () {
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';

    setTimeout(() => {
        this.innerHTML = '<i class="fas fa-chevron-down me-2"></i>Load More';
        this.disabled = false;
        alert('No more demo reviews. In production, this would fetch from server.');
    }, 900);
});
