
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