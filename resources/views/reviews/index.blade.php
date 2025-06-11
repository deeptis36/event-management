@extends('layouts.app')

@section('title', 'Reviews for Talk Proposal')

@section('content')
<div class="max-w-4xl mx-auto mt-6">
    <h2 class="text-2xl font-semibold mb-4">Reviews for Talk Proposal</h2>

    <div class="mt-8">
        <h3 class="text-xl font-bold mb-2">Reviews</h3>
        @forelse ($reviews as $review)
            <div class="bg-white p-4 rounded shadow mb-4 border">
                <p class="text-sm text-gray-600">
                    Reviewed by: <strong>{{ $review->reviewer->name }}</strong>
                    <span class="ml-4">Rating: <strong>{{ $review->rating }}/5</strong></span>
                </p>
                <p class="mt-2 text-gray-800">{{ $review->comments }}</p>
            </div>
        @empty
            <p class="text-gray-600">No reviews available for this proposal.</p>
        @endforelse
    </div>
</div>
@endsection
