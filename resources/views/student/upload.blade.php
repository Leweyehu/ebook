{{-- resources/views/student/upload.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-upload"></i> Submit Document</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('student.submission.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <!-- Personal Information -->
                    <h5 class="mb-3">Personal Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('student_id') is-invalid @enderror" 
                                   id="student_id" name="student_id" value="{{ old('student_id') }}" required>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-control @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                <option value="">Select Semester</option>
                                <option value="Spring">Spring</option>
                                <option value="Summer">Summer</option>
                                <option value="Fall">Fall</option>
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="academic_year" class="form-label">Academic Year <span class="text-danger">*</span></label>
                            <select class="form-control @error('academic_year') is-invalid @enderror" id="academic_year" name="academic_year" required>
                                <option value="">Select Year</option>
                                <option value="2023-2024">2023-2024</option>
                                <option value="2024-2025">2024-2025</option>
                                <option value="2025-2026">2025-2026</option>
                            </select>
                            @error('academic_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="batch" class="form-label">Batch <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('batch') is-invalid @enderror" 
                                   id="batch" name="batch" placeholder="e.g., 2021-2025" value="{{ old('batch') }}" required>
                            @error('batch')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Document Information -->
                    <h5 class="mb-3 mt-4">Document Information</h5>
                    <div class="mb-3">
                        <label for="document_category" class="form-label">Document Category <span class="text-danger">*</span></label>
                        <select class="form-control @error('document_category') is-invalid @enderror" id="document_category" name="document_category" required>
                            <option value="">Select Category</option>
                            <option value="letter">📄 Letter</option>
                            <option value="proposal">📑 Project Proposal</option>
                            <option value="internship">💼 Internship Report</option>
                            <option value="project_document">📁 Project Document</option>
                            <option value="other">📎 Other</option>
                        </select>
                        @error('document_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="project_title_field" style="display: none;">
                        <label for="project_title" class="form-label">Project Title</label>
                        <input type="text" class="form-control @error('project_title') is-invalid @enderror" 
                               id="project_title" name="project_title" placeholder="Enter your project title" value="{{ old('project_title') }}">
                        <small class="text-muted">Required for Proposals and Project Documents</small>
                        @error('project_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="document" class="form-label">Document File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('document') is-invalid @enderror" 
                               id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp" required>
                        <small class="text-muted">
                            Allowed: PDF, Word (DOC/DOCX), Images (JPG, PNG, GIF, WEBP). Max size: 250MB.<br>
                            <strong>Naming Convention:</strong> Your file will be renamed to: <span id="filename_preview">Firstname_Lastname_Type.pdf</span>
                        </small>
                        @error('document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3" placeholder="Additional notes about this document">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>File Naming:</strong> Your file will be automatically renamed to follow the format: 
                        <code>Firstname_Lastname_DocumentType.extension</code>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Submit Document
                        </button>
                        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show/hide project title field based on category
    document.getElementById('document_category').addEventListener('change', function() {
        const category = this.value;
        const projectTitleField = document.getElementById('project_title_field');
        const projectTitleInput = document.getElementById('project_title');
        
        if (category === 'proposal' || category === 'project_document') {
            projectTitleField.style.display = 'block';
            projectTitleInput.required = true;
        } else {
            projectTitleField.style.display = 'none';
            projectTitleInput.required = false;
        }
    });

    // Update filename preview
    document.getElementById('full_name').addEventListener('input', updateFilenamePreview);
    document.getElementById('document_category').addEventListener('change', updateFilenamePreview);
    document.getElementById('document').addEventListener('change', updateFilenamePreview);

    function updateFilenamePreview() {
        const fullName = document.getElementById('full_name').value || 'Firstname Lastname';
        const firstName = fullName.split(' ')[0] || 'Firstname';
        const lastName = fullName.split(' ').length > 1 ? fullName.split(' ').pop() : 'Lastname';
        
        const categoryMap = {
            'letter': 'Letter',
            'proposal': 'Proposal',
            'internship': 'InternshipReport',
            'project_document': 'ProjectDocument',
            'other': 'Other'
        };
        
        const category = document.getElementById('document_category').value;
        const typeName = categoryMap[category] || 'Document';
        
        const fileInput = document.getElementById('document');
        let extension = 'pdf';
        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name;
            extension = fileName.split('.').pop();
        }
        
        const preview = firstName + '_' + lastName + '_' + typeName + '.' + extension;
        document.getElementById('filename_preview').textContent = preview;
    }
</script>
@endpush