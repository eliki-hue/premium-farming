@extends('layout')

@section('title', 'Add Category')

@section('content')
<div class="container max-w-lg">

    {{-- Page Title --}}
    <h1 class="mb-4 text-xl font-semibold">
        Add New Category
    </h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Category Form --}}
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        {{-- Category Name --}}
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   class="form-control"
                   placeholder="e.g. Poultry Feeds"
                   required>
        </div>

        {{-- Category Description --}}
        <div class="mb-3">
            <label class="form-label">Description (optional)</label>
            <textarea name="description"
                      rows="3"
                      class="form-control"
                      placeholder="Short description of this category">{{ old('description') }}</textarea>
        </div>

        {{-- Buttons --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Save Category
            </button>

            <a href="{{ route('categories.index') }}"
               class="btn btn-outline-secondary">
                Cancel
            </a>
        </div>
    </form>

</div>
@endsection
