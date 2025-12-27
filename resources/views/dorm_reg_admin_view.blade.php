<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dorm Submissions - Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="/css/dorm_reg_admin_view.css">  

</head>
<body>
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>
    <div style="height: 90px;"></div>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="page-title">Dorm Submissions</div>
        <div class="admin-profile">
            <div class="admin-avatar">A</div>
            <div class="admin-info">
                <h5>Admin Name</h5>
                <p>Administrator</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card"><div class="stat-icon pending"><i class="fas fa-hourglass-half"></i></div><div class="stat-value">{{$all_pending}}</div><div class="stat-label">Pending</div></div>
        <div class="stat-card"><div class="stat-icon approved"><i class="fas fa-check-circle"></i></div><div class="stat-value">{{$all_approved}}</div><div class="stat-label">Approved</div></div>
        <div class="stat-card"><div class="stat-icon rejected"><i class="fas fa-times-circle"></i></div><div class="stat-value">{{$all_declined}}</div><div class="stat-label">Rejected</div></div>
        <div class="stat-card"><div class="stat-icon total"><i class="fas fa-list"></i></div><div class="stat-value">{{$total_submissions}}</div><div class="stat-label">Total</div></div>
    </div>

    {{-- <!-- Filters -->
    <div class="filters-section">
        <div class="filter-group">
            <label for="statusFilter">Status</label>
            <select id="statusFilter" class="filter-select">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="ownerFilter">Owner</label>
            <select id="ownerFilter" class="filter-select">
                <option value="all">All</option>
                <option value="owner1">Owner 1</option>
                <option value="owner2">Owner 2</option>
            </select>
        </div>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div> --}}

    <!-- Submissions Table -->
    <div class="submissions-container">
        <div class="submissions-header">
            <h3>Submitted Requests For Approval</h3>
        </div>
        <div class="table-responsive">
            <table class="submissions-table">
                <thead>

                    <tr>
                        <th>Owner</th>
                        <th>Dorm Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- showing the pending requests in the table  --}}
                   
                    @forelse ($all_submissions as $subs)
                    <tr>
                        <td class="owner-info"><div class="owner-avatar">O1</div>
                            <div class="owner-details"><h5>{{ $subs->dorm_owner_name }}</h5><p><b>Id: {{ $subs->owner_id }}</b></p></div></td>
                        <td>{{ $subs->dorm_name }}</td>
                        <td><span class="status-badge status-pending">{{ $subs->status }}</span></td>
                        <td class="action-buttons">
                            <a href="/submitted_dorm/{{$subs->id}}" class="btn-action btn-view"  style="text-decoration: none;" title="View Details" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>

                        </td>
                    </tr>    
                    @empty
                        <tr>
                            <th colspan="5" class="text-center">Hurray! no work left!!!</th>
                        </tr>
                                        
                    @endforelse
                       
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src = "/js/dorm_reg_admin_view.js">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
