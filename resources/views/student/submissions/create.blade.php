@extends('layouts.app')

@section('title', 'Submit Document')

@section('content')
<style>
    :root {
        --primary: #003E72;
        --primary-dark: #002b4f;
        --primary-light: #1a5d8f;
        --secondary: #ffc107;
        --success: #28a745;
        --danger: #dc3545;
        --info: #17a2b8;
        --gray-light: #f8f9fc;
        --gray-border: #e3e8ef;
    }

    .submit-container {
        max-width: 900px;
        margin: 0 auto;
    }

    /* Header Card */
    .hero-card {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 35px -10px rgba(0,62,114,0.3);
    }

    .hero-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    /* Progress Steps */
    .progress-steps {
        background: white;
        border-radius: 50px;
        padding: 0.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }

    .step {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.5rem;
        border-radius: 40px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .step.active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(0,62,114,0.2);
    }

    .step-number {
        width: 32px;
        height: 32px;
        background: rgba(0,62,114,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .step.active .step-number {
        background: rgba(255,255,255,0.2);
        color: white;
    }

    /* Form Sections */
    .form-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .form-section:hover {
        box-shadow: 0 8px 35px rgba(0,0,0,0.1);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--gray-border);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: var(--primary);
    }

    .section-title i {
        font-size: 1.4rem;
    }

    /* Form Controls */
    .form-control, .form-select {
        border: 1px solid var(--gray-border);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0,62,114,0.1);
    }

    .input-group-text {
        background: white;
        border: 1px solid var(--gray-border);
        border-right: none;
        border-radius: 12px 0 0 12px;
        color: var(--primary);
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 12px 12px 0;
    }

    /* Category Cards */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .category-card {
        background: white;
        border: 2px solid var(--gray-border);
        border-radius: 16px;
        padding: 1.25rem 0.75rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary);
        box-shadow: 0 10px 25px rgba(0,62,114,0.15);
    }

    .category-card:hover::before {
        transform: scaleX(1);
    }

    .category-card.active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-color: var(--primary);
        color: white;
    }

    .category-card.active i,
    .category-card.active .category-title,
    .category-card.active .category-desc {
        color: white;
    }

    .category-icon {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        color: var(--primary);
    }

    .category-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .category-desc {
        font-size: 0.7rem;
        color: #6c757d;
    }

    /* Upload Area */
    .upload-area {
        border: 2px dashed var(--gray-border);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--gray-light);
    }

    .upload-area:hover {
        border-color: var(--primary);
        background: rgba(0,62,114,0.02);
    }

    .upload-area.drag-over {
        border-color: var(--success);
        background: rgba(40,167,69,0.05);
    }

    /* File Info Card */
    .file-info-card {
        background: linear-gradient(135deg, #e8f4ff 0%, #d4ecff 100%);
        border-radius: 16px;
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    /* Alert Box */
    .info-alert {
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69e 100%);
        border-radius: 16px;
        padding: 1.25rem;
        border: none;
    }

    /* Submit Button */
    .btn-submit {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border: none;
        border-radius: 50px;
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,62,114,0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,62,114,0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .form-section {
            padding: 1.5rem;
        }
        
        .hero-card {
            padding: 1.5rem;
        }
        
        .progress-steps {
            border-radius: 20px;
        }
        
        .step {
            padding: 0.5rem 1rem;
        }
        
        .step-text {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .category-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="submit-container">
    <!-- Hero Section -->
    <div class="hero-card">
        <div style="position: relative; z-index: 1;">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="background: rgba(255,255,255,0.15); width: 60px; height: 60px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-cloud-upload-alt fa-2x"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">Document Submission</h2>
                    <p class="mb-0 opacity-75">Submit your internship documents, proposals, and reports</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="row g-0">
            <div class="col-4">
                <div class="step active" id="step1">
                    <div class="step-number">1</div>
                    <span class="step-text">Personal Info</span>
                </div>
            </div>
            <div class="col-4">
                <div class="step" id="step2">
                    <div class="step-number">2</div>
                    <span class="step-text">Document Details</span>
                </div>
            </div>
            <div class="col-4">
                <div class="step" id="step3">
                    <div class="step-number">3</div>
                    <span class="step-text">Upload & Submit</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('student.submission.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
        @csrf

        <!-- Section 1: Personal Information -->
        <div class="form-section" id="section1">
            <div class="section-title">
                <i class="fas fa-user-circle"></i>
                <span>Personal Information</span>
            </div>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                               id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required>
                    </div>
                    @error('full_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Student ID <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control @error('student_id') is-invalid @enderror" 
                               id="student_id" name="student_id" value="{{ old('student_id', Auth::user()->student_id) }}" required>
                    </div>
                    @error('student_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                    <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                        <option value="">Select Semester</option>
                        <option value="Semester I" {{ old('semester') == 'Semester I' ? 'selected' : '' }}>📘 Semester I</option>
                        <option value="Semester II" {{ old('semester') == 'Semester II' ? 'selected' : '' }}>📙 Semester II</option>
                    </select>
                    @error('semester')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                    <select class="form-select @error('academic_year') is-invalid @enderror" id="academic_year" name="academic_year" required>
                        <option value="">Select Academic Year</option>
                        @php
                            $currentYear = date('Y');
                            $startYear = 2020;
                        @endphp
                        @for($year = $startYear; $year <= $currentYear; $year++)
                            @php $academicYear = $year . '-' . ($year + 1); @endphp
                            <option value="{{ $academicYear }}" {{ old('academic_year') == $academicYear ? 'selected' : '' }}>
                                🎓 {{ $academicYear }}
                            </option>
                        @endfor
                    </select>
                    @error('academic_year')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Year Level <span class="text-danger">*</span></label>
                    <select class="form-select @error('batch') is-invalid @enderror" id="batch" name="batch" required>
                        <option value="">Select Year Level</option>
                        <option value="First Year" {{ old('batch') == 'First Year' ? 'selected' : '' }}>🌟 First Year</option>
                        <option value="Second Year" {{ old('batch') == 'Second Year' ? 'selected' : '' }}>🌟 Second Year</option>
                        <option value="Third Year" {{ old('batch') == 'Third Year' ? 'selected' : '' }}>🌟 Third Year</option>
                        <option value="Fourth Year" {{ old('batch') == 'Fourth Year' ? 'selected' : '' }}>🌟 Fourth Year</option>
                    </select>
                    @error('batch')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Section 2: Document Information -->
        <div class="form-section" id="section2">
            <div class="section-title">
                <i class="fas fa-file-alt"></i>
                <span>Document Information</span>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold mb-3">Document Category <span class="text-danger">*</span></label>
                <div class="category-grid">
                    <div class="category-card" data-category="letter" onclick="selectCategory('letter')">
                        <div class="category-icon"><i class="fas fa-envelope-open-text"></i></div>
                        <div class="category-title">Letter</div>
                        <div class="category-desc">Cover Letter, Recommendation</div>
                    </div>
                    <div class="category-card" data-category="proposal" onclick="selectCategory('proposal')">
                        <div class="category-icon"><i class="fas fa-file-powerpoint"></i></div>
                        <div class="category-title">Proposal</div>
                        <div class="category-desc">Project Proposal</div>
                    </div>
                    <div class="category-card" data-category="internship" onclick="selectCategory('internship')">
                        <div class="category-icon"><i class="fas fa-briefcase"></i></div>
                        <div class="category-title">Internship</div>
                        <div class="category-desc">Internship Report</div>
                    </div>
                    <div class="category-card" data-category="project_document" onclick="selectCategory('project_document')">
                        <div class="category-icon"><i class="fas fa-folder-open"></i></div>
                        <div class="category-title">Project</div>
                        <div class="category-desc">Project Document</div>
                    </div>
                </div>
                <input type="hidden" name="document_category" id="document_category" value="{{ old('document_category') }}">
                @error('document_category')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4" id="project_title_field" style="display: none;">
                <label class="form-label fw-semibold">Project Title <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                    <input type="text" class="form-control @error('project_title') is-invalid @enderror" 
                           id="project_title" name="project_title" placeholder="Enter your project title" value="{{ old('project_title') }}">
                </div>
                <small class="text-muted"><i class="fas fa-info-circle"></i> Required for Proposals and Project Documents</small>
                @error('project_title')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Description (Optional)</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3" 
                          placeholder="Add any additional notes about this document...">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Section 3: Upload -->
        <div class="form-section" id="section3">
            <div class="section-title">
                <i class="fas fa-cloud-upload-alt"></i>
                <span>Upload Document</span>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold">Document File <span class="text-danger">*</span></label>
                
                <div class="upload-area" id="uploadArea">
                    <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: var(--primary);"></i>
                    <p class="fw-semibold mb-1">Click or drag file to upload</p>
                    <small class="text-muted">PDF, DOC, DOCX, JPG, PNG (Max 250MB)</small>
                    <input type="file" class="d-none" id="document" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp" required>
                </div>
                
                <div id="fileInfo" style="display: none;">
                    <div class="file-info-card">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-file-pdf fa-2x" style="color: var(--danger);"></i>
                            <div>
                                <strong id="selectedFileName"></strong>
                                <br>
                                <small id="fileSize" class="text-muted"></small>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFile()">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                </div>
                
                @error('document')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- File Naming Convention -->
            <div class="info-alert">
                <div class="d-flex gap-3">
                    <i class="fas fa-info-circle fa-2x"></i>
                    <div>
                        <strong class="d-block mb-1">File Naming Convention</strong>
                        <p class="mb-2 small">Your file will be automatically renamed to:</p>
                        <code class="bg-white px-3 py-2 rounded d-inline-block" id="filename_preview" style="font-size: 0.85rem;">
                            Firstname_Lastname_DocumentType.pdf
                        </code>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex gap-3 mt-4">
            <button type="submit" class="btn btn-submit flex-grow-1">
                <i class="fas fa-paper-plane me-2"></i> Submit Document
            </button>
            <a href="{{ route('student.submission.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 50px;">
                <i class="fas fa-times me-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // Step navigation
    function updateStepIndicator() {
        let currentSection = 1;
        
        if (document.getElementById('document_category').value) currentSection = 2;
        if (document.getElementById('document').files.length > 0) currentSection = 3;
        
        for (let i = 1; i <= 3; i++) {
            const step = document.getElementById(`step${i}`);
            if (i <= currentSection) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        }
    }
    
    // Category selection
    function selectCategory(category) {
        document.getElementById('document_category').value = category;
        
        document.querySelectorAll('.category-card').forEach(card => {
            if (card.getAttribute('data-category') === category) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });
        
        const projectTitleField = document.getElementById('project_title_field');
        const projectTitleInput = document.getElementById('project_title');
        
        if (category === 'proposal' || category === 'project_document') {
            projectTitleField.style.display = 'block';
            projectTitleInput.required = true;
        } else {
            projectTitleField.style.display = 'none';
            projectTitleInput.required = false;
        }
        
        updateFilenamePreview();
        updateStepIndicator();
    }
    
    // File upload handling
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('document');
    const fileInfo = document.getElementById('fileInfo');
    const selectedFileName = document.getElementById('selectedFileName');
    const fileSizeSpan = document.getElementById('fileSize');
    
    uploadArea.addEventListener('click', () => fileInput.click());
    
    fileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            const file = this.files[0];
            selectedFileName.textContent = file.name;
            
            let size = file.size;
            if (size < 1024) fileSizeSpan.textContent = size + ' bytes';
            else if (size < 1048576) fileSizeSpan.textContent = (size / 1024).toFixed(2) + ' KB';
            else fileSizeSpan.textContent = (size / 1048576).toFixed(2) + ' MB';
            
            fileInfo.style.display = 'block';
            uploadArea.style.display = 'none';
            updateFilenamePreview();
            updateStepIndicator();
        }
    });
    
    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });
    
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('drag-over');
    });
    
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            const file = files[0];
            selectedFileName.textContent = file.name;
            
            let size = file.size;
            if (size < 1024) fileSizeSpan.textContent = size + ' bytes';
            else if (size < 1048576) fileSizeSpan.textContent = (size / 1024).toFixed(2) + ' KB';
            else fileSizeSpan.textContent = (size / 1048576).toFixed(2) + ' MB';
            
            fileInfo.style.display = 'block';
            uploadArea.style.display = 'none';
            updateFilenamePreview();
            updateStepIndicator();
        }
    });
    
    function clearFile() {
        fileInput.value = '';
        fileInfo.style.display = 'none';
        uploadArea.style.display = 'block';
        updateFilenamePreview();
        updateStepIndicator();
    }
    
    // Update filename preview
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
        
        let extension = 'pdf';
        if (fileInput.files.length > 0) {
            const fileName = fileInput.files[0].name;
            extension = fileName.split('.').pop();
        }
        
        const preview = firstName + '_' + lastName + '_' + typeName + '.' + extension;
        document.getElementById('filename_preview').textContent = preview;
    }
    
    // Event listeners
    document.getElementById('full_name').addEventListener('input', updateFilenamePreview);
    document.getElementById('student_id').addEventListener('input', updateFilenamePreview);
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        const oldCategory = '{{ old('document_category') }}';
        if (oldCategory) {
            selectCategory(oldCategory);
        }
        
        if (fileInput.files.length > 0) {
            fileInfo.style.display = 'block';
            uploadArea.style.display = 'none';
        }
        
        updateStepIndicator();
    });
</script>
@endsection