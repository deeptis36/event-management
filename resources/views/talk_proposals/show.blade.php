{{-- resources/views/talk_proposals/show.blade.php --}}
@extends('layouts.app')

@section('title', $talkProposal->title)

@section('content')
    <h1 class="text-3xl font-bold mb-4">{{ $talkProposal->title }}</h1>

    <div class="bg-white p-6 rounded shadow mb-6">
          @include('talk_proposals.form', [
        'action' => route('admin.talk-proposals.update', $talkProposal),
        'talkProposal' => $talkProposal,
        'isEdit' => true
    ])
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">Revisions</h2>
        @foreach ($talkProposal->revisions as $revision)
            <div class="border-t border-gray-200 py-2 text-sm">
                <p><strong>User:</strong> {{ $revision->user->name ?? 'System' }}</p>
                <p><strong>Changes:</strong> {{ json_encode($revision->changes) }}</p>
                <p class="text-gray-500">{{ $revision->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    </div>
@endsection
