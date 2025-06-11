@extends('layouts.app')

@section('title', 'Reviews for Talk Proposal')

@section('content')
<div class="max-w-4xl mx-auto mt-6">
    <h2 class="text-2xl font-semibold mb-4">Users We have</h2>

    <div class="mt-8">
        <h3 class="text-xl font-bold mb-2">Users</h3>
        @forelse ($users as $user)
            <div class="bg-white p-4 rounded shadow mb-4 border">
                <p class="text-sm text-gray-600">
                     <strong>{{ $user->name }}</strong>
                     {{ $user->email }}
                    <span class="ml-4">Rating: <strong>{{ $user->getRoleNames() }}</strong></span>
                </p>

            </div>
        @empty
            <p class="text-gray-600">No user available .</p>
        @endforelse
    </div>
</div>
@endsection
