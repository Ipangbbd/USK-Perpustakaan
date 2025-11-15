@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<style>
/* Scoped Luxury Styles */
.roles-hero {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:1.25rem;
}
.roles-hero h2 {
    margin:0;
    font-weight:400;
    letter-spacing:-0.3px;
}
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
.btn-pill.primary {
    background:#000;
    color:#fff;
    box-shadow:0 8px 22px rgba(0,0,0,0.12);
}

/* Grid */
.grid {
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(280px,1fr));
    gap:1rem;
}

/* Role Card */
.role-card {
    background:#fff;
    border-radius:14px;
    padding:1.1rem 1.2rem;
    border:1px solid #eee;
    transition:transform .18s ease, box-shadow .18s ease;
    display:flex;
    flex-direction:column;
    min-height:150px;
}
.role-card:hover {
    transform:translateY(-6px);
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    border-color:#000;
}

.role-name {
    margin:0;
    font-size:1.1rem;
    font-weight:600;
}

.permissions {
    margin-top:10px;
}
.permissions span {
    display:inline-block;
    padding:4px 10px;
    background:#f6f6f6;
    border-radius:9999px;
    font-weight:500;
    margin-right:6px;
    margin-top:4px;
    font-size:.82rem;
}

/* Actions */
.actions {
    margin-top:14px;
    display:flex;
    gap:8px;
}
.action-pill {
    padding:6px 10px;
    border-radius:9999px;
    border:1px solid transparent;
    background:transparent;
    font-weight:600;
    font-size:.85rem;
    text-decoration:none;
}
.action-pill.edit { color:#0066cc;border-color:rgba(0,102,204,0.08); }
.action-pill.delete { color:#c9302c;border-color:rgba(201,48,44,0.12); }

/* Empty state */
.empty {
    text-align:center;
    padding:3rem 1rem;
    border-radius:12px;
    border:1px dashed #eee;
    color:#b33;
}
.pagination-wrapper {
    margin-top:1.25rem;
    display:flex;
    justify-content:center;
}
</style>


<div class="roles-hero container">
    <div>
        <h2>Roles</h2>
        <div style="color:#666;font-size:.95rem;margin-top:6px;">Manage roles & assigned permissions.</div>
    </div>

    @can('create-role')
        <a href="{{ route('roles.create') }}" class="btn-pill primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                <path d="M12 5v14M5 12h14"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"/>
            </svg>
            Add Role
        </a>
    @endcan
</div>

<div class="container">

    {{-- Success Message --}}
    @if ($message = Session::get('success'))
        <div class="alert"
             style="background:#e8ffe8;border:1px solid #bce8bc;color:#042; border-radius:12px;padding:10px 14px;margin-bottom:14px;">
            {{ $message }}
        </div>
    @endif


    @if ($roles->count())
        <div class="grid">

            @foreach ($roles as $index => $role)
                @php
                    $serial = ($roles->firstItem() ?? 0) + $index;
                @endphp

                <article class="role-card">
                    <h3 class="role-name">{{ $serial }}. {{ $role->name }}</h3>

                    <div class="permissions">
                        @forelse ($role->permissions as $permission)
                            <span>{{ $permission->name }}</span>
                        @empty
                            <span style="background:#ffeaea;color:#a00;">No Permissions</span>
                        @endforelse
                    </div>

                    {{-- Actions --}}
                    <div class="actions">

                        {{-- Edit --}}
                        @if ($role->name !== 'Super Admin')
                            @can('edit-role')
                                <a href="{{ route('roles.edit', $role->id) }}" class="action-pill edit">Edit</a>
                            @endcan
                        @endif

                        {{-- Delete --}}
                        @if ($role->name !== 'Super Admin')
                            @can('delete-role')
                                @if (!Auth::user()->hasRole($role->name))
                                <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="action-pill delete"
                                            onclick="return confirm('Delete this role?');"
                                            type="submit">
                                        Delete
                                    </button>
                                </form>
                                @endif
                            @endcan
                        @endif

                    </div>

                </article>
            @endforeach

        </div>

        <div class="pagination-wrapper">
            {{ $roles->onEachSide(1)->links() }}
        </div>

    @else
        <div class="empty">
            <strong>No roles found.</strong>
            @can('create-role')
                <div style="margin-top:10px;">
                    <a href="{{ route('roles.create') }}" class="btn-pill primary">Add the first role</a>
                </div>
            @endcan
        </div>
    @endif

</div>

@endsection
