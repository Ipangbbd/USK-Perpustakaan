@extends('layouts.app')

@section('title', 'Book Details')

@section('content')
    <style>
        /* Consistent luxury style */
        .page-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .page-hero h2 {
            margin: 0;
            font-weight: 400;
            letter-spacing: -0.3px;
        }

        .btn-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: transparent;
            transition: .15s ease;
        }

        .btn-pill.ghost {
            color: #111;
        }

        .btn-pill.primary {
            background: #000;
            color: #fff;
        }

        .detail-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #eee;
            padding: 1.5rem 1.6rem;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.05);
        }

        .detail-item {
            margin-bottom: 1.4rem;
        }

        .detail-label {
            font-size: 1.05rem;
            color: #111;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .detail-value {
            font-size: 1rem;
            color: #393939ff;
            font-weight: 400;
        }

        .separator {
            height: 1px;
            background: #eee;
            margin: 1rem 0;
        }

        .document-viewer {
            width: 100%;
            height: 600px;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .doc-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            background: #f0f0f0;
            border-radius: 9999px;
            text-decoration: none;
            color: #000;
            font-weight: 600;
            transition: .15s ease;
        }

        .doc-download:hover {
            background: #e0e0e0;
        }

        .docx-viewer {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            line-height: 1.6;
            font-size: 1rem;
            max-height: 700px;
            overflow-y: auto;
        }

        .docx-viewer p {
            margin-bottom: 1rem;
        }

        .docx-viewer h1,
        .docx-viewer h2,
        .docx-viewer h3 {
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
    </style>

    <div class="container">

        <!-- Top Title Bar -->
        <div class="page-hero">
            <div>
                <h2>Book Details</h2>
                <div style="color:#666;font-size:.95rem;margin-top:6px;">
                    View complete information about this entry.
                </div>
            </div>

            <a href="{{ route('books.index') }}" class="btn-pill ghost">← Back</a>
        </div>

        <!-- Details Card -->
        <div class="detail-card">

            @if($book->image)
                <div class="detail-item" style="margin-bottom:1.5rem;">
                    <img src="{{ $book->image_url }}" alt="{{ $book->name }}"
                        style="width:100%;max-height:400px;object-fit:cover;border-radius:12px;">
                </div>
            @endif

            <div class="detail-item">
                <div class="detail-label">Name</div>
                <div class="detail-value">{{ $book->name }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Description</div>
                <div class="detail-value" style="white-space:pre-line;">
                    {{ $book->description }}
                </div>
            </div>

            <div class="separator"></div>

            @if($book->type === 'document' && $book->document_file)
                <div class="detail-item">
                    <div class="detail-label">Document</div>
                    <div style="margin-top:8px;">
                        @php
                            $ext = pathinfo($book->document_file, PATHINFO_EXTENSION);
                        @endphp
                        @if($ext === 'pdf')
                            <embed src="{{ $book->document_url }}" type="application/pdf" class="document-viewer">
                        @elseif($ext === 'docx')
                            <div id="docx-container" class="docx-viewer"></div>
                        @else
                            <div style="padding:16px;background:#f5f5f5;border-radius:12px;text-align:center;">
                                <p style="color:#666;margin-bottom:12px;">Document Preview</p>
                                <a href="{{ $book->document_url }}" class="doc-download" download>
                                    📄 Download {{ strtoupper($ext) }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="separator"></div>

                <div class="separator"></div>
            @endif

            @can('edit-books')
                <div style="margin-top:2rem; display:flex; gap:10px;">
                    <a href="{{ route('books.edit', $book->id) }}" class="btn-pill primary">Edit Book</a>
                </div>
            @endcan

        </div>

    </div>

    @if($book->type === 'document' && $book->document_file && pathinfo($book->document_file, PATHINFO_EXTENSION) === 'docx')
        <script src="https://unpkg.com/mammoth/mammoth.browser.min.js"></script>
        <script>
            fetch("{{ $book->document_url }}")
                .then(res => res.arrayBuffer())
                .then(buffer => mammoth.convertToHtml({ arrayBuffer: buffer }))
                .then(result => {
                    document.getElementById('docx-container').innerHTML = result.value;
                })
                .catch(error => {
                    document.getElementById('docx-container').innerHTML = '<p style="color:red;">Error loading document. <a href="{{ $book->document_url }}" download>Download instead</a></p>';
                });
        </script>
    @endif

@endsection