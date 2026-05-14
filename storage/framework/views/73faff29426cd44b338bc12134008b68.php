<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin - Coupons</title>
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
        .alert{padding:10px 16px;border-radius:4px;margin-bottom:14px;font-size:.875rem;border:1px solid}
        .alert-success{background:#f0fff4;border-color:var(--green);color:var(--green)}
        .alert-error{background:#fff8f8;border-color:var(--error);color:var(--error)}
        .toolbar{display:flex;align-items:center;gap:10px;margin-bottom:14px;flex-wrap:wrap}
        .toolbar h1{font-size:1.3rem;font-weight:700;margin-right:auto}
        .btn{display:inline-block;padding:7px 14px;border-radius:4px;font-size:.85rem;cursor:pointer;font-family:inherit;border:1px solid;text-decoration:none;transition:filter .12s}
        .btn:hover{filter:brightness(1.04);text-decoration:none}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border-color:#a88734;color:var(--text);font-weight:700}
        .btn-sm{padding:4px 10px;font-size:.78rem}
        .btn-danger{background:#fff;border-color:var(--error);color:var(--error)}
        .btn-danger:hover{background:#fff8f8}
        .btn-success{background:#fff;border-color:var(--green);color:var(--green)}
        table{width:100%;border-collapse:collapse;font-size:.85rem;background:var(--white);border:1px solid var(--border);border-radius:8px;overflow:hidden;min-width:700px}
        th{background:#f7f8f8;padding:10px 12px;text-align:left;font-weight:700;color:var(--muted);border-bottom:2px solid var(--border);white-space:nowrap}
        td{padding:9px 12px;border-bottom:1px solid #f5f5f5;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#fafafa}
        .badge{display:inline-block;padding:3px 9px;border-radius:10px;font-size:.72rem;font-weight:700;white-space:nowrap}
        .badge-active{background:#d4edda;color:#155724}
        .badge-inactive{background:#f5f5f5;color:#888}
        .badge-expired{background:#f8d7da;color:#721c24}
        .badge-upcoming{background:#cce5ff;color:#004085}
        .badge-exhausted{background:#fff3cd;color:#856404}
        .coupon-code{font-family:monospace;font-size:.9rem;font-weight:700;background:#f7f8f8;border:1px dashed var(--border);padding:3px 8px;border-radius:3px;letter-spacing:1px}
        .pagination{display:flex;justify-content:center;gap:4px;margin-top:14px;flex-wrap:wrap}
        .pagination a,.pagination span{padding:5px 11px;border:1px solid var(--border);border-radius:4px;font-size:.82rem;background:var(--white);color:var(--link)}
        .pagination .active{background:var(--orange);border-color:var(--orange);color:#fff;font-weight:700}
        .pagination .disabled{color:#ccc}
        footer{background:var(--hdr);color:#888;text-align:center;padding:12px;font-size:.75rem;margin-top:auto}
        @media(max-width:768px){.sidebar{display:none}}
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
    <main class="main">
        <?php if(session('success')): ?><div class="alert alert-success">✓ <?php echo e(session('success')); ?></div><?php endif; ?>
        <?php if(session('error')): ?><div class="alert alert-error"><?php echo e(session('error')); ?></div><?php endif; ?>

        <div class="toolbar">
            <h1>🎟️ Coupons (<?php echo e($coupons->total()); ?>)</h1>
            <a href="<?php echo e(route('admin.coupons.create')); ?>" class="btn btn-primary">+ Create Coupon</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Min Order</th>
                    <th>Max Discount</th>
                    <th>Usage</th>
                    <th>Expires</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><span class="coupon-code"><?php echo e($coupon->code); ?></span></td>
                    <td style="max-width:160px;font-size:.82rem;color:var(--muted)"><?php echo e($coupon->description ?? '—'); ?></td>
                    <td>
                        <strong style="color<?php echo e($coupon->type=='percentage'?'#007600':'#004085'); ?>">
                            <?php echo e($coupon->type_label); ?>

                        </strong>
                    </td>
                    <td><?php echo e($coupon->min_order_amount > 0 ? '₹'.number_format($coupon->min_order_amount,0) : 'None'); ?></td>
                    <td><?php echo e($coupon->max_discount ? '₹'.number_format($coupon->max_discount,0) : 'No cap'); ?></td>
                    <td>
                        <?php echo e($coupon->used_count); ?> / <?php echo e($coupon->usage_limit ?: '∞'); ?>

                        <div style="font-size:.72rem;color:var(--muted)">
                            <?php echo e($coupon->usages_count); ?> orders
                        </div>
                    </td>
                    <td style="font-size:.8rem;white-space:nowrap">
                        <?php echo e($coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Never'); ?>

                    </td>
                    <td>
                        <span class="badge badge-<?php echo e($coupon->status); ?>">
                            <?php echo e(ucfirst($coupon->status)); ?>

                        </span>
                    </td>
                    <td style="white-space:nowrap">
                        <a href="<?php echo e(route('admin.coupons.edit', $coupon->id)); ?>" class="btn btn-sm" style="border-color:var(--link);color:var(--link)">Edit</a>

                        
                        <form action="<?php echo e(route('admin.coupons.toggle', $coupon->id)); ?>" method="POST" style="display:inline">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-sm <?php echo e($coupon->is_active ? 'btn-danger' : 'btn-success'); ?>">
                                <?php echo e($coupon->is_active ? 'Deactivate' : 'Activate'); ?>

                            </button>
                        </form>

                        
                        <form action="<?php echo e(route('admin.coupons.destroy', $coupon->id)); ?>" method="POST" style="display:inline"
                              onsubmit="return confirm('Delete coupon <?php echo e($coupon->code); ?>?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php if($coupons->onFirstPage()): ?><span class="disabled">← Prev</span><?php else: ?><a href="<?php echo e($coupons->previousPageUrl()); ?>">← Prev</a><?php endif; ?>
            <?php $__currentLoopData = range(1,$coupons->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($p==$coupons->currentPage()): ?><span class="active"><?php echo e($p); ?></span>
                <?php else: ?><a href="<?php echo e($coupons->url($p)); ?>"><?php echo e($p); ?></a><?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($coupons->hasMorePages()): ?><a href="<?php echo e($coupons->nextPageUrl()); ?>">Next →</a><?php else: ?><span class="disabled">Next →</span><?php endif; ?>
        </div>
    </main>
</div>
<footer>© 1996–2025, CartNova.com, Inc. Admin Panel</footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\laravel\userside_project\resources\views/admin/coupons/index.blade.php ENDPATH**/ ?>