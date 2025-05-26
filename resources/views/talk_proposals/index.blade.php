{{-- resources/views/talk_proposals/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Talk Proposals')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Talk Proposals</h1>
        <a href="{{ route('talk-proposals.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">New Proposal</a>
    </div>

    <div class="bg-white shadow rounded p-4">
        @forelse ($proposals as $proposal)
            <div class="border-b border-gray-200 py-4">
                <h2 class="text-lg font-semibold">{{ $proposal->title }}</h2>
                <p class="text-sm text-gray-600">{{ Str::limit($proposal->description, 100) }}</p>
                <div class="text-sm mt-2">
                    <span class="font-medium">Status:</span> {{ ucfirst($proposal->status) }}
                </div>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($proposal->tags as $tag)
                        <span class="bg-gray-200 text-sm px-2 py-1 rounded">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <a href="{{ route('talk-proposals.show', $proposal) }}" class="text-blue-500 mt-2 inline-block">View Details</a>
            </div>
        @empty
            <p>No proposals submitted yet.</p>
        @endforelse
    </div>
@endsection
