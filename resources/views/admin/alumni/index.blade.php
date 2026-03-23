@extends('layouts.admin')

@section('title', 'Alumni Management')
@section('page-title', 'Alumni Management')

@section('content')
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: #667eea; color: white; padding: 1rem; border-radius: 10px; text-align: center;"><h3>{{ $stats['total'] }}</h3><p>Total</p></div>
    <div style="background: #ffc107; color: #1a2b3c; padding: 1rem; border-radius: 10px; text-align: center;"><h3>{{ $stats['pending'] }}</h3><p>Pending</p></div>
    <div style="background: #28a745; color: white; padding: 1rem; border-radius: 10px; text-align: center;"><h3>{{ $stats['approved'] }}</h3><p>Approved</p></div>
    <div style="background: #17a2b8; color: white; padding: 1rem; border-radius: 10px; text-align: center;"><h3>{{ $stats['verified'] }}</h3><p>Verified</p></div>
</div>

<div style="margin-bottom: 1rem;">
    <a href="{{ route('admin.alumni.export') }}" class="btn btn-success" style="background:#28a745; color:white; padding:0.5rem 1rem; border-radius:5px; text-decoration:none;">Export CSV</a>
</div>

<div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
    <form method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" style="flex:2; padding:0.5rem;">
        <select name="year" style="padding:0.5rem;"><option value="">All Years</option>@foreach($years as $y)<option value="{{ $y }}">{{ $y }}</option>@endforeach</select>
        <select name="status" style="padding:0.5rem;"><option value="">All Status</option>@foreach($statuses as $s)<option value="{{ $s }}">{{ ucfirst($s) }}</option>@endforeach</select>
        <button type="submit" style="background:#ffc107; padding:0.5rem 1rem; border:none; border-radius:5px;">Filter</button>
        <a href="{{ route('admin.alumni.index') }}" style="background:#6c757d; color:white; padding:0.5rem 1rem; border-radius:5px; text-decoration:none;">Reset</a>
    </form>
</div>

<div style="background:white; border-radius:10px; overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse;">
        <thead style="background:#1a2b3c; color:white;">
            <tr><th style="padding:1rem;">ID</th><th>Name</th><th>Email</th><th>Year</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($alumni as $a)
            <tr style="border-bottom:1px solid #eee;">
                <td style="padding:1rem;">{{ $a->student_id }}</td>
                <td>{{ $a->name }}</td>
                <td>{{ $a->email }}</td>
                <td>{{ $a->graduation_year }}</td>
                <td><span style="background:{{ $a->status=='pending'?'#ffc107':($a->status=='approved'?'#28a745':'#dc3545') }}; color:white; padding:0.2rem 0.5rem; border-radius:20px;">{{ ucfirst($a->status) }}</span></td>
                <td>
                    <a href="{{ route('admin.alumni.show', $a) }}" style="background:#17a2b8; color:white; padding:0.2rem 0.5rem; border-radius:3px; text-decoration:none;">View</a>
                    @if($a->status == 'pending')
                    <form action="{{ route('admin.alumni.verify', $a) }}" method="POST" style="display:inline;">@csrf<button style="background:#28a745; color:white; border:none; padding:0.2rem 0.5rem; border-radius:3px;">Verify</button></form>
                    <form action="{{ route('admin.alumni.reject', $a) }}" method="POST" style="display:inline;">@csrf<button style="background:#dc3545; color:white; border:none; padding:0.2rem 0.5rem; border-radius:3px;">Reject</button></form>
                    @endif
                    <form action="{{ route('admin.alumni.destroy', $a) }}" method="POST" style="display:inline;">@csrf @method('DELETE')<button style="background:#dc3545; color:white; border:none; padding:0.2rem 0.5rem; border-radius:3px;">Delete</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="padding:2rem; text-align:center;">No alumni found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="margin-top:2rem;">{{ $alumni->appends(request()->query())->links() }}</div>
@endsection