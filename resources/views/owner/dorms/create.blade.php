@extends('owner.layout')

@section('content')
    <h1 class="h4 mb-3">Create dorm</h1>
    <form method="POST" action="{{ route('test.test.owner.dorms.store') }}" class="card p-4 shadow-sm">
        @csrf
        @include('owner.dorms.partials.form')
        <div class="mt-3 text-end">
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

