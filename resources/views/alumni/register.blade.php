@extends('layouts.app')

@section('title', 'Alumni Registration')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #003E72 0%, #002b4f 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Alumni Registration</h1>
        <p style="font-size: 1.2rem;">Join our growing alumni community</p>
    </div>
</div>

<div class="container" style="margin-top: -2rem;">
    <div style="max-width: 950px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <ul style="margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="alumniRegistrationForm" action="{{ route('alumni.register.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf

                <!-- Personal Information -->
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <h3 style="color: #003E72; margin-bottom: 1rem;"><i class="fas fa-user"></i> Personal Information</h3>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Student ID *</label>
                        <input type="text" name="student_id" id="student_id" value="{{ old('student_id') }}" required 
                               onblur="validateStudentId()" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <small id="student_id_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Student ID must be alphanumeric (e.g., CS2024001)</small>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Full Name *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                               onblur="validateName()" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <small id="name_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Name should contain only letters and spaces</small>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required 
                               onblur="validateEmail()" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <small id="email_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Enter a valid email address (e.g., name@example.com)</small>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Phone Number</label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" 
                               onblur="validatePhone()" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <small id="phone_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Enter a valid phone number (e.g., +251912345678)</small>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Graduation Year *</label>
                        <select name="graduation_year" id="graduation_year" required onchange="validateGraduationYear()" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Year</option>
                            @for($year = 2013; $year <= 2040; $year++)
                                <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        <small id="graduation_year_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Graduation year cannot be in the future (Current year: {{ date('Y') }})</small>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Degree *</label>
                        <select name="degree" id="degree" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Degree</option>
                            <option value="B.Sc. Computer Science" {{ old('degree') == 'B.Sc. Computer Science' ? 'selected' : '' }}>B.Sc. Computer Science</option>
                        </select>
                    </div>
                </div>

                <!-- Employment Information -->
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin: 2rem 0 1rem;">
                    <h3 style="color: #003E72; margin-bottom: 1rem;"><i class="fas fa-briefcase"></i> Employment Information</h3>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Employment Status *</label>
                        <select name="employment_status" id="employment_status" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Status</option>
                            <option value="employed" {{ old('employment_status') == 'employed' ? 'selected' : '' }}>Employed</option>
                            <option value="self_employed" {{ old('employment_status') == 'self_employed' ? 'selected' : '' }}>Self-Employed</option>
                            <option value="freelance" {{ old('employment_status') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            <option value="unemployed" {{ old('employment_status') == 'unemployed' ? 'selected' : '' }}>Unemployed</option>
                            <option value="student" {{ old('employment_status') == 'student' ? 'selected' : '' }}>Student (Continuing Education)</option>
                            <option value="entrepreneur" {{ old('employment_status') == 'entrepreneur' ? 'selected' : '' }}>Entrepreneur / Business Owner</option>
                            <option value="retired" {{ old('employment_status') == 'retired' ? 'selected' : '' }}>Retired</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Employment Type</label>
                        <select name="employment_type" id="employment_type" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Type</option>
                            <option value="full_time_permanent" {{ old('employment_type') == 'full_time_permanent' ? 'selected' : '' }}>Permanent - Full Time</option>
                            <option value="part_time_permanent" {{ old('employment_type') == 'part_time_permanent' ? 'selected' : '' }}>Permanent - Part Time</option>
                            <option value="contract" {{ old('employment_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                            <option value="gig" {{ old('employment_type') == 'gig' ? 'selected' : '' }}>Gig Work</option>
                            <option value="internship" {{ old('employment_type') == 'internship' ? 'selected' : '' }}>Internship</option>
                            <option value="freelance" {{ old('employment_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            <option value="consultant" {{ old('employment_type') == 'consultant' ? 'selected' : '' }}>Consultant</option>
                            <option value="temporary" {{ old('employment_type') == 'temporary' ? 'selected' : '' }}>Temporary</option>
                        </select>
                    </div>
                </div>

                <!-- Employment Start Date -->
                <div style="margin-top: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Employment Start Date</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <select name="employment_start_month" id="employment_start_month" style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Month</option>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ old('employment_start_month') == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                            @endfor
                        </select>
                        <select name="employment_start_year" id="employment_start_year" onchange="validateEmploymentStartDate()" style="padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Year</option>
                            @for($y = 2013; $y <= 2040; $y++)
                                <option value="{{ $y }}" {{ old('employment_start_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <small id="start_date_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Start date cannot be in the future (Current year: {{ date('Y') }})</small>
                </div>

                <!-- Organization Type -->
                <div style="margin-top: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Organization Type *</label>
                    <select name="organization_type" id="organization_type" required style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Select Organization Type</option>
                        <option value="government" {{ old('organization_type') == 'government' ? 'selected' : '' }}>🏛️ Government / Public Sector</option>
                        <option value="ngo" {{ old('organization_type') == 'ngo' ? 'selected' : '' }}>🤝 NGO / Non-Profit Organization</option>
                        <option value="private" {{ old('organization_type') == 'private' ? 'selected' : '' }}>🏢 Private Sector / Corporation</option>
                        <option value="international" {{ old('organization_type') == 'international' ? 'selected' : '' }}>🌍 International Organization</option>
                        <option value="academic" {{ old('organization_type') == 'academic' ? 'selected' : '' }}>🎓 Academic / University</option>
                        <option value="startup" {{ old('organization_type') == 'startup' ? 'selected' : '' }}>🚀 Startup / Tech Company</option>
                        <option value="self_employed" {{ old('organization_type') == 'self_employed' ? 'selected' : '' }}>👤 Self-Employed / Freelance</option>
                        <option value="entrepreneur" {{ old('organization_type') == 'entrepreneur' ? 'selected' : '' }}>💼 Entrepreneur / Business Owner</option>
                        <option value="research" {{ old('organization_type') == 'research' ? 'selected' : '' }}>🔬 Research Institute</option>
                        <option value="healthcare" {{ old('organization_type') == 'healthcare' ? 'selected' : '' }}>🏥 Healthcare / Medical</option>
                        <option value="financial" {{ old('organization_type') == 'financial' ? 'selected' : '' }}>💰 Financial / Banking</option>
                        <option value="consulting" {{ old('organization_type') == 'consulting' ? 'selected' : '' }}>📊 Consulting Firm</option>
                        <option value="other" {{ old('organization_type') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Current Job Title</label>
                        <input type="text" name="current_job_title" id="current_job_title" value="{{ old('current_job_title') }}" 
                               onblur="validateJobTitle()" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <small id="job_title_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Job title should contain only letters, numbers, and spaces</small>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Current Company / Organization</label>
                        <input type="text" name="current_company" id="current_company" value="{{ old('current_company') }}" 
                               onblur="validateCompany()" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                        <small id="company_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Company name should contain only letters, numbers, and spaces</small>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Job Level / Seniority</label>
                        <select name="job_level" id="job_level" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Level</option>
                            <option value="entry" {{ old('job_level') == 'entry' ? 'selected' : '' }}>Entry Level / Junior</option>
                            <option value="mid" {{ old('job_level') == 'mid' ? 'selected' : '' }}>Mid Level</option>
                            <option value="senior" {{ old('job_level') == 'senior' ? 'selected' : '' }}>Senior Level</option>
                            <option value="lead" {{ old('job_level') == 'lead' ? 'selected' : '' }}>Team Lead / Supervisor</option>
                            <option value="manager" {{ old('job_level') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="director" {{ old('job_level') == 'director' ? 'selected' : '' }}>Director / Head</option>
                            <option value="executive" {{ old('job_level') == 'executive' ? 'selected' : '' }}>Executive / C-Level</option>
                            <option value="owner" {{ old('job_level') == 'owner' ? 'selected' : '' }}>Owner / Founder</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Department / Division</label>
                        <input type="text" name="department" id="department" value="{{ old('department') }}" 
                               placeholder="e.g., Engineering, Marketing, IT" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Industry Sector</label>
                        <select name="industry_sector" id="industry_sector" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Industry</option>
                            <option value="technology" {{ old('industry_sector') == 'technology' ? 'selected' : '' }}>Technology / IT / Software</option>
                            <option value="telecom" {{ old('industry_sector') == 'telecom' ? 'selected' : '' }}>Telecommunications</option>
                            <option value="education" {{ old('industry_sector') == 'education' ? 'selected' : '' }}>Education / Academia</option>
                            <option value="finance" {{ old('industry_sector') == 'finance' ? 'selected' : '' }}>Finance / Banking / Insurance</option>
                            <option value="healthcare" {{ old('industry_sector') == 'healthcare' ? 'selected' : '' }}>Healthcare / Medical</option>
                            <option value="government" {{ old('industry_sector') == 'government' ? 'selected' : '' }}>Government / Public Administration</option>
                            <option value="ngo" {{ old('industry_sector') == 'ngo' ? 'selected' : '' }}>NGO / Non-Profit / Humanitarian</option>
                            <option value="manufacturing" {{ old('industry_sector') == 'manufacturing' ? 'selected' : '' }}>Manufacturing / Industry</option>
                            <option value="construction" {{ old('industry_sector') == 'construction' ? 'selected' : '' }}>Construction / Real Estate</option>
                            <option value="agriculture" {{ old('industry_sector') == 'agriculture' ? 'selected' : '' }}>Agriculture / Agribusiness</option>
                            <option value="energy" {{ old('industry_sector') == 'energy' ? 'selected' : '' }}>Energy / Mining / Oil & Gas</option>
                            <option value="transport" {{ old('industry_sector') == 'transport' ? 'selected' : '' }}>Transport / Logistics</option>
                            <option value="hospitality" {{ old('industry_sector') == 'hospitality' ? 'selected' : '' }}>Hospitality / Tourism</option>
                            <option value="consulting" {{ old('industry_sector') == 'consulting' ? 'selected' : '' }}>Consulting / Professional Services</option>
                            <option value="retail" {{ old('industry_sector') == 'retail' ? 'selected' : '' }}>Retail / E-commerce</option>
                            <option value="media" {{ old('industry_sector') == 'media' ? 'selected' : '' }}>Media / Entertainment</option>
                            <option value="research" {{ old('industry_sector') == 'research' ? 'selected' : '' }}>Research & Development</option>
                            <option value="other" {{ old('industry_sector') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Work Mode</label>
                        <select name="work_mode" id="work_mode" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Work Mode</option>
                            <option value="onsite" {{ old('work_mode') == 'onsite' ? 'selected' : '' }}>On-site (Office)</option>
                            <option value="remote" {{ old('work_mode') == 'remote' ? 'selected' : '' }}>Remote (Work from Home)</option>
                            <option value="hybrid" {{ old('work_mode') == 'hybrid' ? 'selected' : '' }}>Hybrid (Mixed)</option>
                            <option value="flexible" {{ old('work_mode') == 'flexible' ? 'selected' : '' }}>Flexible Schedule</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Location (City, Country)</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                           onblur="validateLocation()" placeholder="e.g., Addis Ababa, Ethiopia" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                    <small id="location_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Location should contain only letters, spaces, and commas</small>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-top: 1rem;">
                    <div>
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Salary Range (Optional)</label>
                        <select name="salary_range" id="salary_range" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">Select Range</option>
                            <option value="< 10,000 ETB" {{ old('salary_range') == '< 10,000 ETB' ? 'selected' : '' }}>&lt; 10,000 ETB</option>
                            <option value="10,000 - 20,000 ETB" {{ old('salary_range') == '10,000 - 20,000 ETB' ? 'selected' : '' }}>10,000 - 20,000 ETB</option>
                            <option value="20,000 - 35,000 ETB" {{ old('salary_range') == '20,000 - 35,000 ETB' ? 'selected' : '' }}>20,000 - 35,000 ETB</option>
                            <option value="35,000 - 50,000 ETB" {{ old('salary_range') == '35,000 - 50,000 ETB' ? 'selected' : '' }}>35,000 - 50,000 ETB</option>
                            <option value="50,000 - 75,000 ETB" {{ old('salary_range') == '50,000 - 75,000 ETB' ? 'selected' : '' }}>50,000 - 75,000 ETB</option>
                            <option value="75,000 - 100,000 ETB" {{ old('salary_range') == '75,000 - 100,000 ETB' ? 'selected' : '' }}>75,000 - 100,000 ETB</option>
                            <option value="> 100,000 ETB" {{ old('salary_range') == '> 100,000 ETB' ? 'selected' : '' }}>&gt; 100,000 ETB</option>
                            <option value="prefer_not_say" {{ old('salary_range') == 'prefer_not_say' ? 'selected' : '' }}>Prefer not to say</option>
                        </select>
                    </div>
                </div>

                <!-- About You -->
                <div style="background: #f8f9fa; padding: 1rem; border-radius: 10px; margin: 2rem 0 1rem;">
                    <h3 style="color: #003E72; margin-bottom: 1rem;"><i class="fas fa-star"></i> About You</h3>
                </div>

                <div style="margin-top: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Bio / Professional Summary</label>
                    <textarea name="bio" id="bio" rows="4" 
                              onblur="validateBio()" placeholder="Tell us about yourself, your career journey, achievements, and what you're passionate about..." 
                              style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 5px;">{{ old('bio') }}</textarea>
                    <small id="bio_error" style="color: #dc3545; display: none; font-size: 0.8rem;">Bio must be between 10 and 1000 characters</small>
                </div>

                <!-- Profile Picture -->
                <div style="margin-top: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Profile Picture</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" onchange="validateImage()" style="width: 100%; padding: 0.8rem;">
                    <small id="image_error" style="color: #dc3545; display: none; font-size: 0.8rem;">File must be an image (JPEG, PNG, JPG) and less than 2MB</small>
                    <small style="color: #6c757d; display: block;">Recommended: Square image, at least 300x300 pixels</small>
                </div>

                <button type="submit" style="width: 100%; margin-top: 2rem; background: #ffc107; color: #003E72; padding: 1rem; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer;">
                    <i class="fas fa-paper-plane"></i> Register as Alumnus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Validation Functions
    function validateStudentId() {
        const studentId = document.getElementById('student_id').value;
        const errorSpan = document.getElementById('student_id_error');
        const regex = /^[A-Za-z0-9]+$/;
        if (studentId && !regex.test(studentId)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateName() {
        const name = document.getElementById('name').value;
        const errorSpan = document.getElementById('name_error');
        const regex = /^[A-Za-z\s]+$/;
        if (name && !regex.test(name)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateEmail() {
        const email = document.getElementById('email').value;
        const errorSpan = document.getElementById('email_error');
        const regex = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
        if (email && !regex.test(email)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validatePhone() {
        const phone = document.getElementById('phone').value;
        const errorSpan = document.getElementById('phone_error');
        const regex = /^[\+]?[0-9\s\-\(\)]{8,20}$/;
        if (phone && !regex.test(phone)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateGraduationYear() {
        const year = document.getElementById('graduation_year').value;
        const errorSpan = document.getElementById('graduation_year_error');
        const currentYear = new Date().getFullYear();
        if (year && parseInt(year) > currentYear) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateEmploymentStartDate() {
        const month = document.getElementById('employment_start_month').value;
        const year = document.getElementById('employment_start_year').value;
        const errorSpan = document.getElementById('start_date_error');
        const currentYear = new Date().getFullYear();
        const currentMonth = new Date().getMonth() + 1;
        
        if (year && parseInt(year) > currentYear) {
            errorSpan.style.display = 'block';
            errorSpan.textContent = 'Start year cannot be in the future';
            return false;
        }
        if (year && parseInt(year) === currentYear && month && parseInt(month) > currentMonth) {
            errorSpan.style.display = 'block';
            errorSpan.textContent = 'Start month cannot be in the future';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateJobTitle() {
        const jobTitle = document.getElementById('current_job_title').value;
        const errorSpan = document.getElementById('job_title_error');
        const regex = /^[A-Za-z0-9\s\-\(\)]+$/;
        if (jobTitle && !regex.test(jobTitle)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateCompany() {
        const company = document.getElementById('current_company').value;
        const errorSpan = document.getElementById('company_error');
        const regex = /^[A-Za-z0-9\s\.\-\&]+$/;
        if (company && !regex.test(company)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateLocation() {
        const location = document.getElementById('location').value;
        const errorSpan = document.getElementById('location_error');
        const regex = /^[A-Za-z\s\,]+$/;
        if (location && !regex.test(location)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateBio() {
        const bio = document.getElementById('bio').value;
        const errorSpan = document.getElementById('bio_error');
        if (bio && (bio.length < 10 || bio.length > 1000)) {
            errorSpan.style.display = 'block';
            return false;
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateImage() {
        const file = document.getElementById('profile_image').files[0];
        const errorSpan = document.getElementById('image_error');
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const maxSize = 2 * 1024 * 1024;
            if (!validTypes.includes(file.type)) {
                errorSpan.textContent = 'File must be JPEG, PNG, or JPG';
                errorSpan.style.display = 'block';
                return false;
            }
            if (file.size > maxSize) {
                errorSpan.textContent = 'File size must be less than 2MB';
                errorSpan.style.display = 'block';
                return false;
            }
        }
        errorSpan.style.display = 'none';
        return true;
    }

    function validateForm() {
        let isValid = true;
        isValid = validateStudentId() && isValid;
        isValid = validateName() && isValid;
        isValid = validateEmail() && isValid;
        isValid = validatePhone() && isValid;
        isValid = validateGraduationYear() && isValid;
        isValid = validateEmploymentStartDate() && isValid;
        isValid = validateJobTitle() && isValid;
        isValid = validateCompany() && isValid;
        isValid = validateLocation() && isValid;
        isValid = validateBio() && isValid;
        isValid = validateImage() && isValid;
        
        if (!isValid) {
            alert('Please correct the errors before submitting.');
        }
        return isValid;
    }
</script>
@endsection