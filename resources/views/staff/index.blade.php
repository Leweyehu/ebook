@extends('layouts.app')

@section('title', 'Our Staff')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Our Staff</h1>
        <p>Meet Mekdela Amba University Computer Science department dedicated instructors and staff members</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Academic Staff -->
    @if($academicStaff->count() > 0)
    <div style="margin-bottom: 4rem;">
        <h2 style="color: #1a2b3c; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 3px solid #ffc107;">
            <i class="fas fa-chalkboard-teacher"></i> Academic Staff
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
            @foreach($academicStaff as $member)
            <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s;">
                <div style="height: 250px; overflow: hidden; background: #f8f9fa;">
                    @if($member->profile_image)
                        <img src="{{ asset($member->profile_image) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a2b3c, #2c3e50);">
                            <i class="fas fa-user-tie" style="font-size: 5rem; color: #ffc107;"></i>
                        </div>
                    @endif
                </div>
                
                <div style="padding: 1.5rem;">
                    <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">{{ $member->name }}</h3>
                    <p style="color: #ffc107; font-weight: 600; margin-bottom: 0.5rem;">{{ $member->position }}</p>
                    <p style="color: #6c757d; font-size: 0.9rem; margin-bottom: 1rem;">{{ $member->qualification }}</p>
                    
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
                        @if($member->email)
                        <p style="margin-bottom: 0.3rem;"><i class="fas fa-envelope" style="color: #ffc107; width: 20px;"></i> {{ $member->email }}</p>
                        @endif
                        @if($member->phone)
                        <p><i class="fas fa-phone" style="color: #ffc107; width: 20px;"></i> {{ $member->phone }}</p>
                        @endif
                    </div>
                    
                    @if($member->bio)
                    <button onclick="showBio('{{ $member->name }}', '{{ $member->bio }}')" style="margin-top: 1rem; background: none; border: 1px solid #ffc107; color: #1a2b3c; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; width: 100%;">
                        View Bio <i class="fas fa-chevron-down"></i>
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Administrative Staff -->
    @if($administrativeStaff->count() > 0)
    <div style="margin-bottom: 4rem;">
        <h2 style="color: #1a2b3c; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 3px solid #ffc107;">
            <i class="fas fa-users-cog"></i> Administrative Staff
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
            @foreach($administrativeStaff as $member)
            <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <div style="height: 200px; overflow: hidden; background: #f8f9fa;">
                    @if($member->profile_image)
                        <img src="{{ asset($member->profile_image) }}" alt="{{ $member->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1a2b3c, #2c3e50);">
                            <i class="fas fa-user-tie" style="font-size: 4rem; color: #ffc107;"></i>
                        </div>
                    @endif
                </div>
                
                <div style="padding: 1.5rem;">
                    <h3 style="color: #1a2b3c; margin-bottom: 0.5rem;">{{ $member->name }}</h3>
                    <p style="color: #ffc107; font-weight: 600; margin-bottom: 0.5rem;">{{ $member->position }}</p>
                    <div style="margin-top: 1rem;">
                        <p><i class="fas fa-envelope" style="color: #ffc107; width: 20px;"></i> {{ $member->email }}</p>
                        @if($member->phone)
                        <p><i class="fas fa-phone" style="color: #ffc107; width: 20px;"></i> {{ $member->phone }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Bio Modal -->
<div id="bioModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center;">
    <div style="background: white; max-width: 500px; width: 90%; border-radius: 15px; padding: 2rem; max-height: 80vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 id="modalName" style="color: #1a2b3c;"></h3>
            <button onclick="closeBio()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <p id="modalBio" style="color: #6c757d; line-height: 1.8;"></p>
    </div>
</div>

<script>
function showBio(name, bio) {
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalBio').textContent = bio;
    document.getElementById('bioModal').style.display = 'flex';
}

function closeBio() {
    document.getElementById('bioModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('bioModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBio();
    }
});
</script>
@endsection