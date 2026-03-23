@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Edit Profile</h1>
    </div>
</div>

<div class="container" style="margin-top: -2rem;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <p style="text-align: center;">Profile edit feature coming soon.</p>
            <div style="text-align: center;">
                <a href="{{ route('alumni.dashboard') }}" style="background: #ffc107; color: #003E72; padding: 0.5rem 1.5rem; border-radius: 5px; text-decoration: none;">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection