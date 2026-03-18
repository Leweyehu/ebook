@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Student Statistics</h1>
        <p>Department of Computer Science</p>
    </div>
</div>

<div class="container">
    <!-- Statistics Cards -->
    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem; margin-bottom: 3rem;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; border-radius: 15px; text-align: center;">
            <i class="fas fa-users" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2rem;">{{ $total }}</h3>
            <p>Total Students</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 2rem; border-radius: 15px; text-align: center;">
            <i class="fas fa-user-graduate" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2rem;">{{ $year1 }}</h3>
            <p>Year 1</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 2rem; border-radius: 15px; text-align: center;">
            <i class="fas fa-user-graduate" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2rem;">{{ $year2 }}</h3>
            <p>Year 2</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 2rem; border-radius: 15px; text-align: center;">
            <i class="fas fa-user-graduate" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2rem;">{{ $year3 }}</h3>
            <p>Year 3</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 2rem; border-radius: 15px; text-align: center;">
            <i class="fas fa-user-graduate" style="font-size: 2.5rem; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 2rem;">{{ $year4 }}</h3>
            <p>Year 4</p>
        </div>
    </div>

    <!-- Chart -->
    <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 3rem;">
        <h3 style="color: #1a2b3c; margin-bottom: 2rem;">Student Distribution by Year</h3>
        <div style="display: flex; gap: 2rem; align-items: flex-end; height: 300px;">
            @foreach($studentsByYear as $year => $count)
            <div style="flex: 1; text-align: center;">
                <div style="background: #ffc107; height: {{ ($count / max(1, $total)) * 250 }}px; border-radius: 10px 10px 0 0;"></div>
                <p style="margin-top: 1rem; font-weight: 600;">{{ $year }}</p>
                <p style="color: #ffc107; font-weight: 700;">{{ $count }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Students -->
    <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="color: #1a2b3c; margin-bottom: 1.5rem;">Recently Enrolled Students</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="padding: 1rem; text-align: left;">Student ID</th>
                    <th style="padding: 1rem; text-align: left;">Name</th>
                    <th style="padding: 1rem; text-align: left;">Year</th>
                    <th style="padding: 1rem; text-align: left;">Section</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentStudents as $student)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 1rem;">{{ $student->student_id }}</td>
                    <td style="padding: 1rem;">{{ $student->name }}</td>
                    <td style="padding: 1rem;">Year {{ $student->year }}</td>
                    <td style="padding: 1rem;">{{ $student->section ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection