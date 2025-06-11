@extends('layouts.app')

@section('title', 'My Talk Proposals')

@section('content')
    <div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header with New Proposal Button -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-gray-900">My Talk Proposals</h1>
            <a href="{{ route('talk-proposals.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg shadow hover:bg-indigo-700 transition duration-150 ease-in-out"
                aria-label="Create a new talk proposal">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Proposal
            </a>
        </div>

        <!-- Proposals List -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            @forelse ($proposals as $proposal)
                <div class="border-b border-gray-200 p-6 hover:bg-gray-50 transition duration-150 ease-in-out"
                    role="article" aria-labelledby="proposal-title-{{ $proposal->id }}">
                    <h2 id="proposal-title-{{ $proposal->id }}" class="text-xl font-semibold text-gray-900">
                        {{ $proposal->title }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">{{ Str::limit($proposal->description, 100) }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <span class="font-medium text-sm text-gray-700">Status:</span>
                        @php
                            $statusStyles = [
                                'draft' => 'bg-yellow-100 text-yellow-800',
                                'submitted' => 'bg-blue-100 text-blue-800',
                                'accepted' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $statusStyle = $statusStyles[$proposal->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $statusStyle }}">
                            {{ ucfirst($proposal->status) }}
                        </span>
                    </div>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($proposal->tags as $tag)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm font-medium rounded-full">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('talk-proposals.show', $proposal) }}"
                            class="text-indigo-600 hover:text-indigo-800 font-medium text-sm transition duration-150 ease-in-out"
                            aria-label="View details for {{ $proposal->title }}">
                            View Details
                        </a>

                        <a href="{{ route('admin.reviews.create', ['talkProposal' => $proposal]) }}"
                            class="text-green-600 hover:text-green-800 font-medium text-sm transition duration-150 ease-in-out"
                            aria-label="Give review for {{ $proposal->title }}">
                            Give Review
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center">
                    <p class="text-gray-500 text-lg">No proposals submitted yet.</p>
                    <a href="{{ route('talk-proposals.create') }}"
                        class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium rounded-lg shadow hover:bg-indigo-700 transition duration-150 ease-in-out">
                        Submit Your First Proposal
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        @if ($proposals->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $proposals->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection
