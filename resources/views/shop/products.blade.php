@extends('layouts.app')

@section('title', 'All Products | Premium Farming Feeds')

@section('content')
<div class="min-h-screen pt-24">

    <!-- HERO -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="hero-title mb-3">Our Premium Product Range</h1>
            <p class="hero-subtitle">
                Scientifically formulated feeds for all livestock types
            </p>

            @if(isset($error))
                <div class="alert alert-warning mt-4">
                    {{ $error }}
                </div>
            @endif
        </div>
    </section>

    {{-- ================= PIG FEEDS ================= --}}
    @if(!empty($groupedProducts['pig']))
    <section class="section bg-light" id="pig-feeds">
        <div class="container">
            <h2 class="section-title">🐖 Pig Feeds</h2>

            <div class="row g-4">
                @foreach($groupedProducts['pig'] as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= POULTRY FEEDS ================= --}}
    @if(!empty($groupedProducts['poultry']))
    <section class="section" id="poultry-feeds">
        <div class="container">
            <h2 class="section-title">🐔 Poultry Feeds</h2>

            <div class="row g-4">
                @foreach($groupedProducts['poultry'] as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= PET FEEDS ================= --}}
    @if(!empty($groupedProducts['pet']))
    <section class="section bg-light" id="pet-feeds">
        <div class="container">
            <h2 class="section-title">🐶 Pet Feeds</h2>

            <div class="row g-4">
                @foreach($groupedProducts['pet'] as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= BY PRODUCTS ================= --}}
    @if(!empty($groupedProducts['byproduct']))
    <section class="section" id="by-products">
        <div class="container">
            <h2 class="section-title">🌾 By-Products</h2>

            <div class="row g-4">
                @foreach($groupedProducts['byproduct'] as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ================= EMPTY STATE ================= --}}
    @if(empty(array_filter($groupedProducts ?? [])) && !isset($error))
    <section class="section">
        <div class="container text-center">
            <div class="alert alert-info">
                No products available at the moment.
            </div>
        </div>
    </section>
    @endif

</div>
@endsection
