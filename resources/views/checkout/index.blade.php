{{-- checkout.index --}}
@extends('layouts.app')

@section('title', 'Checkout | Premium Farming Feeds')

@push('styles')
<style>
    .checkout-container {
        background-color: #f8faf7;
        min-height: calc(100vh - 120px);
        padding: 2rem 0;
    }
    
    /* Progress Steps */
    .checkout-progress {
        margin-bottom: 2rem;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .step.active .step-number {
        background: var(--gradient-green);
        color: white;
        box-shadow: 0 4px 15px rgba(56, 161, 105, 0.3);
    }
    
    .step.completed .step-number {
        background: #28a745;
        color: white;
    }
    
    .step-line {
        position: absolute;
        top: 20px;
        left: 50%;
        right: -50%;
        height: 2px;
        background: #e9ecef;
        z-index: -1;
    }
    
    .step.completed .step-line {
        background: #28a745;
    }
    
    .step-label {
        font-size: 0.85rem;
        font-weight: 500;
        color: #6c757d;
        text-align: center;
    }
    
    .step.active .step-label {
        color: var(--navy-green);
        font-weight: 600;
    }
    
    /* Checkout Cards */
    .checkout-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(42, 110, 63, 0.1);
        border: 1px solid rgba(42, 110, 63, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .checkout-card-header {
        background: linear-gradient(135deg, rgba(56, 161, 105, 0.1), rgba(42, 110, 63, 0.05));
        border-bottom: 1px solid rgba(42, 110, 63, 0.1);
        padding: 1.5rem;
        border-radius: 10px 10px 0 0;
    }
    
    .checkout-card-body {
        padding: 1.5rem;
    }
    
    /* Delivery Options */
    .delivery-option-card {
        border: 2px solid rgba(42, 110, 63, 0.1);
        border-radius: 8px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
        height: 100%;
    }
    
    .delivery-option-card:hover {
        border-color: var(--primary-green);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(42, 110, 63, 0.1);
    }
    
    .delivery-option-card.selected {
        border-color: var(--primary-green);
        background-color: rgba(56, 161, 105, 0.05);
    }
    
    .delivery-badge {
        background: var(--gradient-green);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    
    /* Payment Methods */
    .payment-method-card {
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 100%;
        text-align: center;
    }
    
    .payment-method-card:hover {
        border-color: var(--primary-green);
        transform: translateY(-2px);
    }
    
    .payment-method-card.selected {
        border-color: var(--primary-green);
        background-color: rgba(56, 161, 105, 0.05);
    }
    
    .payment-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .payment-method-card.selected .payment-icon {
        color: var(--primary-green);
    }
    
    /* Summary */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .summary-row.total {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--navy-green);
        border-bottom: none;
        border-top: 2px solid rgba(42, 110, 63, 0.2);
        margin-top: 0.5rem;
        padding-top: 1rem;
    }
    
    /* Buttons */
    .btn-checkout {
        background: var(--gradient-green);
        color: white;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        width: 100%;
        border: none;
    }
    
    .btn-checkout:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(42, 110, 63, 0.3);
    }
    
    .btn-checkout:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .btn-secondary {
        background: #6c757d;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
    }
    
    /* Form Elements */
    .form-label {
        font-weight: 600;
        color: var(--navy-green);
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 1px solid rgba(42, 110, 63, 0.2);
        border-radius: 6px;
        padding: 0.75rem;
        cursor: pointer;
        background-color: white;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(56, 161, 105, 0.25);
    }
    
    .distance-input-wrapper {
        position: relative;
    }
    
    .distance-unit {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        font-size: 0.9rem;
    }
    
    /* Weight Badge */
    .weight-badge {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Terms & Conditions */
    .terms-check {
        padding: 1rem;
        background: rgba(42, 110, 63, 0.05);
        border-radius: 8px;
        margin-top: 1.5rem;
    }
    
    /* Sticky Summary */
    .sticky-summary {
        position: sticky;
        top: 100px;
    }
    
    /* Cart Items */
    .cart-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .cart-item:last-child {
        border-bottom: none;
    }
    
    .cart-item-name {
        font-weight: 500;
    }
    
    .cart-item-details {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    /* Zone Info Styling */
    .zone-info {
        background-color: rgba(13, 110, 253, 0.1);
        padding: 0.5rem;
        border-radius: 6px;
        border-left: 3px solid var(--primary-green);
        margin-top: 0.5rem;
    }
    
    .zone-info.text-success {
        background-color: rgba(25, 135, 84, 0.1);
        border-left-color: #198754;
    }
    
    /* Quick Zone Buttons */
    .quick-zone-btn {
        transition: all 0.3s ease;
        border: 1px solid var(--primary-green);
        color: var(--navy-green);
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .quick-zone-btn:hover {
        background-color: var(--primary-green);
        color: white;
        transform: translateY(-2px);
    }
    
    /* Zone Info Card */
    .zone-info-card {
        background: linear-gradient(135deg, rgba(56, 161, 105, 0.05), rgba(42, 110, 63, 0.03));
        border: 1px solid rgba(56, 161, 105, 0.2);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .zone-info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .zone-info-item:last-child {
        margin-bottom: 0;
    }
    
    /* Quick distance buttons */
    .quick-distance-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    .quick-distance-btn:hover {
        background-color: #e9ecef;
    }
    
    /* Custom Select Fix */
    select.form-select {
        -webkit-appearance: menulist;
        -moz-appearance: menulist;
        appearance: menulist;
        height: auto;
    }
    
    /* Zone Groups */
    .zone-group-header {
        font-weight: bold;
        color: var(--navy-green);
        background-color: #f8f9fa;
    }
    
    .zone-group-divider {
        border-top: 1px solid #dee2e6;
        margin: 5px 0;
    }
    
    /* Working Select Styling */
    .delivery-zone-select {
        position: relative;
        z-index: 1000;
    }
    
    .delivery-zone-select select {
        position: relative;
        z-index: 1001;
    }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="container">
        <!-- Checkout Progress -->
        <div class="checkout-progress">
            <div class="row">
                <div class="col">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <span class="step-label">Cart</span>
                        <div class="step-line"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="step active">
                        <div class="step-number">2</div>
                        <span class="step-label">Delivery</span>
                        <div class="step-line"></div>
                    </div>
                </div>
                <div class="col">
                    <div class="step">
                        <div class="step-number">3</div>
                        <span class="step-label">Payment</span>
                        <div class="step-line"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Delivery & Payment -->
            <div class="col-lg-8">
                <!-- Delivery Information -->
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <h4 class="mb-0" style="color: var(--navy-green); font-family: 'Cormorant Garamond', serif;">
                            <i class="bi bi-truck me-2"></i>Delivery Information
                        </h4>
                        <p class="text-muted mb-0 small mt-2">Please provide delivery details for your order</p>
                    </div>
                    <div class="checkout-card-body">
                        <form id="deliveryForm">
                            @if(Auth::check())
                            <div class="alert alert-info mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                Logged in as: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                           value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                                           value="{{ Auth::check() ? Auth::user()->phone : '' }}" 
                                           pattern="^(07|01)\d{8}$" required
                                           placeholder="07XXXXXXXX or 01XXXXXXXX">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" 
                                       value="{{ Auth::check() ? Auth::user()->email : '' }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="delivery_address" class="form-label">Delivery Address *</label>
                                <textarea class="form-control" id="delivery_address" name="delivery_address" 
                                          rows="3" required placeholder="Farm name, location, nearest town, and directions"></textarea>
                                <small class="text-muted">Please provide detailed directions to your farm</small>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="county" class="form-label">County *</label>
                                    <select class="form-select" id="county" name="county" required>
                                        <option value="">Select County</option>
                                        <option value="Nairobi">Nairobi</option>
                                        <option value="Kiambu">Kiambu</option>
                                        <option value="Muranga">Muranga</option>
                                        <option value="Nyeri">Nyeri</option>
                                        <option value="Kirinyaga">Kirinyaga</option>
                                        <option value="Nakuru">Nakuru</option>
                                        <option value="Uasin Gishu">Uasin Gishu</option>
                                        <option value="Kisumu">Kisumu</option>
                                        <option value="Mombasa">Mombasa</option>
                                        <option value="Machakos">Machakos</option>
                                        <option value="Kitui">Kitui</option>
                                        <option value="Garissa">Garissa</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="town" class="form-label">Town/Nearest Town *</label>
                                    <input type="text" class="form-control" id="town" name="town" required 
                                           placeholder="e.g., Thika, Nakuru Town, etc.">
                                </div>
                            </div>
                            
                            <!-- Delivery Zone Selection WITH AREAS -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="delivery_zone" class="form-label">Delivery Zone *</label>
                                    <div class="delivery-zone-select">
                                        <select class="form-select" id="delivery_zone" name="delivery_zone" required>
                                            <option value="">-- Select Delivery Zone --</option>
                                            
                                            <!-- Nairobi Area -->
                                            <optgroup label="🏙️ NAIROBI METROPOLITAN">
                                                <option value="zone_nairobi_cbd" data-base-fee="500" data-per-km="50" data-free-km="5" data-county="Nairobi">
                                                    Nairobi CBD - KES 500
                                                </option>
                                                <option value="zone_westlands" data-base-fee="450" data-per-km="45" data-free-km="5" data-county="Nairobi">
                                                    Westlands - KES 450
                                                </option>
                                                <option value="zone_karen" data-base-fee="550" data-per-km="55" data-free-km="5" data-county="Nairobi">
                                                    Karen/Langata - KES 550
                                                </option>
                                                <option value="zone_embakasi" data-base-fee="400" data-per-km="40" data-free-km="5" data-county="Nairobi">
                                                    Embakasi - KES 400
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Central Kenya Area -->
                                            <optgroup label="🏞️ CENTRAL KENYA">
                                                <option value="zone_thika_urban" data-base-fee="300" data-per-km="30" data-free-km="5" data-county="Kiambu">
                                                    Thika Urban - KES 300
                                                </option>
                                                <option value="zone_thika_rural" data-base-fee="350" data-per-km="35" data-free-km="5" data-county="Kiambu">
                                                    Thika Rural - KES 350
                                                </option>
                                                <option value="zone_ruiru" data-base-fee="250" data-per-km="25" data-free-km="5" data-county="Kiambu">
                                                    Ruiru - KES 250
                                                </option>
                                                <option value="zone_juja" data-base-fee="280" data-per-km="28" data-free-km="5" data-county="Kiambu">
                                                    Juja - KES 280
                                                </option>
                                                <option value="zone_gatundu" data-base-fee="400" data-per-km="40" data-free-km="5" data-county="Kiambu">
                                                    Gatundu - KES 400
                                                </option>
                                                <option value="zone_limuru" data-base-fee="450" data-per-km="45" data-free-km="5" data-county="Kiambu">
                                                    Limuru - KES 450
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Rift Valley Area -->
                                            <optgroup label="⛰️ RIFT VALLEY">
                                                <option value="zone_nakuru_town" data-base-fee="600" data-per-km="60" data-free-km="5" data-county="Nakuru">
                                                    Nakuru Town - KES 600
                                                </option>
                                                <option value="zone_naivasha" data-base-fee="550" data-per-km="55" data-free-km="5" data-county="Nakuru">
                                                    Naivasha - KES 550
                                                </option>
                                                <option value="zone_eldoret" data-base-fee="800" data-per-km="80" data-free-km="5" data-county="Uasin Gishu">
                                                    Eldoret - KES 800
                                                </option>
                                                <option value="zone_kericho" data-base-fee="750" data-per-km="75" data-free-km="5" data-county="Kericho">
                                                    Kericho - KES 750
                                                </option>
                                                <option value="zone_bomet" data-base-fee="780" data-per-km="78" data-free-km="5" data-county="Bomet">
                                                    Bomet - KES 780
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Western Kenya Area -->
                                            <optgroup label="🌾 WESTERN KENYA">
                                                <option value="zone_kisumu" data-base-fee="850" data-per-km="85" data-free-km="5" data-county="Kisumu">
                                                    Kisumu City - KES 850
                                                </option>
                                                <option value="zone_kakamega" data-base-fee="800" data-per-km="80" data-free-km="5" data-county="Kakamega">
                                                    Kakamega - KES 800
                                                </option>
                                                <option value="zone_bungoma" data-base-fee="820" data-per-km="82" data-free-km="5" data-county="Bungoma">
                                                    Bungoma - KES 820
                                                </option>
                                                <option value="zone_busia" data-base-fee="900" data-per-km="90" data-free-km="5" data-county="Busia">
                                                    Busia - KES 900
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Eastern Kenya Area -->
                                            <optgroup label="🌵 EASTERN KENYA">
                                                <option value="zone_machakos" data-base-fee="400" data-per-km="40" data-free-km="5" data-county="Machakos">
                                                    Machakos - KES 400
                                                </option>
                                                <option value="zone_kitui" data-base-fee="650" data-per-km="65" data-free-km="5" data-county="Kitui">
                                                    Kitui - KES 650
                                                </option>
                                                <option value="zone_embu" data-base-fee="600" data-per-km="60" data-free-km="5" data-county="Embu">
                                                    Embu - KES 600
                                                </option>
                                                <option value="zone_meru" data-base-fee="700" data-per-km="70" data-free-km="5" data-county="Meru">
                                                    Meru - KES 700
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Coast Area -->
                                            <optgroup label="🏖️ COAST REGION">
                                                <option value="zone_mombasa" data-base-fee="1200" data-per-km="120" data-free-km="5" data-county="Mombasa">
                                                    Mombasa Island - KES 1,200
                                                </option>
                                                <option value="zone_mombasa_north" data-base-fee="1100" data-per-km="110" data-free-km="5" data-county="Mombasa">
                                                    Mombasa North - KES 1,100
                                                </option>
                                                <option value="zone_kilifi" data-base-fee="1300" data-per-km="130" data-free-km="5" data-county="Kilifi">
                                                    Kilifi - KES 1,300
                                                </option>
                                                <option value="zone_malindi" data-base-fee="1500" data-per-km="150" data-free-km="5" data-county="Kilifi">
                                                    Malindi - KES 1,500
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Northern Kenya Area -->
                                            <optgroup label="🌄 NORTHERN KENYA">
                                                <option value="zone_garissa" data-base-fee="2000" data-per-km="200" data-free-km="5" data-county="Garissa">
                                                    Garissa - KES 2,000
                                                </option>
                                                <option value="zone_wajir" data-base-fee="2500" data-per-km="250" data-free-km="5" data-county="Wajir">
                                                    Wajir - KES 2,500
                                                </option>
                                                <option value="zone_mandera" data-base-fee="2800" data-per-km="280" data-free-km="5" data-county="Mandera">
                                                    Mandera - KES 2,800
                                                </option>
                                                <option value="zone_marsabit" data-base-fee="2300" data-per-km="230" data-free-km="5" data-county="Marsabit">
                                                    Marsabit - KES 2,300
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Special Zones -->
                                            <optgroup label="⭐ SPECIAL ZONES">
                                                <option value="zone_industrial_area" data-base-fee="350" data-per-km="35" data-free-km="5" data-county="Nairobi">
                                                    Industrial Area Nairobi - KES 350
                                                </option>
                                                <option value="zone_airport" data-base-fee="400" data-per-km="40" data-free-km="5" data-county="Nairobi">
                                                    JKIA & Wilson Airport - KES 400
                                                </option>
                                                <option value="zone_export_zones" data-base-fee="300" data-per-km="30" data-free-km="5" data-county="Kiambu">
                                                    Export Processing Zones - KES 300
                                                </option>
                                            </optgroup>
                                            
                                            <!-- Free Zones -->
                                            <optgroup label="🎉 FREE DELIVERY ZONES">
                                                <option value="zone_turitu" data-base-fee="0" data-per-km="0" data-free-km="0" data-county="Kiambu" style="color: #198754; font-weight: bold;">
                                                    Turitu Area - FREE DELIVERY 🎉
                                                </option>
                                                <option value="zone_thika_store" data-base-fee="0" data-per-km="0" data-free-km="0" data-county="Kiambu" style="color: #198754; font-weight: bold;">
                                                    Thika Store Pickup - FREE
                                                </option>
                                                <option value="zone_nairobi_store" data-base-fee="0" data-per-km="0" data-free-km="0" data-county="Nairobi" style="color: #198754; font-weight: bold;">
                                                    Nairobi Depot - FREE
                                                </option>
                                            </optgroup>
                                            
                                        </select>
                                    </div>
                                    <small class="text-muted">Select your delivery zone based on your location</small>
                                    
                                    <!-- Zone Info Display -->
                                    <div id="zoneInfoDisplay" class="zone-info mt-2" style="display: none;">
                                        <div class="zone-info-card">
                                            <div class="zone-info-item">
                                                <span><i class="bi bi-geo-alt"></i> Zone:</span>
                                                <span id="zoneName" class="fw-bold"></span>
                                            </div>
                                            <div class="zone-info-item">
                                                <span><i class="bi bi-currency-exchange"></i> Base Fee:</span>
                                                <span id="zoneBaseFee" class="fw-bold"></span>
                                            </div>
                                            <div class="zone-info-item">
                                                <span><i class="bi bi-signpost"></i> Per KM Rate:</span>
                                                <span id="zonePerKm" class="fw-bold"></span>
                                            </div>
                                            <div class="zone-info-item">
                                                <span><i class="bi bi-gift"></i> Free Distance:</span>
                                                <span id="zoneFreeKm" class="fw-bold"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="delivery_distance" class="form-label">Distance from our store (km) *</label>
                                    <div class="distance-input-wrapper">
                                        <input type="number" class="form-control" id="delivery_distance" 
                                               name="delivery_distance" min="0" step="0.1" required
                                               placeholder="e.g., 12.5">
                                        <span class="distance-unit">km</span>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted d-block">Approximate distance from our main store in Turitu</small>
                                    </div>
                                    
                                    <!-- Quick Distance Selection -->
                                    <div class="mt-3">
                                        <label class="form-label small">Quick Distance Selection</label>
                                        <div class="d-flex flex-wrap gap-2">
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-distance-btn" data-distance="5">
                                                5 km
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-distance-btn" data-distance="10">
                                                10 km
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-distance-btn" data-distance="15">
                                                15 km
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-distance-btn" data-distance="25">
                                                25 km
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-distance-btn" data-distance="50">
                                                50 km
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm quick-distance-btn" data-distance="100">
                                                100 km
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Alternative Zone Selection by Area -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label">Select by Area:</label>
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <div class="card h-100 border">
                                                <div class="card-body text-center p-2">
                                                    <h6 class="card-title mb-2">🏙️ Nairobi</h6>
                                                    <button type="button" class="btn btn-sm btn-outline-primary w-100 quick-area-btn" data-area="nairobi">
                                                        Select
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="card h-100 border">
                                                <div class="card-body text-center p-2">
                                                    <h6 class="card-title mb-2">🏞️ Central</h6>
                                                    <button type="button" class="btn btn-sm btn-outline-primary w-100 quick-area-btn" data-area="central">
                                                        Select
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="card h-100 border">
                                                <div class="card-body text-center p-2">
                                                    <h6 class="card-title mb-2">⛰️ Rift Valley</h6>
                                                    <button type="button" class="btn btn-sm btn-outline-primary w-100 quick-area-btn" data-area="rift">
                                                        Select
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="card h-100 border">
                                                <div class="card-body text-center p-2">
                                                    <h6 class="card-title mb-2">🌾 Western</h6>
                                                    <button type="button" class="btn btn-sm btn-outline-primary w-100 quick-area-btn" data-area="western">
                                                        Select
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Popular Zones Quick Selection -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label">Popular Zones:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-outline-success btn-sm quick-specific-zone" 
                                                data-zone="zone_thika_urban" data-distance="5">
                                            Thika Urban (5km)
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm quick-specific-zone" 
                                                data-zone="zone_ruiru" data-distance="15">
                                            Ruiru (15km)
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm quick-specific-zone" 
                                                data-zone="zone_juja" data-distance="8">
                                            Juja (8km)
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm quick-specific-zone" 
                                                data-zone="zone_nairobi_cbd" data-distance="45">
                                            Nairobi CBD (45km)
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm quick-specific-zone" 
                                                data-zone="zone_limuru" data-distance="25">
                                            Limuru (25km)
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm quick-specific-zone" 
                                                data-zone="zone_turitu" data-distance="0">
                                            Turitu FREE
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Delivery Type Selection -->
                            <div class="mb-4">
                                <label class="form-label">Delivery Method</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="delivery-option-card" data-type="farm_delivery">
                                            <div class="text-center">
                                                <i class="bi bi-truck fs-2 mb-3" style="color: var(--primary-green);"></i>
                                                <h6 class="fw-bold mb-2">Farm Delivery</h6>
                                                <p class="text-muted small mb-2">We deliver directly to your farm</p>
                                                <span class="delivery-badge" id="farmDeliveryFee">KES {{ number_format($shipping, 0) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="delivery-option-card" data-type="pickup_station">
                                            <div class="text-center">
                                                <i class="bi bi-shop fs-2 mb-3" style="color: var(--primary-green);"></i>
                                                <h6 class="fw-bold mb-2">Pickup Station</h6>
                                                <p class="text-muted small mb-2">Collect from our nearest depot</p>
                                                <span class="delivery-badge">FREE</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="delivery_type" name="delivery_type" value="farm_delivery">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Order Weight</label>
                                <div class="alert alert-info p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bi bi-scale me-2"></i>
                                            <strong>Total Weight:</strong>
                                            <span id="totalWeightDisplay">{{ number_format($totalWeight, 2) }} kg</span>
                                        </div>
                                        <div class="weight-badge">
                                            @php
                                                $weightCategory = $totalWeight <= 5 ? 'Light' : ($totalWeight <= 20 ? 'Medium' : 'Heavy');
                                            @endphp
                                            {{ $weightCategory }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="delivery_notes" class="form-label">Delivery Notes (Optional)</label>
                                <textarea class="form-control" id="delivery_notes" name="delivery_notes" 
                                          rows="2" placeholder="Any special delivery instructions"></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Cart
                                </button>
                                <button type="button" class="btn" id="calculateDeliveryBtn" 
                                        style="background: var(--gradient-green); color: white;">
                                    <i class="bi bi-calculator me-2"></i>Calculate Delivery Fee
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <h4 class="mb-0" style="color: var(--navy-green); font-family: 'Cormorant Garamond', serif;">
                            <i class="bi bi-credit-card me-2"></i>Payment Method
                        </h4>
                    </div>
                    <div class="checkout-card-body">
                        <div class="row">
                            @foreach([
                                ['value' => 'mpesa', 'icon' => 'bi-phone text-success', 'label' => 'M-Pesa', 'desc' => 'Pay via Lipa Na M-Pesa'],
                                ['value' => 'cash_on_delivery', 'icon' => 'bi-cash text-warning', 'label' => 'Cash on Delivery', 'desc' => 'Pay when you receive'],
                                ['value' => 'bank_transfer', 'icon' => 'bi-bank text-primary', 'label' => 'Bank Transfer', 'desc' => 'Direct bank transfer']
                            ] as $payment)
                            <div class="col-md-4 mb-3">
                                <div class="payment-method-card" data-payment="{{ $payment['value'] }}">
                                    <div class="text-center">
                                        <i class="bi {{ $payment['icon'] }} payment-icon"></i>
                                        <h6 class="fw-bold mb-2">{{ $payment['label'] }}</h6>
                                        <p class="text-muted small mb-0">{{ $payment['desc'] }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- M-Pesa Payment Details -->
                        <div id="mpesaDetails" class="mt-4 border p-3 rounded bg-light" style="display: none;">
                            <h6><i class="bi bi-phone me-2"></i> M-Pesa Payment Instructions</h6>
                            <ol class="mb-3">
                                <li>You will receive an M-Pesa prompt on your phone</li>
                                <li>Enter your M-Pesa PIN to complete payment</li>
                                <li>Payment confirmation will be sent via SMS</li>
                            </ol>
                            <div class="mb-3">
                                <label for="mpesa_number" class="form-label">M-Pesa Phone Number *</label>
                                <input type="tel" class="form-control" id="mpesa_number" name="mpesa_number" 
                                       pattern="^(07|01)\d{8}$" placeholder="07XX XXX XXX">
                            </div>
                        </div>
                        
                        <!-- Bank Transfer Details -->
                        <div id="bankDetails" class="mt-4 border p-3 rounded bg-light" style="display: none;">
                            <h6><i class="bi bi-bank me-2"></i> Bank Transfer Details</h6>
                            <div class="mb-3">
                                <p class="mb-1"><strong>Bank:</strong> Equity Bank Kenya Ltd</p>
                                <p class="mb-1"><strong>Account Name:</strong> Premium Farming Feeds Ltd</p>
                                <p class="mb-1"><strong>Account Number:</strong> 1234567890</p>
                                <p class="mb-0"><strong>Branch:</strong> Thika Branch</p>
                            </div>
                            <div class="mb-3">
                                <label for="bank_slip" class="form-label">Upload Payment Slip (Optional)</label>
                                <input type="file" class="form-control" id="bank_slip" name="bank_slip" accept="image/*,.pdf">
                            </div>
                        </div>
                        
                        <input type="hidden" id="payment_method" name="payment_method" value="">
                        
                        <!-- Terms and Conditions -->
                        <div class="terms-check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a> *
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Order Summary -->
            <div class="col-lg-4">
                <div class="sticky-summary">
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <h4 class="mb-0" style="color: var(--navy-green); font-family: 'Cormorant Garamond', serif;">
                                <i class="bi bi-receipt me-2"></i>Order Summary
                            </h4>
                        </div>
                        <div class="checkout-card-body">
                            <!-- Order Items -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Order Items ({{ count($cart) }})</h6>
                                <div style="max-height: 200px; overflow-y: auto;" class="pe-2">
                                    @foreach($cart as $item)
                                    <div class="cart-item">
                                        <div>
                                            <div class="cart-item-name">{{ $item['name'] }}</div>
                                            <div class="cart-item-details">
                                                {{ $item['quantity'] }} × KES {{ number_format($item['price'], 0) }}
                                            </div>
                                        </div>
                                        <div class="fw-bold">
                                            KES {{ number_format($item['price'] * $item['quantity'], 0) }}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Price Breakdown -->
                            <div class="mb-3">
                                <h6 class="fw-bold mb-3">Price Breakdown</h6>
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span id="subtotalDisplay">KES {{ number_format($subtotal, 0) }}</span>
                                </div>
                                
                                <div class="summary-row">
                                    <span>VAT (16%)</span>
                                    <span id="vatDisplay">KES {{ number_format($subtotal * 0.16, 0) }}</span>
                                </div>
                                
                                <!-- Delivery Fee Section -->
                                <div id="deliveryFeeSection" style="display: none;">
                                    <div class="summary-row">
                                        <span>Delivery Fee</span>
                                        <span id="deliveryFeeDisplay" class="text-green fw-bold">KES 0.00</span>
                                    </div>
                                    <div class="alert alert-light p-2 mb-3">
                                        <small class="text-muted" id="deliveryDetails"></small>
                                    </div>
                                </div>
                                
                                <div class="summary-row total">
                                    <span>Total Amount</span>
                                    <span id="totalAmountDisplay">KES {{ number_format($subtotal + ($subtotal * 0.16) + $shipping, 0) }}</span>
                                </div>
                            </div>
                            
                            <!-- Checkout Button -->
                            <button type="button" class="btn-checkout mt-3" id="placeOrderBtn" disabled>
                                <i class="bi bi-lock me-2"></i>Complete Order
                            </button>
                            
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>Secure checkout · SSL encrypted
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Info Card -->
                    <div class="checkout-card mt-3">
                        <div class="checkout-card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Order Information</h6>
                            <ul class="list-unstyled small mb-0">
                                <li class="mb-2">
                                    <i class="bi bi-clock me-2"></i>
                                    <strong>Delivery Time:</strong> 2-3 business days
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-shield me-2"></i>
                                    <strong>Secure Payment:</strong> 256-bit encryption
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-headset me-2"></i>
                                    <strong>Support:</strong> 24/7 Customer Service
                                </li>
                                <li>
                                    <i class="bi bi-arrow-return-left me-2"></i>
                                    <strong>Returns:</strong> 30-day return policy
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Delivery Terms</h6>
                <ul>
                    <li>Delivery within 2-3 business days for major towns</li>
                    <li>Remote areas may take 4-5 business days</li>
                    <li>Delivery fees are non-refundable</li>
                </ul>
                
                <h6>Payment Terms</h6>
                <ul>
                    <li>M-Pesa payments must be confirmed within 15 minutes</li>
                    <li>Cash on delivery requires exact amount</li>
                    <li>Bank transfers must be confirmed before delivery</li>
                </ul>
                
                <h6>Returns & Refunds</h6>
                <ul>
                    <li>Damaged goods must be reported within 24 hours</li>
                    <li>Returns subject to inspection and approval</li>
                    <li>Refunds processed within 5-7 business days</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let selectedPaymentMethod = '';
    let selectedDeliveryType = 'farm_delivery';
    let calculatedDeliveryFee = 0;
    let subtotal = {{ $subtotal }};
    let vat = {{ $subtotal * 0.16 }};
    let totalWeight = {{ $totalWeight }};
    let baseShipping = {{ $shipping }};

    // Initialize delivery type selection
    const farmDeliveryCard = document.querySelector('.delivery-option-card[data-type="farm_delivery"]');
    if (farmDeliveryCard) {
        farmDeliveryCard.classList.add('selected');
    }
    updateDeliveryFee();

    // Delivery Type Selection
    document.querySelectorAll('.delivery-option-card').forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all delivery options
            document.querySelectorAll('.delivery-option-card').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Set delivery type
            selectedDeliveryType = this.getAttribute('data-type');
            document.getElementById('delivery_type').value = selectedDeliveryType;
            
            // Update delivery fee display
            updateDeliveryFee();
        });
    });

    // Zone selection with auto-population
    const zoneSelect = document.getElementById('delivery_zone');
    if (zoneSelect) {
        // Test if select is clickable
        zoneSelect.addEventListener('mousedown', function(e) {
            console.log('Select clicked!');
        });
        
        zoneSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const county = selectedOption.getAttribute('data-county');
            const baseFee = selectedOption.getAttribute('data-base-fee');
            const perKm = selectedOption.getAttribute('data-per-km');
            const freeKm = selectedOption.getAttribute('data-free-km');
            const zoneName = selectedOption.text.split(' - ')[0]; // Extract zone name from option text
            const zoneInfoDisplay = document.getElementById('zoneInfoDisplay');
            
            console.log('Zone selected:', zoneName, 'Value:', this.value);
            
            // Update county field if empty
            const countyField = document.getElementById('county');
            if (county && countyField && !countyField.value) {
                countyField.value = county;
            }
            
            // Show zone info if option is selected and has value
            if (this.value && this.value !== "") {
                if (zoneInfoDisplay) {
                    zoneInfoDisplay.style.display = 'block';
                    
                    // Update zone info details
                    document.getElementById('zoneName').textContent = zoneName;
                    document.getElementById('zoneBaseFee').textContent = 'KES ' + (parseFloat(baseFee) || 0).toLocaleString();
                    document.getElementById('zonePerKm').textContent = 'KES ' + (parseFloat(perKm) || 0).toLocaleString() + '/km';
                    document.getElementById('zoneFreeKm').textContent = (parseFloat(freeKm) || 0) + ' km free';
                    
                    // Change styling for free zones
                    if (parseFloat(baseFee) === 0) {
                        zoneInfoDisplay.classList.remove('text-info');
                        zoneInfoDisplay.classList.add('text-success');
                    } else {
                        zoneInfoDisplay.classList.remove('text-success');
                        zoneInfoDisplay.classList.add('text-info');
                    }
                }
            } else {
                if (zoneInfoDisplay) {
                    zoneInfoDisplay.style.display = 'none';
                }
            }
        });
    }

    // Quick area buttons
    document.querySelectorAll('.quick-area-btn').forEach(button => {
        button.addEventListener('click', function() {
            const area = this.getAttribute('data-area');
            const zoneSelect = document.getElementById('delivery_zone');
            
            if (zoneSelect) {
                // Scroll to and focus the select
                zoneSelect.focus();
                
                // Show alert to select from the area
                let areaName = '';
                switch(area) {
                    case 'nairobi': areaName = 'Nairobi Metropolitan'; break;
                    case 'central': areaName = 'Central Kenya'; break;
                    case 'rift': areaName = 'Rift Valley'; break;
                    case 'western': areaName = 'Western Kenya'; break;
                }
                
                alert(`Please select a zone from the ${areaName} section in the dropdown.`);
            }
        });
    });

    // Quick specific zone buttons
    document.querySelectorAll('.quick-specific-zone').forEach(button => {
        button.addEventListener('click', function() {
            const zoneId = this.getAttribute('data-zone');
            const distance = this.getAttribute('data-distance');
            
            // Set distance
            const distanceInput = document.getElementById('delivery_distance');
            if (distanceInput) {
                distanceInput.value = distance;
            }
            
            // Select the zone in dropdown
            const zoneSelect = document.getElementById('delivery_zone');
            if (zoneSelect) {
                for (let i = 0; i < zoneSelect.options.length; i++) {
                    if (zoneSelect.options[i].value === zoneId) {
                        zoneSelect.selectedIndex = i;
                        zoneSelect.dispatchEvent(new Event('change'));
                        
                        // Update county if zone has county data
                        const selectedOption = zoneSelect.options[i];
                        const county = selectedOption.getAttribute('data-county');
                        const countyField = document.getElementById('county');
                        if (county && countyField && !countyField.value) {
                            countyField.value = county;
                        }
                        break;
                    }
                }
            }
        });
    });

    // Quick distance buttons
    document.querySelectorAll('.quick-distance-btn').forEach(button => {
        button.addEventListener('click', function() {
            const distance = this.getAttribute('data-distance');
            const distanceInput = document.getElementById('delivery_distance');
            if (distanceInput) {
                distanceInput.value = distance;
                
                // Highlight the clicked button
                document.querySelectorAll('.quick-distance-btn').forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-secondary');
                });
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-primary');
            }
        });
    });

    // Auto-suggest based on county selection
    const countySelect = document.getElementById('county');
    if (countySelect) {
        countySelect.addEventListener('change', function() {
            const county = this.value;
            const zoneSelect = document.getElementById('delivery_zone');
            
            if (!county || !zoneSelect) return;
            
            // Find zones for this county
            const matchingZones = [];
            for (let i = 0; i < zoneSelect.options.length; i++) {
                const option = zoneSelect.options[i];
                if (option.value) {
                    const optionCounty = option.getAttribute('data-county');
                    if (optionCounty && optionCounty.toLowerCase() === county.toLowerCase()) {
                        matchingZones.push(option);
                    }
                }
            }
            
            if (matchingZones.length > 0 && !zoneSelect.value) {
                // Auto-select first matching zone
                zoneSelect.selectedIndex = zoneSelect.options.indexOf(matchingZones[0]);
                zoneSelect.dispatchEvent(new Event('change'));
                
                // Show message about matching zones
                console.log(`Found ${matchingZones.length} zones for ${county}`);
            }
        });
    }

    // Calculate Delivery Fee
    const calculateBtn = document.getElementById('calculateDeliveryBtn');
    if (calculateBtn) {
        calculateBtn.addEventListener('click', function() {
            const zoneSelect = document.getElementById('delivery_zone');
            const zoneId = zoneSelect?.value;
            const distance = document.getElementById('delivery_distance')?.value;
            const county = document.getElementById('county')?.value;
            const town = document.getElementById('town')?.value;
            
            if (!zoneId || zoneId === "") {
                alert('Please select a delivery zone');
                zoneSelect?.focus();
                return;
            }
            
            if (!distance || !county || !town) {
                alert('Please fill in all required delivery information');
                return;
            }
            
            // Show loading
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Calculating...';
            this.disabled = true;
            
            // Get zone data from selected option
            const selectedOption = zoneSelect.options[zoneSelect.selectedIndex];
            const baseFee = selectedOption.getAttribute('data-base-fee') || 0;
            const perKm = selectedOption.getAttribute('data-per-km') || 0;
            const freeKm = selectedOption.getAttribute('data-free-km') || 0;
            const zoneName = selectedOption.text.split(' - ')[0];
            
            // Calculate delivery fee locally (for demo)
            const distanceNum = parseFloat(distance);
            const baseFeeNum = parseFloat(baseFee);
            const perKmNum = parseFloat(perKm);
            const freeKmNum = parseFloat(freeKm);
            
            // Calculate distance fee (distance beyond free km)
            const chargeableDistance = Math.max(0, distanceNum - freeKmNum);
            const distanceFee = chargeableDistance * perKmNum;
            
            // Calculate weight fee (example: KES 10 per kg over 20kg)
            const weightFee = Math.max(0, totalWeight - 20) * 10;
            
            // Total delivery fee
            const totalDeliveryFee = baseFeeNum + distanceFee + weightFee;
            
            // Simulate API delay
            setTimeout(() => {
                calculatedDeliveryFee = totalDeliveryFee;
                
                // Update UI
                const deliveryFeeDisplay = document.getElementById('deliveryFeeDisplay');
                const deliveryDetails = document.getElementById('deliveryDetails');
                const deliveryFeeSection = document.getElementById('deliveryFeeSection');
                const farmDeliveryFee = document.getElementById('farmDeliveryFee');
                
                if (deliveryFeeDisplay) deliveryFeeDisplay.textContent = 'KES ' + totalDeliveryFee.toLocaleString('en-US', {minimumFractionDigits: 0});
                if (deliveryDetails) deliveryDetails.innerHTML = 
                    `<strong>${zoneName}</strong> · Base: KES ${baseFeeNum.toLocaleString()} · Distance: KES ${distanceFee.toLocaleString()} · Weight: KES ${weightFee.toLocaleString()}`;
                if (deliveryFeeSection) deliveryFeeSection.style.display = 'block';
                
                // Update total amount
                updateTotalAmount();
                
                // Enable checkout button if payment method is selected
                if (selectedPaymentMethod) {
                    checkCheckoutReady();
                }
                
                // Update farm delivery badge
                if (farmDeliveryFee) farmDeliveryFee.textContent = 'KES ' + totalDeliveryFee.toLocaleString('en-US', {minimumFractionDigits: 0});
                
                // Show success message
                alert(`Delivery fee calculated successfully for ${zoneName}! Total: KES ${totalDeliveryFee.toLocaleString('en-US', {minimumFractionDigits: 0})}`);
                
                this.innerHTML = originalHTML;
                this.disabled = false;
            }, 500);
        });
    }
    
    // Payment Method Selection
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all options
            document.querySelectorAll('.payment-method-card').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Set payment method
            selectedPaymentMethod = this.getAttribute('data-payment');
            document.getElementById('payment_method').value = selectedPaymentMethod;
            
            // Show/hide payment details
            togglePaymentDetails();
            
            // Enable checkout button if delivery fee is calculated
            checkCheckoutReady();
        });
    });
    
    // Toggle payment method details
    function togglePaymentDetails() {
        const mpesaDetails = document.getElementById('mpesaDetails');
        const bankDetails = document.getElementById('bankDetails');
        const mpesaNumberInput = document.getElementById('mpesa_number');
        
        if (mpesaDetails) mpesaDetails.style.display = 'none';
        if (bankDetails) bankDetails.style.display = 'none';
        
        if (selectedPaymentMethod === 'mpesa') {
            if (mpesaDetails) mpesaDetails.style.display = 'block';
            if (mpesaNumberInput) mpesaNumberInput.required = true;
        } else if (selectedPaymentMethod === 'bank_transfer') {
            if (bankDetails) bankDetails.style.display = 'block';
        } else {
            if (mpesaNumberInput) mpesaNumberInput.required = false;
        }
    }
    
    // Update delivery fee based on delivery type
    function updateDeliveryFee() {
        if (selectedDeliveryType === 'pickup_station') {
            calculatedDeliveryFee = 0;
            const deliveryFeeDisplay = document.getElementById('deliveryFeeDisplay');
            const deliveryDetails = document.getElementById('deliveryDetails');
            const deliveryFeeSection = document.getElementById('deliveryFeeSection');
            
            if (deliveryFeeDisplay) deliveryFeeDisplay.textContent = 'KES 0.00';
            if (deliveryDetails) deliveryDetails.innerHTML = 'Free pickup from our depot';
            if (deliveryFeeSection) deliveryFeeSection.style.display = 'block';
        } else {
            calculatedDeliveryFee = baseShipping;
            const deliveryFeeDisplay = document.getElementById('deliveryFeeDisplay');
            const deliveryDetails = document.getElementById('deliveryDetails');
            const deliveryFeeSection = document.getElementById('deliveryFeeSection');
            
            if (deliveryFeeDisplay) deliveryFeeDisplay.textContent = 'KES ' + baseShipping.toLocaleString();
            if (deliveryDetails) deliveryDetails.innerHTML = 'Standard farm delivery (calculate for exact fee)';
            if (deliveryFeeSection) deliveryFeeSection.style.display = 'block';
        }
        
        updateTotalAmount();
    }
    
    // Update total amount
    function updateTotalAmount() {
        const totalAmount = subtotal + vat + calculatedDeliveryFee;
        const totalAmountDisplay = document.getElementById('totalAmountDisplay');
        if (totalAmountDisplay) {
            totalAmountDisplay.textContent = 'KES ' + totalAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    }
    
    // Check if checkout is ready
    function checkCheckoutReady() {
        const termsChecked = document.getElementById('terms')?.checked;
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        
        if (placeOrderBtn) {
            if (selectedPaymentMethod && termsChecked) {
                placeOrderBtn.disabled = false;
            } else {
                placeOrderBtn.disabled = true;
            }
        }
    }
    
    // Terms checkbox change
    const termsCheckbox = document.getElementById('terms');
    if (termsCheckbox) {
        termsCheckbox.addEventListener('change', checkCheckoutReady);
    }
    
    // Place Order
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', function() {
            if (!selectedPaymentMethod) {
                alert('Please select a payment method');
                return;
            }
            
            if (calculatedDeliveryFee === 0 && selectedDeliveryType === 'farm_delivery') {
                if (!confirm('Delivery fee not calculated. Continue with base delivery fee?')) {
                    return;
                }
            }
            
            // Validate form
            const deliveryForm = document.getElementById('deliveryForm');
            if (!deliveryForm.checkValidity()) {
                alert('Please fill in all required fields');
                deliveryForm.reportValidity();
                return;
            }
            
            // Validate phone number format
            const phone = document.getElementById('customer_phone')?.value;
            if (phone && !phone.match(/^(07|01)\d{8}$/)) {
                alert('Please enter a valid Kenyan phone number (07XXXXXXXX or 01XXXXXXXX)');
                document.getElementById('customer_phone')?.focus();
                return;
            }
            
            // Check if zone is selected
            const zoneSelect = document.getElementById('delivery_zone');
            if (!zoneSelect?.value) {
                alert('Please select a delivery zone');
                zoneSelect?.focus();
                return;
            }
            
            // If M-Pesa selected, validate M-Pesa number
            if (selectedPaymentMethod === 'mpesa') {
                const mpesaNumber = document.getElementById('mpesa_number')?.value;
                if (mpesaNumber && !mpesaNumber.match(/^(07|01)\d{8}$/)) {
                    alert('Please enter a valid M-Pesa phone number');
                    document.getElementById('mpesa_number')?.focus();
                    return;
                }
            }
            
            // Confirm order
            if (!confirm('Are you sure you want to place this order?')) {
                return;
            }
            
            // Show loading
            const originalHTML = this.innerHTML;
            this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Processing Order...';
            this.disabled = true;
            
            // Collect form data
            const formData = new FormData();
            formData.append('delivery_address', document.getElementById('delivery_address')?.value || '');
            formData.append('customer_name', document.getElementById('customer_name')?.value || '');
            formData.append('customer_phone', document.getElementById('customer_phone')?.value || '');
            formData.append('customer_email', document.getElementById('customer_email')?.value || '');
            formData.append('delivery_notes', document.getElementById('delivery_notes')?.value || '');
            formData.append('payment_method', selectedPaymentMethod);
            formData.append('delivery_zone_id', document.getElementById('delivery_zone')?.value || '');
            formData.append('delivery_distance', document.getElementById('delivery_distance')?.value || '');
            formData.append('delivery_type', selectedDeliveryType);
            formData.append('county', document.getElementById('county')?.value || '');
            formData.append('town', document.getElementById('town')?.value || '');
            
            // Add M-Pesa number if selected
            if (selectedPaymentMethod === 'mpesa') {
                formData.append('mpesa_number', document.getElementById('mpesa_number')?.value || '');
            }
            
            // Add bank slip if uploaded
            const bankSlip = document.getElementById('bank_slip');
            if (bankSlip?.files.length > 0) {
                formData.append('bank_slip', bankSlip.files[0]);
            }
            
            // Submit order
            fetch('{{ route("checkout.place.order") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data && data.success === false) {
                    alert(data.message || 'Error placing order');
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Network error. Please try again.');
                this.innerHTML = originalHTML;
                this.disabled = false;
            });
        });
    }
    
    // Force select to be clickable
    setTimeout(() => {
        const zoneSelect = document.getElementById('delivery_zone');
        if (zoneSelect) {
            // Remove any interfering styles
            zoneSelect.style.pointerEvents = 'auto';
            zoneSelect.style.cursor = 'pointer';
            zoneSelect.style.zIndex = '1000';
            
            // Add test click handler
            zoneSelect.addEventListener('click', function(e) {
                console.log('Direct click on select!');
            });
        }
    }, 500);
});
</script>
@endpush