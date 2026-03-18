@extends('layouts.app')

@section('title', 'Computer Science Staff')

@push('styles')
<style>
    .staff-header {
        background: linear-gradient(135deg, #1a2b3c 0%, #2c3e50 100%);
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .staff-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        padding: 2rem 0;
    }
    
    .staff-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255,193,7,0.1);
    }
    
    .staff-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(255,193,7,0.2);
        border-color: #ffc107;
    }
    
    .staff-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .staff-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(26,43,60,0.7) 0%, rgba(44,62,80,0.7) 100%);
    }
    
    .staff-image-placeholder {
        font-size: 5rem;
        color: #ffc107;
        position: relative;
        z-index: 1;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .staff-info {
        padding: 1.5rem;
        text-align: center;
    }
    
    .staff-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a2b3c;
        margin-bottom: 0.3rem;
    }
    
    .staff-position {
        color: #ffc107;
        font-weight: 600;
        margin-bottom: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #ffc107;
        display: inline-block;
    }
    
    .staff-department {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 1rem;
        background: #f8f9fa;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        display: inline-block;
    }
    
    .staff-qualification {
        font-size: 0.95rem;
        color: #495057;
        background: #f8f9fa;
        padding: 0.8rem;
        border-radius: 8px;
        margin: 1rem 0;
        border-left: 3px solid #ffc107;
        text-align: left;
    }
    
    .staff-qualification i {
        color: #ffc107;
        margin-right: 0.5rem;
    }
    
    .staff-contact {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }
    
    .staff-contact-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .staff-contact-item i {
        color: #ffc107;
        width: 20px;
    }
    
    .add-staff-btn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #ffc107;
        color: #1a2b3c;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 5px 15px rgba(255,193,7,0.3);
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        z-index: 100;
    }
    
    .add-staff-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(255,193,7,0.4);
    }
    
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    
    .modal.active {
        display: flex;
    }
    
    .modal-content {
        background: white;
        border-radius: 15px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 2rem;
        position: relative;
    }
    
    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #1a2b3c;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 0.8rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-family: inherit;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ffc107;
    }
    
    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #ffc107;
        color: #1a2b3c;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255,193,7,0.3);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem;
        background: white;
        border-radius: 15px;
        margin: 2rem 0;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #ffc107;
        margin-bottom: 1rem;
    }
    
    .search-section {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .search-box {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .search-box input {
        flex: 1;
        padding: 0.8rem;
        border: 2px solid #e9ecef;
        border-radius: 50px;
    }
    
    .stats-bar {
        display: flex;
        justify-content: space-around;
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #ffc107;
    }
    
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .admin-badge {
        position: fixed;
        bottom: 100px;
        right: 30px;
        background: #1a2b3c;
        color: white;
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 0.9rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        text-decoration: none;
        transition: all 0.3s ease;
        z-index: 99;
    }
    
    .admin-badge:hover {
        background: #ffc107;
        color: #1a2b3c;
        transform: translateY(-3px);
    }
    
    .admin-badge i {
        margin-right: 5px;
    }
    
    .login-prompt {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #1a2b3c;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        z-index: 100;
        text-decoration: none;
    }
    
    .login-prompt:hover {
        background: #ffc107;
        color: #1a2b3c;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="staff-header">
    <div class="container">
        <h1 data-aos="fade-up">Computer Science Staff</h1>
        <p data-aos="fade-up" data-aos-delay="100">Meet Mekdelab Amba Computer Science dedicated instructors and staff members</p>
    </div>
</div>

<div class="container">
    <!-- Stats Bar -->
    <div class="stats-bar" data-aos="fade-up">
        <div class="stat-item">
            <div class="stat-value">12</div>
            <div class="stat-label">Total Staff</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">10</div>
            <div class="stat-label">Lecturers</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">2</div>
            <div class="stat-label">Technical Staff</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">8</div>
            <div class="stat-label">MSc Holders</div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section" data-aos="fade-up">
        <div class="search-box">
            <i class="fas fa-search" style="color: #ffc107;"></i>
            <input type="text" id="searchInput" placeholder="Search by name, position, or qualification..." onkeyup="filterStaff()">
        </div>
    </div>

    <!-- Staff Grid -->
    <div id="staffGrid" class="staff-grid" data-aos="fade-up">
        <!-- Staff cards will be loaded here via JavaScript -->
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="empty-state" style="display: none;">
        <i class="fas fa-users"></i>
        <h3>No Staff Members Found</h3>
        <p style="color: #6c757d; margin-bottom: 1rem;">Try adjusting your search criteria.</p>
    </div>
</div>

<!-- Admin Controls - Only visible to logged in users -->
@auth
    <!-- Add Staff Button (only for admin) -->
    <button class="add-staff-btn" onclick="openAddStaffModal()" title="Add New Staff Member">
        <i class="fas fa-plus"></i>
    </button>
    
    <!-- Admin Dashboard Link -->
    <a href="{{ route('dashboard') }}" class="admin-badge" title="Go to Dashboard">
        <i class="fas fa-cog"></i> Admin Dashboard
    </a>
@else
    <!-- Login Button (for non-admin users) -->
    <a href="{{ route('login') }}" class="login-prompt" title="Admin Login">
        <i class="fas fa-lock"></i>
    </a>
@endauth

<!-- Add/Edit Staff Modal - Only functional for admin, but we'll keep it in DOM -->
<div id="staffModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">&times;</button>
        <h2 id="modalTitle" style="margin-bottom: 1.5rem; color: #1a2b3c;">Add New Staff Member</h2>
        
        <form id="staffForm" onsubmit="saveStaff(event)">
            <input type="hidden" id="staffId" value="">
            @csrf
            <input type="hidden" id="isAdmin" value="{{ auth()->check() ? 'true' : 'false' }}">
            
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" id="fullName" required placeholder="e.g., Dr. Abrham Belete">
            </div>
            
            <div class="form-group">
                <label>Position *</label>
                <select id="position" required>
                    <option value="">Select Position</option>
                    <option value="Lecturer">Lecturer</option>
                    <option value="Senior Lecturer">Senior Lecturer</option>
                    <option value="Assistant Lecturer">Assistant Lecturer</option>
                    <option value="Senior Technical Assistant">Senior Technical Assistant</option>
                    <option value="Technical Assistant">Technical Assistant</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Qualification *</label>
                <input type="text" id="qualification" required placeholder="e.g., MSc in Computer Science">
            </div>
            
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" id="phone" placeholder="+251-XXX-XXXXXX">
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" id="email" placeholder="name@mau.edu.et">
            </div>
            
            <div class="form-group">
                <label>Specialization</label>
                <input type="text" id="specialization" placeholder="e.g., Artificial Intelligence">
            </div>
            
            <div class="form-group">
                <label>Profile Image URL</label>
                <input type="url" id="image" placeholder="https://example.com/image.jpg">
            </div>
            
            <div class="form-group">
                <label>Biography</label>
                <textarea id="bio" rows="3" placeholder="Brief description..."></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="padding: 0.8rem 2rem; background: #f8f9fa; border: none; border-radius: 8px; cursor: pointer;">Cancel</button>
                <button type="submit" class="btn">Save Staff Member</button>
            </div>
        </form>
    </div>
</div>

<script>
// Staff data array - Computer Science Department Only
let staffMembers = [
    {
        id: '1',
        name: 'Abrham Belete',
        position: 'Lecturer',
        qualification: 'MSc in Computer Science',
        phone: '+251-XXX-XXXXXX',
        email: 'abrham.belete@mau.edu.et',
        specialization: 'Computer Science',
        image: '',
        bio: 'Lecturer in Computer Science with expertise in various computing domains.'
    },
    {
        id: '2',
        name: 'Mebitu Kefale',
        position: 'Lecturer',
        qualification: 'MSc in Computer Science',
        phone: '+251-XXX-XXXXXX',
        email: 'mebitu.kefale@mau.edu.et',
        specialization: 'Computer Science',
        image: '',
        bio: 'Experienced lecturer in Computer Science.'
    },
    {
        id: '3',
        name: 'Melese Alemante',
        position: 'Lecturer',
        qualification: 'MSc in Computer Science',
        phone: '+251-XXX-XXXXXX',
        email: 'melese.alemante@mau.edu.et',
        specialization: 'Computer Science',
        image: '',
        bio: 'Dedicated educator in computer science.'
    },
    {
        id: '4',
        name: 'Leweyehu Yirsaw',
        position: 'Lecturer',
        qualification: 'MSc in Computer Science',
        phone: '+251-XXX-XXXXXX',
        email: 'leweyehu.yirsaw@mau.edu.et',
        specialization: 'Computer Science',
        image: '',
        bio: 'Computer Science lecturer committed to excellence in teaching.'
    },
    {
        id: '5',
        name: 'Agegnehu Teshome',
        position: 'Lecturer',
        qualification: 'MSc in AI and Data Science',
        phone: '+251-XXX-XXXXXX',
        email: 'agegnehu.teshome@mau.edu.et',
        specialization: 'Artificial Intelligence and Data Science',
        image: '',
        bio: 'Specializes in AI and Data Science with focus on machine learning applications.'
    },
    {
        id: '6',
        name: 'Misge Desta',
        position: 'Lecturer',
        qualification: 'MSc in AI and Data Science',
        phone: '+251-XXX-XXXXXX',
        email: 'misge.desta@mau.edu.et',
        specialization: 'Artificial Intelligence and Data Science',
        image: '',
        bio: 'Expert in AI and data science with research interests in deep learning.'
    },
    {
        id: '7',
        name: 'Shimelis Kasa',
        position: 'Lecturer',
        qualification: 'MSc in Computer Science',
        phone: '+251-XXX-XXXXXX',
        email: 'shimelis.kasa@mau.edu.et',
        specialization: 'Computer Science',
        image: '',
        bio: 'Computer Science lecturer with passion for software development.'
    },
    {
        id: '8',
        name: 'Tahayu Gizachew',
        position: 'Lecturer',
        qualification: 'MSc in Computer Engineering',
        phone: '+251-XXX-XXXXXX',
        email: 'tahayu.gizachew@mau.edu.et',
        specialization: 'Computer Engineering',
        image: '',
        bio: 'Lecturer in computer engineering with focus on hardware and embedded systems.'
    },
    {
        id: '9',
        name: 'Fuad Seid',
        position: 'Lecturer',
        qualification: 'MSc in Computer Engineering',
        phone: '+251-XXX-XXXXXX',
        email: 'fuad.seid@mau.edu.et',
        specialization: 'Computer Engineering',
        image: '',
        bio: 'Computer engineering educator specializing in digital systems.'
    },
    {
        id: '10',
        name: 'Ahmed Siraj',
        position: 'Assistant Lecturer',
        qualification: 'BSc in Computer Engineering',
        phone: '+251-XXX-XXXXXX',
        email: 'ahmed.siraj@mau.edu.et',
        specialization: 'Computer Engineering',
        image: '',
        bio: 'Assistant lecturer in computer engineering.'
    },
    {
        id: '11',
        name: 'Temesgen Tiritie',
        position: 'Senior Technical Assistant',
        qualification: 'BSc in Computer Science',
        phone: '+251-XXX-XXXXXX',
        email: 'temesgen.tiritie@mau.edu.et',
        specialization: 'Computer Science',
        image: '',
        bio: 'Senior technical assistant supporting labs and technical operations.'
    },
    {
        id: '12',
        name: 'Endris Yesuf',
        position: 'Senior Technical Assistant',
        qualification: 'BSc in Computer Science',
        phone: '+251-XXX-XXXXXX',
        email: 'endris.yesuf@mau.edu.et',
        specialization: 'Computer Science',
        image: '',
        bio: 'Senior technical assistant providing technical support for the department.'
    }
];

// Check if user is authenticated (from Laravel)
const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

// Load staff from localStorage or use default data
document.addEventListener('DOMContentLoaded', function() {
    loadStaffData();
    renderStaffGrid();
});

function loadStaffData() {
    const stored = localStorage.getItem('csDepartmentStaff');
    if (stored) {
        staffMembers = JSON.parse(stored);
    } else {
        saveToStorage(); // Save default data
    }
}

// Save to localStorage
function saveToStorage() {
    localStorage.setItem('csDepartmentStaff', JSON.stringify(staffMembers));
}

// Render staff grid
function renderStaffGrid(searchTerm = '') {
    const grid = document.getElementById('staffGrid');
    const emptyState = document.getElementById('emptyState');
    
    let filteredStaff = staffMembers;
    
    // Apply search filter
    if (searchTerm) {
        const term = searchTerm.toLowerCase();
        filteredStaff = staffMembers.filter(s => 
            s.name.toLowerCase().includes(term) ||
            s.position.toLowerCase().includes(term) ||
            s.qualification.toLowerCase().includes(term) ||
            (s.specialization && s.specialization.toLowerCase().includes(term))
        );
    }
    
    if (filteredStaff.length === 0) {
        grid.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }
    
    grid.style.display = 'grid';
    emptyState.style.display = 'none';
    
    let html = '';
    filteredStaff.forEach(staff => {
        html += `
            <div class="staff-card">
                <div class="staff-image">
                    ${staff.image ? 
                        `<img src="${staff.image}" alt="${staff.name}" style="width: 100%; height: 100%; object-fit: cover; position: relative; z-index: 1;">` :
                        `<div class="staff-image-placeholder"><i class="fas fa-user-tie"></i></div>`
                    }
                </div>
                <div class="staff-info">
                    <div class="staff-name">${staff.name}</div>
                    <div class="staff-position">${staff.position}</div>
                    <div class="staff-department"><i class="fas fa-building"></i> Computer Science</div>
                    
                    <div class="staff-qualification">
                        <i class="fas fa-graduation-cap"></i>
                        ${staff.qualification}
                        ${staff.specialization ? `<br><small>Specialization: ${staff.specialization}</small>` : ''}
                    </div>
                    
                    <div class="staff-contact">
                        ${staff.phone ? `
                            <div class="staff-contact-item">
                                <i class="fas fa-phone"></i>
                                <span>${staff.phone}</span>
                            </div>
                        ` : ''}
                        ${staff.email ? `
                            <div class="staff-contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>${staff.email}</span>
                            </div>
                        ` : ''}
                    </div>
                    
                    ${isAuthenticated ? `
                        <div style="margin-top: 1rem; display: flex; gap: 0.5rem; justify-content: center;">
                            <button onclick="editStaff('${staff.id}')" style="background: #e9ecef; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button onclick="deleteStaff('${staff.id}')" style="background: #f8d7da; border: none; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; color: #dc3545;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    });
    
    grid.innerHTML = html;
}

// Search staff
function filterStaff() {
    const searchTerm = document.getElementById('searchInput').value;
    renderStaffGrid(searchTerm);
}

// Open add modal (only if authenticated)
function openAddStaffModal() {
    if (!isAuthenticated) {
        alert('Please login as admin to add staff members.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    document.getElementById('modalTitle').textContent = 'Add New Staff Member';
    document.getElementById('staffForm').reset();
    document.getElementById('staffId').value = '';
    document.getElementById('staffModal').classList.add('active');
}

// Edit staff (only if authenticated)
function editStaff(id) {
    if (!isAuthenticated) {
        alert('Please login as admin to edit staff members.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    const staff = staffMembers.find(s => s.id === id);
    if (!staff) return;
    
    document.getElementById('modalTitle').textContent = 'Edit Staff Member';
    document.getElementById('staffId').value = staff.id;
    document.getElementById('fullName').value = staff.name || '';
    document.getElementById('position').value = staff.position || '';
    document.getElementById('qualification').value = staff.qualification || '';
    document.getElementById('phone').value = staff.phone || '';
    document.getElementById('email').value = staff.email || '';
    document.getElementById('specialization').value = staff.specialization || '';
    document.getElementById('image').value = staff.image || '';
    document.getElementById('bio').value = staff.bio || '';
    
    document.getElementById('staffModal').classList.add('active');
}

// Close modal
function closeModal() {
    document.getElementById('staffModal').classList.remove('active');
}

// Save staff (only if authenticated)
function saveStaff(event) {
    event.preventDefault();
    
    if (!isAuthenticated) {
        alert('Please login as admin to save staff members.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    const id = document.getElementById('staffId').value;
    const staffData = {
        id: id || Date.now().toString(),
        name: document.getElementById('fullName').value,
        position: document.getElementById('position').value,
        qualification: document.getElementById('qualification').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        specialization: document.getElementById('specialization').value,
        image: document.getElementById('image').value,
        bio: document.getElementById('bio').value
    };
    
    if (id) {
        // Update existing
        const index = staffMembers.findIndex(s => s.id === id);
        if (index !== -1) {
            staffMembers[index] = staffData;
        }
    } else {
        // Add new
        staffMembers.push(staffData);
    }
    
    saveToStorage();
    renderStaffGrid();
    closeModal();
    alert('Staff member saved successfully!');
}

// Delete staff (only if authenticated)
function deleteStaff(id) {
    if (!isAuthenticated) {
        alert('Please login as admin to delete staff members.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    if (confirm('Are you sure you want to delete this staff member?')) {
        staffMembers = staffMembers.filter(s => s.id !== id);
        saveToStorage();
        renderStaffGrid();
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('staffModal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>
@endsection