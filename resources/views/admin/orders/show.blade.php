{{-- resources/views/admin/orders/show.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin - Order Detail</title>
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
        .main{flex:1;padding:20px;max-width:860px}
        .alert{padding:10px 16px;border-radius:4px;margin-bottom:14px;font-size:.875rem;border:1px solid}
        .alert-success{background:#f0fff4;border-color:var(--green);color:var(--green)}
        .alert-error{background:#fff8f8;border-color:var(--error);color:var(--error)}
        .section{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:18px;margin-bottom:14px}
        .section h2{font-size:.95rem;font-weight:700;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--border)}
        .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .info-box{background:#f9f9f9;border-radius:4px;padding:12px}
        .info-box h3{font-size:.78rem;font-weight:700;color:var(--muted);text-transform:uppercase;margin-bottom:8px}
        .info-box p{font-size:.875rem;line-height:1.7}
        .badge{display:inline-block;padding:4px 12px;border-radius:10px;font-size:.82rem;font-weight:700}
        .badge-pending{background:#fff3cd;color:#856404}
        .badge-confirmed{background:#cce5ff;color:#004085}
        .badge-shipped{background:#d1ecf1;color:#0c5460}
        .badge-delivered{background:#d4edda;color:#155724}
        .badge-cancelled{background:#f8d7da;color:#721c24}
        .item-row{display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f5f5f5;align-items:center}
        .item-row:last-child{border-bottom:none}
        .item-row img{width:55px;height:55px;object-fit:contain;border:1px solid var(--border);border-radius:4px;background:#fff;padding:3px}
        .item-info{flex:1}
        .item-name{font-size:.875rem;font-weight:400}
        .item-sub{font-size:.75rem;color:var(--muted)}
        .item-price{font-weight:700;font-size:.9rem;white-space:nowrap}
        .price-row{display:flex;justify-content:space-between;font-size:.85rem;margin-bottom:6px}
        .price-row.green{color:var(--green)}
        hr.pdiv{border:none;border-top:1px solid var(--border);margin:8px 0}
        .price-total{display:flex;justify-content:space-between;font-size:1rem;font-weight:700}
        /* STATUS UPDATE FORM */
        .status-form{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
        .status-form select{border:1px solid var(--border);border-radius:4px;padding:7px 10px;font-size:.85rem;outline:none}
        .status-form select:focus{border-color:var(--orange)}
        .btn{display:inline-block;padding:7px 16px;border-radius:4px;font-size:.85rem;cursor:pointer;font-family:inherit;border:1px solid;text-decoration:none}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border-color:#a88734;color:var(--text);font-weight:700}
        .btn-primary:hover{filter:brightness(1.04)}
        .btn-back{background:var(--white);border-color:var(--border);color:var(--text)}
        .btn-back:hover{background:#f7f7f7;text-decoration:none;color:var(--text)}
        footer{background:var(--hdr);color:#888;text-align:center;padding:12px;font-size:.75rem;margin-top:auto}
        @media(max-width:600px){.sidebar{display:none}.info-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<header class="topbar">
    <div class="logo">Cart<span>Nova</span><h6>Admin</h6></div>
    <div class="topbar-right">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('home') }}">← Store</a>
    </div>
</header>
<div class="layout">
    <nav class="sidebar">
        <div class="sidebar-section">Main</div>
        <a href="{{ route('admin.dashboard') }}"><span class="icon">📊</span> Dashboard</a>
        <div class="sidebar-section">Catalog</div>
        <a href="{{ route('admin.products.index') }}"><span class="icon">📦</span> Products</a>
        <a href="{{ route('admin.products.create') }}"><span class="icon">➕</span> Add Product</a>
        <div class="sidebar-section">Sales</div>
        <a href="{{ route('admin.orders.index') }}" class="active"><span class="icon">🛒</span> All Orders</a>
         <a href="{{ route('admin.returns') }}">🔁 Returns</a>
         <a href="{{ route('admin.coupons.index') }}"><span class="icon">🎟️</span> Coupons</a>
        <div class="sidebar-section">Users</div>
        <a href="{{ route('admin.users.index') }}"><span class="icon">👥</span> All Users</a>
         <div class="sidebar-section">Store</div>
        <a href="{{ route('home') }}">🏠 View Store</a>
    </nav>
    <main class="main">
        @if(session('success'))<div class="alert alert-success">✓ {{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

        {{-- Header --}}
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;flex-wrap:wrap">
            <h1 style="font-size:1.3rem;font-weight:700">Order Details</h1>
            <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            {{-- 📄 Invoice Button --}}
    <a href="{{ route('admin.invoice.download', $order->id) }}"
       target="_blank"
       class="btn"
       style="background:#FF9900;border-color:#FF9900;color:#000">
        📄 Download Invoice
    </a>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-back" style="margin-left:auto">← Back to Orders</a>
        </div>

        {{-- Update Status --}}
        <div class="section">
            <h2>🔄 Update Order Status</h2>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf @method('PATCH')
                <div class="status-form">
                    <span style="font-size:.85rem;color:var(--muted)">Current status:</span>
                    <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    <span style="font-size:.85rem;color:var(--muted)">→ Change to:</span>
                    <select name="status">
                        @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>

        {{-- Order Info --}}
        <div class="section">
            <h2>📋 Order Information</h2>
            <div style="display:flex;gap:20px;flex-wrap:wrap;margin-bottom:12px;font-size:.85rem">
                <div><span style="color:var(--muted)">Order # </span><strong>{{ $order->order_number }}</strong></div>
                <div><span style="color:var(--muted)">Date: </span><strong>{{ $order->placed_at->format('d M Y, h:i A') }}</strong></div>
                <div><span style="color:var(--muted)">Payment: </span><strong>{{ $order->payment_label }}</strong></div>
                <div><span style="color:var(--muted)">Pay Status: </span>
                    <strong style="color:{{ $order->payment_status=='paid'?'#007600':'#856404' }}">
                        {{ ucfirst(str_replace('_',' ',$order->payment_status)) }}
                    </strong>
                </div>
            </div>
            <div class="info-grid">
                <div class="info-box">
                    <h3>👤 Customer</h3>
                    <p>
                        <strong>{{ $order->user->name ?? 'N/A' }}</strong><br>
                        {{ $order->user->email ?? '' }}<br>
                        {{ $order->user->phone ?? '' }}
                    </p>
                </div>
                <div class="info-box">
                    <h3>📍 Shipping Address</h3>
                    <p>
                        <strong>{{ $order->full_name }}</strong><br>
                        {{ $order->address_line1 }}<br>
                        @if($order->address_line2){{ $order->address_line2 }}<br>@endif
                        {{ $order->city }}, {{ $order->state }} — {{ $order->pincode }}<br>
                        📞 {{ $order->phone }}
                    </p>
                </div>
            </div>
            @if($order->notes)
                <div style="margin-top:10px;background:#fffdf7;border:1px solid #f0c14b;border-radius:4px;padding:10px;font-size:.85rem">
                    📝 <strong>Notes:</strong> {{ $order->notes }}
                </div>
            @endif
        </div>

        {{-- Items --}}
        <div class="section">
            <h2>🛍️ Items ({{ $order->items->count() }})</h2>
            @foreach($order->items as $item)
            <div class="item-row">
                <img src="{{ asset($item->product_image) }}" alt="{{ $item->product_name }}"
                     onerror="this.src='https://placehold.co/55x55?text=?'">
                <div class="item-info">
                    <div class="item-name">{{ $item->product_name }}</div>
                    <div class="item-sub">{{ $item->product_brand }} · Qty: {{ $item->quantity }} · ₹{{ number_format($item->price,0) }} each</div>
                </div>
                <div class="item-price">₹{{ number_format($item->subtotal,0) }}</div>
                {{-- <form action="{{ route('admin.order.item.remove', $item->id) }}" method="POST"
            onsubmit="return confirm('Are you sure to remove this item?')">
            @csrf
            @method('DELETE')
            <button type="submit" style="
                background:none;
                border:none;
                color:red;
                font-size:18px;
                cursor:pointer;
                margin-left:10px;
            ">
                ❌
            </button>
        </form> --}}
            </div>
            @endforeach

            {{-- Price Summary --}}
            <div style="background:#f9f9f9;border-radius:4px;padding:14px;margin-top:14px">
                <div class="price-row"><span>Subtotal</span><span>₹{{ number_format($order->subtotal,0) }}</span></div>
                @if($order->discount > 0)
                <div class="price-row green"><span>Discount</span><span>-₹{{ number_format($order->discount,0) }}</span></div>
                @endif
                <div class="price-row"><span>Delivery</span><span>{{ $order->delivery_charge==0?'FREE':'₹'.$order->delivery_charge }}</span></div>
                <hr class="pdiv">
                <div class="price-total"><span>Order Total</span><span>₹{{ number_format($order->total,0) }}</span></div>
            </div>
        </div>

    </main>
</div>
<footer>© 1996–2025, CartNova.com, Inc. Admin Panel</footer>
</body>
</html>