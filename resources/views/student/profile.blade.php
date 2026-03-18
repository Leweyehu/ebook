@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Profile Picture</h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if(isset($student->profile_image) && $student->profile_image)
                            <img src="{{ asset($student->profile_image) }}" alt="Profile" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 150px; height: 150px; font-size: 4rem;">
                                {{ substr($student->name ?? Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h5>{{ $student->name ?? Auth::user()->name }}</h5>
                    <p class="text-muted">{{ $student->student_id ?? 'Student' }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Profile Information</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 150px;">Full Name:</th>
                            <td>{{ $student->name ?? Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <th>Student ID:</th>
                            <td>{{ $student->student_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $student->email ?? Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th>Year:</th>
                            <td>{{ $student->year ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Section:</th>
                            <td>{{ $student->section ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Batch:</th>
                            <td>{{ $student->batch ?? 'N/A' }}</td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        <a href="{{ route('student.password.change') }}" class="btn btn-warning">
                            <i class="fas fa-key"></i> Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection