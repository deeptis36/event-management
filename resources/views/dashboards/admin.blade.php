@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>

        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                <!-- Total Talk Proposals -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Talk Proposals</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $data['totalTalkProposals'] }}</dd>
                    </div>
                </div>

                <!-- Pending Proposals -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Proposals</dt>
                        <dd class="mt-1 text-3xl font-semibold text-yellow-600">{{ $data['totalTalkProposalsPending'] }}</dd>
                    </div>
                </div>

                <!-- Approved Proposals -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Approved Proposals</dt>
                        <dd class="mt-1 text-3xl font-semibold text-green-600">{{ $data['totalTalkProposalsApproved'] }}</dd>
                    </div>
                </div>

                <!-- Rejected Proposals -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Rejected Proposals</dt>
                        <dd class="mt-1 text-3xl font-semibold text-red-600">{{ $data['totalTalkProposalsRejected'] }}</dd>
                    </div>
                </div>

                <!-- Total Revisions -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Revisions</dt>
                        <dd class="mt-1 text-3xl font-semibold text-blue-600">{{ $data['totalRevisions'] }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Include Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@endsection
