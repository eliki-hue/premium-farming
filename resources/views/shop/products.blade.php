@extends('layouts.app')

@section('title', 'Products - Premium Farming Feeds')

@push('styles')
<style>
.hero {
    background: linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)),
                url('https://images.unsplash.com/photo-1500382017468-9049fed747ef') center/cover;
    min-height: 70vh;
    display: flex;
    align-items: center;
    color: #fff;
    margin-bottom: 4rem;
    border-radius: 0 0 24px 24px;
}

.hero h1 { 
    font-size: 3.5rem; 
    font-weight: 800; 
    margin-bottom: 1rem;
}

.hero .lead {
    font-size: 1.3rem;
    opacity: 0.95;
    max-width: 600px;
}

.section { 
    padding: 5rem 0; 
}

.product-title {
    font-size: 3rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 3rem;
    text-align: center;
    background: linear-gradient(135deg, #10b981, #059669);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-title {
    font-weight: 800;
    margin-bottom: 2.5rem;
    margin-top: 4rem;
    font-size: 2.2rem;
    color: #1f2937;
    text-align: center;
    position: relative;
}

.section-title::after {
    content: '';
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #10b981, #059669);
    position: absolute;
    bottom: -12px;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 2px;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.product-card {
    border-radius: 20px;
    border: 1px solid #e5e7eb;
    background: #fff;
    transition: all .4s ease;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
}

.product-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
    border-color: #10b981;
}

.product-img {
    height: 260px;
    width: 100%;
    object-fit: contain;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 1.5rem;
    transition: transform .4s ease;
}

.product-card:hover .product-img {
    transform: scale(1.05);
}

.card-body {
    padding: 1.75rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.card-title {
    font-size: 1.3rem;
    font-weight: 800;
    margin-bottom: 0.75rem;
    color: #1f2937;
    line-height: 1.3;
}

.card-text {
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.25rem;
    flex-grow: 1;
    color: #6b7280;
}

.price-tag {
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: #059669;
}

.btn-buy {
    background: linear-gradient(135deg, #10b981, #059669);
    font-weight: 700;
    color: #fff !important;
    padding: 1rem 0;
    border-radius: 12px;
    border: none;
    width: 100%;
    font-size: 1rem;
    transition: all .3s ease;
}

.btn-buy:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
}

.btn-back {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all .3s ease;
    margin: 2rem auto;
}

.btn-back:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-2px);
    color: white;
}

@media (max-width: 768px) {
    .hero h1 { font-size: 2.5rem; }
    .product-grid { 
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem; 
    }
    .product-title { font-size: 2.2rem; }
}
</style>
@endpush

@section('content')
<!-- HERO SECTION -->
<section class="hero">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl">
            <h1 class="mb-8 leading-tight">Discover Our Premium Products</h1>
            <p class="lead">High-quality livestock feeds for poultry, pigs, pets and more. Shop now for maximum growth and production.</p>
        </div>
    </div>
</section>

<!-- PRODUCTS SECTIONS -->
<div class="container mx-auto px-6">
    <h2 class="product-title">All Products</h2>

    {{-- ================= PIG FEEDS ================= --}}
    <h4 class="section-title">🐖 Pig Feeds</h4>
    <div class="product-grid">
        @php
        $pigFeeds = [
            ['id'=>101,'name'=>'Pig Starter Pellets','price'=>2500,'image'=>'images/piggrower.jpeg','desc'=>'Supports early growth and strong immunity for piglets. High protein formula.'],
            ['id'=>102,'name'=>'Pig Grower Mash','price'=>2450,'image'=>'images/spig grower.jpeg','desc'=>'Balanced nutrition for rapid weight gain and muscle development.'],
            ['id'=>103,'name'=>'Sow & Weaner Feed','price'=>2600,'image'=>'images/sowwen.jpeg','desc'=>'Enhances sow fertility, milk production and healthy piglet development.'],
            ['id'=>104,'name'=>'Pig Fattener','price'=>2700,'image'=>'images/pfter.jpeg','desc'=>'Maximum weight gain formula for premium meat quality and finish.']
        ];
        @endphp

        @foreach($pigFeeds as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}" loading="lazy">
            <div class="card-body">
                <h5 class="card-title">{{ $product['name'] }}</h5>
                <p class="card-text">{{ $product['desc'] }}</p>
                <h6 class="price-tag">Ksh {{ number_format($product['price']) }}</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                    <button type="submit" class="btn-buy">Add to Cart</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ================= PET FEEDS ================= --}}
    <h4 class="section-title">🐶 Pet Feeds</h4>
    <div class="product-grid">
        @php
        $petFeeds = [
            ['id'=>201,'name'=>'Dog Meal','price'=>2200,'image'=>'images/dogm.jpeg','desc'=>'Complete balanced nutrition with essential vitamins for all dog breeds.'],
            ['id'=>202,'name'=>'Rabbit Pellets','price'=>2000,'image'=>'images/rabit1.jpeg','desc'=>'High fiber pellets for optimal digestion and healthy rabbit growth.']
        ];
        @endphp

        @foreach($petFeeds as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}" loading="lazy">
            <div class="card-body">
                <h5 class="card-title">{{ $product['name'] }}</h5>
                <p class="card-text">{{ $product['desc'] }}</p>
                <h6 class="price-tag">Ksh {{ number_format($product['price']) }}</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                    <button type="submit" class="btn-buy">Add to Cart</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ================= POULTRY FEEDS ================= --}}
    <h4 class="section-title">🐔 Poultry Feeds</h4>
    <div class="product-grid">
        @php
        $poultryFeeds = [
            ['id'=>301,'name'=>'Chick Starter','price'=>1900,'image'=>'images/chick start.jpeg','desc'=>'High protein starter feed for maximum early chick growth and immunity.'],
            ['id'=>302,'name'=>'Chick Mash','price'=>1850,'image'=>'images/chickmash.jpeg','desc'=>'Nutritionally complete mash for healthy chick development.'],
            ['id'=>303,'name'=>'Growers Mash','price'=>1800,'image'=>'images/growers.jpeg','desc'=>'Balanced grower formula for steady weight gain and feathering.'],
            ['id'=>304,'name'=>'Layers Mash','price'=>1800,'image'=>'images/layers.jpeg','desc'=>'Calcium-rich formula for superior egg production and shell quality.'],
            ['id'=>305,'name'=>'Super Layers','price'=>1950,'image'=>'images/slayers.jpeg','desc'=>'Premium layers feed for maximum egg production and bird health.']
        ];
        @endphp

        @foreach($poultryFeeds as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}" loading="lazy">
            <div class="card-body">
                <h5 class="card-title">{{ $product['name'] }}</h5>
                <p class="card-text">{{ $product['desc'] }}</p>
                <h6 class="price-tag">Ksh {{ number_format($product['price']) }}</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                    <button type="submit" class="btn-buy">Add to Cart</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ================= BY-PRODUCTS ================= --}}
    <h4 class="section-title">🌾 By-Products</h4>
    <div class="product-grid">
        @php
        $byProducts = [
            ['id'=>401,'name'=>'Wheat Bran','price'=>1300,'image'=>'images/bran.jpg','desc'=>'High fiber bulk feed supplement for ruminants and poultry.'],
            ['id'=>402,'name'=>'Wheat Pollard','price'=>1500,'image'=>'images/pollard.jpg','desc'=>'Energy and protein-rich supplement for all livestock.'],
            ['id'=>403,'name'=>'Maize Germ','price'=>1400,'image'=>'images/maize.jpeg','desc'=>'High-energy maize by-product for cost-effective feeding.']
        ];
        @endphp

        @foreach($byProducts as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}" loading="lazy">
            <div class="card-body">
                <h5 class="card-title">{{ $product['name'] }}</h5>
                <p class="card-text">{{ $product['desc'] }}</p>
                <h6 class="price-tag">Ksh {{ number_format($product['price']) }}</h6>
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product['id'] }}">
                    <input type="hidden" name="name" value="{{ $product['name'] }}">
                    <input type="hidden" name="price" value="{{ $product['price'] }}">
                    <input type="hidden" name="image" value="{{ $product['image'] }}">
                    <button type="submit" class="btn-buy">Add to Cart</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <a href="{{ route('home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
        Back to Home
    </a>
</div>
@endsection
