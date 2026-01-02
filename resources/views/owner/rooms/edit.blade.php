@extends('owner.layout')

@section('content')
    <h1 class="h4 mb-3">Edit room in {{ $dorm->name }}</h1>
    <form method="POST" action="{{ route('owner.rooms.update', [$dorm, $room]) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        @include('owner.rooms.partials.form', ['room' => $room])
        <div class="mt-3 text-end">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection

