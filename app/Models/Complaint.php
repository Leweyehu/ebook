<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'complainant_type',
        'name',
        'email',
        'phone',
        'student_id',
        'staff_id',
        'department',
        'year',
        'category',
        'sub_category',
        'subject',
        'description',
        'attachment',
        'priority',
        'status',
        'admin_response',
        'resolved_at',
        'is_anonymous',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    // Generate unique reference number
    public static function generateReferenceNo()
    {
        $prefix = 'CMP';
        $year = date('Y');
        $random = strtoupper(substr(uniqid(), -6));
        return $prefix . $year . $random;
    }

    // Scope filters
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function getPriorityBadgeAttribute()
    {
        $badges = [
            'low' => ['bg' => '#28a745', 'icon' => 'fa-arrow-down'],
            'medium' => ['bg' => '#ffc107', 'icon' => 'fa-minus'],
            'high' => ['bg' => '#fd7e14', 'icon' => 'fa-arrow-up'],
            'urgent' => ['bg' => '#dc3545', 'icon' => 'fa-exclamation-triangle']
        ];
        
        $badge = $badges[$this->priority] ?? $badges['medium'];
        return "<span style='background: {$badge['bg']}; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;'><i class='fas {$badge['icon']}'></i> " . ucfirst($this->priority) . "</span>";
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => ['bg' => '#ffc107', 'icon' => 'fa-clock', 'text' => 'Pending Review'],
            'reviewing' => ['bg' => '#17a2b8', 'icon' => 'fa-search', 'text' => 'Under Review'],
            'resolved' => ['bg' => '#28a745', 'icon' => 'fa-check-circle', 'text' => 'Resolved'],
            'rejected' => ['bg' => '#dc3545', 'icon' => 'fa-times-circle', 'text' => 'Rejected'],
            'escalated' => ['bg' => '#fd7e14', 'icon' => 'fa-arrow-up', 'text' => 'Escalated']
        ];
        
        $badge = $badges[$this->status] ?? $badges['pending'];
        return "<span style='background: {$badge['bg']}; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;'><i class='fas {$badge['icon']}'></i> {$badge['text']}</span>";
    }
}