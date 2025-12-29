<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Dorm - Premium Housing Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>     
    <link rel="stylesheet" href='/css/dorm_reg.css'>
</head>
<body>
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>
    <div style="height: 120px;"></div>
    @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="error_submission">    
                {{ $error }}
                </div>
            @endforeach
    @endif

    @if (session('status'))
                <div class="success_submission">
                {{ session('status') }}
                </div>
            
    @endif
    
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
                        <div class="dorm_image"></div>
                    </div>
                </div>
            </div>
        </div>

        @if (!session('status'))

        
        <div class="form-container">
            


                {{-- <div class="success_submission">
                    {{ session('status') }}
                </div> --}}
                
            {{-- @else  --}}

            <div class="form-header">
                <h2>Register Your Property</h2>
                <p>Complete the form below to list your premium dorm on our platform</p>
            </div>
            
            <form id="dormRegistrationForm" method="POST" action="/dorm_registration" enctype="multipart/form-data">
                @csrf
                <!-- Owner Information -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user-circle"></i>
                        Owner Information
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="ownerName" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="ownerName" name="owner_name" placeholder="Enter your full legal name"     value="{{ old('owner_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="ownerPhone" class="form-label">Contact Number *</label>
                            <input type="tel" class="form-control" id="ownerPhone" name="owner_phone" placeholder="+1 (555) 123-4567"    value="{{ old('owner_phone') }}"  required>
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
                            <input type="text" class="form-control" id="dormName" name="dorm_name" placeholder="Enter your property's name"    value="{{ old('dorm_name') }}"  required>
                        </div>
                        <div class="col-md-12 mb-4">
                            <label for="dormAddress" class="form-label">Address *</label>
                            <input type="text" class="form-control" id="dormAddress" name="dorm_address" placeholder="City, street, or landmark"    value="{{ old('dorm_address') }}"  required>
                        </div>
                        <div class="map_holder">
                        

                        <label for="map" class="form-label">Select your dorm location on the map * </label>
                        <div class="search_location">
                        <input type="text" class="form-control" name = 'dorm_location_on_map' id = "dorm_location_on_map" placeholder = 'Paste here your Dorm location link from Google Maps to ease the process'    value="{{ old('dorm_location_on_map') }}" >

                        <button type = "button" id = "find_location_button" name = 'find_location' onclick="Fetch_location_from_link()">Search & Select Location</button>
                        </div>

                        <div name = 'map' id = "map">
                        </div>

                        <input type="hidden" id = "latitude" name = "latitude" required>
                        <input type="hidden" id = "longitude" name = "longitude" required>
                        <p id = "status"></p>


                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="numRooms" class="form-label">Available Rooms *</label>
                            <input type="number" class="form-control" id="numRooms" name="num_rooms" placeholder="e.g., 25" min="1"   value="{{ old('num_rooms') }}"  required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="roomTypes" class="form-label">Room Categories *</label>
                            <input type="text" class="form-control" id="roomTypes" name="room_types[]" placeholder="Single, Double, Suite, Deluxe"    value="{{ old('room_types[]') }}"  required>
                            <small class="text-muted">Separate categories with commas</small>
                        </div>
                        <!-- Facilities (Checkboxes) -->
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Facilities *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facilities[]" value="WiFi" id="wifi">
                                <label class="form-check-label" for="wifi">WiFi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facilities[]" value="Electricity" id="electricity">
                                <label class="form-check-label" for="electricity">Electricity</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facilities[]" value="Water Supply" id="water">
                                <label class="form-check-label" for="water">Water Supply</label>
                            </div>

                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="Heating" id="heating">
                                    <label class="form-check-label" for="heating">Heating</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="Air Conditioning" id="ac">
                                    <label class="form-check-label" for="ac">Air Conditioning</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="facilities[]" value="Parking" id="parking">
                                    <label class="form-check-label" for="parking">Parking</label>
                                </div>
                            </div>                            

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="facilities[]" value="Other" id="other_facility">
                                <label class="form-check-label" for="other_facility">Other</label>
                                <input type="text" class="form-control mt-1" name="facilities_other" placeholder="Add other facilities: Use commas (,) to separate multiple entires">
                            </div>      
                        </div>                                          
                        <!-- Gender Allowed (Radio) -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Gender Allowed *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Male" id="gender_male" 
                                       {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Female" id="gender_female" 
                                       {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gender" value="Not Gender Specified" id="gender_unspecified" 
                                       {{ old('gender') == 'Not Gender Specified' ? 'checked' : '' }}>
                                <label class="form-check-label" for="gender_unspecified">Not Gender Specified</label>
                            </div>
                        </div>
                    
                        <!-- Student Only (Radio) -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Student Only *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="student_only" value="Yes" id="student_yes" 
                                       {{ old('student_only') == 'Yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="student_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="student_only" value="No" id="student_no" 
                                       {{ old('student_only') == 'No' ? 'checked' : '' }}>
                                <label class="form-check-label" for="student_no">No</label>
                            </div>
                        </div>
                    
                        <!-- Expected Matrimonial Status (Radio) -->
                        <div class="col-md-12 mb-4">
                            <label class="form-label">Expected Matrimonial Status *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="expected_matrimonial_status" value="Married" id="married" 
                                       {{ old('expected_matrimonial_status') == 'Married' ? 'checked' : '' }}>
                                <label class="form-check-label" for="married">Married</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="expected_matrimonial_status" value="Unmarried" id="unmarried" 
                                       {{ old('expected_matrimonial_status') == 'Unmarried' ? 'checked' : '' }}>
                                <label class="form-check-label" for="unmarried">Unmarried</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="expected_matrimonial_status" value="Not Specified" id="not_specified" 
                                       {{ old('expected_matrimonial_status') == 'Not Specified' ? 'checked' : '' }}>
                                <label class="form-check-label" for="not_specified">Not Specified</label>
                            </div>
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
                                    <input type="file" id="passport" name="passport"  required>
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
                                    <input type="file" id="ownership" name="ownership_document"  required>
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
            @endif
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src ="/js/dorm_reg.js"></script>
</body>
</html>