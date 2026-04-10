@extends('layouts.admin')

@section('title', 'Program Management')
@section('page-title', 'Program Management')

@section('content')
<style>
    .nav-tabs .nav-link {
        color: #003E72;
        font-weight: 500;
    }
    .nav-tabs .nav-link.active {
        background: #003E72;
        color: white;
        border-color: #003E72;
    }
    .table-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .status-active {
        background: #d4edda;
        color: #155724;
    }
    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<div class="admin-programs">
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#programs">
                <i class="fas fa-book"></i> Programs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#requirements">
                <i class="fas fa-table"></i> Course Requirements
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#admission">
                <i class="fas fa-door-open"></i> Admission Requirements
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#graduation">
                <i class="fas fa-graduation-cap"></i> Graduation Requirements
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- ========== PROGRAMS TAB ========== -->
        <div class="tab-pane fade show active" id="programs">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i> Academic Programs</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProgramModal">
                        <i class="fas fa-plus"></i> Add Program
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Duration</th>
                                    <th>Credit Hours</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($programs as $program)
                                <tr>
                                    <td>{{ $program->id }}</td>
                                    <td><strong>{{ $program->title }}</strong></td>
                                    <td>
                                        @if($program->type == 'undergraduate')
                                            <span class="badge bg-info">Undergraduate</span>
                                        @else
                                            <span class="badge bg-success">Postgraduate</span>
                                        @endif
                                    </td>
                                    <td>{{ $program->duration_years ?? 'N/A' }} Years</td>
                                    <td>{{ $program->credit_hours ?? 'N/A' }}</td>
                                    <td>
                                        @if($program->is_active)
                                            <span class="status-badge status-active">Active</span>
                                        @else
                                            <span class="status-badge status-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-info" onclick="editProgram({{ $program->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this program?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== COURSE REQUIREMENTS TAB ========== -->
        <div class="tab-pane fade" id="requirements">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-table me-2"></i> Course Requirements</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addRequirementModal">
                        <i class="fas fa-plus"></i> Add Requirement
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Number of Courses</th>
                                    <th>Credit Hours</th>
                                    <th>ECTS</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requirements as $req)
                                <tr>
                                    <td>{{ $req->id }}</td>
                                    <td><strong>{{ $req->category_name }}</strong></td>
                                    <td>{{ $req->number_of_courses }}</td>
                                    <td>{{ $req->credit_hours }}</td>
                                    <td>{{ $req->ects }}</td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-info" onclick="editRequirement({{ $req->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.programs.requirements.destroy', $req->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this requirement?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== ADMISSION REQUIREMENTS TAB ========== -->
        <div class="tab-pane fade" id="admission">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-door-open me-2"></i> Admission Requirements</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAdmissionModal">
                        <i class="fas fa-plus"></i> Add Admission Requirement
                    </button>
                </div>
                <div class="card-body">
                    @foreach($admissionRequirements as $admission)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="mb-2">{{ $admission->title }}</h5>
                                    <p class="mb-0">{{ $admission->content }}</p>
                                    <small class="text-muted">Status: 
                                        @if($admission->is_active)
                                            <span class="status-badge status-active">Active</span>
                                        @else
                                            <span class="status-badge status-inactive">Inactive</span>
                                        @endif
                                    </small>
                                </div>
                                <div class="table-actions">
                                    <button class="btn btn-sm btn-info" onclick="editAdmission({{ $admission->id }})" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.programs.admission.destroy', $admission->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this admission requirement?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ========== GRADUATION REQUIREMENTS TAB ========== -->
        <div class="tab-pane fade" id="graduation">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i> Graduation Requirements</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addGraduationModal">
                        <i class="fas fa-plus"></i> Add Graduation Requirement
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Requirement</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($graduationRequirements as $grad)
                                <tr>
                                    <td>{{ $grad->id }}</td>
                                    <td>{{ $grad->requirement }}</td>
                                    <td>
                                        @if($grad->is_active)
                                            <span class="status-badge status-active">Active</span>
                                        @else
                                            <span class="status-badge status-inactive">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="table-actions">
                                        <button class="btn btn-sm btn-info" onclick="editGraduation({{ $grad->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.programs.graduation.destroy', $grad->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this graduation requirement?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include All Modals -->
@include('admin.programs.modals')
@endsection

@push('scripts')
<script>
    // Edit functions for each type
    function editProgram(id) {
        window.location.href = "{{ url('admin/programs') }}/" + id + "/edit";
    }
    
    function editRequirement(id) {
        // Fetch and populate edit modal (simplified - you can implement AJAX)
        alert('Edit requirement ID: ' + id + ' - Implement AJAX to fetch data');
    }
    
    function editAdmission(id) {
        alert('Edit admission ID: ' + id + ' - Implement AJAX to fetch data');
    }
    
    function editGraduation(id) {
        alert('Edit graduation ID: ' + id + ' - Implement AJAX to fetch data');
    }
</script>
@endpush
