const stars=document.querySelectorAll('#starRating .star');
const ratingInput=document.getElementById('ratingValue');
let currentRating=0;

function highlightStars(rating){
    stars.forEach((s,i)=>s.classList.toggle('active', i<rating));
}

stars.forEach(star=>{
    star.addEventListener('mouseover',()=>highlightStars(parseInt(star.dataset.rating)));
    star.addEventListener('click',()=>{
        currentRating=parseInt(star.dataset.rating);
        ratingInput.value=currentRating;
        highlightStars(currentRating);
    });
    star.addEventListener('mouseleave',()=>highlightStars(currentRating));
});

const reviewText=document.getElementById('reviewText');
const charCount=document.getElementById('charCount');
reviewText.addEventListener('input',()=>charCount.textContent=reviewText.value.length);

const form=document.getElementById('reviewForm');
const reviewsList=document.getElementById('reviewsList');

form.addEventListener('submit',function(e){
    e.preventDefault();
    const rating=parseInt(ratingInput.value);
    const title=document.getElementById('reviewTitle').value.trim();
    const text=reviewText.value.trim();
    if(!rating){alert('Please select a rating');return;}
    if(!title){alert('Please provide a title');return;}
    if(!text){alert('Please write your feedback');return;}

    const card=document.createElement('div');
    card.className='review-card';
    card.setAttribute('data-rating',rating);
    let starHtml='';
    for(let i=1;i<=5;i++){starHtml+=`<i class="${i<=rating?'fas':'far'} fa-star"></i>`;}
    card.innerHTML=`
        <div class="review-header">
            <div class="reviewer-info">
                <div class="reviewer-avatar">U</div>
                <div class="reviewer-details">
                    <h4>You</h4>
                </div>
            </div>
            <div class="review-rating">${starHtml}</div>
        </div>
        <h5 style="margin-bottom:10px;font-weight:700;">${escapeHtml(title)}</h5>
        <p class="review-content">${escapeHtml(text)}</p>
    `;
    reviewsList.prepend(card);
    form.reset();
    currentRating=0;
    ratingInput.value=0;
    highlightStars(0);
    charCount.textContent=0;
});

function escapeHtml(str){return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');}

const filterTabs=document.querySelectorAll('.filter-tab');
filterTabs.forEach(tab=>tab.addEventListener('click',()=>{
    filterTabs.forEach(t=>t.classList.remove('active'));
    tab.classList.add('active');
    const filter=tab.dataset.filter;
    document.querySelectorAll('.review-card').forEach(card=>{
        const r=parseInt(card.dataset.rating);
        card.style.display=(filter==='all'||filter===r.toString())?'block':'none';
    });
}));

document.getElementById('btnLoadMore').addEventListener('click',function(){
    this.disabled=true;
    this.innerHTML='<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
    setTimeout(()=>{
        this.innerHTML='<i class="fas fa-chevron-down me-2"></i>Load More';
        this.disabled=false;
        alert('No more demo reviews. In production, this would fetch from server.');
    },900);
});
