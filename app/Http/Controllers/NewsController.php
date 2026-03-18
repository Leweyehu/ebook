<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display public news page (for website visitors)
     */
    public function index()
    {
        $news = News::published()
                    ->orderBy('created_at', 'desc')
                    ->paginate(9);
        
        $upcomingEvents = News::upcomingEvents()->take(5)->get();
        
        return view('news.public-index', compact('news', 'upcomingEvents'));
    }

    /**
     * Display single news article (public)
     */
    public function show($slug)
    {
        $news = News::where('slug', $slug)
                    ->published()
                    ->firstOrFail();
        
        // Increment views
        $news->increment('views');
        
        // Get related news
        $relatedNews = News::where('category', $news->category)
                           ->where('id', '!=', $news->id)
                           ->published()
                           ->latest()
                           ->take(3)
                           ->get();
        
        return view('news.public-show', compact('news', 'relatedNews'));
    }

    /**
     * ADMIN: Show all news (for admin panel)
     */
    public function adminIndex()
    {
        $news = News::with('creator')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        $publishedCount = News::published()->count();
        $draftCount = News::draft()->count();
        
        return view('admin.news.index', compact('news', 'publishedCount', 'draftCount'));
    }

    /**
     * ADMIN: Show create form
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * ADMIN: Store news
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:news,event,announcement',
            'event_date' => 'nullable|date',
            'event_location' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'sometimes|boolean'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        $data['created_by'] = Auth::id();
        $data['is_published'] = $request->has('is_published') ? true : false;

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/news'), $imageName);
            $data['featured_image'] = 'uploads/news/' . $imageName;
        }

        News::create($data);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News created successfully!');
    }

    /**
     * ADMIN: Show edit form
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * ADMIN: Update news
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:news,event,announcement',
            'event_date' => 'nullable|date',
            'event_location' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'sometimes|boolean'
        ]);

        $data = $request->all();
        $data['is_published'] = $request->has('is_published') ? true : false;
        
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($news->featured_image && file_exists(public_path($news->featured_image))) {
                unlink(public_path($news->featured_image));
            }
            
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/news'), $imageName);
            $data['featured_image'] = 'uploads/news/' . $imageName;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News updated successfully!');
    }

    /**
     * ADMIN: Delete news
     */
    public function destroy(News $news)
    {
        // Delete image
        if ($news->featured_image && file_exists(public_path($news->featured_image))) {
            unlink(public_path($news->featured_image));
        }
        
        $news->delete();
        
        return redirect()->route('admin.news.index')
                        ->with('success', 'News deleted successfully!');
    }

    /**
     * ADMIN: Toggle publish status
     */
    public function toggleStatus(News $news)
    {
        $news->update(['is_published' => !$news->is_published]);
        
        return redirect()->route('admin.news.index')
                        ->with('success', 'News status updated successfully!');
    }
}