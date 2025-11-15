<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BookChapter;

/**
 * Class Books
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property string|null $document_file
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Books extends Model
{
    protected $fillable = ['name', 'description', 'image', 'type', 'document_file'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getDocumentUrlAttribute()
    {
        return $this->document_file ? asset('storage/' . $this->document_file) : null;
    }

    public function chapters()
    {
        return $this->hasMany('App\Models\BookChapter')->orderBy('chapter_number');
    }
}
