@extends('layouts.app')

@section('title', 'About Premium Farming Feeds')

@push('styles')
<style>
    /* Hero Section */
    .about-hero {
        background: linear-gradient(rgba(42, 110, 63, 0.9), rgba(30, 82, 46, 0.9)),
                    url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2070') center/cover;
        padding: 7rem 0 5rem;
        color: white;
        text-align: center;
        position: relative;
    }

    .about-hero h1 {
        font-size: 3.2rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }

    .about-hero p {
        font-size: 1.25rem;
        opacity: 0.95;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.7;
        font-weight: 300;
    }

    /* Section Titles */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e522e;
        margin-bottom: 1rem;
        position: relative;
        text-align: center;
    }

    .section-title:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: #2a6e3f;
        border-radius: 2px;
    }

    .section-subtitle {
        color: #64748b;
        font-size: 1.1rem;
        max-width: 700px;
        margin: 1.5rem auto 3rem;
        text-align: center;
        line-height: 1.6;
    }

    /* Vision & Mission Section */
    .vision-mission-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .vm-card {
        background: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        border-top: 5px solid #2a6e3f;
        position: relative;
        overflow: hidden;
    }

    .vm-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #2a6e3f, #38a169);
    }

    .vm-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    }

    .vm-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2a6e3f, #1e522e);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        color: white;
        font-size: 2.2rem;
        transition: all 0.3s ease;
    }

    .vm-card:hover .vm-icon {
        transform: scale(1.1);
        background: linear-gradient(135deg, #38a169, #2a6e3f);
    }

    .vm-card h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1e522e;
        text-align: center;
    }

    .vm-card p {
        color: #4a5568;
        line-height: 1.8;
        font-size: 1.1rem;
        text-align: center;
    }

    /* Classic Transport & Delivery Section */
    .transport-section {
        padding: 6rem 0;
        background: white;
        position: relative;
    }

    .transport-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .delivery-highlights {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin: 2.5rem 0 3rem;
    }

    .highlight-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.5rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        transition: all 0.3s ease;
        min-width: 180px;
        border: 1px solid #f1f5f9;
    }

    .highlight-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border-color: #2a6e3f;
    }

    .highlight-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #2a6e3f, #38a169);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .highlight-item h4 {
        font-size: 1rem;
        font-weight: 700;
        color: #1e522e;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .highlight-item p {
        color: #64748b;
        font-size: 0.9rem;
        text-align: center;
        margin: 0;
    }

    /* Classic Delivery Options */
    .delivery-options-classic {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .delivery-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        border: 1px solid #f1f5f9;
        position: relative;
        overflow: hidden;
    }

    .delivery-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a6e3f, #38a169);
    }

    .delivery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        border-color: #2a6e3f;
    }

    .delivery-icon-large {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #2a6e3f, #38a169);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .delivery-card:hover .delivery-icon-large {
        transform: rotate(5deg) scale(1.1);
    }

    .delivery-card h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e522e;
        margin-bottom: 1rem;
    }

    .delivery-card p {
        color: #64748b;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        font-size: 1rem;
    }

    .delivery-features-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .delivery-features-list li {
        padding: 0.5rem 0;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .delivery-features-list li i {
        color: #2a6e3f;
        font-size: 1.1rem;
    }

    .delivery-note {
        background: linear-gradient(135deg, rgba(56, 189, 248, 0.1), rgba(56, 161, 105, 0.1));
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 3rem;
        text-align: center;
    }

    .delivery-note h4 {
        color: #0c4a6e;
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .delivery-note p {
        color: #475569;
        margin: 0;
        font-size: 1rem;
    }

    /* Journey Section - Classic Design with UPDATED TRANSPORTATION IMAGE */
    .journey-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        position: relative;
    }

    .journey-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .journey-timeline {
        position: relative;
        max-width: 1000px;
        margin: 0 auto;
    }

    .journey-timeline:before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(to bottom, #2a6e3f, #38a169);
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .journey-item {
        display: flex;
        align-items: center;
        margin-bottom: 4rem;
        position: relative;
    }

    .journey-item:nth-child(odd) {
        flex-direction: row;
    }

    .journey-item:nth-child(even) {
        flex-direction: row-reverse;
    }

    .journey-content {
        flex: 1;
        padding: 2.5rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        position: relative;
        border: 1px solid #f1f5f9;
    }

    .journey-item:nth-child(odd) .journey-content {
        margin-right: 3rem;
    }

    .journey-item:nth-child(even) .journey-content {
        margin-left: 3rem;
    }

    .journey-content:before {
        content: '';
        position: absolute;
        top: 50%;
        width: 20px;
        height: 20px;
        background: white;
        border: 4px solid #2a6e3f;
        border-radius: 50%;
        transform: translateY(-50%);
    }

    .journey-item:nth-child(odd) .journey-content:before {
        right: -40px;
    }

    .journey-item:nth-child(even) .journey-content:before {
        left: -40px;
    }

    .journey-year {
        display: inline-block;
        background: linear-gradient(135deg, #2a6e3f, #38a169);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .journey-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e522e;
        margin-bottom: 1rem;
    }

    .journey-content p {
        color: #4a5568;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        font-size: 1.05rem;
    }

    /* UPDATED: Journey Image Container with Zoomed Out Transportation Image */
    .journey-image {
        flex: 1;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        height: 350px;
        background: #f8fafc;
        position: relative;
    }

    /* Default journey image styling */
    .journey-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    /* UPDATED: Specific styling for transportation image to zoom out */
    .journey-item:nth-child(3) .journey-image img {
        object-fit: contain !important; /* Show entire image without cropping */
        transform: scale(0.85) !important; /* Zoom out by 15% */
        transform-origin: center center;
        background: #f8fafc; /* Background for empty space */
    }

    /* Hover effect for transportation image */
    .journey-item:nth-child(3) .journey-image:hover img {
        transform: scale(0.9) !important; /* Slight zoom on hover */
    }

    /* Hover effect for regular images */
    .journey-image:hover img {
        transform: scale(1.05);
    }

    /* Background for transportation image container */
    .journey-item:nth-child(3) .journey-image {
        background: #f8fafc; /* Ensures background shows around zoomed image */
    }

    .journey-highlights {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .journey-highlight {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.8rem;
        background: rgba(42, 110, 63, 0.05);
        border-radius: 10px;
        color: #2a6e3f;
        font-weight: 500;
    }

    .journey-highlight i {
        font-size: 1.2rem;
    }

    /* Values Section - Classic Design */
    .values-section {
        padding: 6rem 0;
        background: white;
        position: relative;
    }

    .values-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .values-grid-classic {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .value-card-classic {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        transition: all 0.4s ease;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        position: relative;
        overflow: hidden;
    }

    .value-card-classic:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a6e3f, #38a169);
        transform: translateY(-100%);
        transition: transform 0.4s ease;
    }

    .value-card-classic:hover:before {
        transform: translateY(0);
    }

    .value-card-classic:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        border-color: #2a6e3f;
    }

    .value-icon-classic {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2a6e3f, #38a169);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
        transition: all 0.3s ease;
    }

    .value-card-classic:hover .value-icon-classic {
        transform: rotateY(180deg);
        background: linear-gradient(135deg, #38a169, #2a6e3f);
    }

    .value-card-classic h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e522e;
        margin-bottom: 1rem;
    }

    .value-card-classic p {
        color: #64748b;
        line-height: 1.7;
        font-size: 1rem;
    }

    /* Team Section */
    .team-section {
        padding: 6rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        position: relative;
    }

    .team-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 3rem;
        margin-top: 4rem;
    }

    .team-member {
        text-align: center;
        transition: all 0.4s ease;
    }

    .team-member:hover {
        transform: translateY(-10px);
    }

    .team-photo-container {
        width: 220px;
        height: 220px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        overflow: hidden;
        border: 6px solid white;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        position: relative;
        background: #f8fafc;
    }

    .team-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        transition: all 0.6s ease;
    }

    .team-member:hover .team-photo {
        transform: scale(1.1);
    }

    .team-member:hover .team-photo-container {
        border-color: #2a6e3f;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .team-member h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: #1e522e;
        font-weight: 700;
    }

    .team-role {
        color: #2a6e3f;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .team-bio {
        color: #718096;
        font-size: 0.95rem;
        line-height: 1.6;
        max-width: 300px;
        margin: 0 auto;
    }

    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #2a6e3f 0%, #1e522e 100%);
        padding: 6rem 0;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .stats-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 3rem;
        text-align: center;
        position: relative;
    }

    .stat-item {
        padding: 2rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.4s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .stat-item h2 {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        color: #fbbf24;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .stat-item p {
        font-size: 1.2rem;
        opacity: 0.9;
        font-weight: 500;
    }

    /* Branches Section */
    .branches-section {
        padding: 6rem 0;
        background: white;
        position: relative;
    }

    .branches-section:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    }

    .branches-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .branch-card-classic {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        border: 1px solid #f1f5f9;
        position: relative;
        overflow: hidden;
    }

    .branch-card-classic:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2a6e3f, #38a169);
    }

    .branch-card-classic:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        border-color: #2a6e3f;
    }

    .branch-icon-classic {
        font-size: 3rem;
        color: #2a6e3f;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .branch-card-classic:hover .branch-icon-classic {
        transform: scale(1.1);
        color: #38a169;
    }

    .branch-card-classic h3 {
        font-size: 1.5rem;
        color: #1e522e;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .branch-card-classic p {
        color: #718096;
        line-height: 1.7;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .branch-details {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f1f5f9;
    }

    /* Footer Section - Classic */
    .about-footer {
        background: linear-gradient(135deg, #1a472a 0%, #0f2f1c 100%);
        color: white;
        padding: 5rem 0 2rem;
        margin-top: 4rem;
        position: relative;
        overflow: hidden;
    }

    .about-footer:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    }

    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 3rem;
        margin-bottom: 3rem;
        position: relative;
    }

    .footer-column h3 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #f0fdf4;
        position: relative;
        padding-bottom: 0.8rem;
    }

    .footer-column h3:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: #38a169;
        border-radius: 2px;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.8rem;
    }

    .footer-links a {
        color: #cbd5e0;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        font-size: 1rem;
    }

    .footer-links a:hover {
        color: #38a169;
        transform: translateX(8px);
    }

    .contact-info {
        color: #cbd5e0;
        font-size: 1rem;
    }

    .contact-info p {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .social-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .social-icon:hover {
        background: #38a169;
        transform: translateY(-5px) scale(1.1);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 2.5rem;
        text-align: center;
        color: #a0aec0;
        font-size: 0.95rem;
        position: relative;
    }

    .footer-cta {
        background: rgba(56, 161, 105, 0.15);
        border: 2px solid #38a169;
        border-radius: 15px;
        padding: 2.5rem;
        margin-bottom: 3rem;
        text-align: center;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .footer-cta:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at top right, rgba(56, 161, 105, 0.2), transparent 70%);
    }

    .footer-cta h4 {
        color: #38a169;
        margin-bottom: 1.2rem;
        font-size: 1.4rem;
        font-weight: 700;
        position: relative;
    }

    .footer-cta .btn {
        background: linear-gradient(135deg, #38a169, #2a6e3f);
        color: white;
        padding: 1rem 2.5rem;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        font-size: 1.1rem;
        position: relative;
        overflow: hidden;
    }

    .footer-cta .btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .footer-cta .btn:hover:before {
        left: 100%;
    }

    .footer-cta .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(56, 161, 105, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .journey-timeline:before {
            left: 40px;
        }
        
        .journey-item {
            flex-direction: column !important;
            margin-left: 60px;
        }
        
        .journey-item:nth-child(odd) .journey-content,
        .journey-item:nth-child(even) .journey-content {
            margin: 0 0 2rem 0;
        }
        
        .journey-item:nth-child(odd) .journey-content:before,
        .journey-item:nth-child(even) .journey-content:before {
            left: -40px;
            right: auto;
        }
        
        .journey-image {
            width: 100%;
        }
        
        /* Responsive adjustment for transportation image */
        .journey-item:nth-child(3) .journey-image img {
            transform: scale(0.9) !important; /* Less zoom on tablet */
        }
    }

    @media (max-width: 992px) {
        .about-hero h1 {
            font-size: 2.8rem;
        }
        
        .section-title {
            font-size: 2.2rem;
        }
        
        .journey-content h3 {
            font-size: 1.6rem;
        }
        
        .delivery-options-classic {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .highlight-item {
            min-width: 160px;
            padding: 1.2rem;
        }
        
        /* Tablet adjustment for transportation image */
        .journey-item:nth-child(3) .journey-image img {
            transform: scale(0.95) !important;
        }
    }

    @media (max-width: 768px) {
        .about-hero {
            padding: 6rem 0 4rem;
        }
        
        .vm-card, .delivery-card, .value-card-classic, .branch-card-classic {
            padding: 2rem;
        }
        
        .journey-image {
            height: 250px;
        }
        
        .stat-item h2 {
            font-size: 2.8rem;
        }
        
        .team-photo-container {
            width: 180px;
            height: 180px;
        }
        
        .delivery-highlights {
            gap: 1rem;
        }
        
        .highlight-item {
            min-width: 140px;
            padding: 1rem;
        }
        
        /* Mobile adjustment for transportation image */
        .journey-item:nth-child(3) .journey-image img {
            transform: scale(1) !important; /* No zoom on mobile */
            object-fit: cover !important; /* Switch to cover on small screens */
        }
    }

    @media (max-width: 576px) {
        .about-hero h1 {
            font-size: 2.3rem;
        }
        
        .section-title {
            font-size: 1.8rem;
        }
        
        .journey-content h3 {
            font-size: 1.4rem;
        }
        
        .journey-timeline:before {
            left: 20px;
        }
        
        .journey-item {
            margin-left: 40px;
        }
        
        .journey-item:nth-child(odd) .journey-content:before,
        .journey-item:nth-child(even) .journey-content:before {
            left: -30px;
        }
        
        .delivery-highlights {
            flex-direction: column;
            align-items: center;
        }
        
        .highlight-item {
            width: 100%;
            max-width: 300px;
        }
        
        .journey-image {
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <h1>Premium Farming Feeds</h1>
        <p>
            Since 2020, we've been dedicated to transforming livestock farming in Kenya through 
            scientifically formulated, high-quality animal feeds. Our commitment to excellence, 
            farmer education, and sustainable agriculture has established us as a trusted partner 
            for thousands of farmers across the region.
        </p>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="vision-mission-section">
    <div class="container">
        <h2 class="section-title">Our Vision & Mission</h2>
        <p class="section-subtitle">Guided by purpose, driven by passion for agricultural excellence</p>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        Ensuring access to affordable and consistent high quality agricultural solution.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>
                        To be the leading company in the agricultural sector by providing sustainabe, high quality and cost-effective solutions.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Classic Transport & Delivery Section -->
<section class="transport-section">
    <div class="container">
        <h2 class="section-title">Our Delivery Services</h2>
        <p class="section-subtitle">
            Reliable, efficient delivery solutions designed to support your farming operations
        </p>
        
        <!-- Delivery Highlights -->
        <div class="delivery-highlights">
            <div class="highlight-item">
                <div class="highlight-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <h4>Farm Delivery</h4>
                <p>Direct to your farm gate</p>
            </div>
            
            <div class="highlight-item">
                <div class="highlight-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <h4>Flexible Hours</h4>
                <p>Mon-Sat, 8AM-6PM</p>
            </div>
            
            <div class="highlight-item">
                <div class="highlight-icon">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <h4>Wide Coverage</h4>
                <p>Kiambu & surrounding areas</p>
            </div>
            
            <div class="highlight-item">
                <div class="highlight-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4>Tracked Delivery</h4>
                <p>Real-time updates</p>
            </div>
            
            <div class="highlight-item">
                <div class="highlight-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h4>Bulk Orders</h4>
                <p>Special rates available</p>
            </div>
        </div>
        
        <!-- Delivery Options -->
        <div class="delivery-options-classic">
            <div class="delivery-card">
                <div class="delivery-icon-large">
                    <i class="bi bi-truck"></i>
                </div>
                <h3>Farm Delivery Service</h3>
                <p>
                    Our specialized delivery trucks bring quality feeds directly to your farm. 
                    With GPS tracking and professional drivers, we ensure timely, safe delivery 
                    of your orders in perfect condition.
                </p>
                <ul class="delivery-features-list">
                    <li><i class="bi bi-check-circle-fill"></i> Free delivery within 20km radius</li>
                    <li><i class="bi bi-check-circle-fill"></i> Monday to Saturday, 8AM-6PM</li>
                    <li><i class="bi bi-check-circle-fill"></i> Real-time delivery tracking</li>
                    <li><i class="bi bi-check-circle-fill"></i> Professional handling & unloading</li>
                    <li><i class="bi bi-check-circle-fill"></i> Flexible scheduling options</li>
                </ul>
            </div>
            
            <div class="delivery-card">
                <div class="delivery-icon-large">
                    <i class="bi bi-shop"></i>
                </div>
                <h3>Branch Pickup Service</h3>
                <p>
                    Conveniently collect your feeds from any of our three strategically located 
                    branches. Enjoy ample parking, loading assistance, and expert advice from 
                    our trained staff.
                </p>
                <ul class="delivery-features-list">
                    <li><i class="bi bi-check-circle-fill"></i> Three convenient locations</li>
                    <li><i class="bi bi-check-circle-fill"></i> Same hours as delivery service</li>
                    <li><i class="bi bi-check-circle-fill"></i> Free parking facilities</li>
                    <li><i class="bi bi-check-circle-fill"></i> Loading assistance available</li>
                    <li><i class="bi bi-check-circle-fill"></i> Technical advice on-site</li>
                </ul>
            </div>
            
            <div class="delivery-card">
                <div class="delivery-icon-large">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h3>Bulk Order Solutions</h3>
                <p>
                    Tailored solutions for large-scale farmers, cooperatives, and institutions. 
                    Benefit from volume discounts, customized delivery schedules, and dedicated 
                    account management.
                </p>
                <ul class="delivery-features-list">
                    <li><i class="bi bi-check-circle-fill"></i> Significant volume discounts</li>
                    <li><i class="bi bi-check-circle-fill"></i> Customized delivery scheduling</li>
                    <li><i class="bi bi-check-circle-fill"></i> Flexible payment terms</li>
                    <li><i class="bi bi-check-circle-fill"></i> Dedicated account manager</li>
                    <li><i class="bi bi-check-circle-fill"></i> Priority service & support</li>
                </ul>
            </div>
        </div>
        
        <!-- Delivery Note -->
        <div class="delivery-note">
            <h4><i class="bi bi-info-circle me-2"></i> Important Delivery Information</h4>
            <p class="mb-0">
                <strong>Delivery Hours:</strong> Monday to Saturday, 8:00 AM - 6:00 PM • 
                <strong>Order Cut-off:</strong> Orders placed after 3:00 PM are delivered the next business day • 
                <strong>Free Delivery:</strong> Available within 20km radius of our branches
            </p>
        </div>
    </div>
</section>

<!-- Journey Section - Classic Timeline with UPDATED TRANSPORTATION IMAGE -->
<section class="journey-section">
    <div class="container">
        <h2 class="section-title">Our Journey</h2>
        <p class="section-subtitle">A story of growth, innovation, and commitment to farming excellence</p>
        
        <div class="journey-timeline">
            <!-- Beginning -->
            <div class="journey-item">
                <div class="journey-content">
                    <span class="journey-year">2020</span>
                    <h3>Humble Beginnings</h3>
                    <p>
                        Founded in Turitu, Kiambu County by Paul Mbua, a visionary with two decades 
                        of livestock nutrition experience. Started with a single delivery truck, 
                        modest warehouse, and an unwavering commitment to quality.
                    </p>
                    <div class="journey-highlights">
                        <div class="journey-highlight">
                            <i class="bi bi-truck"></i>
                            <span>Single delivery truck</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-building"></i>
                            <span>Small warehouse operation</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-people"></i>
                            <span>Local farmer focus</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-award"></i>
                            <span>Quality-first approach</span>
                        </div>
                    </div>
                </div>
                <div class="journey-image">
                    <img src="{{ asset('images/counter3.jpeg') }}" alt="Our Beginning" 
                         onerror="this.src='https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=800'">
                </div>
            </div>
            
            <!-- Growth -->
            <div class="journey-item">
                <div class="journey-content">
                    <span class="journey-year">2021-2023</span>
                    <h3>Strategic Expansion</h3>
                    <p>
                        Rapid growth driven by farmer trust and product excellence. Expanded to three 
                        branches across Kiambu County, modernized our fleet, and established robust 
                        distribution networks serving thousands of farmers.
                    </p>
                    <div class="journey-highlights">
                        <div class="journey-highlight">
                            <i class="bi bi-shop"></i>
                            <span>3 branch expansion</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-truck"></i>
                            <span>Modernized fleet</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-graph-up"></i>
                            <span>Market leadership</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-people"></i>
                            <span>10,000+ farmers served</span>
                        </div>
                    </div>
                </div>
                <div class="journey-image">
                    <img src="{{ asset('images/counter4.jpeg') }}" alt="Growth & Expansion" 
                         onerror="this.src='https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=800'">
                </div>
            </div>
            
            <!-- Transportation Excellence - UPDATED WITH ZOOMED OUT IMAGE -->
            <div class="journey-item">
                <div class="journey-content">
                    <span class="journey-year">2024</span>
                    <h3>Transportation Excellence</h3>
                    <p>
                        Investing in state-of-the-art logistics to ensure reliable feed delivery. 
                        Our modern fleet, trained drivers, and optimized routes guarantee timely 
                        delivery while maintaining product integrity.
                    </p>
                    <div class="journey-highlights">
                        <div class="journey-highlight">
                            <i class="bi bi-truck"></i>
                            <span>Modern delivery fleet</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-geo-alt"></i>
                            <span>GPS tracking system</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-clock"></i>
                            <span>Optimized delivery routes</span>
                        </div>
                        <div class="journey-highlight">
                            <i class="bi bi-shield-check"></i>
                            <span>Trained professional drivers</span>
                        </div>
                    </div>
                </div>
                <div class="journey-image">
                    <img src="{{ asset('images/trsnp2.jpeg') }}" alt="Transportation Fleet" 
                         style="width: 100%; height: 100%; object-fit: contain; background: #f8fafc;"
                         onerror="this.src='https://images.unsplash.com/photo-1560472354-b33ff0c44a43?q=80&w=1200'">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section - Classic Design -->
<section class="values-section">
    <div class="container">
        <h2 class="section-title">Our Core Values</h2>
        <p class="section-subtitle">The fundamental principles that define our company culture and business practices</p>
        
        <div class="values-grid-classic">
            <div class="value-card-classic">
                <div class="value-icon-classic">
                    <i class="bi bi-award-fill"></i>
                </div>
                <h3>Excellence</h3>
                <p>
                    We never compromise on quality. Every product undergoes rigorous testing and 
                    quality control measures to ensure it meets the highest nutritional standards 
                    for optimal livestock health and productivity.
                </p>
            </div>
            
            <div class="value-card-classic">
                <div class="value-icon-classic">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3>Farmer Success</h3>
                <p>
                    Your success is our success. We provide comprehensive technical support, 
                    educational resources, and personalized advice to help you maximize your 
                    farm's potential and achieve sustainable growth.
                </p>
            </div>
            
            <div class="value-card-classic">
                <div class="value-icon-classic">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h3>Integrity</h3>
                <p>
                    We conduct all business with transparency, honesty, and ethical practices. 
                    What we promise is what we deliver, building trust through consistent 
                    reliability and open communication.
                </p>
            </div>
            
            <div class="value-card-classic">
                <div class="value-icon-classic">
                    <i class="bi bi-truck"></i>
                </div>
                <h3>Reliability</h3>
                <p>
                    Consistent product quality and dependable delivery services you can count on. 
                    Our commitment to punctuality and service excellence ensures your farming 
                    operations run smoothly and efficiently.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Branches Section - Classic Design -->
{{-- <section class="branches-section">
    <div class="container">
        <h2 class="section-title">Our Branches</h2>
        <p class="section-subtitle">Conveniently located branches serving farmers across Kiambu County</p>
        
        <div class="branches-grid">
            <div class="branch-card-classic">
                <div class="branch-icon-classic">
                    <i class="bi bi-shop"></i>
                </div>
                <h3>Turitu Branch</h3>
                <p class="text-muted mb-3">Headquarters & Main Operations Center</p>
                <p>Along Thika-Gatundu Road, strategically located to serve the central farming region.</p>
                <div class="branch-details">
                    <p><i class="bi bi-geo-alt me-2"></i> <strong>Location:</strong> Thika-Gatundu Road</p>
                    <p><i class="bi bi-clock me-2"></i> <strong>Hours:</strong> Mon-Sat, 8AM-6PM</p>
                    <p><i class="bi bi-telephone me-2"></i> <strong>Contact:</strong> +254 700 000000</p>
                </div>
            </div>
            
            <div class="branch-card-classic">
                <div class="branch-icon-classic">
                    <i class="bi bi-building"></i>
                </div>
                <h3>Githiga Branch</h3>
                <p class="text-muted mb-3">Processing Plant & Distribution Hub</p>
                <p>Located at Githiga Shopping Center, featuring modern processing facilities.</p>
                <div class="branch-details">
                    <p><i class="bi bi-geo-alt me-2"></i> <strong>Location:</strong> Githiga Shopping Center</p>
                    <p><i class="bi bi-clock me-2"></i> <strong>Hours:</strong> Mon-Sat, 8AM-6PM</p>
                    <p><i class="bi bi-telephone me-2"></i> <strong>Contact:</strong> +254 700 000001</p>
                </div>
            </div>
            
            <div class="branch-card-classic">
                <div class="branch-icon-classic">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <h3>Ikinu Branch</h3>
                <p class="text-muted mb-3">Latest Expansion & Customer Service Center</p>
                <p>At Ikinu Town Center, designed for easy access and comprehensive customer support.</p>
                <div class="branch-details">
                    <p><i class="bi bi-geo-alt me-2"></i> <strong>Location:</strong> Ikinu Town Center</p>
                    <p><i class="bi bi-clock me-2"></i> <strong>Hours:</strong> Mon-Sat, 8AM-6PM</p>
                    <p><i class="bi bi-telephone me-2"></i> <strong>Contact:</strong> +254 700 000002</p>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info mt-5 text-center">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-2"><i class="bi bi-clock me-2"></i> <strong>All Branches Open:</strong> Monday to Saturday, 8:00 AM - 6:00 PM</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-0"><i class="bi bi-info-circle me-2"></i> <strong>Closed:</strong> Sundays and Public Holidays</p>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Team Section -->
<section class="team-section">
    <div class="container">
        <h2 class="section-title">Our Leadership Team</h2>
        <p class="section-subtitle">Experienced professionals dedicated to advancing livestock nutrition and farming excellence</p>
        
        <div class="team-grid">
            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/boss.jpeg') }}" alt="Paul Mbua" class="team-photo">
                </div>
                <h3>Paul Mbua</h3>
                <p class="team-role">Founder & Chief Executive Officer</p>
                <p class="team-bio">
                    20+ years in livestock nutrition and agricultural development. 
                    Leads research initiatives and strategic direction for the company.
                </p>
            </div>

            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/md boss.jpeg') }}" alt="Joyce Mbua" class="team-photo">
                </div>
                <h3>Joyce Mbua</h3>
                <p class="team-role">Operations Director</p>
                <p class="team-bio">
                    Oversees daily operations across all branches, ensuring quality standards 
                    and efficient service delivery to our valued customers.
                </p>
            </div>

            <div class="team-member">
                <div class="team-photo-container">
                    <img src="{{ asset('images/manager.jpeg') }}" alt="Naomi" class="team-photo">
                </div>
                <h3>Naomi</h3>
                <p class="team-role">Branch Manager - Turitu</p>
                <p class="team-bio">
                    Manages daily operations and customer relations at our flagship Turitu branch, 
                    ensuring exceptional service and customer satisfaction.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="row g-4">
                @foreach([
                    ['number' => '4.8/5', 'label' => 'Average Rating', 'icon' => 'star-fill', 'color' => 'gold-green'],
                    ['number' => '500+', 'label' => 'Satisfied Farmers', 'icon' => 'people-fill', 'color' => 'primary-green'],
                    ['number' => '5+', 'label' => 'Years Experience', 'icon' => 'award-fill', 'color' => 'secondary-green'],
                    ['number' => '98%', 'label' => 'Recommend Us', 'icon' => 'hand-thumbs-up-fill', 'color' => 'accent-green'],
                    ['number' => '50+', 'label' => 'Quality Products', 'icon' => 'basket2-fill', 'color' => 'light-green'],
                    ['number' => '24/7', 'label' => 'Support', 'icon' => 'headset', 'color' => 'dark-green'],
                ] as $stat)
                <div class="col-md-4 col-lg-2">
                    <div class="stat-card animate-on-scroll">
                        <div class="mb-3">
                            <i class="bi bi-{{ $stat['icon'] }} fs-2" style="color: var(--{{ $stat['color'] }});"></i>
                        </div>
                        <div class="stat-number">{{ $stat['number'] }}</div>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
    </div>
</section>

<!-- About Page Footer -->
{{-- <footer class="about-footer">
    <div class="container">
        <div class="footer-cta">
            <h4>Ready to Transform Your Livestock Farming?</h4>
            <p class="mb-3">Experience the Premium Farming Feeds difference today.</p>
            <a href="{{ route('contact') }}" class="btn">
                <i class="bi bi-chat-dots me-2"></i> Contact Us for Quality Feeds
            </a>
        </div>

        <div class="footer-content">
            <div class="footer-column">
                <h3>Premium Farming Feeds</h3>
                <p style="color: #cbd5e0; line-height: 1.6;">
                    Your trusted partner for premium animal nutrition since 2020. 
                    We combine scientific research with practical farming knowledge 
                    to deliver feeds that optimize livestock health and productivity.
                </p>
                <div class="social-links">
                    <a href="#" class="social-icon">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bi bi-envelope"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bi bi-telephone"></i>
                    </a>
                </div>
            </div>

            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Home</a></li>
                    <li><a href="{{ route('about') }}"><i class="bi bi-info-circle"></i> About Us</a></li>
                    <li><a href="{{ route('products') }}"><i class="bi bi-box"></i> Our Products</a></li>
                    <li><a href="{{ route('contact') }}"><i class="bi bi-chat-dots"></i> Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Contact Information</h3>
                <div class="contact-info">
                    <p><i class="bi bi-geo-alt"></i> Turitu, Kiambu County, Kenya</p>
                    <p><i class="bi bi-telephone"></i> +254 700 000000 (Office)</p>
                    <p><i class="bi bi-whatsapp"></i> +254 700 000000 (WhatsApp)</p>
                    <p><i class="bi bi-envelope"></i> info@premiumfarmingfeeds.co.ke</p>
                    <p><i class="bi bi-clock"></i> Monday to Saturday, 8:00 AM - 6:00 PM</p>
                </div>
            </div>

            <div class="footer-column">
                <h3>Our Services</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="bi bi-check-circle"></i> Premium Animal Feeds</a></li>
                    <li><a href="#"><i class="bi bi-check-circle"></i> Farm Delivery Service</a></li>
                    <li><a href="#"><i class="bi bi-check-circle"></i> Technical Consultation</a></li>
                    <li><a href="#"><i class="bi bi-check-circle"></i> Farmer Training Programs</a></li>
                    <li><a href="#"><i class="bi bi-check-circle"></i> Bulk Order Solutions</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Premium Farming Feeds Ltd. All rights reserved.</p>
            <p class="small mt-2">Transforming livestock farming through scientific nutrition, farmer education, and sustainable agricultural practices.</p>
        </div>
    </div>
</footer> --}}
@endsection