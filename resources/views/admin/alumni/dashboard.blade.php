@extends('layouts.admin')

@section('title', 'Alumni Dashboard')
@section('page-title', 'Alumni Analytics Dashboard')

@section('content')
<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-users" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['total'] }}</h3>
        <p>Total Alumni</p>
    </div>
    <div style="background: linear-gradient(135deg, #28a745 0%, #218838 100%); color: white; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-check-circle" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['verified'] }}</h3>
        <p>Verified Alumni</p>
    </div>
    <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-building" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['companies_count'] }}</h3>
        <p>Companies</p>
    </div>
    <div style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #1a2b3c; padding: 1.5rem; border-radius: 10px;">
        <i class="fas fa-map-marker-alt" style="font-size: 2rem;"></i>
        <h3 style="font-size: 2rem; margin: 0.5rem 0;">{{ $stats['locations_count'] }}</h3>
        <p>Locations</p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <!-- Yearly Trend Chart -->
    <div style="background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Alumni by Graduation Year</h3>
        <canvas id="yearlyChart" style="max-height: 300px;"></canvas>
    </div>
    
    <!-- Status Distribution -->
    <div style="background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Status Distribution</h3>
        <canvas id="statusChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<!-- Recent Registrations -->
<div style="background: white; border-radius: 10px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h3 style="color: #1a2b3c; margin-bottom: 1rem;">Recent Registrations</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="padding: 0.8rem; text-align: left;">Name</th>
                <th style="padding: 0.8rem; text-align: left;">Student ID</th>
                <th style="padding: 0.8rem; text-align: left;">Graduation Year</th>
                <th style="padding: 0.8rem; text-align: left;">Status</th>
                <th style="padding: 0.8rem; text-align: left;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats['recent'] as $alumnus)
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 0.8rem;">{{ $alumnus->name }}</td>
                <td style="padding: 0.8rem;">{{ $alumnus->student_id }}</td>
                <td style="padding: 0.8rem;">{{ $alumnus->graduation_year }}</td>
                <td style="padding: 0.8rem;">
                    @if($alumnus->status === 'pending')
                        <span style="background: #ffc107; padding: 0.25rem 0.5rem; border-radius: 20px;">Pending</span>
                    @elseif($alumnus->status === 'approved')
                        <span style="background: #28a745; color: white; padding: 0.25rem 0.5rem; border-radius: 20px;">Approved</span>
                    @else
                        <span style="background: #dc3545; color: white; padding: 0.25rem 0.5rem; border-radius: 20px;">Rejected</span>
                    @endif
                </td>
                <td style="padding: 0.8rem;">{{ $alumnus->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Yearly Trend Chart
    var yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
    var yearlyChart = new Chart(yearlyCtx, {
        type: 'line',
        data: {
            labels: [@foreach($yearlyTrend as $trend) "{{ $trend->graduation_year }}", @endforeach],
            datasets: [{
                label: 'Number of Alumni',
                data: [@foreach($yearlyTrend as $trend) {{ $trend->total }}, @endforeach],
                backgroundColor: 'rgba(255, 193, 7, 0.2)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
    
    // Status Distribution Chart
    var statusCtx = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending ({{ $stats['pending'] }})', 'Approved ({{ $stats['approved'] }})', 'Rejected ({{ $stats['rejected'] }})'],
            datasets: [{
                data: [{{ $stats['pending'] }}, {{ $stats['approved'] }}, {{ $stats['rejected'] }}],
                backgroundColor: ['#ffc107', '#28a745', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
@endsection