@php
    $dorm = $dorm ?? null;
@endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $dorm->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">City</label>
        <input class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city', $dorm->city ?? '') }}">
        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Address</label>
        <input class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $dorm->address ?? '') }}">
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Nearby university</label>
        <input class="form-control @error('nearby_university') is-invalid @enderror" name="nearby_university" value="{{ old('nearby_university', $dorm->nearby_university ?? '') }}">
        @error('nearby_university')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $dorm->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Amenities (comma separated)</label>
        <input class="form-control @error('amenities') is-invalid @enderror" name="amenities" value="{{ old('amenities', isset($dorm->amenities) ? implode(', ', $dorm->amenities) : '') }}">
        @error('amenities')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Rules (comma separated)</label>
        <input class="form-control @error('rules') is-invalid @enderror" name="rules" value="{{ old('rules', isset($dorm->rules) ? implode(', ', $dorm->rules) : '') }}">
        @error('rules')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Photo URLs (comma separated)</label>
        <input class="form-control @error('photos') is-invalid @enderror" name="photos" value="{{ old('photos', isset($dorm->photos) ? implode(', ', $dorm->photos) : '') }}">
        @error('photos')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Contact phone</label>
        <input class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone', $dorm->contact_phone ?? '') }}">
        @error('contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Contact email</label>
        <input class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email', $dorm->contact_email ?? '') }}">
        @error('contact_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

