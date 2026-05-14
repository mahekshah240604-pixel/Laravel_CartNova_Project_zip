{{-- resources/views/addresses/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova  - Your Addresses</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--nav:#232f3e;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#EAEDED;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
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
        .page{max-width:960px;margin:20px auto;padding:0 16px;flex:1;width:100%}
        .alert{padding:10px 16px;border-radius:4px;margin-bottom:14px;font-size:.875rem;border:1px solid}
        .alert-success{background:#f0fff4;border-color:var(--green);color:var(--green)}
        .alert-error{background:#fff8f8;border-color:var(--error);color:var(--error)}
        .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:10px}
        .page-header h1{font-size:1.5rem;font-weight:400}
        .btn{display:inline-block;padding:8px 18px;border-radius:4px;font-size:.875rem;cursor:pointer;font-family:inherit;border:1px solid;text-decoration:none;transition:filter .12s}
        .btn:hover{filter:brightness(1.04);text-decoration:none}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border-color:#a88734;color:var(--text);font-weight:700}
        .btn-sm{padding:5px 12px;font-size:.8rem}
        .btn-outline{background:var(--white);border-color:var(--link);color:var(--link)}
        .btn-danger{background:var(--white);border-color:var(--error);color:var(--error)}
        .btn-danger:hover{background:#fff8f8}

        /* ADDRESS GRID */
        .addr-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px}

        /* ADD NEW CARD */
        .add-card{border:2px dashed var(--border);border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:30px 20px;text-align:center;cursor:pointer;transition:border-color .15s,background .15s;min-height:200px;text-decoration:none;color:var(--muted)}
        .add-card:hover{border-color:var(--orange);background:#fffdf7;text-decoration:none;color:var(--orange)}
        .add-card .plus{font-size:2.5rem;margin-bottom:8px;line-height:1}
        .add-card .label{font-size:.9rem;font-weight:700}

        /* ADDRESS CARD */
        .addr-card{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:18px;display:flex;flex-direction:column;gap:8px;position:relative;transition:box-shadow .15s}
        .addr-card:hover{box-shadow:0 3px 12px rgba(0,0,0,.1)}
        .addr-card.default{border-color:var(--orange);border-width:2px}

        /* DEFAULT BADGE */
        .default-badge{display:inline-flex;align-items:center;gap:4px;background:#fff3cd;border:1px solid var(--orange);color:#856404;border-radius:10px;padding:2px 10px;font-size:.72rem;font-weight:700;margin-bottom:4px;width:fit-content}

        /* TYPE BADGE */
        .type-badge{display:inline-block;font-size:.75rem;color:var(--muted);background:#f5f5f5;border-radius:3px;padding:2px 7px;font-weight:700;margin-bottom:6px}

        .addr-name{font-size:.95rem;font-weight:700;color:var(--text)}
        .addr-line{font-size:.85rem;color:var(--muted);line-height:1.6}
        .addr-phone{font-size:.82rem;color:var(--muted);margin-top:2px}

        /* CARD ACTIONS */
        .addr-actions{display:flex;gap:6px;flex-wrap:wrap;margin-top:6px;padding-top:10px;border-top:1px solid #f5f5f5}

        /* EMPTY STATE */
        .empty{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:50px 20px;text-align:center}
        .empty h2{font-size:1.1rem;font-weight:400;margin-bottom:8px}
        .empty p{color:var(--muted);margin-bottom:16px}

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
        .foot-copy{font-size:.75rem;color:#888}
        @media(max-width:480px){.addr-grid{grid-template-columns:1fr}}
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


<div class="breadcrumb">
    <a href="{{ route('home') }}">🏠Home</a> ›
    <a href="{{ route('profile.index') }}">👤Your Account</a> ›
    Your Addresses
</div>

<div class="page">

    @if(session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <h1>📍 Your Addresses</h1>
        <a href="{{ route('addresses.create') }}" class="btn btn-primary">+ Add New Address</a>
    </div>

    <div class="addr-grid">

        {{-- ADD NEW CARD --}}
        <a href="{{ route('addresses.create') }}" class="add-card">
            <div class="plus">＋</div>
            <div class="label">Add a new address</div>
        </a>

        {{-- ADDRESS CARDS --}}
        @foreach($addresses as $address)
        <div class="addr-card {{ $address->is_default ? 'default' : '' }}">

            @if($address->is_default)
                <div class="default-badge">⭐ Default Address</div>
            @endif

            <div class="type-badge">{{ $address->type_label }}</div>
            <div class="addr-name">{{ $address->full_name }}</div>
            <div class="addr-line">
                {{ $address->address_line1 }}<br>
                @if($address->address_line2){{ $address->address_line2 }}<br>@endif
                {{ $address->city }}, {{ $address->state }}<br>
                {{ $address->pincode }}
            </div>
            <div class="addr-phone">📞 {{ $address->phone }}</div>

            <div class="addr-actions">
                <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-sm btn-outline">Edit</a>

                @if(!$address->is_default)
                    <form action="{{ route('addresses.default', $address->id) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm"
                                style="border-color:#a88734;background:linear-gradient(to bottom,#f7dfa5,#f0c14b);color:var(--text)">
                            Set Default
                        </button>
                    </form>
                    <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('Delete this address?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach

    </div>

    @if($addresses->isEmpty())
        <div class="empty" style="margin-top:14px">
            <div style="font-size:3rem;margin-bottom:12px">📍</div>
            <h2>No addresses saved</h2>
            <p>Add an address to make checkout faster.</p>
            <a href="{{ route('addresses.create') }}" class="btn btn-primary">Add Your First Address</a>
        </div>
    @endif

    <div style="margin-top:20px">
        <a href="{{ route('profile.index') }}" style="font-size:.875rem;color:var(--link)">← Back to Account</a>
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