{{-- @extends('layouts.shop') --}}

@section('title', 'Products')

@section('content')

<style>
    body, h1, h2, h3, h4, h5, h6, p, span, a, li, label {
        color: #000 !important;
    }

    .product-title {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 40px;
        text-align: center;
    }

    .section-title {
        font-weight: 800;
        margin-bottom: 20px;
        margin-top: 40px;
        font-size: 22px;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }

    .product-card {
        border-radius: 14px;
        border: 1px solid #d1d5db;
        background: #fff;
        transition: all .3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    /* ✅ IMAGE FIX (ZOOM OUT & FULL VIEW) */
    .product-img {
        height: 240px;
        width: 100%;
        object-fit: contain;
        background: #f9fafb;
        /* padding: 12px; */
    }

    .card-body {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .card-text {
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 10px;
        flex-grow: 1;
    }

    .price-tag {
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .btn-buy {
        background: #065f46;
        font-weight: 700;
        color: #fff !important;
        padding: 10px 0;
        border-radius: 10px;
        border: none;
        width: 100%;
    }

    .btn-buy:hover {
        background: #064e3b;
    }
</style>

<div class="container py-5">

    <h2 class="product-title">Our Products</h2>

    {{-- ================= PIG FEEDS ================= --}}
    <h4 class="section-title">🐖 Pig Feeds</h4>
    <div class="product-grid">
        @php
        $pigFeeds = [
            ['id'=>101,'name'=>'Pig Starter Pellets','price'=>2500,'image'=>'images/piggrower.jpeg','desc'=>'Supports early growth and strong immunity.'],
            ['id'=>102,'name'=>'Pig Grower Mash','price'=>2450,'image'=>'images/spig grower.jpeg','desc'=>'Balanced nutrition for fast weight gain.'],
            ['id'=>103,'name'=>'Sow & Weaner Feed','price'=>2600,'image'=>'images/sowwen.jpeg','desc'=>'Improves fertility and piglet development.'],
            ['id'=>104,'name'=>'Pig Fattener','price'=>2700,'image'=>'images/pfter.jpeg','desc'=>'Fast weight gain and premium meat quality.']
        ];
        @endphp

        @foreach($pigFeeds as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}">
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
                    <button class="btn-buy">Add to Cart</button>
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
            ['id'=>201,'name'=>'Dog Meal','price'=>2200,'image'=>'images/dogm.jpeg','desc'=>'Complete balanced nutrition for dogs.'],
            ['id'=>202,'name'=>'Rabbit Pellets','price'=>2000,'image'=>'images/rabit1.jpeg','desc'=>'High fiber feed for healthy digestion.']
        ];
        @endphp

        @foreach($petFeeds as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}">
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
                    <button class="btn-buy">Add to Cart</button>
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
            ['id'=>301,'name'=>'Chick Starter','price'=>1900,'image'=>'images/chick start.jpeg','desc'=>'Boosts early chick growth and immunity.'],
            ['id'=>302,'name'=>'Chick Mash','price'=>1850,'image'=>'images/chickmash.jpeg','desc'=>'Healthy development for young chicks.'],
            ['id'=>303,'name'=>'Growers Mash','price'=>1800,'image'=>'images/growers.jpeg','desc'=>'Balanced nutrients for growing poultry.'],
            ['id'=>304,'name'=>'Layers Mash','price'=>1800,'image'=>'images/layers.jpeg','desc'=>'Improves egg production and shell quality.'],
            ['id'=>305,'name'=>'Super Layers','price'=>1950,'image'=>'images/slayers.jpeg','desc'=>'Maximum egg production & shell strength.']
        ];
        @endphp

        @foreach($poultryFeeds as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}">
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
                    <button class="btn-buy">Add to Cart</button>
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
            ['id'=>401,'name'=>'Wheat Bran','price'=>1300,'image'=>'images/bran.jpg','desc'=>'High fiber bulk feed for ruminants.'],
            ['id'=>402,'name'=>'Wheat Pollard','price'=>1500,'image'=>'images/pollard.jpg','desc'=>'Energy and protein supplement feed.'],
            ['id'=>403,'name'=>'Maize Germ','price'=>1400,'image'=>'images/maize.jpeg','desc'=>'High-energy supplement for livestock.']
        ];
        @endphp

        @foreach($byProducts as $product)
        <div class="product-card">
            <img src="{{ asset($product['image']) }}" class="product-img" alt="{{ $product['name'] }}">
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
                    <button class="btn-buy">Add to Cart</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection
