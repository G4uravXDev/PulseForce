@extends('layouts.app')
@section('title', 'Premium Merchandise — PulseForce')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/merchandise.css') }}">
@endpush

@section('content')
<div class="merch-page">

    <div class="merch-nav">
        <div class="nav-logo"><a href="{{ route('landing') }}"><span class="nav-logo-dot"></span>PulseForce</a></div>
        @include('partials.feature-nav-links')
    </div>

    <div class="merch-hero">
        <img class="merch-hero-bg" src="https://images.unsplash.com/photo-1556906781-9a412961c28c?w=1200&q=80&auto=format&fit=crop" alt="Gym gear">
        <div class="merch-hero-overlay"></div>
        <div class="merch-hero-content">
            <div class="section-eyebrow">Pro Shop</div>
            <h1 class="merch-hero-h1">Gear Up.<br><em>Stand Out.</em></h1>
            <p class="merch-hero-p">Premium apparel, performance supplements, and training accessories — everything you need to look and perform your best.</p>
        </div>
    </div>

    <div class="merch-filters">
        <a href="{{ route('features.merchandise', ['category' => 'all']) }}" class="merch-filter-btn {{ $category === 'all' ? 'active' : '' }}"> All Products</a>
        <a href="{{ route('features.merchandise', ['category' => 'apparel']) }}" class="merch-filter-btn {{ $category === 'apparel' ? 'active' : '' }}"> Apparel</a>
        <a href="{{ route('features.merchandise', ['category' => 'supplement']) }}" class="merch-filter-btn {{ $category === 'supplement' ? 'active' : '' }}"> Supplements</a>
        <a href="{{ route('features.merchandise', ['category' => 'accessory']) }}" class="merch-filter-btn {{ $category === 'accessory' ? 'active' : '' }}"> Accessories</a>
    </div>

    <div class="products-container">
        <p style="text-align:center; color:var(--muted); margin-bottom:2rem;">Showing {{ count($products) }} products</p>

        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                <div class="product-img-wrap">
                    <img src="{{ $product['img'] }}" alt="{{ $product['name'] }}">
                    @if($product['badge'])
                        <span class="product-badge {{ $product['category'] }}">{{ $product['badge'] }}</span>
                    @endif
                </div>
                <div class="product-body">
                    <div class="product-name">{{ $product['name'] }}</div>
                    <div class="product-desc">{{ $product['desc'] }}</div>
                    <div class="product-footer">
                        <div class="product-price">
                            {{ $product['price'] }}
                            @if($product['original'])
                                <span class="original">{{ $product['original'] }}</span>
                            @endif
                        </div>
                        <div class="product-rating">
                            <span class="stars">★</span> {{ $product['rating'] }} <span>({{ $product['reviews'] }})</span>
                        </div>
                    </div>
                    @if(count($product['sizes']) > 0)
                        <div class="product-sizes" style="margin-top:0.6rem;">
                            @foreach($product['sizes'] as $size)
                                <span>{{ $size }}</span>
                            @endforeach
                        </div>
                    @endif
                    <button type="button" class="buy-btn" data-name="{{ $product['name'] }}" data-price="{{ $product['price'] }}" style="width:100%; margin-top:1rem; padding:0.75rem; border:none; border-radius:8px; background:var(--rust, #c94f2c); color:#fff; font-family:'Epilogue', sans-serif; font-weight:600; cursor:pointer; transition:background 0.2s;">
                        Buy via WhatsApp
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="merch-back">
        <a href="{{ route('landing') }}#features">&larr; Back to all features</a>
    </div>
</div>

{{-- WHATSAPP PURCHASE POPUP --}}
<div class="mem-popup-overlay" id="buyPopupOverlay">
    <div class="mem-popup">
        <button type="button" class="mem-popup-close" id="buyPopupClose">&times;</button>
        <div class="mem-popup-header">
            <div class="mem-popup-icon" style="font-size:2.5rem; margin-bottom:0.5rem;">🛒</div>
            <h3 class="mem-popup-title" style="font-family:'Syne', sans-serif; font-size:1.4rem; color:var(--charcoal);">Purchase <span id="buyProductName" style="color:var(--rust);">Item</span></h3>
            <p class="mem-popup-price" id="buyProductPrice" style="font-family:'Epilogue', sans-serif; font-weight:600; color:var(--teal); font-size:1.1rem; margin-top:0.3rem;"></p>
        </div>
        <p class="mem-popup-desc" style="font-family:'Epilogue', sans-serif; font-size:0.95rem; color:rgba(28,28,30,0.65); line-height:1.5; margin-bottom:1.5rem;">To place your order, choose your size (if applicable) and confirm your shipping details with us on WhatsApp.</p>
        
        <a href="#" id="buyWhatsappBtn" class="mem-popup-wa-btn" target="_blank" rel="noopener" style="display:flex; align-items:center; justify-content:center; gap:0.6rem; width:100%; padding:0.9rem; background:#25D366; color:#fff; border-radius:12px; font-weight:600; text-decoration:none; box-shadow:0 4px 14px rgba(37,211,102,0.3); transition:all 0.2s;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Chat to Buy
        </a>
    </div>
</div>

<style>
    /* Reuse popup styles from landing */
    .mem-popup-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden; transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .mem-popup-overlay.active { opacity: 1; visibility: visible; }
    .mem-popup {
        background: var(--cream, #f0ebe2); border-radius: 20px; padding: 2.5rem;
        max-width: 420px; width: 90%; position: relative;
        transform: translateY(30px) scale(0.95); transition: transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1);
        box-shadow: 0 30px 60px rgba(0,0,0,0.3); text-align: center;
    }
    .mem-popup-overlay.active .mem-popup { transform: translateY(0) scale(1); }
    .mem-popup-close {
        position: absolute; top: 1rem; right: 1.2rem; background: none; border: none; font-size: 1.8rem;
        color: rgba(28,28,30,0.4); cursor: pointer; transition: color 0.2s, transform 0.2s;
    }
    .mem-popup-close:hover { color: var(--rust); transform: scale(1.1); }
    .buy-btn:hover { background: #b04325 !important; }
    .mem-popup-wa-btn:hover { background: #1ebe5d !important; transform: translateY(-1px); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const WHATSAPP_NUMBER = '916287231231'; // Same as the landing page

    const overlay = document.getElementById('buyPopupOverlay');
    const closeBtn = document.getElementById('buyPopupClose');
    const pName = document.getElementById('buyProductName');
    const pPrice = document.getElementById('buyProductPrice');
    const waBtn = document.getElementById('buyWhatsappBtn');

    document.querySelectorAll('.buy-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const name = btn.getAttribute('data-name');
            const price = btn.getAttribute('data-price');

            pName.textContent = name;
            pPrice.textContent = price;

            const message = encodeURIComponent(`Hi PulseForce! 👋\n\nI'd like to purchase the *${name}* (${price}).\n\nPlease let me know the available payment and shipping options.`);
            waBtn.href = `https://wa.me/${WHATSAPP_NUMBER}?text=${message}`;

            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    function closePopup() {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    closeBtn.addEventListener('click', closePopup);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closePopup();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('active')) closePopup();
    });
});
</script>
@endsection
