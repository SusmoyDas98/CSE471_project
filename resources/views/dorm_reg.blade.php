<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Dorm - Premium Housing Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href='/css/dorm_reg.css'>


    
    <style>
    </style>
</head>
<body>
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>
    <div style="height: 120px;"></div>
    
    <div class="container">
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <span class="hero-badge">✨ Register. Connect. Earn.</span>
                    <h1>From idea to impact — <span>we've got your back</span></h1>
                    <p class="lead">Join the most trusted platform for student housing. Register your dorm and connect with thousands of verified students looking for their perfect home away from home.</p>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">50K+</span>
                            <span class="stat-label">Active Students</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">2.5K+</span>
                            <span class="stat-label">Listed Dorms</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">98%</span>
                            <span class="stat-label">Satisfaction</span>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="hero-image-wrapper">
                        {{-- <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=600" alt="Professional Property Owner"> --}}
                        <div class="dorm_image"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-container">
            <div class="form-header">
                <h2>Register Your Property</h2>
                <p>Complete the form below to list your premium dorm on our platform</p>
            </div>
            
            <form id="dormRegistrationForm" method="POST" action="/register-dorm" enctype="multipart/form-data">
                <!-- Owner Information -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user-circle"></i>
                        Owner Information
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="ownerName" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="ownerName" name="owner_name" placeholder="Enter your full legal name" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="ownerPhone" class="form-label">Contact Number *</label>
                            <input type="tel" class="form-control" id="ownerPhone" name="owner_phone" placeholder="+1 (555) 123-4567" required>
                        </div>
                    </div>
                </div>
                
                <!-- Dorm Information -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-building"></i>
                        Property Details
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="dormName" class="form-label">Property Name *</label>
                            <input type="text" class="form-control" id="dormName" name="dorm_name" placeholder="Enter your property's name" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="numRooms" class="form-label">Available Rooms *</label>
                            <input type="number" class="form-control" id="numRooms" name="num_rooms" placeholder="e.g., 25" min="1" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="roomTypes" class="form-label">Room Categories *</label>
                            <input type="text" class="form-control" id="roomTypes" name="room_types" placeholder="Single, Double, Suite, Deluxe" required>
                            <small class="text-muted">Separate categories with commas</small>
                        </div>
                    </div>
                </div>
                
                <!-- Documents -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-shield-alt"></i>
                        Verification Documents
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">National ID Card *</label>
                            <div class="upload-box" onclick="document.getElementById('nationalId').click()">
                                <label class="upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p class="mb-0">Upload National ID</p>
                                    <small class="text-muted">PDF, JPG, PNG • Max 5MB</small>
                                    <input type="file" id="nationalId" name="national_id" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="file-name" id="nationalIdName"></div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Passport Document *</label>
                            <div class="upload-box" onclick="document.getElementById('passport').click()">
                                <label class="upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p class="mb-0">Upload Passport</p>
                                    <small class="text-muted">PDF, JPG, PNG • Max 5MB</small>
                                    <input type="file" id="passport" name="passport" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="file-name" id="passportName"></div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Property Ownership Proof *</label>
                            <div class="upload-box" onclick="document.getElementById('ownership').click()">
                                <label class="upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p class="mb-0">Upload Ownership Documents</p>
                                    <small class="text-muted">PDF, JPG, PNG • Max 5MB</small>
                                    <input type="file" id="ownership" name="ownership_document" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="file-name" id="ownershipName"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Dorm Pictures -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-images"></i>
                        Property Gallery
                    </div>
                    <div class="upload-box" onclick="document.getElementById('dormPictures').click()">
                        <label class="upload-label">
                            <i class="fas fa-camera-retro"></i>
                            <p class="mb-0">Upload Property Photos</p>
                            <small class="text-muted">Multiple images supported • JPG, PNG • Max 5MB each</small>
                            <input type="file" id="dormPictures" name="dorm_pictures[]" accept=".jpg,.jpeg,.png" multiple required>
                        </label>
                    </div>
                    <div class="preview-images" id="imagePreview"></div>
                </div>
                
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane me-2"></i>Submit Registration
                    </button>
                </div>
                
                <div class="footer-note">
                    <p><i class="fas fa-lock me-2"></i>Your information is secure and will be verified within 24-48 hours</p>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src ="/js/dorm_reg.js">
</body>
</html>