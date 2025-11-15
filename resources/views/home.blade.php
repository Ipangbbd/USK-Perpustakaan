@extends('layouts.app')

@section('content')
<div class="dashboard">

    @if (session('status'))
        <div class="dash-alert">
            {{ session('status') }}
        </div>
    @endif

    <h1 class="dash-title">Dashboard</h1>
    <p class="dash-sub">Welcome back, {{ auth()->user()->name }}.</p>

    <div class="dash-grid">

        @canany(['create-role','edit-role','delete-role'])
        <a href="{{ route('roles.index') }}" class="dash-card">
            <div class="icon"><i class="bi bi-person-fill-gear"></i></div>
            <div class="label">Manage Roles</div>
        </a>
        @endcanany

        @canany(['create-user','edit-user','delete-user'])
        <a href="{{ route('users.index') }}" class="dash-card">
            <div class="icon"><i class="bi bi-people"></i></div>
            <div class="label">Manage Users</div>
        </a>
        @endcanany

        @canany(['create-books','edit-books','delete-books'])
        <a href="{{ route('books.index') }}" class="dash-card">
            <div class="icon"><i class="bi bi-book"></i></div>
            <div class="label">Manage Books</div>
        </a>
        @endcanany

        @can('view-books')
        <a href="{{ route('books.index') }}" class="dash-card">
            <div class="icon"><i class="bi bi-eye"></i></div>
            <div class="label">View Books</div>
        </a>
        @endcan

    </div>

</div>
@endsection
