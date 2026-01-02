var map = L.map('map');
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
let marker;
function placeMarker(latlng){
    if(marker){
        marker.setLatLng(latlng);

    }else{
        marker = L.marker(latlng).addTo(map);
    }

    map.setView(latlng,15);
}
document.addEventListener("DOMContentLoaded", function(){
    const mapHolder = document.getElementById('map_holder');
    if(!mapHolder) return;

    // Use correct camelCase
    const submission_id = mapHolder.dataset.submissionId; 

    fetch(`/api/get_submission_infos/${submission_id}?fields=latitude,longitude`)
        .then(res => res.json())
        .then(data => {
            if (data.latitude && data.longitude){
                placeMarker([data.latitude , data.longitude]);
            }
        })
        .catch(err => console.error("Error fetching submission data:", err));
});


async function decision_made(submission_id, final_verdict){
    var verdict = final_verdict === false?"Declined":"Approved";
    try{
        const response = await fetch(`/api/update_submission_infos/${submission_id}/${verdict}`,{
            method: "POST",
            headers:{
                "content-type": "application/json",
            },
            body:JSON.stringify(
                {
                    submission_id : submission_id,
                    final_verdict: verdict
                }

            )
        });
        const result = await response.json();
        if(!response.ok){
            console.log("API Error", result);
            alert(result.message || "Update Failed" ) ;
            return;
        }
        else{
            var button_space = document.getElementById("button_holder");
            if (final_verdict === false)
                    {
                        button_space.innerHTML = `
                        <div class = "update_declined_message">
                        ${result.success_message}
                        </div>
                        `;
                    }
            else{
                       button_space.innerHTML = `
                        <div class = "update_success_message">
                        ${result.success_message}
                        </div>
                        `;                
            }
            console.log("Status updated successfully");
            // alert(result.message || "Status updated successfully");

        }
    }
    catch(err){
        console.log("An error occured", err);
        alert('Network error. Please try again.');

    }
}