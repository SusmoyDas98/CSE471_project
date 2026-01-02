@extends('owner.layout')

@section('content')
    <h1 class="h4 mb-3">Edit dorm</h1>
    <form method="POST" action="{{ route('owner.dorms.update', $dorm) }}" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        @include('owner.dorms.partials.form', ['dorm' => $dorm])
        <div class="mt-3 text-end">
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection

