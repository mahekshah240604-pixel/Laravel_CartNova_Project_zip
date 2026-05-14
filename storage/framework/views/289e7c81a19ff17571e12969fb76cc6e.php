
<header class="hdr">
    <div class="logo">Cart<span>Nova</span></div>

    <div class="hdr-deliver">
        <span>Deliver to</span><br>
        <strong><?php echo e($user->name); ?></strong>
    </div>

    

    
    <div class="account-menu">
    
    <div class="hdr-account account-menu">
        <span>Hello, <?php echo e($user->name); ?></span>
        <strong>⚙️ Account &amp; Lists ▾</strong>
    </div>

    <div class="account-dropdown">
        <div class="dropdown-left">
            <h4>📋 Your Lists</h4>
            <a href="<?php echo e(route('wishlist.index')); ?>">Your Wishlist</a>
            <a href="#">Create a Wish List</a>
        </div>

        <div class="dropdown-right">
            <h4>Your Account</h4>
            <a href="<?php echo e(route('profile.index')); ?>">Your Account</a>
            <a href="<?php echo e(route('orders.index')); ?>">Your Orders</a>
            <a href="<?php echo e(route('wishlist.index')); ?>">Your Wish List</a>
            <a href="<?php echo e(route('addresses.index')); ?>">Your Addresses</a>
        </div>
    </div>
</div>

    
        
     
    <div class="orders-menu">
    
    <div class="hdr-account account-menu">
        <span>🚚 Returns</span>
        <strong>&amp; Orders ▾</strong>
    </div>

    <div class="orders-dropdown">
        <h4>📦 Your Orders</h4>
        <a href="<?php echo e(route('orders.index')); ?>">📋Track Orders</a>
        <a href="<?php echo e(route('orders.index', ['status' => 'delivered'])); ?>">
        🔁 Return / Replace Items
        </a>
        <a href="<?php echo e(route('orders.index')); ?>">🧾Order History</a>
      <a href="<?php echo e(route('orders.index', ['status' => 'cancelled'])); ?>">
        ❌ Cancelled Orders
    </a>
    </div>
</div>
    
    <div style="color:var(--orange);font-weight:700;font-size:1rem;display:flex;align-items:center;gap:3px">
                🛒 <span id="cartCount" style="background:var(--orange);color:#131921;border-radius:50%;min-width:18px;height:18px;display:flex;align-items:center;justify-content:center;font-size:.7rem;padding:0 3px"><?php echo e($itemCount ?? 0); ?></span>
            </div>
</header>
<?php /**PATH C:\xampp\htdocs\laravel\userside_project\resources\views/layouts/header.blade.php ENDPATH**/ ?>