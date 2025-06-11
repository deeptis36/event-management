@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold">Speaker Dashboard</h1>
    <p>Welcome, {{ $user->name }}!</p>
</div>
@endsection
