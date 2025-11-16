@extends('layouts.app')
@section('title', 'Books')
@section('content')
<style>
.books-hero{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:1.25rem}
.books-hero h2{margin:0;font-weight:400;letter-spacing:-0.3px}
.btn-pill{display:inline-flex;align-items:center;gap:8px;padding:8px 12px;border-radius:9999px;font-weight:600;text-decoration:none;border:1px solid rgba(0,0,0,0.06);background:transparent;transition:all .15s ease;cursor:pointer}
.btn-pill.primary{background:#000;color:#fff;box-shadow:0 8px 22px rgba(0,0,0,0.12)}
.btn-pill.ghost{background:transparent;color:var(--text)}
.btn-pill.danger{background:transparent;border-color:rgba(220,40,40,0.12);color:rgba(220,40,40,1)}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1rem}
.book-card{background:#fff;border-radius:14px;padding:1rem;border:1px solid #eee;transition:transform .18s ease, box-shadow .18s ease;display:flex;flex-direction:column;min-height:148px}
.book-card:hover{transform:translateY(-6px);box-shadow:0 12px 30px rgba(0,0,0,0.08);border-color:#000}
.book-image{width:100%;height:400px;object-fit:cover;border-radius:10px;margin-bottom:0.8rem}
.card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:0.6rem}
.card-title{font-size:1rem;font-weight:600;margin:0;color:var(--text)}
.card-desc{font-size:0.95rem;color:#555;margin-top:6px;flex:1 1 auto;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical}
.card-meta{margin-top:10px;display:flex;align-items:center;justify-content:space-between;gap:8px}
.actions{display:flex;gap:8px}
.pill-action{padding:6px 10px;border-radius:9999px;border:1px solid transparent;background:transparent;font-weight:600;text-decoration:none;font-size:0.85rem}
.pill-action.show{color:#b07a00;border-color:rgba(176,122,0,0.06)}
.pill-action.edit{color:#0066cc;border-color:rgba(0,102,204,0.06)}
.pill-action.delete{color:#c9302c;border-color:rgba(201,48,44,0.06)}
.empty{text-align:center;padding:3rem 1rem;border-radius:12px;border:1px dashed #eee;color:#b33}
.pagination-wrapper{margin-top:1.25rem;display:flex;align-items:center;justify-content:center}
</style>
<div class="books-hero container">
<div>
<h2>Books</h2>
<div style="color:#666;font-size:.95rem;margin-top:6px">Manage library entries — clean and fast.</div>
</div>
<div style="display:flex;align-items:center;gap:8px">
@can('create-books')
<a href="{{ route('books.create') }}" class="btn-pill primary">
<svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden>
<path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
Add Book
</a>
@endcan
</div>
</div>
<div class="container">
@if ($message = Session::get('success'))
<div class="alert" style="background:#e8ffe8;border:1px solid #bce8bc;color:#042;border-radius:12px;padding:10px 14px;margin-bottom:14px">{{ $message }}</div>
@endif
@if ($books->count())
<div class="grid">
@foreach ($books as $index => $book)
@php
$serial = ($books->firstItem() ?? 0) + $index;
@endphp
<article class="book-card" aria-labelledby="book-{{ $book->id }}">
@if($book->image)
<img src="{{ $book->image_url }}" alt="{{ $book->name }}" class="book-image">
@endif
<div class="card-head">
<div>
<h3 id="book-{{ $book->id }}" class="card-title">{{ $book->name }}</h3>
<div class="card-desc">{{ $book->description ?? '-' }}</div>
</div>
<div style="min-width:86px;text-align:right;color:#999;font-size:.9rem">
@if($book->created_at)
<div title="{{ $book->created_at }}">{{ $book->created_at->format('M d, Y') }}</div>
@endif
</div>
</div>
<div class="card-meta">
<div class="actions" role="group" aria-label="book actions">
<a href="{{ route('books.show', $book->id) }}" class="pill-action show" title="Show">Show</a>
@can('edit-books')
<a href="{{ route('books.edit', $book->id) }}" class="pill-action edit" title="Edit">Edit</a>
@endcan
@can('delete-books')
<form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline">
@csrf
@method('DELETE')
<button type="submit" class="pill-action delete" onclick="return confirmDelete(this);" title="Delete">Delete</button>
</form>
@endcan
</div>
</div>
</article>
@endforeach
</div>
<div class="pagination-wrapper">{{ $books->onEachSide(1)->links() }}</div>
@else
<div class="empty">
<strong>No books found.</strong>
@can('create-books')
<div style="margin-top:10px">
<a href="{{ route('books.create') }}" class="btn-pill primary">Add the first book</a>
</div>
@endcan
</div>
@endif
</div>
<script>
function confirmDelete(btn){return confirm('Are you sure you want to delete this book? This action cannot be undone.')}
</script>
@endsection