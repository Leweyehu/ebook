<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsEvent extends Model
{
    use HasFactory;

    protected $table = 'news_events';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'type',
        'featured_image',
        'gallery_images',
        'video_url',
        'event_date',
        'event_time',
        'event_location',
        'organizer',
        'contact_email',
        'contact_phone',
        'is_featured',
        'is_published',
        'views',
        'author',
        'attachments',
        'published_at'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'attachments' => 'array',
        'event_date' => 'date',
        'event_time' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title) . '-' . uniqid();
            }
            if (empty($news->excerpt)) {
                $news->excerpt = Str::limit(strip_tags($news->content), 150);
            }
            if (empty($news->published_at) && $news->is_published) {
                $news->published_at = now();
            }
        });
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('F j, Y');
    }

    public function getFormattedEventDateAttribute()
    {
        if ($this->event_date) {
            return $this->event_date->format('F j, Y');
        }
        return null;
    }

    public function getFormattedEventTimeAttribute()
    {
        if ($this->event_time) {
            return $this->event_time->format('g:i A');
        }
        return null;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('type', 'event')
                     ->where('event_date', '>=', now())
                     ->orderBy('event_date');
    }
}