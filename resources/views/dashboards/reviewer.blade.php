@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Reviewer Dashboard</h1>

    {{-- Filters --}}
    <form method="GET" class="mb-6 flex flex-wrap gap-4">
        <input type="text" name="tag" value="{{ request('tag') }}" placeholder="Tag"
               class="border rounded px-3 py-2 w-48" />
        <input type="text" name="speaker" value="{{ request('speaker') }}" placeholder="Speaker"
               class="border rounded px-3 py-2 w-48" />
        <input type="date" name="date" value="{{ request('date') }}"
               class="border rounded px-3 py-2 w-48" />
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
    </form>

    {{-- Talk Proposals Table --}}
    <table class="w-full table-auto border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Speaker</th>
                <th class="px-4 py-2">Tags</th>
                <th class="px-4 py-2">Submitted</th>
                <th class="px-4 py-2">PDF</th>
                <th class="px-4 py-2">Review</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($talkProposals as $proposal)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $proposal->title }}</td>
                <td class="px-4 py-2">{{ $proposal->speaker->name ?? 'N/A' }}</td>
                <td class="px-4 py-2">
                    @foreach ($proposal->tags as $tag)
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-1 text-xs rounded">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </td>
                <td class="px-4 py-2">{{ $proposal->created_at->format('Y-m-d') }}</td>
                <td class="px-4 py-2">
                    @if ($proposal->pdf_path)
                        <a href="{{ asset('storage/' . $proposal->pdf_path) }}" target="_blank" class="text-blue-600 underline">
                            View PDF
                        </a>
                    @else
                        <span class="text-gray-500">No file</span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    <form action="{{ route('reviews.store') }}" method="POST" class="flex flex-col space-y-2">
                        @csrf
                        <input type="hidden" name="talk_proposal_id" value="{{ $proposal->id }}">

                        <textarea name="comments" rows="2" placeholder="Write review..." required
                                  class="w-full border rounded px-2 py-1"></textarea>

                        <select name="rating" required class="border px-2 py-1 rounded">
                            <option value="">Rating</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>

                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                            Submit Review
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-600">No proposals found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-6">
        {{ $talkProposals->withQueryString()->links() }}
    </div>
</div>

{{-- Real-Time Notification Placeholder --}}
@push('scripts')
<script>
    Echo.channel('talk-proposals')
        .listen('TalkProposalSubmitted', (e) => {
            alert('New proposal submitted by ' + e.speaker.name);
            // Optionally trigger DOM reload or toast
        });
</script>
@endpush

@endsection
