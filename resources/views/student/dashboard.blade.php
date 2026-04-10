@extends('layouts.app')

@section('title', 'Student Dashboard - Document Submission')

@section('content')
<div class="dashboard-wrapper" style="padding: 20px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.25);">
            <i class="fas fa-file-alt" style="font-size: 1.8rem; margin-bottom: 0.5rem; opacity: 0.8;"></i>
            <h3 style="font-size: 1.8rem; margin: 0;">{{ $stats['total'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Total Submissions</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.25);">
            <i class="fas fa-clock" style="font-size: 1.8rem; margin-bottom: 0.5rem; opacity: 0.8;"></i>
            <h3 style="font-size: 1.8rem; margin: 0;">{{ $stats['pending'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Pending Review</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(79, 172, 254, 0.25);">
            <i class="fas fa-check-circle" style="font-size: 1.8rem; margin-bottom: 0.5rem; opacity: 0.8;"></i>
            <h3 style="font-size: 1.8rem; margin: 0;">{{ $stats['approved'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Approved</p>
        </div>
        
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(67, 233, 123, 0.25);">
            <i class="fas fa-times-circle" style="font-size: 1.8rem; margin-bottom: 0.5rem; opacity: 0.8;"></i>
            <h3 style="font-size: 1.8rem; margin: 0;">{{ $stats['rejected'] ?? 0 }}</h3>
            <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Rejected</p>
        </div>
    </div>

    <!-- Welcome Section -->
    <div style="background: linear-gradient(135deg, #1a2b3c 0%, #2c3e50 100%); color: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="margin: 0 0 0.5rem 0; font-weight: 600;">Welcome back, {{ Auth::user()->name }}! 👋</h2>
            <p style="margin: 0; opacity: 0.8;">Mekedela Amba University Student Portal | Document Submission System</p>
        </div>
        <div style="background: rgba(255, 255, 255, 0.1); padding: 0.8rem 1.5rem; border-radius: 50px; border: 1px solid rgba(255,255,255,0.2);">
            <i class="fas fa-id-card me-2" style="color: #ffc107;"></i>
            <span style="font-weight: bold; letter-spacing: 1px;">{{ $student->student_id ?? Auth::user()->student_id ?? 'N/A' }}</span>
        </div>
    </div>

    <!-- Quick Actions Row -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <a href="{{ route('student.submission.create') }}" style="text-decoration: none;">
            <div style="background: linear-gradient(135deg, #28a745, #20c997); color: white; padding: 1.5rem; border-radius: 12px; text-align: center; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;">
                <i class="fas fa-upload" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <h4 style="margin: 0.5rem 0 0.25rem;">Upload New Document</h4>
                <p style="margin: 0; opacity: 0.9; font-size: 0.85rem;">Submit proposal, report, or letter</p>
            </div>
        </a>
        
        <a href="{{ route('student.submissions.index') }}" style="text-decoration: none;">
            <div style="background: linear-gradient(135deg, #17a2b8, #0dcaf0); color: white; padding: 1.5rem; border-radius: 12px; text-align: center; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;">
                <i class="fas fa-folder-open" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                <h4 style="margin: 0.5rem 0 0.25rem;">View All Submissions</h4>
                <p style="margin: 0; opacity: 0.9; font-size: 0.85rem;">Track your submitted documents</p>
            </div>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem;">
        
        <!-- Recent Submissions Section -->
        <div style="background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="background: #f8f9fa; padding: 1.2rem 1.5rem; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <i class="fas fa-history" style="color: #667eea; margin-right: 10px;"></i>
                    <h3 style="font-size: 1.1rem; margin: 0; display: inline-block; color: #1a2b3c;">Recent Submissions</h3>
                </div>
                <a href="{{ route('student.submissions.index') }}" style="color: #667eea; text-decoration: none; font-size: 0.85rem;">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div style="padding: 1.5rem;">
                @forelse($recentSubmissions ?? [] as $submission)
                    <div style="padding: 1rem; border-bottom: 1px solid #f1f1f1; transition: background 0.2s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div>
                                <h4 style="font-size: 0.95rem; margin: 0 0 0.3rem 0; color: #333;">
                                    @if($submission->document_category == 'proposal')
                                        📑 {{ $submission->project_title ?? 'Project Proposal' }}
                                    @elseif($submission->document_category == 'internship')
                                        💼 {{ $submission->project_title ?? 'Internship Report' }}
                                    @elseif($submission->document_category == 'project_document')
                                        📁 {{ $submission->project_title ?? 'Project Document' }}
                                    @elseif($submission->document_category == 'letter')
                                        📄 Letter
                                    @else
                                        📎 Other Document
                                    @endif
                                </h4>
                                <small style="color: #888;">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $submission->created_at->format('M d, Y') }}
                                    <span style="margin: 0 5px">•</span>
                                    <i class="far fa-file me-1"></i> {{ $submission->formatted_file_size }}
                                </small>
                            </div>
                            <div>
                                @if($submission->status == 'pending')
                                    <span style="background: #ffc107; color: #856404; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                                        <i class="fas fa-spinner"></i> Pending
                                    </span>
                                @elseif($submission->status == 'approved')
                                    <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                                        <i class="fas fa-check"></i> Approved
                                    </span>
                                @else
                                    <span style="background: #dc3545; color: white; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">
                                        <i class="fas fa-times"></i> Rejected
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top: 0.5rem;">
                            <a href="{{ route('student.submission.show', $submission->id) }}" style="color: #667eea; text-decoration: none; font-size: 0.8rem; margin-right: 1rem;">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('student.submission.download', $submission->id) }}" style="color: #28a745; text-decoration: none; font-size: 0.8rem;">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 2rem; color: #999;">
                        <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                        <p>No submissions yet.</p>
                        <a href="{{ route('student.submission.create') }}" style="color: #667eea; text-decoration: none;">Upload your first document →</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Navigation & Guidelines -->
        <div>
            <h3 style="color: #1a2b3c; margin-bottom: 1.2rem; font-size: 1.2rem; display: flex; align-items: center;">
                <i class="fas fa-rocket me-2" style="color: #ffc107;"></i> Quick Navigation
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 1rem; margin-bottom: 2rem;">
                <a href="{{ route('student.submission.create') }}" class="nav-card">
                    <i class="fas fa-upload"></i>
                    <span>Submit New Document</span>
                </a>
                
                <a href="{{ route('student.submissions.index') }}" class="nav-card">
                    <i class="fas fa-list-alt"></i>
                    <span>My Submissions</span>
                </a>
                
                <a href="{{ route('student.profile') }}" class="nav-card">
                    <i class="fas fa-user-circle"></i>
                    <span>Profile Settings</span>
                </a>
                
                <a href="{{ route('contact') }}" class="nav-card">
                    <i class="fas fa-headset"></i>
                    <span>Help & Support</span>
                </a>
            </div>
            
            <!-- Document Guidelines Card -->
            <div style="background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 12px; padding: 1.5rem; border-left: 4px solid #ffc107;">
                <h4 style="margin: 0 0 1rem 0; color: #1a2b3c;">
                    <i class="fas fa-info-circle" style="color: #ffc107;"></i> Submission Guidelines
                </h4>
                <ul style="margin: 0; padding-left: 1.2rem; color: #555; font-size: 0.85rem;">
                    <li style="margin-bottom: 0.5rem;">📄 Allowed formats: PDF, DOC, DOCX, JPG, PNG</li>
                    <li style="margin-bottom: 0.5rem;">📏 Max file size: 250MB</li>
                    <li style="margin-bottom: 0.5rem;">🏷️ Files are automatically renamed to: <code>Firstname_Lastname_DocumentType</code></li>
                    <li style="margin-bottom: 0.5rem;">📑 Categories: Letter, Proposal, Internship Report, Project Document</li>
                    <li>⏳ Submissions are reviewed within 3-5 business days</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for the Navigation Cards */
    .nav-card {
        background: white;
        padding: 1.2rem;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        text-decoration: none;
        color: #1a2b3c;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        font-weight: 500;
    }

    .nav-card i {
        font-size: 1.2rem;
        color: #764ba2;
        width: 30px;
        text-align: center;
    }

    .nav-card:hover {
        transform: translateX(8px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: #764ba2;
        color: #764ba2;
    }
    
    .nav-card:hover i {
        color: #ffc107;
    }

    /* Hover effects for action cards */
    .dashboard-wrapper a div[style*="linear-gradient"]:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .dashboard-wrapper > div:last-child {
            grid-template-columns: 1fr !important;
        }
    }
    
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 15px !important;
        }
        
        .nav-card {
            padding: 1rem;
        }
    }
</style>
@endsection