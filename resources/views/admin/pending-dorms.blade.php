<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pending Dorm Registrations - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap');

:root {
    --primary: #0ea5e9;
    --accent: #3b82f6;
    --success: #10b981;
    --danger: #ef4444;
}

body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    min-height: 100vh;
}

.dorm-card {
    background: white;
    border-radius: 18px;
    padding: 28px;
    margin-bottom: 24px;
    box-shadow: 0 8px 24px rgba(14, 165, 233, 0.12);
    transition: all 0.3s ease;
}

.dorm-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(14, 165, 233, 0.18);
}

.btn-approve {
    background: linear-gradient(135deg, #0ea5e9, #3b82f6);
    border: none;
    color: #fff;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 999px;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
    transition: all 0.25s ease;
}
.btn-approve:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(14, 165, 233, 0.35);
}

.btn-decline {
    background: linear-gradient(135deg, #64748b, #475569);
    border: none;
    color: #fff;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 999px;
    box-shadow: 0 4px 12px rgba(71, 85, 105, 0.25);
    transition: all 0.25s ease;
}
.btn-decline:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(71, 85, 105, 0.35);
}

.btn-modal-cancel {
    background: linear-gradient(135deg, #64748b, #475569);
    border: none;
    color: #fff;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 999px;
    box-shadow: 0 4px 12px rgba(71, 85, 105, 0.25);
    transition: all 0.25s ease;
}
.btn-modal-cancel:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(71, 85, 105, 0.35);
}

.btn-modal-decline {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: #fff;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.95rem;
    border-radius: 999px;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    transition: all 0.25s ease;
}
.btn-modal-decline:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
}
</style>
</head>
<body>

<x-page-header>
    <x-slot name="nav_links">
        <x-nav-buttons />
    </x-slot>
</x-page-header>

<div style="height: 120px;"></div>

<div class="container py-5">
<h1 class="text-center mb-5" style="font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary);">
    <i class="fas fa-tasks me-2"></i>Pending Dorm Registrations
</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($pendingDorms->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-check-circle" style="font-size: 4rem; color: #10b981;"></i>
        <h3 class="mt-3 text-secondary">All caught up!</h3>
        <p class="text-secondary">No pending dorm registrations to review</p>
    </div>
@else
    @foreach($pendingDorms as $dorms)
        <div class="dorm-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">{{ $dorms->dorm_name }}</h3>
                    <p class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Location:</strong> {{ $dorms->dorm_location }}</p>
                    <p class="mb-1"><i class="fas fa-door-open me-2 text-primary"></i><strong>Rooms:</strong> {{ $dorms->number_of_rooms }}</p>
                    @php
                        $room_types_display = '';
                        if (is_array($dorms->room_types)) {
                            $room_types_display = implode(', ', $dorms->room_types);
                        } elseif (!empty($dorms->room_types)) {
                            $decoded = json_decode($dorms->room_types, true);
                            $room_types_display = is_array($decoded) ? implode(', ', $decoded) : $dorms->room_types;
                        }
                    @endphp
                    <p class="mb-1"><i class="fas fa-bed me-2 text-primary"></i><strong>Room Types:</strong> {{ $room_types_display }}</p>
                    <p class="mb-1"><i class="fas fa-user me-2 text-primary"></i><strong>Owner:</strong> {{ $dorms->dorm_owner_name }}</p>
                    <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>Submitted {{ \Carbon\Carbon::parse($dorms->created_at)->diffForHumans() }}
                    </small>
                </div>

                <div class="col-md-4 text-end mt-4 mt-md-0" style="padding-right: 80px;">
                    <!-- Approve Button -->
                    <button type="button" class="btn btn-approve mb-2 approve-btn"
                        data-dorm-name="{{ $dorms->dorm_name }}"
                        data-dorm-id="{{ $dorms->id }}"
                        data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="fas fa-check me-2"></i>Approve Dorm
                    </button>

                    <!-- Decline Button -->
                    <button type="button" class="btn btn-decline decline-btn" 
                        data-dorm-name="{{ $dorms->dorm_name }}"
                        data-dorm-id="{{ $dorms->id }}"
                        data-bs-toggle="modal" data-bs-target="#declineModal">
                        <i class="fas fa-times me-2"></i>Decline Dorm
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@endif
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Dorm Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="approveForm">
                @csrf
                <div class="modal-body">
                    <p id="approveDormName" class="fw-bold"></p>
                    <p>Are you sure you want to approve this dorm?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-modal-decline" style="background:#0ea5e9;">Approve Dorm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Decline Modal -->
<div class="modal fade" id="declineModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Decline Dorm Registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="declineForm">
                @csrf
                <div class="modal-body">
                    <p id="modalDormName" class="fw-bold"></p>
                    <label class="form-label fw-bold">Reason for declining</label>
                    <textarea class="form-control" name="reason" rows="4" required placeholder="Explain why this registration is being declined..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-modal-decline">Decline Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Approve Modal
const approveButtons = document.querySelectorAll('.approve-btn');
const approveDormName = document.getElementById('approveDormName');
const approveForm = document.getElementById('approveForm');

approveButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const dormName = btn.getAttribute('data-dorm-name');
        const dormId = btn.getAttribute('data-dorm-id');
        approveDormName.textContent = dormName;
        approveForm.action = `/admin/dorms/${dormId}/approve`; // FIXED
    });
});

// Decline Modal
const declineButtons = document.querySelectorAll('.decline-btn');
const modalDormName = document.getElementById('modalDormName');
const declineForm = document.getElementById('declineForm');
const declineModal = document.getElementById('declineModal');
const reasonTextarea = declineForm.querySelector('textarea');

declineButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const dormName = btn.getAttribute('data-dorm-name');
        const dormId = btn.getAttribute('data-dorm-id');
        modalDormName.textContent = dormName;
        declineForm.action = `/admin/dorms/${dormId}/decline`; // FIXED
    });
});

// Reset decline modal on close
declineModal.addEventListener('hidden.bs.modal', () => {
    reasonTextarea.value = '';
    modalDormName.textContent = '';
});
</script>

</body>
</html>
