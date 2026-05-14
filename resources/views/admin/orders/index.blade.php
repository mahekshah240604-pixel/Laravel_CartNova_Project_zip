{{-- resources/views/admin/orders/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>CartNova Admin — Orders</title>
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
        .toolbar{display:flex;align-items:center;gap:10px;margin-bottom:14px;flex-wrap:wrap}
        .toolbar h1{font-size:1.3rem;font-weight:700;margin-right:auto}
        .toolbar input,.toolbar select{border:1px solid var(--border);border-radius:4px;padding:7px 10px;font-size:.85rem;outline:none}
        .btn{display:inline-block;padding:7px 14px;border-radius:4px;font-size:.85rem;cursor:pointer;font-family:inherit;border:1px solid;text-decoration:none}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border-color:#a88734;color:var(--text);font-weight:700}
        .btn-sm{padding:4px 10px;font-size:.78rem}
        table{width:100%;border-collapse:collapse;font-size:.84rem;background:var(--white);border:1px solid var(--border);border-radius:8px;overflow:hidden;min-width:700px}
        th{background:#f7f8f8;padding:10px 12px;text-align:left;font-weight:700;color:var(--muted);border-bottom:2px solid var(--border);white-space:nowrap}
        td{padding:9px 12px;border-bottom:1px solid #f5f5f5;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#fafafa}
        .badge{display:inline-block;padding:3px 8px;border-radius:10px;font-size:.72rem;font-weight:700;white-space:nowrap}
        .badge-pending{background:#fff3cd;color:#856404}
        .badge-confirmed{background:#cce5ff;color:#004085}
        .badge-shipped{background:#d1ecf1;color:#0c5460}
        .badge-delivered{background:#d4edda;color:#155724}
        .badge-cancelled{background:#f8d7da;color:#721c24}
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

        <div class="toolbar">
            <h1>🛒 Orders ({{ $orders->total() }})</h1>
            <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Order # or customer name...">
                <select name="status" onchange="this.form.submit()">
                    <option value="all">All Status</option>
                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request('search')||request('status'))
                    <a href="{{ route('admin.orders.index') }}" class="btn" style="border-color:var(--border)">Clear</a>
                @endif
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td style="font-size:.8rem;font-weight:700">{{ $order->order_number }}</td>
                    <td>
                        <div style="font-weight:700">{{ $order->user->name ?? 'Deleted User' }}</div>
                        <div style="font-size:.75rem;color:var(--muted)">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td style="white-space:nowrap;font-size:.82rem">{{ $order->placed_at->format('d M Y') }}</td>
                    <td>{{ $order->items->count() }} item(s)</td>
                    <td style="font-weight:700;white-space:nowrap">₹{{ number_format($order->total,0) }}</td>
                    <td><span style="font-size:.78rem;background:#f0f0f0;padding:2px 6px;border-radius:3px">{{ strtoupper($order->payment_method) }}</span></td>
                    <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    {{-- <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a>
                    </td> --}}
                    <td style="display:flex;gap:6px;flex-wrap:wrap">

    {{-- 👁 VIEW --}}
    <a href="{{ route('admin.orders.show', $order->id) }}"
       class="btn btn-primary btn-sm">
        👁 View
    </a>

    {{-- 📄 INVOICE --}}
    <a href="{{ route('admin.invoice.download', $order->id) }}"
       target="_blank"
       style="background:#FF9900;border-color:#FF9900;color:#000"
       class="btn btn-sm">
        📄 Invoice
    </a>

    {{-- ❌ DELETE --}}
    <form action="{{ route('admin.orders.destroy', $order->id) }}"
          method="POST"
          onsubmit="return confirm('Delete this order?')">
        @csrf
        @method('DELETE')

        <button type="submit"
            style="background:#fff;border:1px solid red;color:red"
            class="btn btn-sm">
            ❌ Delete
        </button>
    </form>

</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            @if($orders->onFirstPage())<span class="disabled">← Prev</span>@else<a href="{{ $orders->previousPageUrl() }}">← Prev</a>@endif
            @foreach(range(1,$orders->lastPage()) as $p)
                @if($p==$orders->currentPage())<span class="active">{{ $p }}</span>
                @else<a href="{{ $orders->url($p) }}">{{ $p }}</a>@endif
            @endforeach
            @if($orders->hasMorePages())<a href="{{ $orders->nextPageUrl() }}">Next →</a>@else<span class="disabled">Next →</span>@endif
        </div>
    </main>
</div>
<footer>© 1996–2025, CartNova · Admin Panel · All rights reserved</footer>
</body>
</html>