@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<style>
/* Same luxury look from Add page */
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

.info-box {
    padding:12px 14px;
    background:#f0f0f0;
    border-radius:12px;
    font-size:0.9rem;
    color:#666;
    margin-bottom:1.25rem;
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
</style>

<div class="container">

    <!-- PAGE HEADER -->
    <div class="page-hero">
        <div>
            <h2>Edit Book</h2>
            <div style="color:#666;font-size:.95rem;margin-top:6px;">
                Update the book’s information with a refined interface.
            </div>
        </div>

        <a href="{{ route('books.index') }}" class="btn-pill ghost">
            ← Back
        </a>
    </div>

    <!-- FORM CARD -->
    <div class="form-card">

        @if($book->type === 'document')
            <div class="info-box">
                📄 This is a document-based book. You can update the document file or keep the current one.
            </div>
        @else
            <div class="info-box">
                📝 This is a manual entry book. You can update the description and cover image.
            </div>
        @endif

        <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- HIDDEN TYPE INPUT -->
            <input type="hidden" name="type" value="{{ $book->type }}">

            <!-- NAME -->
            <div class="form-group">
                <label class="label-title">Book Name</label>
                <input
                    type="text"
                    name="name"
                    class="input-modern @error('name') is-invalid @enderror"
                    value="{{ $book->name }}"
                    placeholder="Enter the book name..."
                >
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            
                <!-- DESCRIPTION (Manual only) -->
                <div class="form-group">
                    <label class="label-title">Description</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="input-modern @error('description') is-invalid @enderror"
                        placeholder="Write a short description...">{{ $book->description }}</textarea>

                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @if($book->type === 'document')
                <!-- DOCUMENT FILE (Document only) -->
                <div class="form-group">
                    <label class="label-title">Document File</label>
                    @if($book->document_file)
                        <div style="padding:12px;background:#f5f5f5;border-radius:8px;margin-bottom:12px;font-size:0.9rem;">
                            📄 Current file: 
                            <a href="{{ $book->document_url }}" target="_blank" style="color:#0066cc;text-decoration:none;">
                                {{ basename($book->document_file) }}
                            </a>
                        </div>
                    @endif
                    <input
                        type="file"
                        name="document_file"
                        class="input-modern @error('document_file') is-invalid @enderror"
                        accept=".pdf,.doc,.docx"
                        id="editDocumentInput"
                        onchange="previewDocumentEdit(event)"
                    >
                    <div style="font-size:0.85rem;color:#666;margin-top:6px;">
                        Leave empty to keep current document. Accepted formats: PDF, DOC, DOCX (Max 10MB)
                    </div>
                    <div id="editDocPreview" class="doc-preview-container" style="display:none;">
                        <span class="doc-preview-label">New File Preview:</span>
                        <div id="editDocxPreview"></div>
                    </div>
                    @error('document_file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @endif

            <!-- IMAGE -->
            <div class="form-group">
                <label class="label-title">Book Cover Image</label>
                @if($book->image)
                    <div style="margin-bottom:12px;">
                        <img src="{{ $book->image_url }}" alt="{{ $book->name }}" style="max-width:150px;border-radius:8px;">
                        <div style="font-size:0.85rem;color:#666;margin-top:8px;">Current image</div>
                    </div>
                @endif
                <input
                    type="file"
                    name="image"
                    class="input-modern @error('image') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                >
                <div style="font-size:0.85rem;color:#666;margin-top:6px;">
                    Leave empty to keep current image. Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB)
                </div>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- SUBMIT -->
            <div style="margin-top:1.8rem; display:flex; justify-content:center;">
                <button type="submit" class="btn-pill primary" style="padding:10px 30px;">
                    Update Book
                </button>
            </div>

        </form>

    </div>

</div>

<script>
function previewDocumentEdit(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    const ext = file.name.split('.').pop().toLowerCase();
    const previewContainer = document.getElementById('editDocPreview');
    const docxPreview = document.getElementById('editDocxPreview');
    
    if (ext === 'docx') {
        const reader = new FileReader();
        reader.onload = function(e) {
            const arrayBuffer = e.target.result;
            
            // Load Mammoth.js
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/mammoth/mammoth.browser.min.js';
            script.onload = function() {
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
            document.head.appendChild(script);
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
