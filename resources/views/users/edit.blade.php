@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<style>
/* Hero */
.user-edit-hero {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:1.25rem;
}
.user-edit-hero h2 {
    margin:0;
    font-weight:400;
    letter-spacing:-0.3px;
}

/* Buttons */
.btn-pill {
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 12px;
    border-radius:9999px;
    font-weight:600;
    text-decoration:none;
    border:1px solid rgba(0,0,0,0.06);
    background:transparent;
    transition:all .15s ease;
    cursor:pointer;
}
.btn-pill.primary { background:#000;color:#fff;box-shadow:0 8px 22px rgba(0,0,0,0.12); }

/* Card */
.card-lux {
    background:#fff;
    border-radius:16px;
    padding:1.6rem 1.8rem;
    border:1px solid #eee;
    box-shadow:0 10px 32px rgba(0,0,0,0.06);
    max-width:640px;
    margin:0 auto;
}

/* Inputs */
.form-block { margin-bottom:1.25rem; }
.form-block label {
    font-weight:600;
    font-size:.95rem;
    margin-bottom:6px;
    display:block;
}

.lux-input,
.lux-select {
    width:100%;
    padding:10px 14px;
    border-radius:10px;
    border:1px solid #ddd;
    background:#fafafa;
    transition:border-color .15s ease, box-shadow .15s ease;
}

.lux-input:focus,
.lux-select:focus {
    border-color:#000;
    box-shadow:0 0 0 2px rgba(0,0,0,0.08);
    outline:none;
}

.invalid-feedback { color:#c33; font-size:.85rem; margin-top:4px; }

/* Submit */
.submit-btn {
    padding:10px 16px;
    border-radius:9999px;
    background:#000;
    color:#fff;
    border:none;
    font-weight:600;
    box-shadow:0 8px 22px rgba(0,0,0,0.18);
    transition:all .15s ease;
}
.submit-btn:hover {
    transform:translateY(-2px);
}
</style>

<div class="container">

    <div class="user-edit-hero">
        <h2>Edit User</h2>

        <a href="{{ route('users.index') }}" class="btn-pill">
            &larr; Back
        </a>
    </div>

    <div class="card-lux">

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAME --}}
            <div class="form-block">
                <label>Name</label>
                <input 
                    type="text"
                    name="name"
                    value="{{ $user->name }}"
                    class="lux-input @error('name') is-invalid @enderror"
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div class="form-block">
                <label>Email Address</label>
                <input 
                    type="email"
                    name="email"
                    value="{{ $user->email }}"
                    class="lux-input @error('email') is-invalid @enderror"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="form-block">
                <label>Password <span style="color:#777;font-weight:400;font-size:.85rem;">(leave empty to keep current)</span></label>
                <input 
                    type="password"
                    name="password"
                    class="lux-input @error('password') is-invalid @enderror"
                >
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="form-block">
                <label>Confirm Password</label>
                <input 
                    type="password"
                    name="password_confirmation"
                    class="lux-input"
                >
            </div>

            {{-- ROLES --}}
            <div class="form-block">
                <label>Roles</label>
                <select 
                    name="roles[]" 
                    class="lux-select @error('roles') is-invalid @enderror"
                    multiple
                >
                    @foreach ($roles as $role)
                        @if ($role !== 'Super Admin')
                            <option value="{{ $role }}"
                                {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @else
                            @if (Auth::user()->hasRole('Super Admin'))
                                <option value="{{ $role }}"
                                    {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endif
                        @endif
                    @endforeach
                </select>

                @error('roles')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- SUBMIT --}}
            <div style="margin-top:1.8rem; text-align:right;">
                <button type="submit" class="submit-btn">
                    Update User
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
