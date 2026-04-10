<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentSubmission extends Model
{
    use HasFactory;

    protected $table = 'document_submissions';

    protected $fillable = [
        'user_id',
        'full_name',
        'student_id',
        'semester',
        'academic_year',
        'batch',
        'project_title',
        'document_category',
        'original_filename',
        'stored_filename',
        'file_path',
        'mime_type',
        'file_size',
        'description',
        'status',
        'admin_notes',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'file_size' => 'integer',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for formatted file size
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    // Get category badge color
    public function getCategoryBadgeAttribute()
    {
        $badges = [
            'letter' => 'primary',
            'proposal' => 'info',
            'internship' => 'success',
            'project_document' => 'warning',
            'other' => 'secondary',
        ];
        return $badges[$this->document_category] ?? 'secondary';
    }

    // Get status badge color
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
        ];
        return $badges[$this->status] ?? 'secondary';
    }
}