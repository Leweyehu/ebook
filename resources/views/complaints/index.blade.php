@extends('layouts.app')

@section('title', 'Submit Complaint - Computer Science Department')
@section('page-title', 'Submit a Complaint')

@section('content')
<div class="page-header" style="background: linear-gradient(135deg, #1a2b3c 0%, #2c3e50 100%); color: white; padding: 4rem 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Submit a Complaint</h1>
        <p style="font-size: 1.2rem;">We take your concerns seriously. Your voice matters.</p>
    </div>
</div>

<div class="container" style="margin-top: -2rem;">
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        <!-- Info Sidebar -->
        <div>
            <div style="background: white; border-radius: 15px; padding: 1.5rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                <h3 style="color: #1a2b3c; margin-bottom: 1rem;">
                    <i class="fas fa-info-circle" style="color: #ffc107;"></i> Important Information
                </h3>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 1rem; display: flex; gap: 1rem;">
                        <i class="fas fa-shield-alt" style="color: #28a745;"></i>
                        <span>Your complaint is confidential</span>
                    </li>
                    <li style="margin-bottom: 1rem; display: flex; gap: 1rem;">
                        <i class="fas fa-clock" style="color: #ffc107;"></i>
                        <span>Response time: 3-7 Working days</span>
                    </li>
                    <li style="margin-bottom: 1rem; display: flex; gap: 1rem;">
                        <i class="fas fa-file-alt" style="color: #17a2b8;"></i>
                        <span>Reference number provided for tracking</span>
                    </li>
                </ul>
            </div>
            
            <div style="background: linear-gradient(135deg, #ffc107, #ffed4a); border-radius: 15px; padding: 1.5rem; text-align: center;">
                <i class="fas fa-headset" style="font-size: 3rem; color: #1a2b3c;"></i>
                <h3 style="color: #1a2b3c; margin: 1rem 0;">Need Help?</h3>
                <p>Contact the Computer Science Office</p>
                <p><i class="fas fa-envelope"></i> cs@mkau.edu.et</p>
                <p><i class="fas fa-phone"></i> +251-988-322-475</p>
            </div>
        </div>
        
        <!-- Complaint Form -->
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h2 style="color: #1a2b3c; margin-bottom: 1.5rem;">Complaint Form</h2>
            
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
            
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Complainant Type -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">I am a *</label>
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="radio" name="complainant_type" value="student" required> Student
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="radio" name="complainant_type" value="staff"> Staff/Faculty
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="radio" name="complainant_type" value="other"> Other
                        </label>
                    </div>
                </div>
                
                <div class="student-fields" style="display: none;">
                    <div style="margin-bottom: 1.5rem;">
                        <label>Student ID</label>
                        <input type="text" name="student_id" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label>Year of Study</label>
                        <select name="year" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                            <option value="">Select Year</option>
                            <option value="1">Year 1</option>
                            <option value="2">Year 2</option>
                            <option value="3">Year 3</option>
                            <option value="4">Year 4</option>
                        </select>
                    </div>
                </div>
                
                <div class="staff-fields" style="display: none;">
                    <div style="margin-bottom: 1.5rem;">
                        <label>Staff ID</label>
                        <input type="text" name="staff_id" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Full Name *</label>
                    <input type="text" name="name" required class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Email Address *</label>
                    <input type="email" name="email" required class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Department</label>
                    <input type="text" name="department" class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
                
                <!-- Complaint Category -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Complaint Category *</label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                        @foreach($categories as $key => $cat)
                        <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; border: 2px solid #e9ecef; border-radius: 8px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="category" value="{{ $key }}" required> 
                            <i class="fas {{ $cat['icon'] }}" style="color: {{ $cat['color'] }};"></i>
                            <span>{{ $cat['label'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Sub-category (Optional)</label>
                    <input type="text" name="sub_category" class="form-control" placeholder="e.g., Exam result, Grade dispute, etc." style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Subject / Title *</label>
                    <input type="text" name="subject" required class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Detailed Description *</label>
                    <textarea name="description" rows="6" required class="form-control" style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;"></textarea>
                </div>
                
                <!-- Priority Level -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Priority Level *</label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                        @foreach($priorities as $key => $desc)
                        <label style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; border: 2px solid #e9ecef; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="priority" value="{{ $key }}" required>
                            <span><strong>{{ ucfirst($key) }}</strong><br><small>{{ $desc }}</small></span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="checkbox" name="is_anonymous" value="1">
                        <span>Submit Anonymously (Your personal information will be hidden)</span>
                    </label>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label>Supporting Documents (PDF, DOC, JPG - Max 5MB)</label>
                    <input type="file" name="attachment" accept=".pdf,.doc,.docx,.jpg,.png" style="width: 100%; padding: 0.5rem;">
                </div>
                
                <button type="submit" style="width: 100%; padding: 1rem; background: #ffc107; color: #1a2b3c; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; font-size: 1.1rem;">
                    <i class="fas fa-paper-plane"></i> Submit Complaint
                </button>
            </form>
        </div>
    </div>
    
    <!-- Track Complaint Section -->
    <div style="margin-top: 3rem; text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 15px;">
        <h3 style="color: #1a2b3c;">Already Submitted a Complaint?</h3>
        <p>Track your complaint status using your reference number</p>
        <a href="{{ route('complaints.track') }}" style="display: inline-block; padding: 0.8rem 2rem; background: #1a2b3c; color: white; text-decoration: none; border-radius: 5px;">
            <i class="fas fa-search"></i> Track Complaint
        </a>
    </div>
</div>

<script>
    // Show/hide fields based on complainant type
    document.querySelectorAll('input[name="complainant_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelector('.student-fields').style.display = this.value === 'student' ? 'block' : 'none';
            document.querySelector('.staff-fields').style.display = this.value === 'staff' ? 'block' : 'none';
        });
    });
</script>
@endsection