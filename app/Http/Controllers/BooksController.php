<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Http\Requests\StoreBooksRequest;
use App\Http\Requests\UpdateBooksRequest;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:view-books', [
            'only' => ['index', 'show']
        ]);

        $this->middleware('permission:create-books', [
            'only' => ['create', 'store']
        ]);

        $this->middleware('permission:edit-books', [
            'only' => ['edit', 'update']
        ]);

        $this->middleware('permission:delete-books', [
            'only' => ['destroy']
        ]);
    }

    public function index(): View
    {
        return view('books.index', [
            'books' => Books::orderByDesc('id')->paginate(10)
        ]);
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function store(StoreBooksRequest $request): RedirectResponse
    {
        // Validate and prepare data
        $data = $request->validated();

        // Extract pages (JSON string) then remove it from data to avoid mass assignment
        $pagesJson = $data['pages'] ?? null;
        if (array_key_exists('pages', $data)) {
            unset($data['pages']);
        }

        // Store files if present
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        if ($request->hasFile('document_file')) {
            $data['document_file'] = $request->file('document_file')->store('documents', 'public');
        }

        \Log::info('Book data being stored:', $data);

        // Create the book record
        $book = Books::create($data);

        // If manual type, create chapters from pages JSON
        if (($data['type'] ?? $request->get('type')) === 'manual' && $pagesJson) {
            $pages = json_decode($pagesJson, true) ?? [];
            foreach ($pages as $index => $pageContent) {
                if (trim((string)$pageContent) !== '') {
                    $book->chapters()->create([
                        'chapter_number' => $index + 1,
                        'title' => 'Page ' . ($index + 1),
                        'content' => $pageContent,
                    ]);
                }
            }
        }

        return redirect()
            ->route('books.index')
            ->withSuccess('Book added successfully.');
    }

    public function show(Books $book): View
    {
        return view('books.show', [
            'book' => $book
        ]);
    }

    public function edit(Books $book): View
    {
        return view('books.edit', [
            'book' => $book
        ]);
    }

    public function update(UpdateBooksRequest $request, Books $book): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        if ($request->hasFile('document_file')) {
            if ($book->document_file) {
                Storage::disk('public')->delete($book->document_file);
            }
            $data['document_file'] = $request->file('document_file')->store('documents', 'public');
        }

        $book->update($data);

        return redirect()
            ->route('books.index')
            ->withSuccess('Book updated successfully.');
    }

    public function destroy(Books $book): RedirectResponse
    {
        \Log::info('Deleting book:', [
            'id' => $book->id,
            'image' => $book->image,
            'document_file' => $book->document_file
        ]);

        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
            \Log::info('Image deleted: ' . $book->image);
        }

        if ($book->document_file && Storage::disk('public')->exists($book->document_file)) {
            Storage::disk('public')->delete($book->document_file);
            \Log::info('Document deleted: ' . $book->document_file);
        }

        $book->delete();

        return redirect()
            ->route('books.index')
            ->withSuccess('Book deleted successfully.');
    }
}
