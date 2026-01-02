@php
    $vacancy = $vacancy ?? null;
@endphp
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" name="status">
            @foreach(['open','closed','filled'] as $status)
                <option value="{{ $status }}" @selected(old('status', $vacancy->status ?? 'open') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Available from</label>
        <input type="date" class="form-control @error('available_from') is-invalid @enderror" name="available_from" value="{{ old('available_from', $vacancy && $vacancy->available_from ? $vacancy->available_from->format('Y-m-d') : '') }}">
        @error('available_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label">Available to</label>
        <input type="date" class="form-control @error('available_to') is-invalid @enderror" name="available_to" value="{{ old('available_to', $vacancy && $vacancy->available_to ? $vacancy->available_to->format('Y-m-d') : '') }}">
        @error('available_to')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Notes</label>
        <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3">{{ old('notes', $vacancy->notes ?? '') }}</textarea>
        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

