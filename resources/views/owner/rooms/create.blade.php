@extends('owner.layout')

@section('content')
    <h1 class="h4 mb-3">Add room to {{ $dorm->name }}</h1>
    <form method="POST" action="{{ route('owner.rooms.store', $dorm) }}" class="card p-4 shadow-sm">
        @csrf
        @include('owner.rooms.partials.form', ['room' => null])
        <div class="mt-3 text-end">
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

