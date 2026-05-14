<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin - Create Coupon</title>

    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--sidebar:#1a252f;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#f0f2f5;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
        .topbar{background:var(--hdr);display:flex;align-items:center;padding:10px 20px;gap:16px}
        .logo{font-size:1.3rem;font-weight:900;color:#fff;font-family:Arial Black,sans-serif}
        .logo span{color:var(--orange)}
        .admin-badge{background:var(--orange);color:var(--hdr);font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:3px;margin-left:4px}
        .topbar-right{margin-left:auto;display:flex;gap:12px}
        .topbar-right a{color:#ccc;font-size:.85rem}
        .layout{display:flex;flex:1}
        .sidebar{width:220px;background:var(--sidebar);flex-shrink:0;padding:16px 0}
        .sidebar-section{padding:6px 16px;font-size:.7rem;color:#7f8c8d;text-transform:uppercase;letter-spacing:.5px;margin-top:12px;margin-bottom:4px}
        .sidebar a{display:flex;align-items:center;gap:10px;padding:9px 16px;color:#bdc3c7;font-size:.875rem;border-left:3px solid transparent;transition:background .15s}
        .sidebar a:hover,.sidebar a.active{background:rgba(255,255,255,.08);color:#fff;border-left-color:var(--orange);text-decoration:none}
        .sidebar a .icon{font-size:1rem;width:20px;text-align:center}
        .main{flex:1;padding:20px;overflow-x:auto}
        .container{max-width:900px;margin:30px auto;background:#fff;padding:20px;border-radius:8px}
        h1{margin-bottom:20px}
        label{display:block;margin-top:10px;font-weight:bold}
        input,select{width:100%;padding:8px;margin-top:5px;border:1px solid #ccc;border-radius:5px}
        button{margin-top:15px;background:#FF9900;border:none;padding:10px 15px;color:#000;font-weight:bold;cursor:pointer}
        a{display:inline-block;margin-top:10px;color:#007185}
        .row{display:grid;grid-template-columns:1fr 1fr;gap:15px}
    </style>
</head>
<body>
<header class="topbar">
    <div class="logo">Cart<span>Nova</span><h6>Admin</h6></div>
    <div class="topbar-right">
        <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
        <a href="<?php echo e(route('home')); ?>">← Store</a>
    </div>
</header>
<div class="layout">
    <nav class="sidebar">
        <div class="sidebar-section">Main</div>
        <a href="<?php echo e(route('admin.dashboard')); ?>"><span class="icon">📊</span> Dashboard</a>
        <div class="sidebar-section">Catalog</div>
        <a href="<?php echo e(route('admin.products.index')); ?>"><span class="icon">📦</span> Products</a>
        <a href="<?php echo e(route('admin.products.create')); ?>"><span class="icon">➕</span> Add Product</a>
        <div class="sidebar-section">Sales</div>
        <a href="<?php echo e(route('admin.orders.index')); ?>"><span class="icon">🛒</span> All Orders</a>
        <a href="<?php echo e(route('admin.returns')); ?>" >🔁 Returns</a>
        <a href="<?php echo e(route('admin.coupons.index')); ?>" class="active"><span class="icon">🎟️</span> Coupons</a>
        <div class="sidebar-section">Users</div>
        <a href="<?php echo e(route('admin.users.index')); ?>"><span class="icon">👥</span> All Users</a>
        <div class="sidebar-section">Store</div>
        <a href="<?php echo e(route('home')); ?>">🏠 View Store</a>
    </nav>
<div class="container">
    <h1>🎟️ Create Coupon</h1>

    <a href="<?php echo e(route('admin.coupons.index')); ?>">← Back to Coupons</a>

    <?php if($errors->any()): ?>
        <div style="color:red;margin-top:10px">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.coupons.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <label>Coupon Code</label>
        <input type="text" name="code" value="<?php echo e(old('code')); ?>" required>

        <label>Description</label>
        <input type="text" name="description" value="<?php echo e(old('description')); ?>">

        <div class="row">
            <div>
                <label>Type</label>
                <select name="type" required>
                    <option value="">Select</option>
                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed</option>
                </select>
            </div>

            <div>
                <label>Value</label>
                <input type="number" name="value" required>
            </div>
        </div>

        <div class="row">
            <div>
                <label>Min Order</label>
                <input type="number" name="min_order_amount">
            </div>

            <div>
                <label>Max Discount</label>
                <input type="number" name="max_discount">
            </div>
        </div>

        <label>Usage Limit</label>
        <input type="number" name="usage_limit">

        <label>Per User Limit</label>
        <input type="number" name="per_user_limit" value="1">

        <label>Start Date</label>
        <input type="datetime-local" name="starts_at">

        <label>Expiry Date</label>
        <input type="datetime-local" name="expires_at">

        <label>
            <input type="checkbox" name="is_active" value="1"> Active
        </label>

        <button type="submit">Create Coupon</button>
    </form>
</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\laravel\userside_project\resources\views/admin/coupons/create.blade.php ENDPATH**/ ?>