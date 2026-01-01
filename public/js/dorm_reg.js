
// File name display for single file uploads
function displayFileName(inputId, displayId) {
    const input = document.getElementById(inputId);
    const display = document.getElementById(displayId);
    
    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            display.textContent = '✓ ' + this.files[0].name;
        }
    });
}

displayFileName('nationalId', 'nationalIdName');
displayFileName('passport', 'passportName');
displayFileName('ownership', 'ownershipName');

// Image preview for multiple images
const dormPicturesInput = document.getElementById('dormPictures');
const imagePreview = document.getElementById('imagePreview');
let selectedFiles = [];

dormPicturesInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    selectedFiles = [...selectedFiles, ...files];
    displayImages();
});


const ownership = document.getElementById('ownership');
const imagePreview_docs = document.getElementById('imagePreview_docs');
let selectedFiles_docs = [];

ownership.addEventListener('change', function (e) {
    // Add new files to selectedFiles_docs
    const files = Array.from(e.target.files);
    selectedFiles_docs = [...selectedFiles_docs, ...files];

    // Update the input's files so HTML validation works
    const dt = new DataTransfer();
    selectedFiles_docs.forEach(file => dt.items.add(file));
    ownership.files = dt.files;

    // Display preview
    displayImages_docs();
});

function displayImages_docs() {
    imagePreview_docs.innerHTML = '';

    selectedFiles_docs.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const div = document.createElement('div');
            div.className = 'preview-image';
            div.innerHTML = `
                <div class="doc-box">
                    <img src="${e.target.result}" alt="Document Preview">
                    <span>${file.name}</span>
                    <button type="button" class="remove-image" onclick="removeDocument(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            imagePreview_docs.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removeDocument(index) {
    selectedFiles_docs.splice(index, 1);

    // Update the input's files so HTML validation works
    const dt = new DataTransfer();
    selectedFiles_docs.forEach(file => dt.items.add(file));
    ownership.files = dt.files;

    displayImages_docs();
}




function displayImages() {
    imagePreview.innerHTML = '';
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'preview-image';
            div.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-image" onclick="removeImage(${index})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            imagePreview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    displayImages();
    
    // Update file input
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    dormPicturesInput.files = dt.files;
}

// Form validation
document.getElementById('dormRegistrationForm').addEventListener('submit', function(e) {
    const phone = document.getElementById('ownerPhone').value;
    const phoneRegex = /^[+]?[\d\s-()]+$/;
    
    if (!phoneRegex.test(phone)) {
        e.preventDefault();
        alert('Please enter a valid phone number');
        return false;
    }
    
    if (selectedFiles.length === 0) {
        e.preventDefault();
        alert('Please upload at least one property photo to showcase your space');
        return false;
    }
});

var map = L.map('map');
setTimeout(function () {
    map.invalidateSize();
}, 200);

map.setView([23.807859221461392, 90.42861728673599], 10);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

//the map marker

let marker ;
function placeMarker(latlng){
    if(marker){
        marker.setLatLng(latlng);
    }
    else{
        marker = L.marker(latlng).addTo(map);
    }

    document.getElementById('latitude').value = latlng.lat;
    document.getElementById('longitude').value = latlng.lng;

    // console.log("Latitude:", document.getElementById('latitude').value);
    // console.log("Longitude:", document.getElementById('longitude').value);    
}

map.on('click', function(e){
    placeMarker(e.latlng);
});

function Fetch_location_from_link(){
    var map_link_given = document.getElementById("dorm_location_on_map").value;
    if (!map_link_given){
        return ;
    }
    var given_link = String(map_link_given);

    var start_loc = given_link.indexOf("@");
    if(start_loc === -1) return; 
    var start_from = start_loc+1;
    var shrinked_link = given_link.slice(start_from);
    var parts = shrinked_link.split(",");
    var lat = parseFloat(parts[0]);
    var lng = parseFloat(parts[1]);
    if(isNaN(lat) || isNaN(lng)) return; 
    placeMarker({lat: lat, lng : lng});
    map.setView([lat, lng], 15);

    // console.log("Latitude:", document.getElementById('latitude').value);
    // console.log("Longitude:", document.getElementById('longitude').value);    
}
    // Log the updated values
