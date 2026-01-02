<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landlord Dashboard - DormMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landlord.css') }}">
</head>
<body>
    <x-page-header>
        <x-slot name="nav_links">
            <x-nav-buttons />
        </x-slot>
    </x-page-header>

    <div class="main-content" id="mainContent">
        <div class="dashboard-header">
            <h1>Property Management Dashboard</h1>
            <p>Manage your listings, track tenants, and monitor property performance</p>
        </div>

        @if(count($properties) === 0)
            <div class="empty-state" style="padding: 120px 20px;">
                <i class="fas fa-building"></i>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--text-primary); margin-bottom: 20px;">
                    Start Listing Your Properties
                </h2>
                <p style="font-size: 1.2rem; color: var(--text-secondary); max-width: 600px; margin: 0 auto 40px;">
                    You haven't listed any properties yet. Create your first listing to start connecting with potential tenants.
                </p>
                <button onclick="alert('List your first property!')" style="background: linear-gradient(135deg, var(--primary), var(--accent)); color: white; border: none; padding: 18px 48px; border-radius: 50px; font-size: 1.2rem; font-weight: 700; cursor: pointer;">
                    <i class="fas fa-plus-circle" style="margin-right: 10px;"></i>List Your Property
                </button>
            </div>
        @else
            {{-- Stats --}}
            <div class="stats-grid">
                <div class="stat-card success">
                    <div class="stat-icon success">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Properties</div>
                </div>

                <div class="stat-card primary">
                    <div class="stat-icon primary">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $stats['active'] }}</div>
                    <div class="stat-label">Active Listings</div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">Pending Approval</div>
                </div>

                <div class="stat-card danger">
                    <div class="stat-icon danger">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-value">{{ $stats['rented'] }}</div>
                    <div class="stat-label">Currently Rented</div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab('all')">All Properties</button>
                <button class="tab-btn" onclick="switchTab('active')">Active Listings</button>
                <button class="tab-btn" onclick="switchTab('pending')">Pending Approval</button>
                <button class="tab-btn" onclick="switchTab('rented')">Rented Properties</button>
            </div>

            {{-- Tab Contents --}}
            @php
                $statuses = ['all', 'active', 'pending', 'rented'];
            @endphp

            @foreach($statuses as $status)
                <div id="{{ $status }}Tab" class="tab-content {{ $status==='all' ? 'active' : '' }}">
                    <div class="properties-grid">
                        @foreach($properties as $property)
                            @if($status==='all' || $property['status'] === $status)
                                <div class="property-card">
                                    <div class="property-image" style="background: {{ $property['gradient'] }};">
                                        <i class="fas fa-{{ $property['icon'] }}"></i>
                                        <div class="property-status {{ $property['status'] }}">
                                            {{ ucfirst($property['status']) }}
                                        </div>
                                    </div>
                                    <div class="property-content">
                                        <h3 class="property-title">{{ $property['title'] }}</h3>
                                        <div class="property-address">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $property['address'] }}</span>
                                        </div>
                                        <div class="property-details">
                                            <div class="property-detail">
                                                <div class="property-detail-value">{{ $property['bed'] }}</div>
                                                <div class="property-detail-label">Bedroom{{ $property['bed'] > 1 ? 's' : '' }}</div>
                                            </div>
                                            <div class="property-detail">
                                                <div class="property-detail-value">{{ $property['bath'] }}</div>
                                                <div class="property-detail-label">Bathroom{{ $property['bath'] > 1 ? 's' : '' }}</div>
                                            </div>
                                            <div class="property-detail">
                                                <div class="property-detail-value">{{ $property['sqft'] }}</div>
                                                <div class="property-detail-label">Sq Ft</div>
                                            </div>
                                        </div>
                                        <div class="property-price">{{ $property['price'] }}<span>{{ $property['price_note'] ?? '/month' }}</span></div>
                                        @isset($property['tenant'])
                                            <div class="tenant-badge"><i class="fas fa-user"></i><span>{{ $property['tenant'] }}</span></div>
                                        @endisset
                                        <div class="property-actions" style="@isset($property['tenant']) margin-top:12px; @endisset">
                                            <button class="btn-property btn-edit" onclick="alert('Edit property')">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </button>
                                            <button class="btn-property btn-view" onclick="alert('View property')">
                                                <i class="fas fa-eye me-2"></i>View
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <button class="add-property-btn" id="addPropertyBtn" onclick="alert('Add new property...')">
        <i class="fas fa-plus"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById(tabName+'Tab').classList.add('active');
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
