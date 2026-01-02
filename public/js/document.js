// Document upload JS: drag/drop, previews, submit handling
(function(){
    function handleFileSelect(event, fieldId) {
        const file = event.target.files[0];
        if (file) displayFilePreview(file, fieldId);
    }

    function handleDragOver(event) {
        event.preventDefault();
        event.currentTarget.classList.add('dragover');
    }

    function handleDragLeave(event) {
        event.currentTarget.classList.remove('dragover');
    }

    function handleDrop(event, fieldId) {
        event.preventDefault();
        event.currentTarget.classList.remove('dragover');
        const file = event.dataTransfer.files[0];
        if (file) {
            const input = document.getElementById(fieldId);
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            displayFilePreview(file, fieldId);
        }
    }

    function displayFilePreview(file, fieldId) {
        const preview = document.getElementById(`preview-${fieldId}`);
        if (!preview) return;
        const fileName = preview.querySelector('.file-name');
        const fileSize = preview.querySelector('.file-size');
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        preview.classList.add('active');
    }

    function removeFile(fieldId) {
        const input = document.getElementById(fieldId);
        const preview = document.getElementById(`preview-${fieldId}`);
        if (input) input.value = '';
        if (preview) preview.classList.remove('active');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // expose to global
    window.handleFileSelect = handleFileSelect;
    window.handleDragOver = handleDragOver;
    window.handleDragLeave = handleDragLeave;
    window.handleDrop = handleDrop;
    window.displayFilePreview = displayFilePreview;
    window.removeFile = removeFile;

    // submit handler (progress UI only)
    document.addEventListener('DOMContentLoaded', function(){
        const form = document.getElementById('registrationForm');
        const submitBtn = document.getElementById('submitBtn');
        if (form && submitBtn) {
            form.addEventListener('submit', function(e){
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                // allow normal form submission
            });
        }

        // initialize previews from server-provided paths (if any)
        if (window.existingFiles) {
            Object.keys(window.existingFiles).forEach(function(key){
                const url = window.existingFiles[key];
                if (url) {
                    const fieldId = key; // expected to be 'studentId', 'governmentId', 'personalPhoto', 'reference'
                    const preview = document.getElementById(`preview-${fieldId}`);
                    if (!preview) return;
                    const fileName = preview.querySelector('.file-name');
                    const fileSize = preview.querySelector('.file-size');
                    // Set a display name from URL
                    const parts = url.split('/');
                    fileName.textContent = parts[parts.length-1] || url;
                    fileSize.textContent = '';
                    preview.classList.add('active');
                    // if image, show thumbnail inside preview (optional)
                    if (fieldId === 'personalPhoto') {
                        // append thumbnail
                        const img = document.createElement('img');
                        img.src = url;
                        img.style.maxHeight = '60px';
                        img.style.marginRight = '12px';
                        const info = preview.querySelector('.file-info');
                        if (info && !info.querySelector('img')) info.insertBefore(img, info.firstChild);
                    }
                }
            });
        }
    });
})();
