@php
    $room = $room ?? null;
@endphp
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Label</label>
        <input class="form-control @error('label') is-invalid @enderror" name="label" value="{{ old('label', $room->label ?? '') }}" required>
        @error('label')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Capacity</label>
        <input type="number" min="1" class="form-control @error('capacity') is-invalid @enderror" name="capacity" value="{{ old('capacity', $room->capacity ?? 1) }}" required>
        @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Price</label>
        <input type="number" min="0" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $room->price ?? '') }}">
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Room type</label>
        <input class="form-control @error('room_type') is-invalid @enderror" name="room_type" value="{{ old('room_type', $room->room_type ?? '') }}">
        @error('room_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" name="is_shared" value="1" id="is_shared"
                   {{ old('is_shared', $room->is_shared ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_shared">Shared room</label>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Size (sqft)</label>
        <input type="number" min="0" class="form-control @error('size_sqft') is-invalid @enderror" name="size_sqft" value="{{ old('size_sqft', $room->size_sqft ?? '') }}">
        @error('size_sqft')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Gender policy</label>
        <input class="form-control @error('gender_policy') is-invalid @enderror" name="gender_policy" value="{{ old('gender_policy', $room->gender_policy ?? '') }}">
        @error('gender_policy')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Available from</label>
        <input type="date" class="form-control @error('available_from') is-invalid @enderror" name="available_from" value="{{ old('available_from', $room && $room->available_from ? $room->available_from->format('Y-m-d') : '') }}">
        @error('available_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

