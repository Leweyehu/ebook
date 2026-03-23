@extends('layouts.admin')

@section('title', 'Alumni Report')
@section('page-title', 'Alumni Reports')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.alumni.index') }}" style="background: #6c757d; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Back to Alumni
    </a>
</div>

<!-- Report Type Selector -->
<div style="background: #f8f9fa; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
    <form method="GET" action="{{ route('admin.alumni.report') }}" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
        <div style="flex: 2;">
            <label style="display: block; margin-bottom: 0.5rem;">Report Type</label>
            <select name="type" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                <option value="year" {{ $reportType == 'year' ? 'selected' : '' }}>By Graduation Year</option>
                <option value="location" {{ $reportType == 'location' ? 'selected' : '' }}>By Location</option>
                <option value="company" {{ $reportType == 'company' ? 'selected' : '' }}>By Company</option>
                <option value="job_title" {{ $reportType == 'job_title' ? 'selected' : '' }}>By Job Title</option>
                <option value="degree" {{ $reportType == 'degree' ? 'selected' : '' }}>By Degree</option>
                <option value="status" {{ $reportType == 'status' ? 'selected' : '' }}>By Status</option>
            </select>
        </div>
        <div>
            <button type="submit" style="background: #ffc107; color: #1a2b3c; padding: 0.8rem 1.5rem; border: none; border-radius: 5px; cursor: pointer;">
                Generate Report
            </button>
        </div>
    </form>
</div>

<!-- Report Chart and Table -->
<div style="background: white; border-radius: 10px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h2 style="color: #1a2b3c; margin-bottom: 2rem;">{{ $reportTitle }}</h2>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Chart -->
        <div>
            <canvas id="reportChart" style="max-height: 400px;"></canvas>
        </div>
        
        <!-- Table -->
        <div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #1a2b3c; color: white;">
                        <th style="padding: 0.8rem; text-align: left;">Category</th>
                        <th style="padding: 0.8rem; text-align: left;">Count</th>
                        <th style="padding: 0.8rem; text-align: left;">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = $reportData->sum('total');
                    @endphp
                    @foreach($reportData as $item)
                    <tr style="border-bottom: 1px solid #e9ecef;">
                        <td style="padding: 0.8rem;">
                            @if($reportType == 'year')
                                Class of {{ $item->graduation_year }}
                            @elseif($reportType == 'location')
                                {{ $item->location }}
                            @elseif($reportType == 'company')
                                {{ $item->current_company }}
                            @elseif($reportType == 'job_title')
                                {{ $item->current_job_title }}
                            @elseif($reportType == 'degree')
                                {{ $item->degree }}
                            @else
                                {{ ucfirst($item->status) }}
                            @endif
                        </td>
                        <td style="padding: 0.8rem;">{{ $item->total }}</td>
                        <td style="padding: 0.8rem;">{{ round(($item->total / $total) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Export Report Button -->
    <div style="margin-top: 2rem; text-align: right;">
        <a href="{{ route('admin.alumni.export', ['type' => $reportType]) }}" style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
            <i class="fas fa-download"></i> Export Report
        </a>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('reportChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($reportData as $item)
                    @if($reportType == 'year')
                        "{{ $item->graduation_year }}",
                    @elseif($reportType == 'location')
                        "{{ $item->location }}",
                    @elseif($reportType == 'company')
                        "{{ $item->current_company }}",
                    @elseif($reportType == 'job_title')
                        "{{ $item->current_job_title }}",
                    @elseif($reportType == 'degree')
                        "{{ $item->degree }}",
                    @else
                        "{{ ucfirst($item->status) }}",
                    @endif
                @endforeach
            ],
            datasets: [{
                label: 'Number of Alumni',
                data: [@foreach($reportData as $item) {{ $item->total }}, @endforeach],
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgba(0, 62, 114, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Alumni'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: '{{ $reportType == 'year' ? 'Graduation Year' : ($reportType == 'location' ? 'Location' : ($reportType == 'company' ? 'Company' : ($reportType == 'job_title' ? 'Job Title' : 'Category'))) }}'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection