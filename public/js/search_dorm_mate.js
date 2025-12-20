document.addEventListener("click", function(e) {
    if (e.target.closest(".btn-ai-mode")) {
        const button = e.target.closest(".btn-ai-mode");
        const user_id = button.dataset.userId;
        console.log("AI button clicked! user_id =", user_id); 

        activateAIMode(user_id);
        const target = document.getElementById("come_here");
        if(target){
            target.scrollIntoView({ behavior: "smooth" });
        }        
    }
});

document.addEventListener("click", function(e){
    if(e.target.closest('#apply_search_btn')){
        const button = e.target.closest("#apply_search_btn");
        const user_id  =  button.dataset.userId;
        console.log("search button clicked");
        filter_users(user_id);
        const target = document.getElementById("come_here");
        if(target){
            target.scrollIntoView({ behavior: "smooth" });
        }        
    }
    if(e.target.closest('#apply_filter_btn')){
        const button = e.target.closest("#apply_filter_btn");
        const user_id  =  button.dataset.userId;
        console.log("filter button clicked");
        filter_users(user_id);
        const target = document.getElementById("come_here");
        if(target){
            target.scrollIntoView({ behavior: "smooth" });
        }        
    }    
});

async function filter_users(user_id){
    console.log("filter_user function called");
    const name = document.getElementById("manualSearch")?.value ?? "" ;
    const min_age = document.getElementById("filterAgeMin")?.value ?? "" ;
    const max_age = document.getElementById("filterAgeMax")?.value ?? "" ;
    const gender =  document.getElementById("filterGender")?.value ?? "" ;
    const dorm_id = document.getElementById('filterDorm')?.value ?? "" ;
    const filter_values = {'min_age':min_age, "max_age":max_age, "gender":gender, "dorm_id":dorm_id, "name":name};
    const params = new URLSearchParams(filter_values).toString();
      try {
        console.log('calling the api');
        const response = await fetch(`/api/get_filtered_suggestions_dorm_mate/${user_id}?${params}`, {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        });

        if (!response.ok) {
            console.log('error detected');
            const errorData = await response.json();
            console.log(errorData.message);
            throw new Error(errorData.message || "Something went wrong");
        }
        console.log('called success the api');

        const best_matches = await response.json();
        console.log(best_matches);
        console.log(best_matches.length);

        const roommate_show_place = document.querySelector(".results-container");
        console.log(roommate_show_place);

        if (best_matches.length > 0) {
            roommate_show_place.innerHTML = `
            `;
        roommate_show_place.innerHTML = best_matches.map(match => `
            <div class="suggested_roommate card p-3 mb-4 shadow-sm d-flex flex-column" id="come_here">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="dorm_mate_name mb-0"><a id="id-hyperlink" href = '/user_profile/${match.user_id}' target='_blank'>${match.name}</a></h5>
                </div>
                <div class="dorm_mate_email text-secondary mb-2">
                    <i class="fas fa-envelope me-1"></i>${match.email}
                </div>
                <div class="common-section mb-0">
                    <i class="fa-solid fa-house me-1"></i>
                    <span class="dorm"><strong>${match.dorm}</strong></span>
                </div>

                <hr>
                
                <div class="common-section mb-1">
                    <strong>Age:</strong>
                    
                        ${match.age}
                    
                </div>                

                <div class="common-section mb-2">
                    <strong>Gender:</strong>
                        ${match.gender}
                    
                </div>                

                <div class="common-section mb-3">
                    <strong>Common Hobbies:</strong>
                    <div class="d-flex flex-wrap mt-1">
                        ${match.common_hobbies.join(",")}
                    </div>
                </div>
                
                <div class="common-section mb-4">
                    <strong>Common Preferences:</strong>
                    <div class="d-flex flex-wrap mt-1">
                        ${match.common_preferences.join(",")}
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-sm">Chat</button>
                </div>
            </div>
        `).join('');

        } else {
            roommate_show_place.innerHTML = `
                <div class="suggested_roommate" id="dorm_mate_found_none">
                    No matches found. 
                </div>
            `;
        }
       console.log("try block ends here");


    }catch (error) {
        const roommate_show_place = document.querySelector(".results-container");
        roommate_show_place.innerHTML = `
            <div class="suggested_roommate" id="dorm_mate_not_found">
                Something went wrong, please try again.
            </div>
        `;
       console.log("catch block ends here");

        console.error(error);
    }
}

async function activateAIMode(user_id) {
    console.log("activate-ai function called");
    try {
        const response = await fetch(`/api/get_auto_suggestions_dorm_mate/${user_id}`, {
            method: "GET",
            headers: {
                "Accept": "application/json"
            }
        });

        if (!response.ok) {
            const errorData = await response.json();
            console.log(errorData.message);
            throw new Error(errorData.message || "Something went wrong");
        }

        const best_matches = await response.json();
        console.log(best_matches);
        console.log(best_matches.length);

        const roommate_show_place = document.querySelector(".results-container");
        console.log(roommate_show_place);

        if (best_matches.length > 0) {
            roommate_show_place.innerHTML = `
            `;
        // roommate_show_place.innerHTML = best_matches.map(match => `
        //     <div class="suggested_roommate card p-3 mb-4 shadow-sm d-flex flex-column" id="dorm_mate_found">
        //         <div class="d-flex justify-content-between align-items-center mb-2">
        //             <h5 class="dorm_mate_name mb-0"><a id="id-hyperlink" href = '/user_profile/${match.user_id}' target='_blank'>${match.name}</a></h5>
        //             <span class="badge bg-success dorm_mate_percentage">${match.matching_percentage.toFixed(0)}%</span>
        //         </div>
        //         <div class="dorm_mate_email text-secondary mb-2">
        //             <i class="fas fa-envelope me-1"></i>${match.email}
        //         </div>
                
        //         <div class="common-section mb-2">
        //             <strong>Common Hobbies:</strong>
        //             <div class="d-flex flex-wrap mt-1">
        //                 ${match.common_hobbies}
        //             </div>
        //         </div>
                
        //         <div class="common-section mb-3">
        //             <strong>Common Preferences:</strong>
        //             <div class="d-flex flex-wrap mt-1">
        //                 ${match.common_preferences}
        //             </div>
        //         </div>
                
        //         <div class="d-flex justify-content-end">
        //             <button class="btn btn-primary btn-sm">Chat</button>
        //         </div>
        //     </div>
        // `).join('');
        roommate_show_place.innerHTML = best_matches.map(match => `
            <div class="suggested_roommate card p-3 mb-4 shadow-sm d-flex flex-column" id="dorm_mate_found">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="dorm_mate_name mb-0"><a id="id-hyperlink" href = '/user_profile/${match.user_id}' target='_blank'>${match.name}</a></h5>
                    <span class="badge bg-success dorm_mate_percentage">${match.matching_percentage.toFixed(0)}%</span>
                </div>
                <div class="dorm_mate_email text-secondary mb-2">
                    <i class="fas fa-envelope me-1"></i>${match.email}
                </div>
                <div class="common-section mb-0">
                    <i class="fa-solid fa-house me-1"></i>
                    <span class="dorm"><strong>${match.dorm}</strong></span>
                </div>

                <hr>
                
                <div class="common-section mb-1">
                    <strong>Age:</strong>
                    
                        ${match.age}
                    
                </div>                

                <div class="common-section mb-2">
                    <strong>Gender:</strong>
                        ${match.gender}
                    
                </div>                

                <div class="common-section mb-3">
                    <strong>Common Hobbies:</strong>
                    <div class="d-flex flex-wrap mt-1">
                        ${match.common_hobbies.join(",")}
                    </div>
                </div>
                
                <div class="common-section mb-4">
                    <strong>Common Preferences:</strong>
                    <div class="d-flex flex-wrap mt-1">
                        ${match.common_preferences.join(",")}
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-sm">Chat</button>
                </div>
            </div>
        `).join('');        

        } else {
            roommate_show_place.innerHTML = `
                <div class="suggested_roommate" id="dorm_mate_found_none">
                    No matches found. Please update your profile for better suggestions.
                </div>
            `;
        }
       console.log("try block ends here");


    } catch (error) {
        const roommate_show_place = document.querySelector(".results-container");
        roommate_show_place.innerHTML = `
            <div class="suggested_roommate" id="dorm_mate_not_found">
                Something went wrong, please try again.
            </div>
        `;
       console.log("catch block ends here");

        console.error(error);
    }
}


