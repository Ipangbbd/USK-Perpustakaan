@extends('layouts.app')

@section('title', 'Add Role')

@section('content')
<style>
.form-wrapper {
    max-width:600px;
    margin:0 auto;
}
.form-card {
    background:#fff;
    border-radius:16px;
    padding:1.6rem 1.8rem;
    border:1px solid #eee;
    box-shadow:0 8px 22px rgba(0,0,0,0.06);
}
.form-title {
    font-size:1.45rem;
    font-weight:500;
    margin:0;
}
.back-pill {
    padding:6px 12px;
    border-radius:9999px;
    border:1px solid rgba(0,0,0,0.1);
    font-weight:600;
    text-decoration:none;
    background:#fafafa;
}
.btn-pill.primary {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:10px 18px;
    border-radius:9999px;
    background:#000;
    color:#fff;
    font-weight:600;
    border:none;
    width:100%;
    transition:0.15s ease;
    cursor:pointer;
}
.btn-pill.primary:hover {
    opacity:.85;
}

.label {
    font-weight:600;
    margin-bottom:4px;
    display:block;
}

.input {
    width:100%;
    border-radius:10px;
    padding:10px 12px;
    border:1px solid #ddd;
    background:#fdfdfd;
}
.input:focus {
    border-color:#000;
}

.checkbox-group {
    display:flex;
    flex-direction:column;
    gap:8px;
    max-height:260px;
    overflow:auto;
    padding:8px 4px;
    border:1px solid #ddd;
    border-radius:12px;
    background:#fafafa;
}

.checkbox-item {
    display:flex;
    align-items:center;
    gap:10px;
    padding:6px 4px;
}

.checkbox-item label {
    margin:0;
    cursor:pointer;
}

.error {
    color:#c9302c;
    font-size:.85rem;
    margin-top:4px;
}
</style>

<div class="container form-wrapper">

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem;">
        <h2 class="form-title">Add New Role</h2>

        <a href="{{ route('roles.index') }}" class="back-pill">&larr; Back</a>
    </div>

    <div class="form-card">

        <form action="{{ route('roles.store') }}" method="post">
            @csrf

            {{-- Role Name --}}
            <div style="margin-bottom:1.2rem;">
                <label class="label" for="name">Role Name</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       class="input @error('name') is-invalid @enderror">

                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Permissions with Checkboxes --}}
            <div style="margin-bottom:1.2rem;">
                <label class="label">Permissions</label>

                <div class="checkbox-group @error('permissions') is-invalid @enderror">

                    @foreach ($permissions as $permission)
                        <div class="checkbox-item">
                            <input 
                                type="checkbox" 
                                id="perm-{{ $permission->id }}" 
                                name="permissions[]" 
                                value="{{ $permission->id }}"
                                {{ in_array($permission->id, old('permissions') ?? []) ? 'checked' : '' }}
                            >
                            <label for="perm-{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach

                </div>

                @error('permissions')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-pill primary">Add Role</button>

        </form>

    </div>

</div>

@endsection
