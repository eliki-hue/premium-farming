@extends('layouts.app')

@section('title', 'Contact Us - Premium Farming Feeds')

@push('styles')
<style>
    .contact-hero {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        padding: 6rem 0 4rem;
        color: white;
        text-align: center;
    }

    .contact-hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .contact-hero p {
        font-size: 1.3rem;
        opacity: 0.9;
    }

    .contact-section {
        padding: 4rem 0;
        background-color: var(--light-bg);
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }

    .contact-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .contact-card h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: var(--text-dark);
    }

    .contact-info-item {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 2rem;
        align-items: start;
    }

    .contact-icon {
        width: 50px;
        height: 50px;
        background-color: var(--primary-green);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .contact-details h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .contact-details p {
        color: var(--text-muted);
        margin: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
    }

    .form-control {
        width: 100%;
        padding: 0.9rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-green);
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .btn-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(45, 95, 78, 0.3);
    }

    @media (max-width: 992px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }

        .contact-hero h1 {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<section class="contact-hero">
    <div class="container">
        <h1>Get in Touch</h1>
        <p>We're here to help with all your livestock feed needs</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Information -->
            <div class="contact-card">
                <h2>Contact Information</h2>

                <div class="contact-info-item">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Our Location</h3>
                        <p>Nairobi, Kenya</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-icon" style="background-color: var(--accent-orange);">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Phone Number</h3>
                        <p>+254 700 000 000</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-icon" style="background-color: #10b981;">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Email Address</h3>
                        <p>info@premiumfeeds.co.ke</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <div class="contact-icon" style="background-color: #6366f1;">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h3>Business Hours</h3>
                        <p>Monday - Saturday: 8:00 AM - 6:00 PM<br>
                        Sunday: Closed</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-card">
                <h2>Send Us a Message</h2>

                <form method="POST" action="#">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea id="message" name="message" class="form-control" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection