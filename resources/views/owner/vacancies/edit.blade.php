@extends('owner.layout')

@section('content')
    <h1 class="h4 mb-3">Edit vacancy for room {{ $vacancy->room->label }}</h1>
    <form method="POST" action="{{ route('owner.vacancies.update', $vacancy) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        @include('owner.vacancies.partials.form', ['vacancy' => $vacancy])
        <div class="mt-3 text-end">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection

