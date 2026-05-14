{{-- resources/views/checkout/success.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova - Order Placed!</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--nav:#232f3e;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#EAEDED;--white:#fff;--green:#007600;--error:#CC0C39}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px}
        a{text-decoration:none;color:var(--link)}
        a:hover{text-decoration:underline;color:#C45500}
        .hdr{background:var(--hdr);display:flex;align-items:center;gap:16px;padding:8px 16px}
        .logo{font-size:1.6rem;font-weight:900;color:#fff;letter-spacing:-1px;font-family:Arial Black,sans-serif}
        .logo span{color:var(--orange)}
        .nav{background:var(--nav);padding:6px 16px;display:flex;gap:2px}
        .nav a{color:#fff;font-size:.85rem;padding:5px 10px;border-radius:2px;border:1px solid transparent}
        .nav a:hover{border-color:#fff;text-decoration:none}


        .breadcrumb{padding:8px 16px;font-size:.8rem;color:var(--muted);background:var(--white);border-bottom:1px solid var(--border)}
        .breadcrumb a{color:var(--link)}

        .page{max-width:900px;margin:20px auto;padding:0 16px;flex:1}

        /* SUCCESS BANNER */
        .success-banner{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:24px 28px;margin-bottom:16px;display:flex;align-items:flex-start;gap:16px}
        .check-circle{width:52px;height:52px;background:var(--green);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.6rem;color:#fff}
        .success-text h1{font-size:1.3rem;font-weight:700;color:var(--green);margin-bottom:4px}
        .success-text p{font-size:.88rem;color:var(--muted);line-height:1.6}
        .order-num{font-size:.9rem;color:var(--text);margin-top:6px}
        .order-num strong{color:var(--link)}

        /* ORDER DETAILS */
        .order-card{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:20px;margin-bottom:14px}
        .order-card h2{font-size:1rem;font-weight:700;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid var(--border)}

        /* DELIVERY INFO */
        .delivery-timeline{display:flex;align-items:center;gap:0;margin-bottom:16px;flex-wrap:wrap}
        .d-step{flex:1;text-align:center;position:relative;min-width:80px}
        .d-step .d-icon{width:36px;height:36px;border-radius:50%;background:#f0f0f0;display:flex;align-items:center;justify-content:center;margin:0 auto 6px;font-size:1.1rem;border:2px solid var(--border)}
        .d-step.done .d-icon{background:var(--green);border-color:var(--green);color:#fff}
        .d-step.active .d-icon{background:var(--orange);border-color:var(--orange);color:#fff}
        .d-step .d-label{font-size:.72rem;color:var(--muted)}
        .d-step.done .d-label,.d-step.active .d-label{color:var(--text);font-weight:700}
        .d-line{flex:1;height:2px;background:var(--border);min-width:20px}
        .d-line.done{background:var(--green)}

        /* ADDRESS + PAYMENT */
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
        .info-box{background:#f9f9f9;border-radius:4px;padding:14px}
        .info-box h3{font-size:.85rem;font-weight:700;margin-bottom:8px;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
        .info-box p{font-size:.875rem;line-height:1.7;color:var(--text)}

        /* ORDER ITEMS */
        .order-item{display:flex;gap:14px;padding:12px 0;border-bottom:1px solid #f0f0f0;align-items:center}
        .order-item:last-child{border-bottom:none}
        .order-item img{width:65px;height:65px;object-fit:contain;border:1px solid var(--border);border-radius:4px;padding:4px;background:#fff}
        .order-item-info{flex:1}
        .order-item-name{font-size:.88rem;font-weight:400;margin-bottom:3px}
        .order-item-brand{font-size:.78rem;color:var(--muted)}
        .order-item-qty{font-size:.78rem;color:var(--muted)}
        .order-item-price{font-size:.9rem;font-weight:700;white-space:nowrap}

        /* PRICE SUMMARY */
        .price-summary{background:#f9f9f9;border-radius:4px;padding:14px}
        .price-row{display:flex;justify-content:space-between;font-size:.85rem;margin-bottom:7px}
        .price-row.green{color:var(--green)}
        hr.pdiv{border:none;border-top:1px solid var(--border);margin:8px 0}
        .price-total{display:flex;justify-content:space-between;font-size:1rem;font-weight:700}

        /* ACTION BUTTONS */
        .actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:4px}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border:1px solid #a88734;border-radius:4px;padding:9px 20px;font-size:.9rem;font-weight:700;cursor:pointer;font-family:inherit;color:var(--text);text-decoration:none;display:inline-block}
        .btn-primary:hover{filter:brightness(1.04);text-decoration:none;color:var(--text)}
        .btn-secondary{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:9px 20px;font-size:.9rem;cursor:pointer;font-family:inherit;color:var(--text);text-decoration:none;display:inline-block}
        .btn-secondary:hover{background:#f7f7f7;text-decoration:none;color:var(--text)}

        .hdr-right {
    display: flex;
    align-items: center;
    gap: 18px;
    margin-left: auto;
}

.hdr-link {
    color: #fff;
    font-size: .85rem;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

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

        footer{background:var(--hdr);color:#ccc;text-align:center;padding:16px;margin-top:auto}
        .foot-links{display:flex;justify-content:center;flex-wrap:wrap;gap:6px 20px;margin-bottom:8px}
        .foot-links a{color:#ccc;font-size:.78rem}
        .foot-copy{font-size:.75rem;color:#888}

      @media(max-width:700px){
            .page{flex-direction:column}
            .product-img-wrap,.buy-box{width:100%}
            .related-grid{grid-template-columns:repeat(2,1fr)}
        }
    </style>
</head>
<body>

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
<div class="breadcrumb">
    <a href="{{ route('home') }}">🏠Home</a> ›
    <a href="{{ route('products.index') }}">🏬Products</a> ›
    {{-- <a href="{{ route('products.index', ['category'=>$product->category]) }}">📂{{ $product->category }}</a> ›
    {{ Str::limit($product->name, 50) }} --}}
</div>
<div class="page">

    {{-- SUCCESS BANNER --}}
    <div class="success-banner">
        <div class="check-circle">✓</div>
        <div class="success-text">
            <h1>Order placed, thank you!</h1>
            <p>Confirmation will be sent to <strong>{{ auth()->user()->email }}</strong></p>
            <div class="order-num">
                Order #: <strong>{{ $order->order_number }}</strong>
                &nbsp;|&nbsp;
                {{-- Placed on: {{ $order->placed_at->format('d M Y, h:i A') }} --}}
                Placed on: {{ $order->placed_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}
            </div>
        </div>
    </div>

    {{-- DELIVERY TIMELINE --}}
    <div class="order-card">
        <h2>📦 Delivery Status</h2>
        <div class="delivery-timeline">
            <div class="d-step done">
                <div class="d-icon">✓</div>
                <div class="d-label">Order Placed</div>
            </div>
            <div class="d-line done"></div>
            <div class="d-step {{ in_array($order->status, ['confirmed','shipped','delivered']) ? 'done' : '' }}">
                <div class="d-icon">✓</div>
                <div class="d-label">Confirmed</div>
            </div>
            <div class="d-line {{ in_array($order->status, ['shipped','delivered']) ? 'done' : '' }}"></div>
            <div class="d-step {{ in_array($order->status, ['shipped','delivered']) ? ($order->status == 'shipped' ? 'active' : 'done') : '' }}">
                <div class="d-icon">🚚</div>
                <div class="d-label">Shipped</div>
            </div>
            <div class="d-line {{ $order->status == 'delivered' ? 'done' : '' }}"></div>
            <div class="d-step {{ $order->status == 'delivered' ? 'done' : '' }}">
                <div class="d-icon">🏠</div>
                <div class="d-label">Delivered</div>
            </div>
        </div>

        {{-- <p style="font-size:.85rem;color:var(--muted)">
            @if($order->payment_method == 'cod')
                💵 <strong>Cash on Delivery</strong> — Pay ₹{{ number_format($order->total, 0) }} when your order arrives.
            @elseif($order->payment_method == 'upi')
                📱 <strong>UPI Payment</strong> — Payment confirmed. ✓
            @else
                💳 <strong>Card Payment</strong> — Payment confirmed. ✓
            @endif
        </p> --}}
        {{-- Current status explanation --}}
        <div style="margin-top:14px;background:#f9f9f9;border-radius:6px;padding:12px 16px;font-size:.85rem">
            @switch($order->status)
                @case('confirmed')
                    <div style="color:#007600;font-weight:700;margin-bottom:4px">✅ Your order is confirmed!</div>
                    <div style="color:#565959">Our team is preparing your order. You will be notified when it ships.</div>
                    @break
                @case('shipped')
                    <div style="color:#0066C0;font-weight:700;margin-bottom:4px">🚚 Your order is on its way!</div>
                    <div style="color:#565959">Your order has been shipped and will be delivered soon.</div>
                    @break
                @case('delivered')
                    <div style="color:#007600;font-weight:700;margin-bottom:4px">🏠 Your order has been delivered!</div>
                    <div style="color:#565959">We hope you love your purchase! You can leave a review on the product page.</div>
                    @break
                @case('cancelled')
                    <div style="color:#CC0C39;font-weight:700;margin-bottom:4px">❌ This order has been cancelled.</div>
                    <div style="color:#565959">@if($order->payment_method != 'cod') Refund will be initiated within 5-7 business days. @endif</div>
                    @break
                @default
                    <div style="color:#856404;font-weight:700;margin-bottom:4px">🕐 Order is being processed...</div>
                    <div style="color:#565959">Your order is pending confirmation. You will receive an update shortly.</div>
            @endswitch
        </div>
 
        {{-- Payment info --}}
        <div style="margin-top:10px;font-size:.85rem;color:#565959;border-top:1px solid #eee;padding-top:10px">
            @if($order->payment_method == 'cod')
                💵 <strong>Cash on Delivery</strong> — Please keep <strong>₹{{ number_format($order->total, 0) }}</strong> ready at the time of delivery.
            @elseif($order->payment_method == 'razorpay')
                💳 <strong>Online Payment</strong> — Payment of ₹{{ number_format($order->total, 0) }} confirmed. ✓
                @if($order->razorpay_payment_id)
                    <div style="font-size:.78rem;color:#888;margin-top:2px">Txn ID: {{ $order->razorpay_payment_id }}</div>
                @endif
            @else
                💳 <strong>Card Payment</strong> — Payment confirmed. ✓
            @endif
        </div>
 
        {{-- Admin note --}}
        <div style="margin-top:10px;background:#fff3cd;border:1px solid #ffc107;border-radius:4px;padding:8px 12px;font-size:.78rem;color:#856404">
            ℹ️ <strong>Status Updates:</strong> Your order status will be updated by our team. You will receive a notification when your order is shipped and delivered. Track your order in <a href="{{ route('orders.show', $order->order_number) }}" style="color:#004085;font-weight:700">My Orders</a>.
        </div>
    </div>

    {{-- ADDRESS + PAYMENT --}}
    <div class="order-card">
        <h2>📋 Order Information</h2>
        <div class="info-grid">
            <div class="info-box">
                <h3>📍 Shipping Address</h3>
                <p>
                    <strong>{{ $order->full_name }}</strong><br>
                    {{ $order->address_line1 }}<br>
                    @if($order->address_line2){{ $order->address_line2 }}<br>@endif
                    {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}<br>
                    📞 {{ $order->phone }}
                </p>
            </div>
            <div class="info-box">
                <h3>💳 Payment</h3>
                <p>
                    <strong>{{ $order->payment_label }}</strong><br>
                    Status:
                    @if($order->payment_status == 'paid')
                        <span style="color:var(--green);font-weight:700">✓ Paid</span>
                    @else
                        <span style="color:var(--orange);font-weight:700">Pay on Delivery</span>
                    @endif
                    <br><br>
                    Order Total: <strong>₹{{ number_format($order->total, 0) }}</strong>
                </p>
            </div>
        </div>
    </div>

    {{-- ORDER ITEMS --}}
    <div class="order-card">
        <h2>🛍️ Items Ordered ({{ $order->items->count() }})</h2>

        @foreach($order->items as $item)
            <div class="order-item">
                <img src="{{ asset($item->product_image) }}"
                     alt="{{ $item->product_name }}"
                     onerror="this.onerror=null;this.src='{{ asset('images/products/placeholder.png') }}'">
                <div class="order-item-info">
                    <div class="order-item-name">{{ $item->product_name }}</div>
                    <div class="order-item-brand">by {{ $item->product_brand }}</div>
                    <div class="order-item-qty">Qty: {{ $item->quantity }}</div>
                </div>
                <div class="order-item-price">₹{{ number_format($item->subtotal, 0) }}</div>
            </div>
        @endforeach

        {{-- Price Summary --}}
        <div class="price-summary" style="margin-top:14px">
            <div class="price-row">
                <span>Items Subtotal</span>
                <span>₹{{ number_format($order->subtotal, 0) }}</span>
            </div>
            @if($order->discount > 0)
            <div class="price-row green">
                <span>Discount Savings</span>
                <span>-₹{{ number_format($order->discount, 0) }}</span>
            </div>
            @endif
            <div class="price-row {{ $order->delivery_charge == 0 ? 'green' : '' }}">
                <span>Delivery Charges</span>
                <span>{{ $order->delivery_charge == 0 ? 'FREE' : '₹'.$order->delivery_charge }}</span>
            </div>
            <hr class="pdiv">
            <div class="price-total">
                <span>Order Total</span>
                <span>₹{{ number_format($order->total, 0) }}</span>
            </div>
            @if($order->discount > 0)
            <p style="color:var(--green);font-size:.82rem;margin-top:8px;text-align:center;font-weight:700">
                🎉 You saved ₹{{ number_format($order->discount, 0) }} on this order!
            </p>
            @endif
        </div>
    </div>

    {{-- ACTION BUTTONS --}}
    <div class="actions">
        <a href="{{ route('products.index') }}" class="btn-primary">Continue Shopping</a>
        <a href="{{ route('orders.index') }}" class="btn-secondary">Go to Order History </a>
    </div>

</div>

@include('layouts.footer')
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