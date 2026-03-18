@extends('layouts.app')

@section('title', 'Computer Science Curriculum')

@push('styles')
<style>
    :root {
        --primary: #1a2b3c;
        --accent: #ffc107;
        --success: #28a745;
        --danger: #dc3545;
        --info: #17a2b8;
        --warning: #fd7e14;
    }

    .curriculum-header {
        background: linear-gradient(135deg, var(--primary) 0%, #2c3e50 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 50px 50px;
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-align: center;
        border-bottom: 4px solid var(--accent);
    }

    .summary-card h3 {
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .summary-card .value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--accent);
    }

    .summary-card .label {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .year-section {
        margin-bottom: 3rem;
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .year-title {
        background: var(--primary);
        color: white;
        padding: 1rem 2rem;
        margin: 0;
        font-size: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .year-title span {
        background: var(--accent);
        color: var(--primary);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 1rem;
    }

    .semester-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .semester-card {
        background: #f8f9fa;
        border-radius: 15px;
        overflow: hidden;
    }

    .semester-header {
        background: var(--accent);
        color: var(--primary);
        padding: 1rem;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .course-list {
        padding: 1rem;
    }

    .course-item {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 0.8rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .course-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(255,193,7,0.2);
    }

    .course-icon {
        width: 40px;
        height: 40px;
        background: var(--accent);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .course-details {
        flex: 1;
    }

    .course-code {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.9rem;
    }

    .course-title {
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    .course-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .course-meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .category-badge {
        padding: 0.2rem 0.8rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-compulsory { background: #cce5ff; color: #004085; }
    .badge-elective { background: #d4edda; color: #155724; }
    .badge-supportive { background: #fff3cd; color: #856404; }
    .badge-common { background: #e2d5f1; color: #6f42c1; }

    .upload-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .upload-area {
        border: 2px dashed var(--accent);
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        background: #fff9e6;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        background: #fff3cd;
        transform: scale(1.02);
    }

    .upload-area i {
        font-size: 3rem;
        color: var(--accent);
        margin-bottom: 1rem;
    }

    .btn {
        padding: 10px 25px;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: var(--accent);
        color: var(--primary);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,193,7,0.3);
    }

    .btn-success {
        background: var(--success);
        color: white;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 2000;
        justify-content: center;
        align-items: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 2rem;
        position: relative;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--primary);
    }

    .form-control {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent);
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="curriculum-header">
    <div class="container text-center">
        <h1 class="display-4" data-aos="fade-up">Computer Science Curriculum</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Bachelor of Science in Computer Science - 4 Year Program</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success" data-aos="fade-up">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="summary-cards" data-aos="fade-up">
        <div class="summary-card">
            <h3>Compulsory</h3>
            <div class="value">{{ $totals['compulsory']['credit_hours'] }} Cr</div>
            <div class="label">{{ $totals['compulsory']['ects'] }} ECTS</div>
        </div>
        <div class="summary-card">
            <h3>Elective</h3>
            <div class="value">{{ $totals['elective']['credit_hours'] }} Cr</div>
            <div class="label">{{ $totals['elective']['ects'] }} ECTS</div>
        </div>
        <div class="summary-card">
            <h3>Supportive</h3>
            <div class="value">{{ $totals['supportive']['credit_hours'] }} Cr</div>
            <div class="label">{{ $totals['supportive']['ects'] }} ECTS</div>
        </div>
        <div class="summary-card">
            <h3>Common</h3>
            <div class="value">{{ $totals['common']['credit_hours'] }} Cr</div>
            <div class="label">{{ $totals['common']['ects'] }} ECTS</div>
        </div>
        <div class="summary-card">
            <h3>Total</h3>
            <div class="value">{{ $totals['all']['credit_hours'] }} Cr</div>
            <div class="label">{{ $totals['all']['ects'] }} ECTS</div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center mb-4" data-aos="fade-up">
        <button class="btn btn-primary" onclick="openAddCourseModal()">
            <i class="fas fa-plus"></i> Add Course
        </button>
        <button class="btn btn-primary" onclick="openUploadModal()">
            <i class="fas fa-upload"></i> Upload Materials
        </button>
        <form action="{{ route('cs-courses.seed') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success" onclick="return confirm('Load the complete curriculum?')">
                <i class="fas fa-database"></i> Load Curriculum Data
            </button>
        </form>
    </div>

    <!-- Curriculum Display -->
    @foreach([1,2,3,4] as $year)
        @if(isset($courses[$year]))
            <div class="year-section" data-aos="fade-up">
                <div class="year-title">
                    Year {{ $year }}
                    <span>
                        @php
                            $yearCredits = 0;
                            $yearEcts = 0;
                            foreach($courses[$year] as $semester => $semCourses) {
                                foreach($semCourses as $course) {
                                    $yearCredits += $course->credit_hours;
                                    $yearEcts += $course->ects;
                                }
                            }
                        @endphp
                        {{ $yearCredits }} Cr | {{ $yearEcts }} ECTS
                    </span>
                </div>
                <div class="semester-grid">
                    @foreach([1,2] as $semester)
                        @if(isset($courses[$year][$semester]))
                            <div class="semester-card">
                                <div class="semester-header">
                                    Semester {{ $semester }}
                                    @php
                                        $semCredits = $courses[$year][$semester]->sum('credit_hours');
                                        $semEcts = $courses[$year][$semester]->sum('ects');
                                    @endphp
                                    <span style="float: right;">{{ $semCredits }} Cr | {{ $semEcts }} ECTS</span>
                                </div>
                                <div class="course-list">
                                    @foreach($courses[$year][$semester] as $course)
                                        <div class="course-item" onclick="viewCourse({{ $course->id }})">
                                            <div class="course-icon">
                                                <i class="fas fa-code"></i>
                                            </div>
                                            <div class="course-details">
                                                <div class="course-code">{{ $course->course_code }}</div>
                                                <div class="course-title">{{ $course->course_title }}</div>
                                                <div class="course-meta">
                                                    <span><i class="fas fa-weight"></i> {{ $course->credit_hours }} Cr</span>
                                                    <span><i class="fas fa-graduation-cap"></i> {{ $course->ects }} ECTS</span>
                                                    <span><i class="fas fa-clock"></i> {{ $course->lecture_hours }}/{{ $course->lab_hours }}/{{ $course->tutorial_hours }}</span>
                                                </div>
                                            </div>
                                            <span class="category-badge badge-{{ $course->category }}">
                                                {{ $course->category_name }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>

<!-- Add Course Modal -->
<div id="courseModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('courseModal')">&times;</button>
        <h2>Add New Course</h2>
        <form action="{{ route('cs-courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Course Code</label>
                <input type="text" name="course_code" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Course Title</label>
                <input type="text" name="course_title" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>ECTS</label>
                        <input type="number" name="ects" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Credit Hours</label>
                        <input type="number" step="0.5" name="credit_hours" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control" required>
                            <option value="compulsory">Compulsory</option>
                            <option value="elective">Elective</option>
                            <option value="supportive">Supportive</option>
                            <option value="common">Common</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Year</label>
                        <select name="year" class="form-control" required>
                            <option value="1">Year 1</option>
                            <option value="2">Year 2</option>
                            <option value="3">Year 3</option>
                            <option value="4">Year 4</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lecture Hours</label>
                        <input type="number" name="lecture_hours" class="form-control" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lab Hours</label>
                        <input type="number" name="lab_hours" class="form-control" value="0">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tutorial Hours</label>
                        <input type="number" name="tutorial_hours" class="form-control" value="0">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Course Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label>Syllabus (PDF)</label>
                <input type="file" name="syllabus" class="form-control" accept=".pdf">
            </div>
            <button type="submit" class="btn btn-primary">Save Course</button>
        </form>
    </div>
</div>

<!-- Upload Materials Modal -->
<div id="uploadModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal('uploadModal')">&times;</button>
        <h2>Upload Course Materials</h2>
        <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="form-group">
                <label>Select Course</label>
                <select name="course_id" class="form-control" id="courseSelect" required>
                    <option value="">Choose a course</option>
                    @foreach(CSCourse::all() as $course)
                        <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_title }}</option>
                    @endforeach
                </select>
            </div>
            <div id="materialFields">
                <div class="material-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Material Title</label>
                                <input type="text" name="material_titles[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Type</label>
                                <select name="material_types[]" class="form-control" required>
                                    <option value="syllabus">Syllabus</option>
                                    <option value="lecture_note">Lecture Note</option>
                                    <option value="lab_manual">Lab Manual</option>
                                    <option value="assignment">Assignment</option>
                                    <option value="reference">Reference</option>
                                    <option value="image">Image</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>File</label>
                                <input type="file" name="materials[]" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary" onclick="addMaterialField()">
                <i class="fas fa-plus"></i> Add Another Material
            </button>
            <button type="submit" class="btn btn-success">Upload Materials</button>
        </form>
    </div>
</div>

<script>
function openAddCourseModal() {
    document.getElementById('courseModal').classList.add('active');
}

function openUploadModal() {
    document.getElementById('uploadModal').classList.add('active');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

function addMaterialField() {
    const materialGroup = document.querySelector('.material-group').cloneNode(true);
    materialGroup.querySelectorAll('input').forEach(input => input.value = '');
    document.getElementById('materialFields').appendChild(materialGroup);
}

function viewCourse(courseId) {
    // Redirect to course detail page or open modal
    alert('Course details view coming soon! Course ID: ' + courseId);
}

window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
}
</script>
@endsection