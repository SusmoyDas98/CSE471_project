<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dorm Registration - Documents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/document.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-building"></i> DormLuxe</a>
        </div>
    </nav>
    <div style="height:100px"></div>
    <div class="hero-section text-center">
        <div class="container">
            <span class="hero-badge"><i class="fas fa-home me-2"></i>Dorm Registration</span>
            <h1 class="hero-title">Find Your <span>Perfect Dorm</span></h1>
            <p class="hero-subtitle">Complete your registration to access premium dormitory facilities and connect with roommates</p>
        </div>
    </div>

    <div class="container">
        <div class="registration-container">
            <div class="form-header text-center mb-4">
                <h3>Complete Your Registration</h3>
                <p>Please provide the following documents to verify your identity</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form id="registrationForm" method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-section mb-4">
                    <label class="form-label"><i class="fas fa-id-card"></i> Student ID Card <span class="required text-danger">*</span></label>
                    <div class="file-upload-area" onclick="document.getElementById('studentId').click()" ondrop="handleDrop(event,'studentId')" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text">Click to upload or drag and drop</div>
                        <div class="file-upload-hint">PDF, JPG, PNG (Max 5MB)</div>
                    </div>
                    <input type="file" id="studentId" name="student_id" class="file-input" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(event,'studentId')" required style="display:none">
                    <div class="file-preview" id="preview-studentId">
                        <div class="file-info"><i class="fas fa-file-alt"></i><div><div class="file-name"></div><div class="file-size"></div></div></div>
                        <button type="button" class="remove-file btn btn-link text-danger" onclick="removeFile('studentId')"><i class="fas fa-times"></i></button>
                    </div>
                </div>

                <div class="form-section mb-4">
                    <label class="form-label"><i class="fas fa-passport"></i> Government ID <span class="required text-danger">*</span></label>
                    <div class="file-upload-area" onclick="document.getElementById('governmentId').click()" ondrop="handleDrop(event,'governmentId')" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text">Click to upload or drag and drop</div>
                        <div class="file-upload-hint">PDF, JPG, PNG (Max 5MB)</div>
                    </div>
                    <input type="file" id="governmentId" name="government_id" class="file-input" accept=".pdf,.jpg,.jpeg,.png" onchange="handleFileSelect(event,'governmentId')" required style="display:none">
                    <div class="file-preview" id="preview-governmentId">
                        <div class="file-info"><i class="fas fa-file-alt"></i><div><div class="file-name"></div><div class="file-size"></div></div></div>
                        <button type="button" class="remove-file btn btn-link text-danger" onclick="removeFile('governmentId')"><i class="fas fa-times"></i></button>
                    </div>
                </div>

                <div class="form-section mb-4">
                    <label class="form-label"><i class="fas fa-camera"></i> Personal Photo <span class="required text-danger">*</span></label>
                    <div class="file-upload-area" onclick="document.getElementById('personalPhoto').click()" ondrop="handleDrop(event,'personalPhoto')" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text">Click to upload or drag and drop</div>
                        <div class="file-upload-hint">JPG, PNG (Max 5MB)</div>
                    </div>
                    <input type="file" id="personalPhoto" name="personal_photo" class="file-input" accept=".jpg,.jpeg,.png" onchange="handleFileSelect(event,'personalPhoto')" required style="display:none">
                    <div class="file-preview" id="preview-personalPhoto">
                        <div class="file-info"><i class="fas fa-file-image"></i><div><div class="file-name"></div><div class="file-size"></div></div></div>
                        <button type="button" class="remove-file btn btn-link text-danger" onclick="removeFile('personalPhoto')"><i class="fas fa-times"></i></button>
                    </div>
                </div>

                <div class="form-section mb-4">
                    <label class="form-label"><i class="fas fa-user-friends"></i> Reference Letter (Optional)</label>
                    <div class="file-upload-area" onclick="document.getElementById('reference').click()" ondrop="handleDrop(event,'reference')" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                        <div class="file-upload-text">Click to upload or drag and drop</div>
                        <div class="file-upload-hint">PDF, DOC, DOCX (Max 5MB)</div>
                    </div>
                    <input type="file" id="reference" name="reference" class="file-input" accept=".pdf,.doc,.docx" onchange="handleFileSelect(event,'reference')" style="display:none">
                    <div class="file-preview" id="preview-reference">
                        <div class="file-info"><i class="fas fa-file-pdf"></i><div><div class="file-name"></div><div class="file-size"></div></div></div>
                        <button type="button" class="remove-file btn btn-link text-danger" onclick="removeFile('reference')"><i class="fas fa-times"></i></button>
                    </div>
                </div>

                <div class="submit-section">
                    <button type="submit" class="btn-submit" id="submitBtn"><i class="fas fa-paper-plane me-2"></i>Submit Registration</button>
                </div>

                <div class="success-message" id="successMessage">
                    <i class="fas fa-check-circle success-icon"></i>
                    <h4>Registration Submitted Successfully!</h4>
                    <p>Your documents are being reviewed. We'll notify you within 24-48 hours.</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // provide existing file URLs for the external JS to initialize previews
        window.existingFiles = {
            studentId: @json(isset($document) && $document->Student_id ? asset('storage/' . $document->Student_id) : ''),
            governmentId: @json(isset($document) && $document->Government_id ? asset('storage/' . $document->Government_id) : ''),
            personalPhoto: @json(isset($document) && $document->Personal_photo ? asset('storage/' . $document->Personal_photo) : ''),
            reference: @json(isset($document) && $document->Reference ? asset('storage/' . $document->Reference) : ''),
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/document.js') }}"></script>
</body>
</html>
