@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details: ' . $user->name)

@section('content')
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="color: #1a2b3c;">User Information</h2>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.users.edit', $user) }}" style="background: #ffc107; color: #1a2b3c; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-edit"></i> Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <!-- User Info Card -->
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 10px;">
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <span style="font-size: 2.5rem; color: white; font-weight: bold;">
                        {{ substr($user->name, 0, 1) }}
                    </span>
                </div>
                <h3 style="margin-top: 1rem;">{{ $user->name }}</h3>
                <span style="background: {{ 
                    $user->role === 'admin' ? '#dc3545' : 
                    ($user->role === 'staff' ? '#ffc107' : '#28a745') 
                }}; color: {{ $user->role === 'staff' ? '#1a2b3c' : 'white' }}; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; display: inline-block;">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            <div style="border-top: 1px solid #dee2e6; padding-top: 1rem;">
                <div style="margin-bottom: 1rem;">
                    <strong style="color: #666;">Status:</strong><br>
                    <span style="background: {{ $user->is_active ? '#28a745' : '#dc3545' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 3px; font-size: 0.85rem; display: inline-block; margin-top: 0.3rem;">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div style="margin-bottom: 1rem;">
                    <strong style="color: #666;">Member since:</strong><br>
                    <span>{{ $user->created_at->format('F d, Y') }}</span>
                </div>
                <div style="margin-bottom: 1rem;">
                    <strong style="color: #666;">Last updated:</strong><br>
                    <span>{{ $user->updated_at->format('F d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div style="background: #f8f9fa; padding: 2rem; border-radius: 10px;">
            <h3 style="margin-bottom: 1.5rem; color: #1a2b3c;">Account Details</h3>
            
            <table style="width: 100%;">
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: 600; color: #666; width: 150px;">Full Name:</td>
                    <td style="padding: 0.75rem 0;">{{ $user->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: 600; color: #666;">Email Address:</td>
                    <td style="padding: 0.75rem 0;">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: 600; color: #666;">Role:</td>
                    <td style="padding: 0.75rem 0;">
                        <span style="background: {{ 
                            $user->role === 'admin' ? '#dc3545' : 
                            ($user->role === 'staff' ? '#ffc107' : '#28a745') 
                        }}; color: {{ $user->role === 'staff' ? '#1a2b3c' : 'white' }}; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem;">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: 600; color: #666;">Student/Staff ID:</td>
                    <td style="padding: 0.75rem 0;">{{ $user->student_id ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: 600; color: #666;">Department:</td>
                    <td style="padding: 0.75rem 0;">{{ $user->department ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.75rem 0; font-weight: 600; color: #666;">Email Verified:</td>
                    <td style="padding: 0.75rem 0;">
                        @if($user->email_verified_at)
                            <span style="color: #28a745;">✓ Verified on {{ $user->email_verified_at->format('M d, Y') }}</span>
                        @else
                            <span style="color: #dc3545;">✗ Not verified</span>
                        @endif
                    </td>
                </tr>
            </table>

            @if($user->role === 'staff' && $user->staff)
            <div style="margin-top: 2rem; border-top: 1px solid #dee2e6; padding-top: 1.5rem;">
                <h3 style="margin-bottom: 1rem; color: #1a2b3c;">Associated Staff Record</h3>
                <p><strong>Position:</strong> {{ $user->staff->position ?? 'N/A' }}</p>
                <p><strong>Qualification:</strong> {{ $user->staff->qualification ?? 'N/A' }}</p>
                <p><strong>Specialization:</strong> {{ $user->staff->specialization ?? 'N/A' }}</p>
            </div>
            @endif

            @if($user->role === 'student' && $user->student)
            <div style="margin-top: 2rem; border-top: 1px solid #dee2e6; padding-top: 1.5rem;">
                <h3 style="margin-bottom: 1rem; color: #1a2b3c;">Associated Student Record</h3>
                <p><strong>Year:</strong> {{ $user->student->year ?? 'N/A' }}</p>
                <p><strong>Section:</strong> {{ $user->student->section ?? 'N/A' }}</p>
                <p><strong>Batch:</strong> {{ $user->student->batch ?? 'N/A' }}</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection