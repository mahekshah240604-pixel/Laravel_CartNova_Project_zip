{{-- resources/views/cart/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CartNova - Shopping Cart</title>
    <style>
       *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--nav:#232f3e;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#EAEDED;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
        a:hover{text-decoration:underline;color:#C45500}

        /* HEADER */
        .hdr{background:var(--hdr);display:flex;align-items:center;gap:10px;padding:8px 16px;flex-wrap:wrap}
        .logo{font-size:1.6rem;font-weight:900;color:#fff;letter-spacing:-1px;font-family:Arial Black,sans-serif;flex-shrink:0}
        .logo span{color:var(--orange)}
        .hdr-search{flex:1;display:flex;border-radius:4px;overflow:hidden;min-width:200px}
        .hdr-search input{flex:1;border:none;padding:8px 12px;font-size:.9rem;outline:none}
        .hdr-search button{background:var(--orange);border:none;padding:0 16px;cursor:pointer;font-size:1.1rem}
        .hdr-right{display:flex;gap:16px;align-items:center;flex-shrink:0}
        .hdr-link{color:#fff;font-size:.85rem;line-height:1.3}
        .hdr-link span{display:block;color:#ccc;font-size:.72rem}

         /* NAV */
        .nav{background:var(--nav);display:flex;align-items:center;padding:6px 16px;gap:2px}
        .nav a{color:#fff;font-size:.85rem;padding:5px 10px;border-radius:2px;border:1px solid transparent}
        .nav a:hover,.nav a.active{border-color:#fff;text-decoration:none}

        /* BREADCRUMB */
        .breadcrumb{background:var(--white);padding:8px 16px;font-size:.8rem;color:var(--muted);border-bottom:1px solid var(--border)}
        .breadcrumb a{color:var(--link)}
        /* PAGE LAYOUT */
        .page{max-width:1200px;margin:16px auto;padding:0 16px;display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap}

        /* CART MAIN */
        .cart-main{flex:1;min-width:0}

        /* CART HEADER */
        .cart-header{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:16px 20px;margin-bottom:12px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
        .cart-header h1{font-size:1.5rem;font-weight:400}
        .cart-header .price-col{color:var(--muted);font-size:.85rem;text-align:right}

        /* ALERT */
        .alert{padding:10px 16px;border-radius:4px;margin-bottom:12px;font-size:.875rem;border:1px solid}
        .alert-success{background:#f0fff4;border-color:var(--green);color:var(--green)}
        .alert-error{background:#fff8f8;border-color:var(--error);color:var(--error)}

        /* CART ITEM */
        .cart-item{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:16px;margin-bottom:8px;display:flex;gap:16px;align-items:flex-start;transition:opacity .3s}
        .cart-item.removing{opacity:0}
        .item-img{width:100px;height:100px;object-fit:contain;flex-shrink:0;border:1px solid var(--border);border-radius:4px;padding:4px;background:#fff}
        .item-body{flex:1;min-width:0}
        .item-name{font-size:.95rem;font-weight:400;color:var(--text);margin-bottom:4px;line-height:1.4}
        .item-name:hover{color:var(--orange)}
        .item-brand{font-size:.8rem;color:var(--muted);margin-bottom:4px}
        .item-stock{font-size:.8rem;color:var(--green);font-weight:700;margin-bottom:8px}
        .item-prime{display:inline-block;background:#00a8e0;color:#fff;font-size:.65rem;font-weight:700;padding:2px 5px;border-radius:2px;margin-bottom:6px}
        .item-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-top:8px}
        .qty-select{border:1px solid var(--border);border-radius:4px;padding:4px 8px;font-size:.85rem;cursor:pointer;background:linear-gradient(to bottom,#f7f8f8,#e7e9ea);outline:none}
        .qty-select:focus{border-color:var(--orange)}
        .btn-action{background:none;border:none;color:var(--link);font-size:.85rem;cursor:pointer;padding:4px 0;font-family:inherit}
        .btn-action:hover{color:#C45500;text-decoration:underline}
        .btn-action.delete{color:var(--error)}
        .divider-v{color:var(--border);font-size:.85rem}
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

        /* ITEM PRICE */
        .item-price{text-align:right;flex-shrink:0;min-width:90px}
        .item-price .amount{font-size:1.1rem;font-weight:700}
        .item-price .original{font-size:.78rem;color:var(--muted);text-decoration:line-through;display:block}
        .item-price .saved{font-size:.78rem;color:var(--green)}

        /* EMPTY CART */
        .empty-cart{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:40px;text-align:center}
        .empty-cart h2{font-size:1.2rem;font-weight:400;margin-bottom:8px}
        .empty-cart p{color:var(--muted);font-size:.9rem;margin-bottom:16px}
        .btn-shop{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border:1px solid #a88734;border-radius:4px;padding:8px 20px;font-size:.9rem;font-weight:700;cursor:pointer;font-family:inherit;color:var(--text)}
        .btn-shop:hover{filter:brightness(1.04)}

        /* SUBTOTAL SIDEBAR */
        .cart-sidebar{width:280px;flex-shrink:0;position:sticky;top:16px}
        .summary-box{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:18px}
        .summary-box h3{font-size:.95rem;margin-bottom:14px}
        .summary-box h3 span{color:var(--green)}
        .summary-row{display:flex;justify-content:space-between;font-size:.85rem;margin-bottom:8px;color:var(--text)}
        .summary-row.discount{color:var(--green)}
        .summary-row.free{color:var(--green)}
        .summary-divider{border:none;border-top:1px solid var(--border);margin:10px 0}
        .summary-total{display:flex;justify-content:space-between;font-size:1rem;font-weight:700;margin-bottom:16px}
        .summary-total span:last-child{font-size:1.2rem}
        .btn-checkout{width:100%;background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border:1px solid #a88734;border-radius:20px;padding:10px;font-size:.95rem;font-weight:700;cursor:pointer;font-family:inherit;color:var(--text);transition:filter .12s}
        .btn-checkout:hover{filter:brightness(1.04)}
        .summary-note{font-size:.75rem;color:var(--muted);text-align:center;margin-top:10px}
        .btn-clear{width:100%;background:none;border:1px solid var(--border);border-radius:4px;padding:7px;font-size:.82rem;cursor:pointer;font-family:inherit;color:var(--muted);margin-top:8px}
        .btn-clear:hover{background:#f7f7f7;color:var(--error);border-color:var(--error)}

        /* CONTINUE SHOPPING */
        .continue{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:12px 16px;margin-top:8px;font-size:.85rem}

        footer{background:var(--hdr);color:#ccc;text-align:center;padding:16px;margin-top:auto}
        .foot-links{display:flex;justify-content:center;flex-wrap:wrap;gap:6px 20px;margin-bottom:8px}
        .foot-links a{color:#ccc;font-size:.78rem}
        .foot-copy{font-size:.75rem;color:#888}

        @media(max-width:768px){
            .page{flex-direction:column}
            .cart-sidebar{width:100%;position:static}
        }
    </style>
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
{{-- BREADCRUMB --}}
<div class="breadcrumb">
    <a href="{{ route('home') }}">🏠Home</a> ›
    <a href="{{ route('products.index') }}">🛍️Products</a> ›
    🛒Shopping Cart
    ›<a href="{{ route('orders.index') }}">📦My Order</a> 
     
</div>

<div class="page">

    {{-- CART MAIN --}}
    <div class="cart-main">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        {{-- Cart Header --}}
        <div class="cart-header">
            <h1>Shopping Cart</h1>
            @if($cartItems->count() > 0)
                <div class="price-col">Price</div>
            @endif
        </div>

        @if($cartItems->count() > 0)

            {{-- Cart Items --}}
            @foreach($cartItems as $item)
                <div class="cart-item" id="cart-item-{{ $item->id }}">

                    {{-- Image --}}
                    <a href="{{ route('products.show', $item->product->id) }}">
                        <img class="item-img"
                             src="{{ asset($item->product->image) }}"
                             alt="{{ $item->product->name }}"
                             onerror="this.onerror=null;this.src='{{ asset('images/products/placeholder.png') }}'">
                    </a>

                    {{-- Details --}}
                    <div class="item-body">
                        @if($item->product->is_prime)
                            <span class="item-prime">⚡ prime</span>
                        @endif
                        <a href="{{ route('products.show', $item->product->id) }}" class="item-name">
                            {{ $item->product->name }}
                        </a>
                        <div class="item-brand">by {{ $item->product->brand }}</div>
                        <div class="item-stock">In Stock</div>

                        {{-- Actions --}}
                        <div class="item-actions">
                            {{-- Quantity --}}
                            <select class="qty-select"
                                    data-item-id="{{ $item->id }}"
                                    onchange="updateQty(this)">
                                @for($q = 1; $q <= min($item->product->stock, 10); $q++)
                                    <option value="{{ $q }}" {{ $item->quantity == $q ? 'selected' : '' }}>
                                        Qty: {{ $q }}
                                    </option>
                                @endfor
                            </select>

                            <span class="divider-v">|</span>

                            {{-- Delete --}}
                            <button class="btn-action delete"
                                    onclick="removeItem({{ $item->id }}, this)">
                                Delete
                            </button>

                            <span class="divider-v">|</span>

                            {{-- Save for Later --}}
                            {{-- <button class="btn-action">Save for later</button> --}}
                            <form action="{{ route('cart.save', $item->product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-action">
                                   💾 Save for later
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="item-price">
                        <span class="amount" id="item-subtotal-{{ $item->id }}">
                            ₹{{ number_format($item->quantity * $item->product->price, 0) }}
                        </span>
                        @if($item->product->original_price)
                            <span class="original">₹{{ number_format($item->product->original_price, 0) }}</span>
                            <span class="saved">Save {{ $item->product->discount }}%</span>
                        @endif
                    </div>
                </div>
            @endforeach

            {{-- Subtotal at bottom --}}
            <div style="background:var(--white);border:1px solid var(--border);border-radius:4px;padding:14px 20px;text-align:right;font-size:1rem">
                {{-- Subtotal ({{ $itemCount }} {{ Str::plural('item', $itemCount) }}): --}}
                Subtotal (<span id="itemCountText">{{ $itemCount }}</span> items):
                <strong style="font-size:1.1rem" id="subtotal-bottom">₹{{ number_format($subtotal, 0) }}</strong>
            </div>

        @else
            {{-- Empty Cart --}}
            <div class="empty-cart">
                <div style="font-size:3rem;margin-bottom:12px">🛒</div>
                <h2>Your CartNova Cart is empty</h2>
                <p>Shop today's deals</p>
                <a href="{{ route('products.index') }}">
                    <button class="btn-shop">Continue Shopping</button>
                </a>
            </div>
        @endif

        {{-- Continue Shopping --}}
        <div class="continue">
            <a href="{{ route('products.index') }}">← Continue Shopping</a>
        </div>

    </div>

    {{-- SIDEBAR SUMMARY --}}
    @if($cartItems->count() > 0)
    <aside class="cart-sidebar">
        <div class="summary-box">

            {{-- Free delivery notice --}}
            <h3>
                @if($delivery == 0)
                    ✅ Your order qualifies for <span>FREE Delivery</span>
                @else
                    Add ₹{{ 499 - $subtotal }} more for FREE Delivery
                @endif
            </h3>

            <div class="summary-row">
                <span>Subtotal ({{ $itemCount }} {{ Str::plural('item', $itemCount) }})</span>
                <span id="summary-subtotal">₹{{ number_format($subtotal, 0) }}</span>
            </div>

            @if($discount > 0)
            <div class="summary-row discount">
                <span>Discount savings</span>
                <span>-₹{{ number_format($discount, 0) }}</span>
            </div>
            @endif

            <div class="summary-row {{ $delivery == 0 ? 'free' : '' }}">
                <span>Delivery</span>
                <span id="summary-delivery">{{ $delivery == 0 ? 'FREE' : '₹'.$delivery }}</span>
            </div>

            <hr class="summary-divider">

            <div class="summary-total">
                <span>Order Total</span>
                <span id="summary-total">₹{{ number_format($total, 0) }}</span>
            </div>

            {{-- <button class="btn-checkout" onclick="handleCheckout()">
                Proceed to Checkout
            </button> --}}
            {{-- ✅ AFTER — direct hyperlink to checkout page --}}
            <a href="{{ route('checkout.index') }}" class="btn-checkout"
            style="display:block;text-align:center;text-decoration:none;color:var(--text)">
                Proceed to Checkout
            </a>

            <p class="summary-note">🔒 Secure checkout</p>

            {{-- Clear Cart --}}
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="btn-clear"
                        onclick="return confirm('Clear entire cart?')">
                    🗑 Clear entire cart
                </button>
            </form>
        </div>
    </aside>
    @endif

</div>

<footer>
    <div class="foot-links">
        <a href="{{ route('conditions') }}">⚖️ Conditions of Use</a>
        <a href="{{ route('privacy') }}">🔒 Privacy Notice</a>
        <a href="{{ route('help') }}">💬 Help</a>
        <a href="{{ route('careers') }}">💼 Careers</a>
        <a href="{{ route('press') }}">📰 Press Releases</a>
    </div>
    <p class="foot-copy">© 1996–2025, CartNova.com, Inc. or its affiliates</p>
</footer>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ── Update Quantity ──────────────────────────────────────────
function updateQty(select) {
    const itemId = select.dataset.itemId;
    const qty    = select.value;

    fetch('{{ route("cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ cart_item_id: itemId, quantity: qty })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Update item subtotal
            const itemSub = document.getElementById('item-subtotal-' + itemId);
            if (itemSub) itemSub.textContent = data.item_subtotal;

            // Update summary
            document.getElementById('summary-subtotal').textContent  = data.subtotal;
            document.getElementById('summary-delivery').textContent  = data.delivery;
            document.getElementById('summary-total').textContent     = data.total;
            document.getElementById('subtotal-bottom').textContent   = data.subtotal;
            document.getElementById('cartCount').textContent         = data.item_count;
        }
    })
    .catch(() => location.reload());
}

// ── Remove Item ──────────────────────────────────────────────
function removeItem(itemId, btn) {
    const row = document.getElementById('cart-item-' + itemId);
    row.classList.add('removing');

    fetch('{{ route("cart.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ cart_item_id: itemId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            setTimeout(() => {
                row.remove();
               document.getElementById('cartCount').textContent = data.count;
               document.getElementById('itemCountText').textContent = data.count;      
            // document.getElementById('cartCount').textContent = data.count;

            // const itemText = document.getElementById('itemCountText');
            // if (itemText) {
            //     itemText.textContent = data.count;
            // }
                document.getElementById('summary-subtotal').textContent = data.subtotal;
                document.getElementById('summary-delivery').textContent = data.delivery;
                document.getElementById('summary-total').textContent = data.total;
                document.getElementById('subtotal-bottom').textContent = data.subtotal;
                // Reload if cart empty
                if (data.count == 0) location.reload();
            }, 300);
        }
    })
    .catch(() => location.reload());
}

// ── Checkout ─────────────────────────────────────────────────
function handleCheckout() {
    alert('Checkout coming soon! 🚀');
}
</script>
<script>
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