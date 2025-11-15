@extends('layouts.app')

@section('title', 'Add Book')

@section('content')
<style>
/* Match index's luxury aesthetic */
.page-hero {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:1.5rem;
}

.page-hero h2 {
    margin:0;
    font-weight:400;
    letter-spacing:-0.3px;
}

.btn-pill {
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 14px;
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

.btn-pill.ghost {
    background:transparent;
    color:var(--text);
}

.form-card {
    background:#fff;
    border-radius:16px;
    padding:1.5rem;
    border:1px solid #eee;
    box-shadow:0 10px 26px rgba(0,0,0,0.04);
    max-width:700px;
    margin:auto;
}

.tabs {
    display:flex;
    gap:8px;
    margin-bottom:1.5rem;
    border-bottom:1px solid #eee;
}

.tab-btn {
    padding:12px 16px;
    border:none;
    background:transparent;
    cursor:pointer;
    font-weight:600;
    font-size:0.95rem;
    color:#666;
    border-bottom:3px solid transparent;
    transition:all .15s ease;
}

.tab-btn.active {
    color:#000;
    border-bottom-color:#000;
}

.tab-content {
    display:none;
}

.tab-content.active {
    display:block;
}

.form-group {
    margin-bottom:1.25rem;
}

.label-title {
    font-weight:600;
    margin-bottom:6px;
    font-size:0.95rem;
}

.input-modern {
    width:100%;
    border-radius:12px;
    padding:12px 14px;
    border:1px solid #ddd;
    background:#fafafa;
    transition:.15s ease;
}

.input-modern:focus {
    border-color:#000;
    background:#fff;
}

.text-danger {
    margin-top:4px;
    font-size:0.85rem;
    display:block;
}

select.input-modern {
    cursor:pointer;
}

.doc-preview-container {
    margin-top:12px;
    padding:12px;
    background:#f9f9f9;
    border-radius:8px;
    max-height:300px;
    overflow-y:auto;
    border:1px solid #e0e0e0;
}

.doc-preview-label {
    font-size:0.85rem;
    color:#666;
    margin-bottom:8px;
    display:block;
}

.page-editor {
    background:#f9f9f9;
    border:1px solid #ddd;
    border-radius:12px;
    padding:16px;
    margin-bottom:1.25rem;
}

.page-nav {
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:16px;
    padding:12px;
    background:#fff;
    border-radius:8px;
    border:1px solid #e0e0e0;
}

.page-counter {
    font-weight:600;
    font-size:0.95rem;
    color:#666;
}

.page-controls {
    display:flex;
    gap:8px;
}

.page-btn {
    padding:6px 12px;
    border-radius:8px;
    border:1px solid #ddd;
    background:#fff;
    cursor:pointer;
    font-weight:600;
    font-size:0.85rem;
    transition:.15s ease;
}

.page-btn:hover {
    background:#f0f0f0;
    border-color:#000;
}

.page-btn:disabled {
    opacity:0.5;
    cursor:not-allowed;
}

.page-textarea {
    width:100%;
    min-height:400px;
    border-radius:8px;
    padding:12px;
    border:1px solid #ddd;
    background:#fff;
    font-family:'Courier New', monospace;
    font-size:0.95rem;
    resize:vertical;
}

.page-textarea:focus {
    border-color:#000;
    outline:none;
}

</style>

<div class="container">

    <!-- PAGE TITLE BAR -->
    <div class="page-hero">
        <div>
            <h2>Add New Book</h2>
            <div style="color:#666;font-size:.95rem;margin-top:6px;">
                Create a new library entry — clean and simple.
            </div>
        </div>

        <a href="{{ route('books.index') }}" class="btn-pill ghost">
            ← Back
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="form-card">

        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('manual', this)">Manual Entry</button>
            <button class="tab-btn" onclick="switchTab('document', this)">Upload Document</button>
        </div>

        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- HIDDEN TYPE INPUT -->
            <input type="hidden" name="type" id="bookType" value="manual">

            <!-- MANUAL TAB -->
            <div id="manual" class="tab-content active">
                <!-- NAME -->
                <div class="form-group">
                    <label class="label-title">Book Name</label>
                    <input
                        type="text"
                        name="name"
                        class="input-modern @error('name') is-invalid @enderror"
                        placeholder="Enter the book name..."
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label class="label-title">Description</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="input-modern @error('description') is-invalid @enderror"
                        placeholder="Write a short description...">{{ old('description') }}</textarea>

                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- IMAGE -->
                <div class="form-group">
                    <label class="label-title">Book Cover Image</label>
                    <input
                        type="file"
                        name="image"
                        class="input-modern @error('image') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                    >
                    <div style="font-size:0.85rem;color:#666;margin-top:6px;">
                        Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB)
                    </div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- PAGE EDITOR -->
                <div class="form-group">
                    <label class="label-title">Book Content (Pages)</label>
                    <div class="page-editor">
                        <div class="page-nav">
                            <span class="page-counter">Page <span id="currentPage">1</span> of <span id="totalPages">1</span></span>
                            <div class="page-controls">
                                <button type="button" class="page-btn" onclick="prevPage()" id="prevBtn" disabled>← Previous</button>
                                <button type="button" class="page-btn" onclick="nextPage()" id="nextBtn">Next →</button>
                                <button type="button" class="page-btn" onclick="addPage()" style="background:#000;color:#fff;">+ Add Page</button>
                                <button type="button" class="page-btn" onclick="removePage()" id="removeBtn" style="background:#dc3545;color:#fff;display:none;">Remove</button>
                            </div>
                        </div>
                        <textarea 
                            id="pageContent" 
                            class="page-textarea"
                            placeholder="Write your book content here..."></textarea>
                    </div>
                    <input type="hidden" id="pagesData" name="pages" value="[]">
                </div>
            </div>

            <!-- DOCUMENT TAB -->
            <div id="document" class="tab-content">
                <!-- NAME -->
                <div class="form-group">
                    <label class="label-title">Book Name</label>
                    <input
                        type="text"
                        name="name"
                        class="input-modern @error('name') is-invalid @enderror"
                        placeholder="Enter the book name..."
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- DESCRIPTION (Optional for documents) -->
                <div class="form-group">
                    <label class="label-title">Description (Optional)</label>
                    <textarea
                        name="description"
                        rows="3"
                        class="input-modern @error('description') is-invalid @enderror"
                        placeholder="Write a short description...">{{ old('description') }}</textarea>

                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- DOCUMENT FILE -->
                <div class="form-group">
                    <label class="label-title">Upload PDF or Document</label>
                    <input
                        type="file"
                        name="document_file"
                        class="input-modern @error('document_file') is-invalid @enderror"
                        accept=".pdf,.doc,.docx"
                        id="documentFile"
                        onchange="previewDocument(event)"
                    >
                    <div style="font-size:0.85rem;color:#666;margin-top:6px;">
                        Accepted formats: PDF, DOC, DOCX (Max 10MB)
                    </div>
                    <div id="docPreview" class="doc-preview-container" style="display:none;">
                        <span class="doc-preview-label">Preview:</span>
                        <div id="docxPreview"></div>
                    </div>
                    @error('document_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- IMAGE -->
                <div class="form-group">
                    <label class="label-title">Book Cover Image (Optional)</label>
                    <input
                        type="file"
                        name="image"
                        class="input-modern @error('image') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                    >
                    <div style="font-size:0.85rem;color:#666;margin-top:6px;">
                        Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB)
                    </div>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- SUBMIT -->
            <div style="margin-top:1.8rem; display:flex; justify-content:center;">
                <button type="submit" class="btn-pill primary" style="padding:10px 28px;">
                    Save Book
                </button>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/mammoth@1/mammoth.browser.min.js"></script>
<script>
// Page Editor State
let pages = [''];
let currentPageIndex = 0;

function updatePageDisplay() {
    const pageContent = document.getElementById('pageContent');
    if (!pageContent) return;
    
    pageContent.value = pages[currentPageIndex] || '';
    document.getElementById('currentPage').textContent = currentPageIndex + 1;
    document.getElementById('totalPages').textContent = pages.length;

    // Update button states
    document.getElementById('prevBtn').disabled = currentPageIndex === 0;
    document.getElementById('nextBtn').disabled = currentPageIndex === pages.length - 1;
    document.getElementById('removeBtn').style.display = pages.length > 1 ? 'inline-block' : 'none';
    
    // Update hidden input with all pages as JSON
    document.getElementById('pagesData').value = JSON.stringify(pages);
}

function prevPage() {
    if (currentPageIndex > 0) {
        pages[currentPageIndex] = document.getElementById('pageContent').value;
        currentPageIndex--;
        updatePageDisplay();
    }
}

function nextPage() {
    if (currentPageIndex < pages.length - 1) {
        pages[currentPageIndex] = document.getElementById('pageContent').value;
        currentPageIndex++;
        updatePageDisplay();
    }
}

function addPage() {
    pages[currentPageIndex] = document.getElementById('pageContent').value;
    pages.push('');
    currentPageIndex = pages.length - 1;
    updatePageDisplay();
}

function removePage() {
    if (pages.length > 1) {
        pages.splice(currentPageIndex, 1);
        if (currentPageIndex >= pages.length) {
            currentPageIndex = pages.length - 1;
        }
        updatePageDisplay();
    }
}

// Initialize page editor on load
document.addEventListener('DOMContentLoaded', function() {
    const pageContent = document.getElementById('pageContent');
    if (pageContent) {
        pageContent.addEventListener('input', function() {
            pages[currentPageIndex] = this.value;
            document.getElementById('pagesData').value = JSON.stringify(pages);
        });
        updatePageDisplay();
    }

    // Ensure current page is saved right before form submit
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function () {
            const pc = document.getElementById('pageContent');
            if (pc && typeof currentPageIndex !== 'undefined') {
                pages[currentPageIndex] = pc.value;
                document.getElementById('pagesData').value = JSON.stringify(pages);
            }
        });
    }
});

// Tab switching logic
function switchTab(tab, btn) {
    // Save current page content before switching tabs
    if (currentPageIndex !== undefined) {
        const pageContent = document.getElementById('pageContent');
        if (pageContent) {
            pages[currentPageIndex] = pageContent.value;
            document.getElementById('pagesData').value = JSON.stringify(pages);
        }
    }

    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    
    // Show selected tab
    document.getElementById(tab).classList.add('active');
    btn.classList.add('active');
    
    // Update hidden input
    document.getElementById('bookType').value = tab;
}

// Document file preview with Mammoth.js
function previewDocument(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    const ext = file.name.split('.').pop().toLowerCase();
    const previewContainer = document.getElementById('docPreview');
    const docxPreview = document.getElementById('docxPreview');
    
    if (ext === 'docx') {
        const reader = new FileReader();
        reader.onload = function(e) {
            const arrayBuffer = e.target.result;
            mammoth.convertToHtml({arrayBuffer: arrayBuffer})
                .then(result => {
                    docxPreview.innerHTML = result.value;
                    previewContainer.style.display = 'block';
                })
                .catch(error => {
                    docxPreview.innerHTML = '<p style="color:#999;">Preview not available</p>';
                    previewContainer.style.display = 'block';
                });
        };
        reader.readAsArrayBuffer(file);
    } else if (ext === 'pdf') {
        docxPreview.innerHTML = '<p style="color:#999;">PDF preview not available in form. Upload to view.</p>';
        previewContainer.style.display = 'block';
    } else {
        previewContainer.style.display = 'none';
    }
}
</script>

@endsection
