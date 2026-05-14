
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova.com - Welcome</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --orange: #FF9900;
            --header-dark: #131921;
            --header-mid: #232f3e;
            --text: #0F1111;
            --muted: #565959;
            --link: #007185;
            --border: #ddd;
            --bg: #EAEDED;
            --white: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a { text-decoration: none; color: var(--link); }
        a:hover { text-decoration: underline; color: #C45500; }

        /* ── HEADER ── */
        .hdr {
            background: var(--header-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            flex-wrap: wrap;

            overflow: visible;
        }

        .logo {
            font-size: 1.6rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -1px;
            font-family: Arial Black, sans-serif;
            margin-right: 6px;
            flex-shrink: 0;
        }
        .logo span { color: var(--orange); }

        .hdr-deliver {
            flex: 1;
            color: #ccc;
            font-size: .75rem;
            line-height: 1.3;
            min-width: 80px;
        }
        .hdr-deliver strong { color: #fff; font-size: .8rem; }

        .hdr-search {
            flex: 4;
            display: flex;
            border-radius: 4px;
            overflow: hidden;
            min-width: 180px;
        }
        .hdr-search select {
            background: #f3f3f3;
            border: none;
            padding: 0 6px;
            font-size: .75rem;
            cursor: pointer;
            border-right: 1px solid #cdcdcd;
            max-width: 80px;
        }
        .hdr-search input {
            flex: 1;
            border: none;
            padding: 8px 10px;
            font-size: .9rem;
            outline: none;
        }
        .hdr-search button {
            background: var(--orange);
            border: none;
            padding: 0 14px;
            cursor: pointer;
            font-size: 1.1rem;
        }
        .hdr-search button:hover { background: #e68a00; }

        .hdr-account {
            color: #fff;
            font-size: .8rem;
            line-height: 1.4;
            flex-shrink: 0;
            text-align: center;
            position: relative;
             z-index: 1;

        }
        .hdr-account span { display: block; color: #ccc; font-size: .72rem; }
        .hdr-account strong { font-size: .85rem; }
        /* link wrapper */
        .hdr-cart-link {
            text-decoration: none;
            color: inherit;
        }

        /* hover effect 🔥 */
        .hdr-cart-link:hover {
            text-decoration: none;
            opacity: 0.85;
        }

        .hdr-cart {
            color: #fff;
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: .85rem;
            font-weight: 700;
            flex-shrink: 0;
            position: relative;
        }
        .hdr-cart svg { color: var(--orange); }
        .cart-count {
            position: absolute;
            top: -6px;
            right: -10px;
            background: var(--orange);
            color: #000;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 11px;
            font-weight: bold;
        }

        /* ── NAV BAR ── */
        .nav {
            background: var(--header-mid);
            display: flex;
            align-items: center;
            padding: 6px 16px;
            gap: 4px;
            overflow-x: auto;
        }
        .nav a {
            color: #fff;
            font-size: .85rem;
            padding: 4px 8px;
            white-space: nowrap;
            border-radius: 2px;
            border: 1px solid transparent;
        }
        .nav a:hover {
            border-color: #fff;
            text-decoration: none;
        }
        .nav-all {
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 700 !important;
        }

        /* ── ALERT ── */
        .alert-success {
            background: #fff;
            border: 1px solid #007600;
            border-left: 4px solid #007600;
            color: #007600;
            padding: 10px 16px;
            margin: 10px 16px;
            border-radius: 4px;
            font-size: .875rem;
        }

        /* ── HERO BANNER ── */
        .hero {
            background: linear-gradient(135deg, #232f3e 0%, #37475a 50%, #131921 100%);
            color: #fff;
            padding: 30px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 70% 50%, rgba(255,153,0,.15) 0%, transparent 60%);
        }
        .hero-content { position: relative; z-index: 1; max-width: 600px; margin: 0 auto; }
        .hero h1 { font-size: 1.6rem; margin-bottom: 8px; }
        .hero h1 span { color: var(--orange); }
        .hero p { color: #ccc; margin-bottom: 18px; font-size: .95rem; }
        .hero-btn {
            display: inline-block;
            background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
            border: 1px solid #a88734;
            border-radius: 4px;
            padding: 10px 28px;
            font-size: .95rem;
            font-weight: 700;
            color: var(--text);
            cursor: pointer;
        }
        .hero-btn:hover { filter: brightness(1.05); text-decoration: none; color: var(--text); }

        /* ── MAIN CONTENT ── */
        .main {
            flex: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px;
            width: 100%;
        }

        /* ── ACCOUNT CARD ── */
        .account-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
        }
        .account-info { display: flex; align-items: center; gap: 14px; }
        .avatar {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, var(--header-mid), var(--header-dark));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.4rem; font-weight: 700;
            flex-shrink: 0;
        }
        .account-text h2 { font-size: 1.1rem; font-weight: 700; margin-bottom: 2px; }
        .account-text p { font-size: .8rem; color: var(--muted); }
        .account-text .email { color: var(--link); font-size: .8rem; }

        .account-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-outline {
            border: 1px solid #a88734;
            background: linear-gradient(to bottom,#f7dfa5,#f0c14b);
            border-radius: 4px;
            padding: 7px 16px;
            font-size: .85rem;
            cursor: pointer;
            font-family: inherit;
            color: var(--text);
        }
        .btn-outline:hover { filter: brightness(1.04); }
        .btn-logout {
            border: 1px solid var(--border);
            background: #fff;
            border-radius: 4px;
            padding: 7px 16px;
            font-size: .85rem;
            cursor: pointer;
            font-family: inherit;
            color: var(--text);
        }
        .btn-logout:hover { background: #f7f7f7; border-color: #999; }

        /* ── GRID ── */
        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--border);
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .card-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 16px;
            text-align: center;
            transition: box-shadow .15s, transform .15s;
            cursor: pointer;
        }
        .card-box:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,.12);
            transform: translateY(-2px);
        }
        .card-box .icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .card-box h3 { font-size: .9rem; font-weight: 700; margin-bottom: 4px; }
        .card-box p  { font-size: .78rem; color: var(--muted); }

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
/* 🔥 SIDE MENU (ALL) */
.side-menu {
    position: fixed;
    top: 0;
    left: -300px;
    width: 280px;
    height: 100%;
    background: #fff;
    z-index: 99999;
    overflow-y: auto;
    transition: 0.3s;
    box-shadow: 2px 0 10px rgba(0,0,0,0.3);
}

.side-menu.active {
    left: 0;
}

.side-header {
    background: #232f3e;
    color: #fff;
    padding: 15px;
    font-weight: bold;
    font-size: 16px;
}

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

.side-title {
    padding: 10px 16px;
    font-weight: bold;
    font-size: 15px;
    background: #f7f7f7;
}

.menu-close {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 20px;
    cursor: pointer;
}

/* overlay */
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

        /* ── FOOTER ── */
        footer {
            background: var(--header-dark);
            color: #ccc;
            text-align: center;
            padding: 20px 16px;
            margin-top: auto;
        }
        .foot-links {
            display: flex; justify-content: center; flex-wrap: wrap;
            gap: 6px 20px; margin-bottom: 8px;
        }
        .foot-links a { color: #ccc; font-size: .78rem; }
        .foot-links a:hover { color: #fff; }
        .foot-copy { font-size: .75rem; color: #888; }
    </style>
</head>
<body>

<!-- Header include -->
    <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<div id="menuOverlay" class="menu-overlay" onclick="closeMenu()"></div>

<div id="sideMenu" class="side-menu">
    
    <div class="side-header">
        👤 Hello, Sign in
        <span class="menu-close" onclick="closeMenu()">✖</span>
    </div>

    <div class="side-title">Trending</div>
    <a href="<?php echo e(route('products.index', ['sort' => 'best_selling'])); ?>">Bestsellers</a>
    <a href="<?php echo e(route('products.index', ['sort' => 'newest'])); ?>">New Releases</a>
    <a href="<?php echo e(route('products.index', ['sort' => 'popular'])); ?>">Movers and Shakers</a>

    <div class="side-title">Programs & Features</div>
     <a href="<?php echo e(route('profile.index')); ?>">🔒 Login & Security</a>
        <a href="<?php echo e(route('addresses.index')); ?>">📍 Your Addresses</a>
        <a href="<?php echo e(route('profile.payment')); ?>">💳 Payment Options</a>
        <a href="<?php echo e(route('wishlist.index')); ?>">❤️ Your Wishlist</a>
        <a href="<?php echo e(route('profile.gift-cards')); ?>">🎁 Gift Cards</a>
        <a href="<?php echo e(route('profile.customer-support')); ?>">💬 Customer Service</a>
        <a href="<?php echo e(route('profile.customer-support-notifications')); ?>">🔔 Notifications</a>

    <div class="side-title">Help & Settings</div>
   <a href="<?php echo e(route('profile.index')); ?>">👤 Your Account</a>
        <a href="<?php echo e(route('help')); ?>">💬 Customer Service</a>
        <a href="<?php echo e(route('login')); ?>">🔑 Sign in</a>

</div>

<nav class="nav">
    
    <a href="javascript:void(0)" class="nav-all" onclick="openMenu()">☰ All</a>   
     <a href="<?php echo e(route('products.index')); ?>">🔥Today's Deals</a>
    <a href="<?php echo e(route('profile.customer-support')); ?>">📞Customer Service</a>
    <a href="<?php echo e(route('profile.registry')); ?>">📋Registry</a>
    <a href="<?php echo e(route('profile.gift-cards')); ?>">🎁Gift Cards</a>
    <a href="<?php echo e(route('profile.sell')); ?>">🏷️ sell</a>
</nav>


<?php if(session('status')): ?>
    <div class="alert-success">✓ <?php echo e(session('status')); ?></div>
<?php endif; ?>


<div class="hero">
    <div class="hero-content">
        <h1>👨🏻‍💻Welcome back, <span><?php echo e($user->name); ?></span>!</h1>
        <p>Discover millions of products at great prices. Start shopping today.</p>
        <a href="<?php echo e(route('products.index')); ?>" class="hero-btn">Shop Now</a>
    </div>
</div>


<main class="main">

    
    <div class="account-card">
        <div class="account-info">
            <div class="avatar"><?php echo e(strtoupper(substr($user->name, 0, 1))); ?></div>
            <div class="account-text">
                <h2><?php echo e($user->name); ?></h2>
                <p class="email"><?php echo e($user->email); ?></p>
                <p>Member since <?php echo e($user->created_at->format('F Y')); ?></p>
            </div>
        </div>
        <div class="account-actions">
            
            <a href="<?php echo e(route('profile.index')); ?>" class="btn-outline">Manage Account</a>
            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn-logout">Sign Out</button>
            </form>
        </div>
    </div>

    
    <div class="section-title">Your Account</div>
    <div class="cards-grid">
        <a href="<?php echo e(route('orders.index')); ?>" style="text-decoration:none;color:inherit;">
        <div class="card-box">
            <div class="icon">📦</div>
            <h3>Your Orders</h3>
            <p>Track, return or buy things again</p>
        </div>
        <a href="<?php echo e(route('profile.index')); ?>" style="text-decoration:none;color:inherit;">
        <div class="card-box">
            <div class="icon">🔒</div>
            <h3>Login & Security</h3>
            <p>Edit login, name and mobile number</p>
        </div>
       <a href="<?php echo e(route('addresses.index')); ?>" style="text-decoration:none;color:inherit;">
        <div class="card-box">
            <div class="icon">📍</div>
            <h3>Your Addresses</h3>
            <p>Edit addresses for orders and gifts</p>
        </div>
        <a href="<?php echo e(route('profile.payment')); ?>" style="text-decoration:none;color:inherit;">
        <div class="card-box">
            <div class="icon">💳</div>
            <h3>Payment Options</h3>
            <p>Edit or add payment methods</p>
        </div>
        <a href="<?php echo e(route('wishlist.index')); ?>" style="text-decoration:none;color:inherit;">
        
         <div class="card-box">
            <div class="icon">❤️</div>
            <h3>Your Wishlist</h3>
            <p>View and manage your wish list</p>
        </div>
        <a href="<?php echo e(route('profile.gift-cards')); ?>" style="text-decoration:none;color:inherit;">
        <div class="card-box">
            <div class="icon">🎁</div>
            <h3>Gift Cards</h3>
            <p>View balance or redeem a card</p>
        </div>
        <a href="<?php echo e(route('profile.customer-support')); ?>" style="text-decoration:none;color:inherit;">
        <div class="card-box">
            <div class="icon">💬</div>
            <h3>Customer Service</h3>
            <p>Browse self-service options</p>
        </div>
         <a href="<?php echo e(route('notifications.index')); ?>" style="text-decoration:none;color:inherit;">
        <div class="card-box">
            <div class="icon">🔔</div>
            <h3>Notifications</h3>
            <p>Manage your notification settings</p>
        </div>
    </div>

</main>

<!-- footer include -->
    <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<script>
function openMenu() {
    document.getElementById("sideMenu").classList.add("active");
    document.getElementById("menuOverlay").classList.add("active");
}

function closeMenu() {
    document.getElementById("sideMenu").classList.remove("active");
    document.getElementById("menuOverlay").classList.remove("active");
}
</script>
<script>
// Load notification count for home page bell
fetch('<?php echo e(route("notifications.count")); ?>')
    .then(r => r.json())
    .then(data => {
        const badge = document.getElementById('homeBellBadge');
        if (badge && data.count > 0) {
            badge.textContent = data.count > 9 ? '9+' : data.count;
            badge.style.display = 'flex';
        }
    })
    .catch(() => {});
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\laravel\userside_project\resources\views/home.blade.php ENDPATH**/ ?>