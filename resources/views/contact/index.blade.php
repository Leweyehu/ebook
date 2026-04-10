@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>User Contact Support</h1>
        <p>Get in touch with the Department of Computer Science</p>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; text-align: center;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
        <!-- Contact Information -->
        <div>
            <h2 style="color: #1a2b3c; margin-bottom: 2rem;">Get in Touch</h2>
            
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: #ffc107; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-map-marker-alt" style="color: #1a2b3c; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h3 style="color: #1a2b3c; margin-bottom: 0.3rem;">Address</h3>
                        <p style="color: #6c757d;">Mekedela Amba University<br>Gimba, Ethiopia</p>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: #ffc107; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-phone" style="color: #1a2b3c; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h3 style="color: #1a2b3c; margin-bottom: 0.3rem;">Phone</h3>
                        <p style="color: #6c757d;">+251-988-322-475</p>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background: #ffc107; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-envelope" style="color: #1a2b3c; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h3 style="color: #1a2b3c; margin-bottom: 0.3rem;">Email</h3>
                        <p style="color: #6c757d;">cs@mau.edu.et</p>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div style="background: #ffc107; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="color: #1a2b3c; font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h3 style="color: #1a2b3c; margin-bottom: 0.3rem;">Office Hours</h3>
                        <p style="color: #6c757d;">Monday - Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM - 1:00 PM</p>
                    </div>
                </div>
            </div>

            <!-- Map -->
            <div style="border-radius: 15px; overflow: hidden; height: 250px;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3940.123456789!2d39.123456!3d11.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDA3JzI0LjQiTiAzOcKwMDcnMjYuNCJF!5e0!3m2!1sen!2set!4v1234567890"
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

        <!-- Contact Form -->
        <div style="background: white; border-radius: 15px; padding: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h2 style="color: #1a2b3c; margin-bottom: 2rem;">Please enter the following information so that we may help you.

</h2>
            
            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                
                @if($errors->any())
                    <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                        <ul style="margin-bottom: 0;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-user" style="color: #ffc107; margin-right: 0.5rem;"></i>Full Name *
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-envelope" style="color: #ffc107; margin-right: 0.5rem;"></i>Email Address *
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-heading" style="color: #ffc107; margin-right: 0.5rem;"></i>Subject *
                    </label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required
                           style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a2b3c;">
                        <i class="fas fa-comment" style="color: #ffc107; margin-right: 0.5rem;"></i>Message *
                    </label>
                    <textarea name="message" rows="5" required
                              style="width: 100%; padding: 0.8rem; border: 2px solid #e9ecef; border-radius: 5px;">{{ old('message') }}</textarea>
                </div>

                <button type="submit" 
                        style="width: 100%; padding: 1rem; background: #ffc107; color: #1a2b3c; border: none; border-radius: 5px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
    </div>
</div>
@endsection