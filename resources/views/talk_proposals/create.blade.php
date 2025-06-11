{{-- resources/views/talk_proposals/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Talk Proposal')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Submit a New Talk Proposal</h1>

    <form action="{{ route('admin.talk-proposals.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label class="block font-medium">Title</label>
            <input type="text" name="title" class="w-full mt-1 p-2 border rounded" value="{{ old('title') }}">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium">Description</label>
            <textarea name="description" class="w-full mt-1 p-2 border rounded" rows="5">{{ old('description') }}</textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium">Presentation PDF (optional)</label>
            <input type="file" name="presentation_pdf" class="w-full mt-1">
            @error('presentation_pdf') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium">Tags (comma-separated)</label>
            <input type="text" name="tags[]" class="w-full mt-1 p-2 border rounded" placeholder="e.g. AI, Laravel, Security">
            @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Submit</button>
        </div>
    </form>
@endsection
