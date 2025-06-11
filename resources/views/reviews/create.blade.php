@extends('layouts.app')

@section('title', 'Give Review')

@section('content')
    <div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Review for: {{ $talkProposal->title }}</h1>

        <form action="{{ route('admin.review.store',['talkProposal' => $talkProposal]) }}" method="POST" class="space-y-4">
            @csrf

            <input type="hidden" name="talk_proposal_id" value="{{ $talkProposal->id }}">

            <div>
                <label for="rating" class="block font-medium text-sm text-gray-700">Rating (1–5)</label>
                <select name="rating" id="rating" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Select Rating --</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('rating') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="comments" class="block font-medium text-sm text-gray-700">Comments</label>
                <textarea name="comments" id="comments" rows="5"
                    class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('comments') }}</textarea>
                @error('comments') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Submit Review</button>
            </div>
        </form>
    </div>
@endsection
