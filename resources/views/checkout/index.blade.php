<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CartNova - Checkout</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--nav:#232f3e;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#EAEDED;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
        a:hover{text-decoration:underline;color:#C45500}

        /* HEADER */
        .hdr{background:var(--hdr);display:flex;align-items:center;gap:10px;padding:8px 16px;flex-wrap:wrap}
        .logo{font-size:1.6rem;font-weight:900;color:#fff;letter-spacing:-1px;font-family:Arial Black,sans-serif}
        .logo span{color:var(--orange)}
        .hdr-right{display:flex;gap:16px;align-items:center;flex-shrink:0}
        .hdr-link{color:#fff;font-size:.85rem;line-height:1.3}
        .hdr-link span{display:block;color:#ccc;font-size:.72rem}

        /* NAV */
        .nav{background:var(--nav);display:flex;align-items:center;padding:6px 16px;gap:2px;overflow-x:auto}
        .nav a{color:#fff;font-size:.85rem;padding:5px 10px;border-radius:2px;border:1px solid transparent;white-space:nowrap}
        .nav a:hover{border-color:#fff;text-decoration:none}

        /* PAGE LAYOUT */
        .page{display:flex;flex:1;max-width:1200px;margin:0 auto;width:100%;padding:16px;gap:20px}

        /* MAIN */
        .main{flex:1;min-width:0}
        .section{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:20px;margin-bottom:16px}
        .section h2{font-size:1.1rem;font-weight:700;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)}

        /* FORM */
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .form-grid.full{grid-template-columns:1fr}
        .field{display:flex;flex-direction:column;gap:6px}
        .field label{font-size:.85rem;font-weight:700;color:var(--text)}
        .field input,.field select{border:1px solid var(--border);border-radius:4px;padding:8px 12px;font-size:.9rem;font-family:inherit;outline:none;width:100%;transition:border-color .12s,box-shadow .12s}
        .field input:focus,.field select:focus{border-color:#e77600;box-shadow:0 0 0 3px rgba(228,121,17,.2)}
        .field .error{color:var(--error);font-size:.75rem;margin-top:2px}

        /* PAYMENT METHODS */
        .payment-methods{display:grid;grid-template-columns:repeat(auto-fit,minmax:150px,1fr));gap:12px;margin-bottom:16px}
        .payment-method{border:2px solid var(--border);border-radius:8px;padding:16px;text-align:center;cursor:pointer;transition:border-color .15s,background .15s}
        .payment-method:hover{border-color:var(--orange);background:#fff8f8}
        .payment-method.selected{border-color:var(--orange);background:#fff8f8}
        .payment-method input{display:none}
        .payment-method .icon{font-size:2rem;margin-bottom:8px}
        .payment-method .name{font-weight:700;color:var(--text);margin-bottom:4px}
        .payment-method .desc{font-size:.75rem;color:var(--muted)}

        /* COUPON */
        .coupon-section{background:#f9f9f9;border:1px solid var(--border);border-radius:4px;padding:12px;margin-bottom:16px}
        .coupon-input-group{display:flex;gap:8px}
        .coupon-input{flex:1;border:1px solid var(--border);border-radius:4px;padding:8px 12px;font-size:.9rem;outline:none}
        .coupon-input:focus{border-color:var(--orange)}
        .coupon-btn{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border:1px solid #a88734;border-radius:4px;padding:8px 16px;font-size:.85rem;cursor:pointer;font-family:inherit;font-weight:700;color:var(--text)}
        .coupon-btn:hover{filter:brightness(1.04)}
        .coupon-success{color:var(--green);font-size:.85rem;margin-top:6px}
        .coupon-error{color:var(--error);font-size:.85rem;margin-top:6px}

        /* ORDER SUMMARY */
        .summary{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:20px;position:sticky;top:20px}
        .summary h3{font-size:1.1rem;font-weight:700;margin-bottom:16px}
        .summary-row{display:flex;justify-content:space-between;font-size:.9rem;margin-bottom:8px}
        .summary-row.total{font-weight:700;font-size:1rem;padding-top:12px;border-top:1px solid var(--border);margin-top:8px}
        .summary-row.discount{color:var(--green)}
        .btn-place{width:100%;background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border:1px solid #a88734;border-radius:8px;padding:14px;font-size:1rem;cursor:pointer;font-family:inherit;font-weight:700;color:var(--text);transition:filter .15s;margin-top:16px}
        .btn-place:hover{filter:brightness(1.04)}
        .btn-place:disabled{opacity:.6;cursor:not-allowed}

        /* CART ITEMS */
        .cart-items{margin-bottom:16px}
        .cart-item{display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--border)}
        .cart-item:last-child{border-bottom:none}
        .cart-item img{width:60px;height:60px;object-fit:contain;border:1px solid var(--border);border-radius:4px;flex-shrink:0}
        .cart-item-info{flex:1;min-width:0}
        .cart-item-name{font-size:.9rem;color:var(--text);margin-bottom:4px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .cart-item-details{display:flex;justify-content:space-between;align-items:center}
        .cart-item-price{font-weight:700;color:var(--text)}
        .cart-item-qty{font-size:.85rem;color:var(--muted)}

        /* ALERTS */
        .alert{padding:12px 16px;border-radius:4px;margin-bottom:16px}
        .alert-error{background:#fff8f8;border:1px solid var(--error);color:var(--error)}
        .alert-success{background:#f0f8f0;border:1px solid var(--green);color:var(--green)}
         /* 🔥 ACCOUNT DROPDOWN */
.account-menu {
    position: relative;
    cursor: pointer;
}

.account-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 320px;
    background: #fff;
    color: #000;
    display: none;
    padding: 15px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 999;
    gap: 20px;
}

.account-dropdown h4 {
    font-size: 14px;
    margin-bottom: 8px;
}

.account-dropdown a {
    display: block;
    font-size: 13px;
    color: #333;
    margin-bottom: 6px;
    text-decoration: none;
}

.account-dropdown a:hover {
    color: #FF9900;
}

.account-menu:hover .account-dropdown {
    display: flex;
}

.account-dropdown,
.orders-dropdown {
    z-index: 9999;
    position: absolute;
}
/* 🔥 ORDERS DROPDOWN */
.orders-menu {
    position: relative;
    cursor: pointer;
}

.orders-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 220px;
    background: #fff;
    color: #000;
    display: none;
    padding: 12px;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 999;
}

.orders-dropdown h4 {
    font-size: 14px;
    margin-bottom: 8px;
}

.orders-dropdown a {
    display: block;
    font-size: 13px;
    color: #333;
    margin-bottom: 6px;
    text-decoration: none;
}

.orders-dropdown a:hover {
    color: #FF9900;
}

.orders-menu:hover .orders-dropdown {
    display: block;
}


/* 🔥 SIDE MENU */
.side-menu {
    position: fixed;
    top: 0;
    left: -300px;
    width: 280px;
    height: 100%;
    background: #fff;
    z-index: 99999;
    overflow-y: auto;
    transition: left 0.3s ease;
    box-shadow: 2px 0 10px rgba(0,0,0,0.3);
}

.side-menu.active {
    left: 0;
}

/* HEADER */
.side-header {
    background: #232f3e;
    color: #fff;
    padding: 15px;
    font-weight: bold;
    font-size: 16px;
    position: relative;
}

/* CLOSE BUTTON */
.menu-close {
    position: absolute;
    right: 12px;
    top: 10px;
    font-size: 20px;
    cursor: pointer;
}

/* LINKS */
.side-menu a {
    display: block;
    padding: 12px 16px;
    color: #111;
    text-decoration: none;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.side-menu a:hover {
    background: #f3f3f3;
}

/* SECTION TITLE */
.side-title {
    padding: 10px 16px;
    font-weight: bold;
    font-size: 15px;
    background: #f7f7f7;
}

/* 🔥 OVERLAY */
.menu-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    display: none;
    z-index: 99998;
}

.menu-overlay.active {
    display: block;
}
 footer{background:var(--hdr);color:#ccc;text-align:center;padding:16px}
        .foot-links{display:flex;justify-content:center;flex-wrap:wrap;gap:6px 20px;margin-bottom:8px}
        .foot-links a{color:#ccc;font-size:.78rem}
        .foot-copy{font-size:.75rem;color:#888}

        @media(max-width:700px){
            .page{flex-direction:column}
            .product-img-wrap,.buy-box{width:100%}
            .related-grid{grid-template-columns:repeat(2,1fr)}
        }

        /* @media(max-width:768px){.page{flex-direction:column}.form-grid{grid-template-columns:1fr}.payment-methods{grid-template-columns:1fr 1fr}.summary{position:static}} */
    </style>
<!-- CSRF Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

{{-- HEADER --}}
<header class="hdr">
    <a href="{{ route('home') }}" style="text-decoration:none">
        <div class="logo">Cart<span>Nova</span></div>
    </a>
    <form style="flex:1;display:flex;border-radius:4px;overflow:hidden;max-width:1100px" method="GET" action="{{ route('products.index') }}">
         <input type="text" name="search" placeholder="Search CartNova" style="flex:1;border:none;padding:8px 12px;font-size:.9rem;outline:none"> 
         <button type="submit" style="background:var(--orange);border:none;padding:0 16px;cursor:pointer;font-size:1.1rem">&#128269;</button> </form>
    <div class="hdr-right">
        <div class="hdr-link">
            {{-- <span>Hello, {{ auth()->user()->name }}</span>
            <strong>Account &amp; Lists</strong> --}}
            <div class="account-menu">
                {{-- <div class="hdr-account"> --}}
                <div class="hdr-account account-menu" style="display:flex;flex-direction:column;line-height:1.2">
    <span style="font-size:.75rem;color:#ccc">
        Hello, {{ auth()->user()->name ?? 'Guest' }}
    </span>
    <strong style="font-size:.9rem;color:#fff">
        ⚙️ Account &amp; Lists ▾
    </strong>
</div>
                 <div class="account-dropdown">
                    <div class="dropdown-left">
                        <h4>📋 Your Lists</h4>
                        <a href="{{ route('wishlist.index') }}">❤️Your Wishlist</a>
                        <a href="#">➕Create a Wish List</a>
                    </div>
                 <div class="dropdown-right">
                    <h4>👤Your Account</h4>
                    <a href="{{ route('profile.index') }}">🔐 Your Account</a>
                    <a href="{{ route('orders.index') }}">📦Your Orders</a>
                    <a href="{{ route('wishlist.index') }}">❤️Your Wish List</a>
                    <a href="{{ route('addresses.index') }}">📍Your Addresses</a>
                </div>
                </div>
            </div>  
        </div>
        {{-- <a href="{{ route('orders.index') }}" style="text-decoration:none">
    <div class="hdr-link">
        <span>Returns</span>
        <strong>📦 Your Orders ▾</strong>
    </div>
</a> --}}
        {{-- Wishlist icon --}}
         <a href="{{ route('wishlist.index') }}" style="text-decoration:none">
            <div style="color:var(--orange);font-weight:700;font-size:1rem;display:flex;align-items:center;gap:3px">
                ❤️ <span id="wishlistCount" style="background:var(--orange);color:#131921;border-radius:50%;min-width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:.7rem;padding:0 3px">0</span>
            </div>
        </a>
         <div class="hdr-link">
            <div class="orders-menu">
             {{-- <div class="hdr-account"> --}}
                <div class="hdr-account account-menu">
                    <span>🚚 Returns</span>
                    <strong>&amp; Orders ▾</strong>
                 </div>
                <div class="orders-dropdown">
                    <h4>📦 Your Orders</h4>
                     <a href="{{ route('orders.index') }}">📋Track Orders</a>
                     <a href="{{ route('orders.index', ['status' => 'delivered']) }}">
                     🔁 Return / Replace Items
                     </a>
                     <a href="{{ route('orders.index') }}">🧾Order History</a>
                     <a href="{{ route('orders.index', ['status' => 'cancelled']) }}">
                    ❌ Cancelled Orders
                    </a>
                </div>
            </div>
        </div>  
        {{-- Cart icon --}}
       <a href="{{ route('cart.index') }}" style="text-decoration:none">
            <div style="color:var(--orange);font-weight:700;font-size:1rem;display:flex;align-items:center;gap:3px">
                🛒 <span id="cartCount" style="background:var(--orange);color:#131921;border-radius:50%;min-width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:.7rem;padding:0 3px">{{ $itemCount ?? 0 }}</span>
            </div>
        </a>
    </div>
</header>
{{-- 🔥 SIDE MENU --}}
<div id="menuOverlay" class="menu-overlay" onclick="closeMenu()"></div>

<div id="sideMenu" class="side-menu">
    
    <div class="side-header">
        👤 Hello, Sign in
        <span class="menu-close" onclick="closeMenu()">✖</span>
    </div>

    <div class="side-title">Trending</div>
    <a href="{{ route('products.index', ['sort' => 'best_selling']) }}">Bestsellers</a>
    <a href="{{ route('products.index', ['sort' => 'newest']) }}">New Releases</a>
    <a href="{{ route('products.index', ['sort' => 'popular']) }}">Movers and Shakers</a>

    <div class="side-title">Programs & Features</div>
     <a href="{{ route('profile.index') }}">🔒 Login & Security</a>
        <a href="{{ route('addresses.index') }}">📍 Your Addresses</a>
        <a href="{{ route('profile.payment') }}">💳 Payment Options</a>
        <a href="{{ route('wishlist.index') }}">❤️ Your Wishlist</a>
        <a href="{{ route('profile.gift-cards') }}">🎁 Gift Cards</a>
        <a href="{{ route('profile.customer-support') }}">💬 Customer Service</a>
        <a href="{{ route('profile.customer-support-notifications') }}">🔔 Notifications</a>

    <div class="side-title">Help & Settings</div>
   <a href="{{ route('profile.index') }}">👤 Your Account</a>
        <a href="{{ route('help') }}">💬 Customer Service</a>
        <a href="{{ route('login') }}">🔑 Sign in</a>

</div>

{{-- NAV --}}
<nav class="nav">
    {{-- <a href="{{ route('home') }}">☰ All</a> --}}
    <a href="javascript:void(0)" class="nav-all" onclick="openMenu()">☰ All</a>   
    <a href="{{ route('products.index') }}">🔥Today's Deals</a>
     {{-- FIXED CATEGORIES --}}
    <a href="{{ route('products.index', ['category' => 'Books']) }}">📚 Books</a>
    <a href="{{ route('products.index', ['category' => 'Electronics']) }}">📱 Electronics</a>
    <a href="{{ route('products.index', ['category' => 'Fashion']) }}">👗 Fashion</a>
    <a href="{{ route('products.index', ['category' => 'Home & Kitchen']) }}">🏠 Home & Kitchen</a>
    <a href="{{ route('products.index', ['category' => 'Sports']) }}">⚽ Sports</a>
    {{-- @foreach($categories as $cat)
        <a href="{{ route('products.index', ['category'=>$cat]) }}"
           class="{{ request('category')==$cat ? 'active' : '' }}">{{ $cat }}</a>
    @endforeach --}}
{{-- @foreach($categories as $cat)
    <a href="{{ route('products.index', ['category'=>$cat]) }}">
        {{ $categoryIcons[$cat] ?? '📦' }} {{ $cat }}
    </a>
@endforeach --}}
</nav>
<div class="page">

    <main class="main">
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        {{-- SHIPPING ADDRESS --}}
        <div class="section">
            <h2>🚚 Shipping Address</h2>
            <form action="{{ route('checkout.place-order') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" required
                               value="{{ old('full_name', auth()->user()->name) }}" autocomplete="name">
                        @error('full_name')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required
                               value="{{ old('email', auth()->user()->email) }}" autocomplete="email">
                        @error('email')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required
                               value="{{ old('phone', auth()->user()->phone ?? '') }}" autocomplete="tel">
                        @error('phone')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label for="pincode">Pincode *</label>
                        <input type="text" id="pincode" name="pincode" required maxlength="6"
                               value="{{ old('pincode') }}" autocomplete="postal-code">
                        @error('pincode')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field full">
                        <label for="address_line1">Address Line 1 *</label>
                        <input type="text" id="address_line1" name="address_line1" required
                               value="{{ old('address_line1') }}" autocomplete="address-line1">
                        @error('address_line1')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field full">
                        <label for="address_line2">Address Line 2 (Optional)</label>
                        <input type="text" id="address_line2" name="address_line2"
                               value="{{ old('address_line2') }}" autocomplete="address-line2">
                    </div>
                    <div class="field">
                        <label for="city">City *</label>
                        <input type="text" id="city" name="city" required autocomplete="address-level2"
                               value="{{ old('city') }}">
                        @error('city')<span class="error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label for="state">State *</label>
                        <select id="state" name="state" required>
                            <option value="">Select State</option>
                            <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                            <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                            <option value="Delhi" {{ old('state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                            <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                        </select>
                        @error('state')<span class="error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- PAYMENT METHOD --}}
            <div class="section">
                <h2>💳 Payment Method</h2>
                <div class="payment-methods">
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="razorpay" checked>
                        <div class="icon">💳</div>
                        <div class="name">Razorpay</div>
                        <div class="desc">Credit Card, Debit Card, UPI, Net Banking</div>
                    </label>
                    <label class="payment-method">
                        <input type="radio" name="payment_method" value="cod">
                        <div class="icon">💵</div>
                        <div class="name">Cash on Delivery</div>
                        <div class="desc">Pay when you receive</div>
                    </label>
                </div>
            </div>

            {{-- COUPON --}}
            <div class="section">
                <h2>🎟️ Coupon Code</h2>
                <div class="coupon-section">
                    <div class="coupon-input-group">
                        <input type="text" class="coupon-input" id="couponCode" 
                               placeholder="Enter coupon code" 
                               value="{{ session('coupon_code') ?? '' }}">
                        <button type="button" class="coupon-btn" onclick="applyCoupon()">Apply</button>
                    </div>
                    @if(session('coupon_success'))
                        <div class="coupon-success">{{ session('coupon_success') }}</div>
                    @endif
                    @if(session('coupon_error'))
                        <div class="coupon-error">{{ session('coupon_error') }}</div>
                    @endif
                </div>
            </div>

            {{-- CART ITEMS --}}
            <div class="section">
                <h2>🛒 Order Items ({{ $itemCount }})</h2>
                <div class="cart-items">
                    @foreach($cartItems as $item)
                        <div class="cart-item">
                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}">
                            <div class="cart-item-info">
                                <div class="cart-item-name">{{ $item->product->name }}</div>
                                <div class="cart-item-details">
                                    <div>
                                        <div class="cart-item-price">₹{{ number_format($item->product->price, 0) }}</div>
                                        <div class="cart-item-qty">Qty: {{ $item->quantity }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </form>
        </main>

        {{-- ORDER SUMMARY --}}
        <aside class="summary">
            <h3>Order Summary</h3>
            <div class="summary-row">
                <span>Subtotal ({{ $itemCount }} items)</span>
                <span>₹{{ number_format($subtotal, 0) }}</span>
            </div>
            @if($discount > 0)
                <div class="summary-row discount">
                    <span>Discount</span>
                    <span>-₹{{ number_format($discount, 0) }}</span>
                </div>
            @endif
            <div class="summary-row">
                <span>Delivery Charge</span>
                <span>{{ $deliveryCharge == 0 ? 'FREE' : '₹' . number_format($deliveryCharge, 0) }}</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>₹{{ number_format($total, 0) }}</span>
            </div>
            <button type="submit" form="checkoutForm" class="btn-place" id="placeOrderBtn">
                Place Order
            </button>
        </aside>
</div>
@include('layouts.footer')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Payment method selection
document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.payment-method').forEach(method => {
            method.classList.remove('selected');
        });
        this.closest('.payment-method').classList.add('selected');
    });
});

// Initialize selected payment method
document.querySelector('input[name="payment_method"]:checked').closest('.payment-method').classList.add('selected');

// Apply coupon
function applyCoupon() {
    const code = document.getElementById('couponCode').value.trim();
    if (!code) return;

    const btn = event.target;
    const originalText = btn.textContent;
    btn.disabled = true;
    btn.textContent = 'Applying...';

    fetch('{{ route("coupon.apply") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Coupon response:', data);
        if (data.success) {
            // Update UI without reloading the page
            btn.disabled = false;
            btn.textContent = originalText;
            
            // Show success message
            const couponDiv = document.querySelector('.coupon-section');
            if (couponDiv) {
                const successMsg = document.createElement('div');
                successMsg.className = 'coupon-success';
                successMsg.textContent = data.message;
                couponDiv.appendChild(successMsg);
            }
            
            // Update order summary if data includes updated totals
            if (data.updated_totals) {
                location.reload(); // Only reload if totals are updated
            } else {
                // Clear coupon input
                document.getElementById('couponCode').value = '';
            }
        } else {
            btn.disabled = false;
            btn.textContent = originalText;
            alert(data.message || 'Invalid coupon code');
        }
    })
    .catch(error => {
        console.error('Coupon error:', error);
        btn.disabled = false;
        btn.textContent = originalText;
        alert('Something went wrong: ' + error.message + '. Please try again.');
    });
}

// Handle form submission
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    console.log('Form submission started');
    
    const paymentMethodElement = document.querySelector('input[name="payment_method"]:checked');
    
    if (!paymentMethodElement) {
        console.error('No payment method selected!');
        alert('Please select a payment method (COD or Razorpay)');
        return;
    }
    
    const paymentMethod = paymentMethodElement.value;
    console.log('Payment method selected:', paymentMethod);
    
    const btn = document.getElementById('placeOrderBtn');
    const originalText = btn.textContent;
    
    btn.disabled = true;
    btn.textContent = 'Processing...';
    
    console.log('Button disabled, processing started');
    
    if (paymentMethod === 'razorpay') {
        // Get form data properly - use the form element
        const formElement = document.getElementById('checkoutForm');
        const formData = new FormData(formElement);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        
        // Add payment method explicitly
        data.payment_method = paymentMethod;
        
        console.log('Submitting Razorpay payment:', data);
        
        // Check CSRF token
        console.log('CSRF Token:', CSRF);
        console.log('Route URL:', '{{ route("payment.create-order") }}');
        
        // Submit to PaymentController for Razorpay
        fetch('{{ route("payment.create-order") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Redirect to Razorpay payment page
                console.log('Redirecting to Razorpay with data:', data);
                const redirectUrl = `/payment/razorpay?order_id=${data.order_id}&amount=${data.amount}&key=${data.key}`;
                console.log('Redirect URL:', redirectUrl);
                window.location.href = redirectUrl;
            } else {
                btn.disabled = false;
                btn.textContent = originalText;
                
                // Handle validation errors
                if (data.errors) {
                    let errorMessage = 'Please fix the following errors:\n';
                    for (let field in data.errors) {
                        errorMessage += `- ${data.errors[field][0]}\n`;
                    }
                    alert(errorMessage);
                } else {
                    alert(data.error || 'Payment failed. Please try again.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.textContent = originalText;
            alert('Something went wrong: ' + error.message + '. Please try again.');
        });
    } else {
        // Submit normally for COD
        this.submit();
    }
});

// Handle Enter key in coupon input
document.getElementById('couponCode').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        applyCoupon();
    }
});

// ── Remove from wishlist ────────────────────────────────────────
function removeWishlist(productId, btn) {
    const card = document.getElementById('wcard-' + productId);
    if (card) {
        card.style.transition = 'opacity .3s, transform .3s';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.95)';
    }

    fetch('{{ route("wishlist.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            setTimeout(() => {
                if (card) card.remove();
                // Update counts
                document.getElementById('wishlistCount').textContent = data.count;
                // If empty, reload to show empty state
                if (data.count == 0) location.reload();
            }, 300);
        }
    })
    .catch(() => location.reload());
}

// ── Load wishlist count on page load ───────────────────────────
fetch('{{ route("wishlist.count") }}')
    .then(r => r.json())
    .then(data => {
        const el = document.getElementById('wishlistCount');
        if (el) el.textContent = data.count;
    });
</script>
<script>
function openMenu() {
    document.getElementById("sideMenu").classList.add("active");
    document.getElementById("menuOverlay").classList.add("active");
}

function closeMenu() {
    document.getElementById("sideMenu").classList.remove("active");
    document.getElementById("menuOverlay").classList.remove("active");
}

function toggleWishlist(id, btn){
    fetch("{{ route('wishlist.toggle') }}",{
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":CSRF
        },
        body:JSON.stringify({product_id:id})
    })
    .then(r => r.json())
    .then(d => {
        //  console.log(d);
        if(!d.success) return;

        if(d.status === 'added'){
            // btn.classList.add('wishlisted');
            // btn.innerText = "❤️";
             btn.innerText = "❤️";
             btn.classList.add('wishlisted');
        } else {
            // btn.classList.remove('wishlisted');
            // btn.innerText = "🤍";
              btn.innerText = "🤍";
            btn.classList.remove('wishlisted');
        }

        document.getElementById('wishlistCount').innerText = d.count;
    });
}
 /* =========================
   LOAD COUNTS (WISHLIST + CART)
========================= */
// Load wishlist & cart counts on page load
window.addEventListener('load', () => {
Promise.all([
    fetch('{{ route("wishlist.count") }}').then(r => r.json()),
    fetch('{{ route("cart.count") }}').then(r => r.json())
]).then(([w, c]) => {
        document.getElementById('wishlistCount').textContent = w.count;
        document.getElementById('cartCount').textContent = c.count;
    });
});
</script>
</body>
</html>
