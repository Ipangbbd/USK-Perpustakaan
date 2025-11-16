@extends('layouts.app')
@section('title', 'Edit Role')
@section('content')
<style>
.form-wrapper{max-width:600px;margin:0 auto}
.form-card{background:#fff;border-radius:16px;padding:1.6rem 1.8rem;border:1px solid #eee;box-shadow:0 8px 22px rgba(0,0,0,0.06)}
.form-title{font-size:1.45rem;font-weight:500;margin:0}
.back-pill{padding:6px 12px;border-radius:9999px;border:1px solid rgba(0,0,0,0.1);font-weight:600;text-decoration:none;background:#fafafa}
.btn-pill.primary{display:inline-flex;align-items:center;justify-content:center;padding:10px 18px;border-radius:9999px;background:#000;color:#fff;font-weight:600;border:none;width:100%;transition:0.15s ease;cursor:pointer}
.btn-pill.primary:hover{opacity:.85}
.label{font-weight:600;margin-bottom:4px;display:block}
.input,.select-box{width:100%;border-radius:10px;padding:10px 12px;border:1px solid #ddd;background:#fdfdfd;transition:0.15s ease}
.input:focus,.select-box:focus{border-color:#000}
.error{color:#c9302c;font-size:.85rem;margin-top:4px}
</style>
<div class="container form-wrapper">
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem">
<h2 class="form-title">Edit Role</h2>
<a href="{{ route('roles.index') }}" class="back-pill">&larr; Back</a>
</div>
<div class="form-card">
<form action="{{ route('roles.update', $role->id) }}" method="post">
@csrf
@method('PUT')
<div style="margin-bottom:1.2rem">
<label class="label" for="name">Role Name</label>
<input type="text" id="name" name="name" value="{{ $role->name }}" class="input @error('name') is-invalid @enderror">
@error('name')
<div class="error">{{ $message }}</div>
@enderror
</div>
<div style="margin-bottom:1.2rem">
<label class="label" for="permissions">Permissions</label>
<select id="permissions" name="permissions[]" class="select-box @error('permissions') is-invalid @enderror" multiple style="height:220px">
@foreach ($permissions as $permission)
<option value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions ?? []) ? 'selected' : '' }}>{{ $permission->name }}</option>
@endforeach
</select>
@error('permissions')
<div class="error">{{ $message }}</div>
@enderror
</div>
<button type="submit" class="btn-pill primary">Update Role</button>
</form>
</div>
</div>
@endsection