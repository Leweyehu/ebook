@extends('layouts.app')

@section('title', 'Success Stories - Alumni')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Alumni Success Stories</h1>
        <p style="font-size: 1.2rem;">Inspiring journeys of our graduates</p>
    </div>
</div>

<div class="container">
    <div style="text-align: center; padding: 4rem; background: white; border-radius: 15px;">
        <i class="fas fa-book-open" style="font-size: 4rem; color: #ccc;"></i>
        <p style="margin-top: 1rem; color: #666;">Success stories coming soon. Check back later!</p>
        <a href="{{ route('alumni.index') }}" style="display: inline-block; margin-top: 1rem; background: #ffc107; color: #003E72; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">
            Browse Alumni Directory
        </a>
    </div>
</div>
@endsection