// // Log all clicks for debugging (optional)
// document.addEventListener('click', function(event) {
//     console.log('Clicked element:', event.target);
// });

// ⭐ USER UI ONLY: STAR RATING LOGIC
const starContainer = document.getElementById('starRating');
const ratingInput = document.getElementById('ratingValue');

if (starContainer && ratingInput) {
    const stars = starContainer.querySelectorAll('.star');
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
}

// ⭐ USER UI ONLY: CHARACTER COUNT TRACKER
const reviewText = document.getElementById('reviewText');
const charCount = document.getElementById('charCount');

if (reviewText && charCount) {
    reviewText.addEventListener('input', () => {
        charCount.textContent = reviewText.value.length;
    });
}

// ⭐ SANITIZATION (safe to keep globally)
function escapeHtml(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}



// Submit handler — POST to API and prepend result without reload
// document.getElementById('reviewForm').addEventListener('submit', async function (event) {
//     event.preventDefault();
const reviewForm = document.getElementById('reviewForm');

if (reviewForm) {
    
    reviewForm.addEventListener('submit', async function (event) {
        event.preventDefault();
    const rating = parseInt(document.getElementById('ratingValue').value || 0, 10);
    const review_text = document.getElementById('reviewText').value.trim();

    if (!rating || rating < 1) { alert('Please select a rating'); return; }
    if (!review_text) { alert('Please write your feedback'); return; }

    try {
        const res = await fetch('/api/website_reviews_post', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ review_text, rating })
        });

        const data = await res.json().catch(() => ({}));

        if (!res.ok) {
            if (data && data.errors) {
                const msgs = Object.values(data.errors).flat().join('\n');
                alert('Validation error:\n' + msgs);
                return;
            }
            alert('Submission failed');
            return;
        }

        if (!data.status) {
            alert(data.message || 'Submission failed');
            return;
        }

        // prepend the new review (server should return created review)
        const review = data.review;
<<<<<<< HEAD
        console.log(review);
=======
>>>>>>> afia-branch
        const reviewsList = document.getElementById('reviewsList');
        const placeholder = reviewsList.querySelector('p');
        if (placeholder && placeholder.textContent.includes('No reviews yet')) placeholder.remove();

<<<<<<< HEAD
        const name = escapeHtml(review.username || 'Anonymous');
=======
        const name = escapeHtml(review.user_name || 'Anonymous');
>>>>>>> afia-branch
        const message = escapeHtml(review.message || review.review_text || review_text);
        const starsCount = parseInt(review.rating || rating, 10) || 0;
        let starsHtml = '';
        for (let i = 0; i < starsCount; i++) starsHtml += '<i class="fas fa-star"></i>';

        const card = document.createElement('div');
        card.className = 'review-card';
        card.dataset.rating = starsCount;
        card.innerHTML = `
        <div id = "reviewsList" class="new_review">
            <div class="review-header" >
                <div class="reviewer-info">
                    <div class="reviewer-avatar">${name.charAt(0) || 'U'}</div>
                    <div class="reviewer-details"><h4>${name}</h4></div>
                </div>
                <div class="review-rating">${starsHtml}</div>
            </div>
            <p class="review-content">${message}</p>
        </div>
        `;

        reviewsList.insertAdjacentElement('afterbegin', card);


        // reset form
        document.getElementById('reviewText').value = '';
        document.getElementById('charCount').textContent = '0';
        ratingInput.value = 0; currentRating = 0; highlightStars(0);

    } catch (err) {
        console.error(err);
        alert('Something went wrong. Please try again.');
    }
    const writeReviewSection = document.querySelector('.write-review-section');

    if (writeReviewSection) {
        writeReviewSection.innerHTML = '';

        const alertDiv = document.createElement('div');
        alertDiv.className = 'already_have';
        alertDiv.innerHTML = `
            <strong>Thank you!</strong> 😃 <br>
            For submitting a review. We appreciate your feedback.
        `;

        // Insert the thank-you note
        writeReviewSection.appendChild(alertDiv);
    }    
});
}
document.addEventListener('click', function(event) {

    //  HIDE / UNHIDE 
    const hideButton = event.target.closest(".btn.btn-outline-secondary.btn-sm.hide");
    if (hideButton) {
        console.log('hidding started');
        const messageID = hideButton.getAttribute('data-message-id');
        const state = hideButton.dataset.state || 'visible'; // current state
        console.log(state);

        const newLabel = state === 'visible' ? 'Hidden' : 'Visible';
        console.log(newLabel);


        fetch(`/api/website_reviews_update/${messageID}/${newLabel}`, {
            method: "POST",
            headers: { 'Content-Type': "application/json" }
        })
        .then(response => response.json())
        .then(response => {
            console.log(`Review ${messageID} updated: ${newLabel}`);

            // Update button state and text
            hideButton.dataset.state = newLabel === 'Hidden' ? 'hidden' : 'visible';
            hideButton.innerHTML = newLabel === 'Hidden'
                ? "<i class='fas fa-eye-slash summary-icon'></i> Unhide"
                : "<i class='fas fa-eye summary-icon'></i> Hide Selected";

            // Update review card style for Hide/Unhide
            const messageCard = document.querySelector(
                `#visible_review-${messageID}, #hidden_review-${messageID}, #deleted_review-${messageID}`
            );

            if (messageCard) {
                if (newLabel === 'Hidden') {
                    messageCard.style.backgroundColor = "gainsboro";
                    messageCard.style.color = "darkgray";
                } else { // Visible
                    messageCard.style.backgroundColor = "white";
                    messageCard.style.color = "black";
                }
            }


            // Update hiddenReviews counter
            const hiddenCounter = document.querySelector(`#hiddenReviews`);
            let val = parseInt(hiddenCounter.innerText, 10);
            if (isNaN(val)) val = 0;
            hiddenCounter.innerText = newLabel === 'Hidden' ? val + 1 : val - 1;
        })
        .catch(error => console.error('Error:', error));
    }

    // DELETE / RESTORE 
    const deleteButton = event.target.closest(".btn.btn-outline-danger.btn-sm.delete");
    if (deleteButton) {
        const messageID = deleteButton.getAttribute('data-message-id');
        const state = deleteButton.dataset.state || 'visible'; // current state
        const newLabel = state === 'visible' ? 'Deleted' : 'Visible';

        fetch(`/api/website_reviews_update/${messageID}/${newLabel}`, {
            method: "POST",
            headers: { 'Content-Type': "application/json" }
        })
        .then(response => response.json())
        .then(response => {
            console.log(`Review ${messageID} updated: ${newLabel}`);

            // Update button state and text
            deleteButton.dataset.state = newLabel === 'Deleted' ? 'deleted' : 'visible';
            deleteButton.innerHTML = newLabel === 'Deleted'
                ? "<i class='fas fa-undo'></i> Restore"
                : "<i class='fas fa-trash'></i> Delete Selected";


            // Update review card style for Delete/Restore
            const messageCard = document.querySelector(
                `#visible_review-${messageID}, #hidden_review-${messageID}, #deleted_review-${messageID}`
            );
            
            if (messageCard) {
                if (newLabel === 'Deleted') {
                    messageCard.style.backgroundColor = "#f8d7da"; // light red
                    messageCard.style.color = "#721c24";           // dark red
                } else { // Visible
                    messageCard.style.backgroundColor = "white";
                    messageCard.style.color = "black";
                }
            }
            
            // Update deletedReviews counter
            const deletedCounter = document.querySelector(`#deletedReviews`);
            let val = parseInt(deletedCounter.innerText, 10);
            if (isNaN(val)) val = 0;
            deletedCounter.innerText = newLabel === 'Deleted' ? val + 1 : val - 1;
            
        })
        .catch(error => console.error('Error:', error));
    }

});

document.addEventListener('click', function (event) {

    const ShowDeleted = event.target.closest(".summary-item.summary-muted.delete");

    if (!ShowDeleted) return;

    console.log('Showing deleted reviews…');

    const state = "Deleted";

    fetch(`/api/website_reviews_get/${state}`, {
        method: "GET",
        headers: {
            "Accept": "application/json"
        }
    })
    .then(res => res.json())
    .then(data => {

        const reviewsList = document.getElementById('reviewsList');
        reviewsList.innerHTML = '';

        if (!data || !data.reviews || data.reviews.length === 0) {
            reviewsList.innerHTML = `<p>No deleted reviews.</p>`;
            return;
        }

        data.reviews.forEach(review => {

            const stars = Array(review.rating)
                .fill('<i class="fas fa-star"></i>')
                .join('');

            reviewsList.innerHTML += `
                <div class="review-card" id="deleted_review-${review.id}">
                    
                    <div class="review-header">
                        <div class="reviewer-info">
<<<<<<< HEAD
                            <div class="reviewer-avatar">${review.username?.charAt(0) ?? 'U'}</div>
                            <div class="reviewer-details">
                                <h4>${review.username}</h4>
=======
                            <div class="reviewer-avatar">${review.user_name?.charAt(0) ?? 'U'}</div>
                            <div class="reviewer-details">
                                <h4>${review.user_name}</h4>
>>>>>>> afia-branch
                            </div>
                        </div>

                        <div class="review-rating">
                            ${stars}
                        </div>
                    </div>

                    <p class="review-content">${review.message}</p>

                    <div class="admin-panel mb-4 p-3 border rounded bg-light">
                        <h5 class="mb-3">
                            <i class="fas fa-user-shield me-2"></i>Admin Controls
                        </h5>

                        <div class="d-flex flex-wrap gap-2">

                            <button 
                                class="btn btn-outline-danger btn-sm delete"
                                id="deleteSelected-${review.id}"
                                data-message-id="${review.id}"
                                data-state="deleted">
                                <i class="fas fa-undo"></i> Restore
                            </button>

                        </div>
                    </div>

                </div>
            `;
        });

    })
    .catch(err => console.error(err));
});


document.addEventListener('click', function(event) {

    const ShowHidden = event.target.closest(".summary-item.summary-muted");

    // Only trigger if it's the Hidden box
    if (ShowHidden && ShowHidden.querySelector('#hiddenReviews')) {

        console.log('showing hidden');

        const state = "Hidden";

        fetch(`/api/website_reviews_get/${state}`)
        .then(res => res.json())
        .then(data => {

            const reviewsList = document.getElementById('reviewsList');
            reviewsList.innerHTML = ''; // clear previous reviews

            data.reviews.forEach(review => {

                let hideButtonHtml = '';
                if (review.label === 'Hidden') {
                    hideButtonHtml = `
                        <button class="btn btn-outline-secondary btn-sm hide" 
                                id="hideSelected-${review.id}" 
                                data-message-id="${review.id}" 
                                data-state="hidden">
                            <i class='fas fa-eye-slash summary-icon'></i> Unhide
                        </button>`;
                } else {
                    hideButtonHtml = `
                        <button class="btn btn-outline-secondary btn-sm hide" 
                                id="hideSelected-${review.id}" 
                                data-message-id="${review.id}" 
                                data-state="visible">
                            <i class='fas fa-eye summary-icon'></i> Hide Selected
                        </button>`;
                }

<<<<<<< HEAD
               
                console.log(review);
=======
                // let deleteButtonHtml = '';
                // if (review.label === 'Deleted') {
                //     deleteButtonHtml = `
                //         <button class="btn btn-outline-danger btn-sm delete" 
                //                 id="deleteSelected-${review.id}" 
                //                 data-message-id="${review.id}" 
                //                 data-state="deleted">
                //             <i class='fas fa-undo'></i> Restore
                //         </button>`;
                // } else {
                //     deleteButtonHtml = `
                //         <button class="btn btn-outline-danger btn-sm delete" 
                //                 id="deleteSelected-${review.id}" 
                //                 data-message-id="${review.id}" 
                //                 data-state="visible">
                //             <i class='fas fa-trash'></i> Delete Selected
                //         </button>`;
                // }

>>>>>>> afia-branch
                const reviewHtml = `
                <div class="review-card" id="hidden_review-${review.id}">
                    <div class="review-header">
                        <div class="reviewer-info">
<<<<<<< HEAD
                            <div class="reviewer-avatar">${review.username.charAt(0) || 'U'}</div>
                            <div class="reviewer-details"><h4>${review.username}</h4></div>
=======
                            <div class="reviewer-avatar">${review.user_name.charAt(0) || 'U'}</div>
                            <div class="reviewer-details"><h4>${review.user_name}</h4></div>
>>>>>>> afia-branch
                        </div>
                        <div class="review-rating">${'★'.repeat(review.rating)}</div>
                    </div>
                    <p class="review-content">${review.message}</p>

                    <div class="admin-panel mb-4 p-3 border rounded bg-light">
                        <h5 class="mb-3"><i class="fas fa-user-shield me-2"></i>Admin Controls</h5>
                        <div class="d-flex flex-wrap gap-2">
                            ${hideButtonHtml}

                        </div>
                    </div>
                </div>`;

                reviewsList.innerHTML += reviewHtml;
            });
        });
    }
});
document.addEventListener('click', function(event) {
    const showAll = event.target.closest(".summary-item.home");

    if (showAll) {
        location.reload(); // just refreshes the page
    }
});
