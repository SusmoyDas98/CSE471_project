@extends('owner.layout')

@section('content')
    <h1 class="h4 mb-3">Post vacancy for room {{ $room->label }}</h1>
    <form method="POST" action="{{ route('owner.vacancies.store', $room) }}" class="card p-4 shadow-sm">
        @csrf
        @include('owner.vacancies.partials.form', ['vacancy' => null])
        <div class="mt-3 text-end">
            <button class="btn btn-primary">Post</button>
        </div>
    </form>
@endsection

