<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\ChatbotController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/programs', [App\Http\Controllers\ProgramController::class, 'index'])->name('programs');

Route::get('/program-courses', function () {
    return view('program-courses');
})->name('program-courses');

// Public Staff Page
Route::get('/staff', [StaffController::class, 'index'])->name('staff');

// News Routes (Public) - Shows only published news
Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Students Page (Public)
Route::get('/students', [StudentController::class, 'index'])->name('students');

// Contact Routes (Public)
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// ========== COMPLAINT ROUTES (Public) ==========
Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/complaints/thankyou/{reference_no}', [ComplaintController::class, 'thankyou'])->name('complaints.thankyou');
Route::get('/complaints/track', [ComplaintController::class, 'trackForm'])->name('complaints.track-form');
Route::post('/complaints/track', [ComplaintController::class, 'track'])->name('complaints.track');

// ========== ALUMNI ROUTES (Public) ==========
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/register', [AlumniController::class, 'registerForm'])->name('alumni.register');
Route::post('/alumni/register', [AlumniController::class, 'register'])->name('alumni.register.store');
Route::get('/alumni/{alumni}', [AlumniController::class, 'show'])->name('alumni.show');

// ========== CHATBOT ROUTES (Public) ==========
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Messaging Routes (Accessible to all authenticated users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('messages')->name('messages.')->group(function () {
    Route::get('/', [App\Http\Controllers\MessageController::class, 'index'])->name('index');
    Route::get('/unread-count', [App\Http\Controllers\MessageController::class, 'unreadCount'])->name('unread-count');
    Route::get('/create/{user}', [App\Http\Controllers\MessageController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\MessageController::class, 'store'])->name('store');
    Route::get('/{conversation}', [App\Http\Controllers\MessageController::class, 'show'])->name('show');
    Route::post('/{conversation}/send', [App\Http\Controllers\MessageController::class, 'sendMessage'])->name('send');
    
    // Course forum
    Route::get('/course/{course}/forum', [App\Http\Controllers\MessageController::class, 'courseForum'])->name('course-forum');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Staff Management
    Route::get('/staff', [StaffController::class, 'admin'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');
    Route::patch('/staff/{staff}/toggle-status', [StaffController::class, 'toggleStatus'])->name('staff.toggle-status');
    
    // News Management
    Route::get('/news', [NewsController::class, 'adminIndex'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::patch('/news/{news}/toggle-status', [NewsController::class, 'toggleStatus'])->name('news.toggle-status');
    
    // Student Management
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'admin'])->name('index');
        Route::post('/store', [StudentController::class, 'store'])->name('store');
        Route::post('/upload', [StudentController::class, 'upload'])->name('upload');
        Route::get('/template', [StudentController::class, 'downloadTemplate'])->name('template');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
    });
    
    // Contact Messages Management
    Route::get('/contacts', [ContactController::class, 'admin'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::patch('/contacts/{contact}/mark-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
    
    // Complaint Management (Admin)
    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ComplaintController::class, 'index'])->name('index');
        Route::get('/{complaint}', [App\Http\Controllers\Admin\ComplaintController::class, 'show'])->name('show');
        Route::post('/{complaint}/respond', [App\Http\Controllers\Admin\ComplaintController::class, 'respond'])->name('respond');
        Route::patch('/{complaint}/status', [App\Http\Controllers\Admin\ComplaintController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{complaint}/approve', [App\Http\Controllers\Admin\ComplaintController::class, 'approve'])->name('approve');
        Route::patch('/{complaint}/reject', [App\Http\Controllers\Admin\ComplaintController::class, 'reject'])->name('reject');
        Route::delete('/{complaint}', [App\Http\Controllers\Admin\ComplaintController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [App\Http\Controllers\Admin\ComplaintController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/export/csv', [App\Http\Controllers\Admin\ComplaintController::class, 'export'])->name('export');
    });
    
    // ========== ALUMNI MANAGEMENT (ADMIN) ==========
    Route::prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AlumniController::class, 'index'])->name('index');
        Route::get('/dashboard', [App\Http\Controllers\Admin\AlumniController::class, 'dashboard'])->name('dashboard');
        Route::get('/report', [App\Http\Controllers\Admin\AlumniController::class, 'report'])->name('report');
        Route::get('/export', [App\Http\Controllers\Admin\AlumniController::class, 'export'])->name('export');
        Route::get('/{alumni}', [App\Http\Controllers\Admin\AlumniController::class, 'show'])->name('show');
        Route::post('/{alumni}/verify', [App\Http\Controllers\Admin\AlumniController::class, 'verify'])->name('verify');
        Route::post('/{alumni}/reject', [App\Http\Controllers\Admin\AlumniController::class, 'reject'])->name('reject');
        Route::delete('/{alumni}', [App\Http\Controllers\Admin\AlumniController::class, 'destroy'])->name('destroy');
    });
    
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/create-from-staff', [UserController::class, 'createFromStaff'])->name('create-from-staff');
        Route::post('/store-from-staff', [UserController::class, 'storeFromStaff'])->name('store-from-staff');
        Route::get('/create-from-student', [UserController::class, 'createFromStudent'])->name('create-from-student');
        Route::post('/store-from-student', [UserController::class, 'storeFromStudent'])->name('store-from-student');
        Route::get('/bulk/staff', [UserController::class, 'bulkCreateStaff'])->name('bulk.staff');
        Route::get('/bulk/students', [UserController::class, 'bulkCreateStudents'])->name('bulk.students');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // ========== COURSE STRUCTURE MANAGEMENT ==========
    Route::prefix('course-structure')->name('course-structure.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CourseStructureController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\CourseStructureController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\CourseStructureController::class, 'store'])->name('store');
        Route::get('/upload', [App\Http\Controllers\Admin\CourseStructureController::class, 'uploadForm'])->name('upload-form');
        Route::post('/upload', [App\Http\Controllers\Admin\CourseStructureController::class, 'upload'])->name('upload');
        Route::get('/template', [App\Http\Controllers\Admin\CourseStructureController::class, 'downloadTemplate'])->name('template');
        Route::get('/{courseStructure}/edit', [App\Http\Controllers\Admin\CourseStructureController::class, 'edit'])->name('edit');
        Route::put('/{courseStructure}', [App\Http\Controllers\Admin\CourseStructureController::class, 'update'])->name('update');
        Route::delete('/{courseStructure}', [App\Http\Controllers\Admin\CourseStructureController::class, 'destroy'])->name('destroy');
        Route::patch('/{courseStructure}/toggle-status', [App\Http\Controllers\Admin\CourseStructureController::class, 'toggleStatus'])->name('toggle-status');
    });
    
    // ========== COMPREHENSIVE COURSE MANAGEMENT ROUTES ==========
    Route::prefix('courses')->name('courses.')->group(function () {
        // Basic CRUD
        Route::get('/', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\CourseController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\CourseController::class, 'store'])->name('store');
        Route::get('/{course}', [App\Http\Controllers\Admin\CourseController::class, 'show'])->name('show');
        Route::get('/{course}/edit', [App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [App\Http\Controllers\Admin\CourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [App\Http\Controllers\Admin\CourseController::class, 'destroy'])->name('destroy');
        Route::patch('/{course}/toggle-status', [App\Http\Controllers\Admin\CourseController::class, 'toggleStatus'])->name('toggle-status');
        
        // Bulk Upload Routes
        Route::get('/upload', [App\Http\Controllers\Admin\CourseController::class, 'uploadForm'])->name('upload-form');
        Route::post('/upload', [App\Http\Controllers\Admin\CourseController::class, 'upload'])->name('upload');
        Route::get('/template', [App\Http\Controllers\Admin\CourseController::class, 'downloadTemplate'])->name('template');
        
        // Assignment Routes
        Route::get('/{course}/assign', [App\Http\Controllers\Admin\CourseController::class, 'assignForm'])->name('assign');
        Route::post('/{course}/assign', [App\Http\Controllers\Admin\CourseController::class, 'assign'])->name('assign.store');
        
        // Student enrollment management
        Route::get('/{course}/manage-students', [App\Http\Controllers\Admin\CourseController::class, 'manageStudents'])->name('manage-students');
        Route::post('/{course}/enroll-students', [App\Http\Controllers\Admin\CourseController::class, 'enrollStudents'])->name('enroll-students');
        Route::delete('/{course}/students/{student}', [App\Http\Controllers\Admin\CourseController::class, 'removeStudent'])->name('remove-student');
        
        // Legacy instructor assignment
        Route::get('/{course}/assign-instructors', [App\Http\Controllers\Admin\CourseController::class, 'assignInstructors'])->name('assign-instructors');
        Route::put('/{course}/update-instructors', [App\Http\Controllers\Admin\CourseController::class, 'updateInstructors'])->name('update-instructors');
        
        // API Routes for AJAX
        Route::get('/by-year/{year}', [App\Http\Controllers\Admin\CourseController::class, 'getByYear'])->name('by-year');
        Route::get('/{course}/enrollment-stats', [App\Http\Controllers\Admin\CourseController::class, 'enrollmentStats'])->name('enrollment-stats');
    });
    
    // ========== COURSE OFFERING ROUTES ==========
    Route::prefix('course-offerings')->name('courses.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\CourseOfferingController::class, 'index'])->name('offerings');
        Route::post('/offer', [App\Http\Controllers\Admin\CourseOfferingController::class, 'offerCourse'])->name('offer');
        Route::post('/offer-multiple', [App\Http\Controllers\Admin\CourseOfferingController::class, 'offerMultipleCourses'])->name('offer-multiple');
        Route::get('/by-year-semester', [App\Http\Controllers\Admin\CourseOfferingController::class, 'getCoursesByYearAndSemester'])->name('by-year-semester');
        Route::get('/students-by-year', [App\Http\Controllers\Admin\CourseOfferingController::class, 'getStudentsByYear'])->name('students-by-year');
        Route::get('/offering-summary', [App\Http\Controllers\Admin\CourseOfferingController::class, 'getOfferingSummary'])->name('offering-summary');
    });
    
    // ========== DOCUMENT SUBMISSION MANAGEMENT (ADMIN) ==========
    Route::prefix('document-submissions')->name('document-submissions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DocumentSubmissionController::class, 'index'])->name('index');
        Route::get('/{submission}', [App\Http\Controllers\Admin\DocumentSubmissionController::class, 'show'])->name('show');
        Route::get('/{submission}/download', [App\Http\Controllers\Admin\DocumentSubmissionController::class, 'download'])->name('download');
        Route::post('/{submission}/approve', [App\Http\Controllers\Admin\DocumentSubmissionController::class, 'approve'])->name('approve');
        Route::post('/{submission}/reject', [App\Http\Controllers\Admin\DocumentSubmissionController::class, 'reject'])->name('reject');
        Route::delete('/{submission}', [App\Http\Controllers\Admin\DocumentSubmissionController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv', [App\Http\Controllers\Admin\DocumentSubmissionController::class, 'export'])->name('export');
    });
    
    // ========== PROGRAM MANAGEMENT ROUTES (ADMIN) ==========
    Route::resource('programs', App\Http\Controllers\Admin\ProgramController::class);
    
    // Program Requirements Routes
    Route::post('/requirements', [App\Http\Controllers\Admin\ProgramController::class, 'storeRequirement'])->name('programs.requirements.store');
    Route::put('/requirements/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'updateRequirement'])->name('programs.requirements.update');
    Route::delete('/requirements/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'destroyRequirement'])->name('programs.requirements.destroy');
    
    // Admission Requirements Routes
    Route::post('/admission', [App\Http\Controllers\Admin\ProgramController::class, 'storeAdmission'])->name('programs.admission.store');
    Route::put('/admission/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'updateAdmission'])->name('programs.admission.update');
    Route::delete('/admission/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'destroyAdmission'])->name('programs.admission.destroy');
    
    // Graduation Requirements Routes
    Route::post('/graduation', [App\Http\Controllers\Admin\ProgramController::class, 'storeGraduation'])->name('programs.graduation.store');
    Route::put('/graduation/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'updateGraduation'])->name('programs.graduation.update');
    Route::delete('/graduation/{id}', [App\Http\Controllers\Admin\ProgramController::class, 'destroyGraduation'])->name('programs.graduation.destroy');
    
    // Statistics/Analytics
    Route::get('/statistics', function () {
        return view('admin.statistics');
    })->name('statistics');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
});

/*
|--------------------------------------------------------------------------
| Staff Routes (Protected) - COMPREHENSIVE STAFF DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['staff'])->prefix('staff')->name('staff.')->group(function () {
    // Staff Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Staff\StaffDashboardController::class, 'index'])->name('dashboard');
    
    // ========== PROFILE MANAGEMENT ==========
    Route::get('/profile/edit', [App\Http\Controllers\Staff\StaffDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\Staff\StaffDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password/change', [App\Http\Controllers\Staff\StaffDashboardController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/update', [App\Http\Controllers\Staff\StaffDashboardController::class, 'updatePassword'])->name('password.update');
    
    // ========== COURSE MANAGEMENT ==========
    Route::get('/courses', [App\Http\Controllers\Staff\CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [App\Http\Controllers\Staff\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/students', [App\Http\Controllers\Staff\CourseController::class, 'students'])->name('courses.students');
    
    // ========== COURSE MATERIALS ==========
    Route::get('/courses/{course}/materials/create', [App\Http\Controllers\Staff\CourseMaterialController::class, 'create'])->name('materials.create');
    Route::post('/courses/{course}/materials', [App\Http\Controllers\Staff\CourseMaterialController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/download', [App\Http\Controllers\Staff\CourseMaterialController::class, 'download'])->name('materials.download');
    Route::delete('/materials/{material}', [App\Http\Controllers\Staff\CourseMaterialController::class, 'destroy'])->name('materials.destroy');
    
    // ========== ASSIGNMENTS ==========
    Route::get('/courses/{course}/assignments/create', [App\Http\Controllers\Staff\AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/courses/{course}/assignments', [App\Http\Controllers\Staff\AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{assignment}', [App\Http\Controllers\Staff\AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{assignment}/edit', [App\Http\Controllers\Staff\AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{assignment}', [App\Http\Controllers\Staff\AssignmentController::class, 'update'])->name('assignments.update');
    Route::get('/assignments/{assignment}/bulk-grade', [App\Http\Controllers\Staff\AssignmentController::class, 'bulkGrade'])->name('assignments.bulk-grade');
    Route::post('/assignments/{assignment}/bulk-grade', [App\Http\Controllers\Staff\AssignmentController::class, 'submitBulkGrade'])->name('assignments.submit-bulk-grade');
    Route::get('/assignments/{assignment}/download-all', [App\Http\Controllers\Staff\AssignmentController::class, 'downloadAllSubmissions'])->name('assignments.download-all');
    
    // ========== ASSIGNMENT SUBMISSIONS ==========
    Route::get('/submissions/{submission}/grade', [App\Http\Controllers\Staff\AssignmentController::class, 'gradeSubmission'])->name('assignments.grade');
    Route::post('/submissions/{submission}/grade', [App\Http\Controllers\Staff\AssignmentController::class, 'submitGrade'])->name('assignments.submit-grade');
    Route::get('/submissions/{submission}/download', [App\Http\Controllers\Staff\AssignmentController::class, 'downloadSubmission'])->name('submissions.download');
    
    // ========== COURSE NOTICES ==========
    Route::get('/courses/{course}/notices/create', [App\Http\Controllers\Staff\CourseNoticeController::class, 'create'])->name('notices.create');
    Route::post('/courses/{course}/notices', [App\Http\Controllers\Staff\CourseNoticeController::class, 'store'])->name('notices.store');
    Route::get('/notices/{notice}/edit', [App\Http\Controllers\Staff\CourseNoticeController::class, 'edit'])->name('notices.edit');
    Route::put('/notices/{notice}', [App\Http\Controllers\Staff\CourseNoticeController::class, 'update'])->name('notices.update');
    Route::delete('/notices/{notice}', [App\Http\Controllers\Staff\CourseNoticeController::class, 'destroy'])->name('notices.destroy');
    Route::get('/notices/{notice}/download', [App\Http\Controllers\Staff\CourseNoticeController::class, 'downloadAttachment'])->name('notices.download');
    
    // ========== GRADES MANAGEMENT ==========
    Route::get('/courses/{course}/grades', [App\Http\Controllers\Staff\GradeController::class, 'index'])->name('grades.index');
    Route::post('/courses/{course}/students/{student}/grades', [App\Http\Controllers\Staff\GradeController::class, 'store'])->name('grades.store');
    Route::get('/courses/{course}/grades/final', [App\Http\Controllers\Staff\GradeController::class, 'finalGrades'])->name('grades.final');
    Route::get('/courses/{course}/grades/export', [App\Http\Controllers\Staff\GradeController::class, 'export'])->name('grades.export');
    
    // ========== MESSAGES ==========
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('messages');
    Route::get('/messages/{conversation}', [App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/send', [App\Http\Controllers\MessageController::class, 'sendMessage'])->name('messages.send');
    
    // ========== NEWS (READ-ONLY) ==========
    Route::get('/news', [NewsController::class, 'staffIndex'])->name('news.index');
    Route::get('/news/{news}', [NewsController::class, 'staffShow'])->name('news.show');
    
    // ========== STUDENTS (READ-ONLY) ==========
    Route::get('/students', [StudentController::class, 'staffIndex'])->name('students.index');
    Route::get('/students/{student}', [StudentController::class, 'staffShow'])->name('students.show');
    
    // ========== COMPLAINTS (STAFF VIEW) ==========
    Route::get('/complaints', [App\Http\Controllers\Staff\ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [App\Http\Controllers\Staff\ComplaintController::class, 'show'])->name('complaints.show');
    
    // ========== DOCUMENT SUBMISSION REVIEW (STAFF) ==========
    Route::prefix('document-submissions')->name('document-submissions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Staff\DocumentSubmissionController::class, 'index'])->name('index');
        Route::get('/{submission}', [App\Http\Controllers\Staff\DocumentSubmissionController::class, 'show'])->name('show');
        Route::get('/{submission}/download', [App\Http\Controllers\Staff\DocumentSubmissionController::class, 'download'])->name('download');
        Route::post('/{submission}/review', [App\Http\Controllers\Staff\DocumentSubmissionController::class, 'review'])->name('review');
    });
});

/*
|--------------------------------------------------------------------------
| Student Routes (Protected) - WITH DOCUMENT SUBMISSION SYSTEM
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    // Student Dashboard
    Route::get('/dashboard', [App\Http\Controllers\StudentController::class, 'dashboard'])->name('dashboard');
    
    // Student Profile
    Route::get('/profile', [App\Http\Controllers\StudentController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\StudentController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password/change', [App\Http\Controllers\StudentController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/update', [App\Http\Controllers\StudentController::class, 'updatePassword'])->name('password.update');
    
    // Student Courses
    Route::get('/courses', [App\Http\Controllers\StudentController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}', [App\Http\Controllers\StudentController::class, 'courseDetail'])->name('courses.show');
    
    // Student Grades
    Route::get('/grades', [App\Http\Controllers\StudentController::class, 'grades'])->name('grades');
    
    // Course Materials
    Route::get('/courses/{course}/materials', [App\Http\Controllers\StudentController::class, 'materials'])->name('materials');
    Route::get('/materials/{material}/download', [App\Http\Controllers\StudentController::class, 'downloadMaterial'])->name('materials.download');
    
    // Student Assignments
    Route::get('/courses/{course}/assignments', [App\Http\Controllers\StudentController::class, 'assignments'])->name('assignments');
    Route::get('/assignments/{assignment}', [App\Http\Controllers\StudentController::class, 'assignmentDetail'])->name('assignments.show');
    Route::post('/assignments/{assignment}/submit', [App\Http\Controllers\StudentController::class, 'submitAssignment'])->name('assignments.submit');
    
    // Student Notices
    Route::get('/notices', [App\Http\Controllers\StudentController::class, 'notices'])->name('notices');
    
    // News (read-only)
    Route::get('/news', [App\Http\Controllers\NewsController::class, 'studentIndex'])->name('news.index');
    Route::get('/news/{news}', [App\Http\Controllers\NewsController::class, 'studentShow'])->name('news.show');
    
    // Student Complaints
    Route::get('/my-complaints', [App\Http\Controllers\StudentController::class, 'myComplaints'])->name('complaints');
    Route::get('/complaints/{complaint}', [App\Http\Controllers\StudentController::class, 'complaintDetail'])->name('complaints.show');
    
    // ========== DOCUMENT SUBMISSION SYSTEM (STUDENT) ==========
    // Primary routes
    Route::prefix('documents')->name('submission.')->group(function () {
        Route::get('/', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'store'])->name('store');
        Route::get('/{id}', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'show'])->name('show');
        Route::get('/{id}/download', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'download'])->name('download');
        Route::delete('/{id}', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'destroy'])->name('destroy');
    });
    
    // Alias routes for convenience (these work alongside the primary routes)
    Route::get('/submissions', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submission/create', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'create'])->name('submission.create');
    Route::post('/submission', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'store'])->name('submission.store');
    Route::get('/submission/{id}', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'show'])->name('submission.show');
    Route::get('/submission/{id}/download', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'download'])->name('submission.download');
    Route::delete('/submission/{id}', [App\Http\Controllers\Student\DocumentSubmissionController::class, 'destroy'])->name('submission.destroy');
});

/*
|--------------------------------------------------------------------------
| Alumni Routes (Protected - Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('alumni')->name('alumni.')->group(function () {
    Route::get('/dashboard', [AlumniController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile/edit', [AlumniController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [AlumniController::class, 'updateProfile'])->name('profile.update');
    Route::get('/jobs/create', [AlumniController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [AlumniController::class, 'storeJob'])->name('jobs.store');
});

/*
|--------------------------------------------------------------------------
| REAL-TIME CHAT ROUTES (Accessible to all authenticated users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [App\Http\Controllers\ChatController::class, 'index'])->name('index');
    Route::get('/conversation/{conversation}', [App\Http\Controllers\ChatController::class, 'getConversation'])->name('conversation');
    Route::post('/send-message', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('send');
    Route::post('/start-conversation', [App\Http\Controllers\ChatController::class, 'startConversation'])->name('start');
    Route::get('/online-users', [App\Http\Controllers\ChatController::class, 'getOnlineUsers'])->name('online-users');
    Route::post('/update-status', [App\Http\Controllers\ChatController::class, 'updateStatus'])->name('update-status');
    Route::post('/typing/{conversation}', [App\Http\Controllers\ChatController::class, 'typing'])->name('typing');
    Route::post('/mark-read/{conversation}', [App\Http\Controllers\ChatController::class, 'markAsRead'])->name('mark-read');
    Route::get('/unread-count', [App\Http\Controllers\ChatController::class, 'getUnreadCount'])->name('unread-count');
});

/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
*/

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::get('/all-assignments', [App\Http\Controllers\StudentController::class, 'allAssignments'])->name('all-assignments');

/*
|--------------------------------------------------------------------------
| ADDED: Staff Admin Route (For Staff Management)
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->get('/staff-admin', [StaffController::class, 'admin'])->name('staff.admin');

/*
|--------------------------------------------------------------------------
| Fallback Route (404 handling)
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return view('errors.404');
});