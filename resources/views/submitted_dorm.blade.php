<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Submitted Dorm Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>         
=======
>>>>>>> afia-branch
    <style>
        body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; background:#f7fbff; color:#0c4a6e}
        .page-card{background:#fff;border-radius:12px;padding:22px;border:1px solid rgba(14,165,233,0.08)}
        .avatar{width:56px;height:56px;border-radius:8px;background:linear-gradient(135deg,#38bdf8,#3b82f6);display:flex;align-items:center; border-radius:50%;justify-content:center;color:#fff;font-weight:700}
        .label{font-size:.78rem;color:#075985;font-weight:700}
        .value{font-size:1rem;color:#0c4a6e;font-weight:600}
        .chip{display:inline-block;padding:6px 10px;border-radius:999px;background:#eef9ff;color:#0369a1;font-weight:700;margin-right:6px;margin-bottom:6px}
        .gallery img{width:100%;height:160px;object-fit:cover;border-radius:8px;border:1px solid rgba(14,165,233,0.06)}
        .doc-link{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:10px;background:linear-gradient(135deg,#0ea5e9,#06b6d4);color:#fff;text-decoration:none;margin-right:8px}
        #approved_message{ background-color:greenyellow; font-weight:bolder; color:rgb(0, 84, 0)   }
        #declined_message{ background-color:red; font-weight:bold;  color:rgb(123, 0, 0)      }
<<<<<<< HEAD
        #map_holder{flex:1}
        #map{ height:100%; width:100%;}
        .col-lg-4{display:flex; flex-direction: column; gap:20px}
        .update_declined_message{
            height: auto;
            width: 100%;
            background-color:rgb(255, 115, 115);
            font-weight:bolder;
            font-size: large;
            color: rgb(87, 20, 20);
            border-top: 2px solid rgb(87, 20, 20);
            border-bottom: 2px solid rgb(87, 20, 20);
            padding:10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: serif;

            /* border-radius:12px; */
        }
        .update_success_message {
            height: auto;
            width: 100%;
            background-color: rgb(98 255 98);
            font-weight: bold;
            font-size: large;
            color: rgb(0, 75, 0);
            border-top: 2px solid rgb(0, 75, 0);
            border-bottom: 2px solid rgb(0, 75, 0);
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            /* border-radius: 12px; */
            font-family: serif;
        }
        .label{

            /* background-color: #0369a1; */
            color: #0369a1;       
            font-family: Verdana, Geneva, Tahoma, sans-serif;     
            font-size: large;
        }
        .value{
            font-family:Arial, Helvetica, sans-serif;
            font-weight: normal;
        }
        #table_title{
            background-color: #0369a1;
            color: white;
            text-align: center;
            /* font-weight: bold; */
        }
        #table_value{
            font-weight: 600;
            text-align: center;
        }
        .submission-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .submission-table td {
            border: 0.5px solid #ccc;
            padding: 6px;
        }

        .chip {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 12px;
            background-color: #f0f0f0;
            font-size: 13px;
        }

        
=======
>>>>>>> afia-branch
    </style>
</head>
<body>
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>
    <div style="height:90px"></div>

    <div class="container my-5">
        @if(empty($submission_infos))
            <div class="page-card text-center">
                <h4 class="mb-2">Submission not found</h4>
                <p class="text-muted">The requested dorm submission could not be located.</p>
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">Go back</a>
            </div>
        @else
        <div class="row gy-4">
            <div class="col-lg-8">
                <div class="page-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div class="label">Property Name</div>
                            <div class="value">{{ $submission_infos->dorm_name }}</div>
                        </div>
                        <div class="text-end">
                            <div class="label">Submitted</div>
<<<<<<< HEAD
                            <div class="text-muted">{{ ($submission_infos->created_at) ?? '—' }}</div>
=======
                            <div class="text-muted">{{ ($submission_infos->submitted_at) ?? '—' }}</div>
>>>>>>> afia-branch
                        </div>
                    </div>

                    <hr>

<<<<<<< HEAD
                    <table class="submission-table">
                        <!-- First row: headings -->
                        <tr>
                            <td id="table_title"><strong>Location</strong></td>
                            <td id="table_title"><strong>Rooms</strong></td> 
                        </tr>
                        <!-- First row: values -->
                        <tr>
                            <td id="table_value">{{ $submission_infos->dorm_location ?? '—' }}</td>
                            <td id="table_value">{{ $submission_infos->number_of_rooms ?? '—' }}</td>
                        </tr>
                    
                        <!-- Second row: headings -->
                        <tr>
                            <td id="table_title"><strong>Status</strong></td>
                            <td id="table_title"><strong>Gender Preference</strong></td>
                        </tr>
                        <!-- Second row: values -->
                        <tr>
                            <td id="table_value"><span class="chip">{{ ucfirst($submission_infos->status ?? 'pending') }}</span></td>
                            <td id="table_value">{{ $submission_infos->gender_preference ?? '—' }}</td>
                        </tr>
                    
                        <!-- Third row: headings -->
                        <tr>
                            <td id="table_title"><strong>Student Only</strong></td>
                            <td id="table_title"><strong>Expected Marital Status</strong></td>
                        </tr>
                        <!-- Third row: values -->
                        <tr>
                            <td id="table_value">{{ $submission_infos->student_only ?? '—' }}</td>
                            <td id="table_value">{{ $submission_infos->expected_marital_status ?? '—' }}</td>
                        </tr>
                    </table>
=======
                    <div class="row">
                        <div class="col-md-6">
                            <div class="label">Location</div>
                            <div class="value">{{ $submission_infos->dorm_location ?? '—' }}</div>
                        </div>
                        <div class="col-md-3">
                            <div class="label">Rooms</div>
                            <div class="value">{{ $submission_infos->number_of_rooms ?? '—' }}</div>
                        </div>
                        <div class="col-md-3 text-end">
                            <div class="label">Status</div>
                            <div><span class="chip">{{ ucfirst($submission_infos->status ?? 'pending') }}</span></div>
                        </div>
                    </div>
>>>>>>> afia-branch

                    <div class="mt-4">
                        <div class="label mb-2">Room Types</div>
                        @php
                            $types = $submission_infos->room_types ?? [];
                            if(is_string($types)) {
                                try { $types = json_decode($types, true) ?? explode(',', $types); } catch(
                                    Exception $e) { $types = [$types]; }
                            }
                        @endphp
                        @foreach($types as $t)
                            <span class="chip">{{ trim($t) }}</span>
                        @endforeach
                    </div>
<<<<<<< HEAD
                    <div class="mt-4">
                        <div class="label mb-2">Dorm Hotline</div>
                         <span class="chip">{{ $submission_infos->dorm_hotline ?? '—' }}</span>
                    </div>


                    <div class="mt-4">
                        <div class="label mb-2">Facilities </div>
                        @php
                            $facilities = $submission_infos->facilities ?? [];
                            if(is_string($facilities)) {
                                try { $facilities = json_decode($facilities, true) ?? explode(',', $facilities); } catch(
                                    Exception $e) { $facilities = [$facilities]; }
                            }
                        @endphp
                        @foreach($facilities as $f)
                            <span class="chip">{{ trim($f) }}</span>
                        @endforeach
                    </div>                    

                    <div class="mt-4">
                        <div class="label mb-2">Property Images</div>
                        @php $images = $submission_infos->dorm_pictures ?? [];
=======

                    <div class="mt-4">
                        <div class="label mb-2">Property Images</div>
                        @php $images = $submission_infos->dorm_images ?? [];
>>>>>>> afia-branch
                             if(is_string($images)) { try{ $images = json_decode($images, true) ?? [$images]; }catch(Exception $e){ $images = [$images]; } }
                        @endphp
                        @if(empty($images))
                            <p class="text-muted">No images uploaded.</p>
                        @else
                            <div class="row gallery g-3">
                                @foreach($images as $img)
                                    <div class="col-6 col-md-4">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($img) }}" target="_blank">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($img) }}" alt="dorm image">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
<<<<<<< HEAD
                    <div class="mt-4">
                        <div class="label mb-2">Owner Documents</div>
                    
                        @php
                            $docs = $submission_infos->property_ownership_doc ?? [];
                            if(is_string($docs)) {
                                try {
                                    $docs = json_decode($docs, true) ?? [$docs];
                                } catch(Exception $e) {
                                    $docs = [$docs];
                                }
                            }
                        @endphp
                    
                        @if(empty($docs))
                            <p class="text-muted">No documents uploaded.</p>
                        @else
                            <div class="row g-3">
                                @foreach($docs as $doc)
                                    @php
                                        $lower = strtolower($doc);
                                    @endphp
                                    <div class="col-6 col-md-4 text-center">
                                        @if(substr($lower, -3) === 'pdf')
                                            <!-- PDF document -->
                                            <a href="{{ Storage::url($doc) }}" target="_blank" class="d-block p-3 border rounded bg-light">
                                                <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                <div class="small text-truncate">Click here to view</div>
                                            </a>
                                        @elseif(substr($lower, -3) === 'jpg' || substr($lower, -4) === 'jpeg' || substr($lower, -3) === 'png' || substr($lower, -3) === 'gif')
                                            <!-- Image thumbnail -->
                                            <a href="{{ Storage::url($doc) }}" target="_blank">
                                                <img src="{{ Storage::url($doc) }}" alt="Document" class="img-fluid rounded border">
                                            </a>
                                        @else
                                            <!-- Unknown file type -->
                                            <a href="{{ Storage::url($doc) }}" target="_blank" class="d-block p-3 border rounded bg-secondary text-white">
                                                <i class="fas fa-file fa-3x mb-2"></i>
                                                <div class="small text-truncate">{{ basename($doc) }}</div>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
   
=======
>>>>>>> afia-branch

                    <div class="mt-4">
                        <div class="label mb-2">Owner Documents</div>
                        <div class="d-flex flex-wrap">
<<<<<<< HEAD
                            @if(!empty($submission_infos->owner_national_id))
                                <a class="doc-link" href="{{ \Illuminate\Support\Facades\Storage::url($submission_infos->owner_national_id) }}" target="_blank">
                                    <i class="fas fa-id-card"></i> National ID
                                </a>
                            @endif
                            @if(!empty($submission_infos->passport))
                                <a class="doc-link" href="{{ \Illuminate\Support\Facades\Storage::url($submission_infos->passport) }}" target="_blank">
                                    <i class="fas fa-passport"></i> Passport
                                </a>
                            @endif
                            {{-- @if(!empty($submission_infos->property_ownership_doc))
                                <a class="doc-link" href="{{ \Illuminate\Support\Facades\Storage::url($submission_infos->property_ownership_doc) }}" target="_blank">
                                    <i class="fas fa-file-alt"></i> Ownership Doc
                                </a>
                            @endif --}}
=======
                            @if(!empty($submission_infos->owner_nid))
                                <a class="doc-link" href="{{ \Illuminate\Support\Facades\Storage::url($submission_infos->owner_nid) }}" target="_blank">
                                    <i class="fas fa-id-card"></i> National ID
                                </a>
                            @endif
                            @if(!empty($submission_infos->owner_passport))
                                <a class="doc-link" href="{{ \Illuminate\Support\Facades\Storage::url($submission_infos->owner_passport) }}" target="_blank">
                                    <i class="fas fa-passport"></i> Passport
                                </a>
                            @endif
                            @if(!empty($submission_infos->property_document))
                                <a class="doc-link" href="{{ \Illuminate\Support\Facades\Storage::url($submission_infos->property_document) }}" target="_blank">
                                    <i class="fas fa-file-alt"></i> Ownership Doc
                                </a>
                            @endif
>>>>>>> afia-branch
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="page-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
<<<<<<< HEAD
                        <div class="avatar">{{ strtoupper(substr($dorm_owner_user_infos->name ?? 'U',0,1)) }}</div>
                        <div>
                            <div class="label">Owner</div>
                            <div class="value">{{ $dorm_owner_user_infos->name ?? '—' }}</div>
                            <div class="text-muted">{{ $dorm_owner_user_infos->email ?? '—' }}</div>
=======
                        <div class="avatar">{{ strtoupper(substr($dorm_owner_infos->name ?? 'U',0,1)) }}</div>
                        <div>
                            <div class="label">Owner</div>
                            <div class="value">{{ $dorm_owner_infos->name ?? '—' }}</div>
                            <div class="text-muted">{{ $dorm_owner_infos->email ?? '—' }}</div>
>>>>>>> afia-branch
                        </div>
                    </div>

                    <hr>

<<<<<<< HEAD
                    <div class="mb-2"><div class="label">Owner ID</div><div class="value">{{ $dorm_owner_infos->user_id ?? '—' }}</div></div>
                    {{-- add the user Contact Number --}}
                    <div class="mb-2"><div class="label">Contract Number:</div><div class="value">{{ $dorm_owner_infos->contact_number ?? '—' }}</div></div>   
                    <div class="mb-2"><div class="label">Gender:</div><div class="value">{{ $dorm_owner_infos->gender ?? '—' }}</div></div>                                  
                    <div class="mb-2"><div class="label">Age:</div><div class="value">{{ $dorm_owner_infos->age ?? '—' }}</div></div>                                                    
                    <div class="mb-2"><div class="label">Role</div><div class="value">{{ $dorm_owner_user_infos->role ?? 'user' }}</div></div>
                    <div class="mb-2"><div class="label">Subscription</div><div class="value">{{ $dorm_owner_user_infos->subscription_type ?? '—' }}</div></div>
                    <div class="mb-2"><div class="label">Joined</div><div class="value">{{ optional($dorm_owner_user_infos->created_at)->diffForHumans() ?? '—' }}</div></div>

                </div>
                <div class="map_holder" id="map_holder" data-submission-id  = "{{ $submission_infos->id }}">
                    
                    <div class="map" id = "map">

                    </div>
                </div>
            </div>
        </div>
            {{-- Approve / Decline actions --}}
            @if (!$status_update)
                 
            
            <div class="row mt-4" id =  "button_holder">
                <div class="col-12 text-center">
                    <div class="d-flex justify-content-center gap-3" >
                            <button type="button" class="btn btn-success btn-lg" onclick = "decision_made({{$submission_infos->id}}, true)">
                                <i class="fas fa-check me-2"></i>Approve
                            </button>
                            <button type="button" class="btn btn-danger btn-lg" onclick = "decision_made({{$submission_infos->id}}, false)">
                                <i class="fas fa-times me-2"></i>Decline
                            </button>
                    </div>
                </div>
            </div>
=======
                    <div class="mb-2"><div class="label">Owner ID</div><div class="value">{{ $dorm_owner_infos->id ?? '—' }}</div></div>
                    <div class="mb-2"><div class="label">Role</div><div class="value">{{ $dorm_owner_infos->role ?? 'user' }}</div></div>
                    <div class="mb-2"><div class="label">Subscription</div><div class="value">{{ $dorm_owner_infos->subscription_type ?? '—' }}</div></div>
                    <div class="mb-2"><div class="label">Joined</div><div class="value">{{ optional($dorm_owner_infos->created_at)->diffForHumans() ?? '—' }}</div></div>

                </div>
            </div>
        </div>
            @if (!session('status') && !session('message'))
            {{-- Approve / Decline actions --}}
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <div class="d-flex justify-content-center gap-3">
                        @if(!empty($submission_infos) && $submission_infos->status == 'Pending')
                        <form method="POST" action="{{ route('dorm_reg.approve',['id' => $submission_infos->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check me-2"></i>Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('dorm_reg.decline',['id' => $submission_infos->id]) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-times me-2"></i>Decline
                            </button>

                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @else
                <div class="row mt-4">
                    <div class="col-12">
                        @if (session('status')=="Approved")
                            <div class="alert alert-info text-center" id="approved_message">
                                {{ session('message') }}
                            </div> 
                        @else
                            <div class="alert alert-info text-center" id="declined_message">
                                {{ session('message') }}
                            </div> 
                        @endif
                    </div>
                </div>
>>>>>>> afia-branch
            @endif
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<<<<<<< HEAD
    <script src ="/js/submitted_dorm.js"></script>

=======
>>>>>>> afia-branch
</body>
</html>
