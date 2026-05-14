<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova Admin — Returns</title>

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
        
        table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #ddd}
        th{background:#f7f8f8;padding:10px;text-align:left}
        td{padding:10px;border-bottom:1px solid #eee}
        
        .badge{padding:4px 10px;border-radius:20px;font-size:.75rem;font-weight:700}
        .pending{background:#fff3cd;color:#856404}
        .approved{background:#d4edda;color:#155724}
        .rejected{background:#f8d7da;color:#721c24}

        .btn{padding:5px 10px;border-radius:4px;border:1px solid #ddd;cursor:pointer}
        .btn-update{background:#FF9900;color:#000;border:none}
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
        <a href="<?php echo e(route('admin.orders.index')); ?>" ><span class="icon">🛒</span> All Orders</a>
         <a href="<?php echo e(route('admin.returns')); ?>" class="active">🔁 Returns</a>
         <a href="<?php echo e(route('admin.coupons.index')); ?>"><span class="icon">🎟️</span> Coupons</a>
        <div class="sidebar-section">Users</div>
        <a href="<?php echo e(route('admin.users.index')); ?>"><span class="icon">👥</span> All Users</a>
         <div class="sidebar-section">Store</div>
        <a href="<?php echo e(route('home')); ?>">🏠 View Store</a>
    </nav>

    
    <main class="main">

        <h1>🔁 Return Requests</h1>
        <br>

        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>User</th>
                    <th>Reason</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Pickup Address</th>   <!-- ✅ ADD -->
                    <th>Pickup Date</th>      <!-- ✅ ADD -->
                    <th>Pickup Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>#<?php echo e($return->order->order_number ?? $return->order_id); ?></td>
                    <td><?php echo e($return->user->name ?? $return->user_id); ?></td>
                    <td><?php echo e($return->reason); ?></td>
                    <td><?php echo e($return->message ?? 'No message'); ?></td>

                    <td>
                        <span class="badge <?php echo e($return->status); ?>">
                            <?php echo e(ucfirst($return->status)); ?>

                        </span>
                    </td>
                    <td><?php echo e($return->pickup_address); ?></td>
                        <td><?php echo e($return->pickup_date ?? '-'); ?></td>
                        <td><?php echo e(ucfirst($return->pickup_status)); ?></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('admin.return.update', $return->id)); ?>">
                            <?php echo csrf_field(); ?>

                            <select name="status">
                                <option value="pending" <?php echo e($return->status=='pending'?'selected':''); ?>>Pending</option>
                                <option value="approved" <?php echo e($return->status=='approved'?'selected':''); ?>>Approve</option>
                                <option value="rejected" <?php echo e($return->status=='rejected'?'selected':''); ?>>Reject</option>
                            </select>

                            <button class="btn btn-update">Update</button>
                        </form>
                    </td>
                        
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </main>
</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\laravel\userside_project\resources\views/admin/returns/index.blade.php ENDPATH**/ ?>