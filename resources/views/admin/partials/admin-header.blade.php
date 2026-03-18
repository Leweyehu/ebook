<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 15px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 2rem;">
            <!-- Dashboard Icon and Text -->
            <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: white;">
                <i class="fas fa-tachometer-alt" style="font-size: 2rem; color: #ffc107;"></i>
                <span style="font-size: 1.5rem; font-weight: 600;">dashboard</span>
            </a>
            
            <!-- ADMIN Badge -->
            <div style="background: #ffc107; color: #1a2b3c; padding: 0.3rem 1rem; border-radius: 50px; font-weight: 700; font-size: 1rem; letter-spacing: 1px;">
                ADMIN
            </div>
        </div>
        
        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 50px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; font-size: 1rem; transition: all 0.3s ease;">
                <i class="fas fa-sign-out-alt"></i>
                <span>logout</span>
            </button>
        </form>
    </div>
    
    <!-- Welcome Message -->
    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2);">
        <p style="font-size: 1rem; opacity: 0.9;">Welcome, <strong>{{ Auth::user()->name }}</strong>! ({{ ucfirst(Auth::user()->role) }})</p>
    </div>
</div>