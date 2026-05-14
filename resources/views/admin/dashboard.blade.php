{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova Admin — Dashboard</title>

    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--sidebar:#1a252f;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#f0f2f5;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
 
        /* TOP BAR */
        .topbar{background:var(--hdr);display:flex;align-items:center;padding:10px 20px;gap:16px}
        .topbar .logo{font-size:1.3rem;font-weight:900;color:#fff;font-family:Arial Black,sans-serif;flex-shrink:0}
        .topbar .logo span{color:var(--orange)} .topbar .logo{font-size:1.1rem}
        .topbar .admin-badge{background:var(--orange);color:var(--hdr);font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:3px;margin-left:4px}
        .topbar-right{margin-left:auto;display:flex;align-items:center;gap:12px}
        .topbar-right a{color:#ccc;font-size:.85rem}
        .topbar-right a:hover{color:#fff;text-decoration:none}
        .avatar{width:30px;height:30px;background:var(--orange);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--hdr);font-weight:700;font-size:.85rem}
 
        /* LAYOUT */
        .layout{display:flex;flex:1}
 
        /* SIDEBAR */
        .sidebar{width:220px;background:var(--sidebar);flex-shrink:0;padding:16px 0}
        .sidebar-section{padding:6px 16px;font-size:.7rem;color:#7f8c8d;text-transform:uppercase;letter-spacing:.5px;margin-top:12px;margin-bottom:4px}
        .sidebar a{display:flex;align-items:center;gap:10px;padding:9px 16px;color:#bdc3c7;font-size:.875rem;transition:background .15s,color .15s;border-left:3px solid transparent}
        .sidebar a:hover,.sidebar a.active{background:rgba(255,255,255,.08);color:#fff;border-left-color:var(--orange);text-decoration:none}
        .sidebar a .icon{font-size:1rem;width:20px;text-align:center;flex-shrink:0}
        .sidebar .badge{background:var(--error);color:#fff;font-size:.65rem;font-weight:700;padding:1px 5px;border-radius:8px;margin-left:auto}
 
        /* MAIN CONTENT */
        .main{flex:1;padding:20px;overflow-x:hidden}
        .page-header{margin-bottom:20px}
        .page-header h1{font-size:1.4rem;font-weight:700;color:var(--text)}
        .page-header p{font-size:.85rem;color:var(--muted);margin-top:2px}
 
        /* ALERT */
        .alert{padding:10px 16px;border-radius:4px;margin-bottom:16px;font-size:.875rem;border:1px solid}
        .alert-success{background:#f0fff4;border-color:var(--green);color:var(--green)}
        .alert-error{background:#fff8f8;border-color:var(--error);color:var(--error)}
 
        /* STAT CARDS */
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:14px;margin-bottom:20px}
        .stat-card{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:16px;display:flex;flex-direction:column;gap:6px;transition:box-shadow .15s}
        .stat-card:hover{box-shadow:0 3px 12px rgba(0,0,0,.1)}
        .stat-card .icon{font-size:1.6rem}
        .stat-card .label{font-size:.78rem;color:var(--muted);font-weight:400}
        .stat-card .value{font-size:1.5rem;font-weight:700;color:var(--text)}
        .stat-card .sub{font-size:.75rem;color:var(--muted)}
        .stat-card.red .value{color:var(--error)}
        .stat-card.green .value{color:var(--green)}
        .stat-card.orange .value{color:var(--orange)}
        .stat-card.blue .value{color:#004085}
 
        /* SECTION */
        .section{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:18px;margin-bottom:16px}
        .section h2{font-size:.95rem;font-weight:700;margin-bottom:14px;padding-bottom:8px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
        .section h2 a{font-size:.82rem;font-weight:400;color:var(--link)}
 
        /* TABLE */
        table{width:100%;border-collapse:collapse;font-size:.85rem}
        th{background:#f7f8f8;padding:8px 12px;text-align:left;font-weight:700;color:var(--muted);border-bottom:2px solid var(--border);white-space:nowrap}
        td{padding:8px 12px;border-bottom:1px solid #f5f5f5;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#fafafa}
 
        /* STATUS BADGES */
        .badge{display:inline-block;padding:3px 8px;border-radius:10px;font-size:.72rem;font-weight:700;white-space:nowrap}
        .badge-pending  {background:#fff3cd;color:#856404}
        .badge-confirmed{background:#cce5ff;color:#004085}
        .badge-shipped  {background:#d1ecf1;color:#0c5460}
        .badge-delivered{background:#d4edda;color:#155724}
        .badge-cancelled{background:#f8d7da;color:#721c24}
 
        /* STATUS CHART */
        .status-chart{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}
        .status-item{flex:1;min-width:80px;background:#f9f9f9;border:1px solid var(--border);border-radius:6px;padding:10px;text-align:center}
        .status-item .num{font-size:1.3rem;font-weight:700;margin-bottom:2px}
        .status-item .lbl{font-size:.72rem;color:var(--muted)}
 
        /* TOP PRODUCTS */
        .product-row{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f5f5f5}
        .product-row:last-child{border-bottom:none}
        .product-row img{width:40px;height:40px;object-fit:contain;border:1px solid var(--border);border-radius:4px;background:#fff;padding:2px}
        .product-row-info{flex:1;min-width:0}
        .product-row-name{font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text)}
        .product-row-sub{font-size:.75rem;color:var(--muted)}
        .product-row-price{font-size:.85rem;font-weight:700;white-space:nowrap}
 
        /* BUTTONS */
        .btn{display:inline-block;padding:6px 14px;border-radius:4px;font-size:.82rem;cursor:pointer;font-family:inherit;border:1px solid;text-decoration:none;transition:filter .12s}
        .btn:hover{filter:brightness(1.04);text-decoration:none}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border-color:#a88734;color:var(--text);font-weight:700}
        .btn-sm{padding:4px 10px;font-size:.78rem}
 
        footer{background:var(--hdr);color:#888;text-align:center;padding:12px;margin-top:auto;font-size:.75rem}
 
        @media(max-width:768px){
            .sidebar{display:none}
            .stats-grid{grid-template-columns:repeat(2,1fr)}
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="logo">
        Cart<span>Nova</span><h6>Admin</h6>
        {{-- <span class="admin-badge">ADMIN</span> --}}
       
    </div>

    <div class="topbar-right">
        <a href="{{ route('home') }}">← Store Front</a>
        <a href="{{ route('admin.orders.index') }}">Orders</a>
        <a href="{{ route('admin.products.index') }}">Products</a>

        <div class="avatar">
            {{-- {{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }} --}}
             <span>{{ auth()->user()->name ?? 'Guest' }}</span>
        </div>
        

        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline">
            @csrf
            {{-- <button type="submit" style="background:none;border:none;color:#ccc;cursor:pointer;">
                Sign Out
            </button> --}}
             <button type="submit" style="background:rgba(255,107,0,.15);border:1px solid rgba(255,107,0,.3);color:#FF6B00;cursor:pointer;font-size:.82rem;border-radius:6px;padding:5px 12px;font-family:inherit;transition:background .15s" onmouseover="this.style.background='rgba(255,107,0,.25)'" onmouseout="this.style.background='rgba(255,107,0,.15)'">🚪 Sign Out</button>
        </form>
    </div>
</header>

<div class="layout">

    {{-- SIDEBAR --}}
    <nav class="sidebar">
        <div class="sidebar-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="active">📊 Dashboard</a>

        <div class="sidebar-section">Catalog</div>
        <a href="{{ route('admin.products.index') }}">📦 Products</a>
        <a href="{{ route('admin.products.create') }}">➕ Add Product</a>

        <div class="sidebar-section">Sales</div>
        <a href="{{ route('admin.orders.index') }}">
            🛒 All Orders
            @if(($stats['pending_orders'] ?? 0) > 0)
                <span class="badge">{{ $stats['pending_orders'] }}</span>
            @endif
        </a>
        {{-- ✅ ADD THIS --}}
        <a href="{{ route('admin.returns') }}">🔁 Returns</a>
     <a href="{{ route('admin.coupons.index') }}"><span class="icon">🎟️</span> Coupons</a>

        <div class="sidebar-section">Users</div>
        <a href="{{ route('admin.users.index') }}">👥 All Users</a>

        <div class="sidebar-section">Store</div>
        <a href="{{ route('home') }}">🏠 View Store</a>
    </nav>

    {{-- MAIN --}}
    <main class="main">

        <div class="page-header">
            <h1>📊 Dashboard</h1>
            {{-- <p>Welcome back, {{ auth()->user()->name ?? 'Admin' }}!</p> --}}
              <p>Welcome back, {{ auth()->user()->name }}! Here's what's happening.</p>
        </div>

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card">👥 Users<br><span class="value">{{ $stats['total_users'] ?? 0 }}</span></div>
            <div class="stat-card">📦 Products<br><span class="value">{{ $stats['total_products'] ?? 0 }}</span></div>
            <div class="stat-card">🛒 Orders<br><span class="value">{{ $stats['total_orders'] ?? 0 }}</span></div>
            <div class="stat-card">💰 Revenue<br><span class="value">₹{{ number_format($stats['total_revenue'] ?? 0) }}</span></div>
            <div class="stat-card">🕐 Pending<br><span class="value">{{ $stats['pending_orders'] ?? 0 }}</span></div>
            <div class="stat-card">⚠️ Low Stock<br><span class="value">{{ $stats['low_stock'] ?? 0 }}</span></div>
        </div>
{{-- ORDERS BY STATUS --}}
            <div class="section">
                <h2>📋 Orders by Status</h2>
                <div class="status-chart">
                    @foreach(['pending'=>'🕐','confirmed'=>'✅','shipped'=>'🚚','delivered'=>'🏠','cancelled'=>'❌'] as $s=>$icon)
                    <div class="status-item">
                        <div class="num">{{ $ordersByStatus[$s] ?? 0 }}</div>
                        <div class="lbl">{{ $icon }} {{ ucfirst($s) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
             {{-- TOP PRODUCTS --}}
            <div class="section">
                <h2>⭐ Top Products <a href="{{ route('admin.products.index') }}">View all</a></h2>
                @foreach($topProducts as $p)
                <div class="product-row">
                    <img src="{{ asset($p->image) }}" alt="{{ $p->name }}"
                         onerror="this.src='https://placehold.co/40x40?text=?'">
                    <div class="product-row-info">
                        <div class="product-row-name">{{ $p->name }}</div>
                        <div class="product-row-sub">{{ $p->category }} · Stock: {{ $p->stock }}</div>
                    </div>
                    <div class="product-row-price">₹{{ number_format($p->price,0) }}</div>
                </div>
                @endforeach
            </div>
        </div>
        {{-- RECENT ORDERS --}}
        <div class="section">
            <h2>🛒 Recent Orders</h2>

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
                         <th>Invoice</th> 
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders ?? [] as $order)
                    <tr>
                        {{-- <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ optional($order->placed_at)->format('d M Y') }}</td>
                        <td>₹{{ number_format($order->total ?? 0) }}</td> --}}
                         <td><a href="{{ route('admin.orders.show', $order->id) }}" style="font-size:.8rem">{{ $order->order_number }}</a></td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td style="white-space:nowrap">{{ $order->placed_at->format('d M Y') }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td style="font-weight:700">₹{{ number_format($order->total,0) }}</td>
                        <td>{{ strtoupper($order->payment_method) }}</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm">View</a></td>

                        <td>
                            <a href="{{ route('admin.invoice.download', $order->id) }}"
                            style="padding:5px 10px;background:#FF9900;color:#000;border-radius:4px;font-size:.75rem;font-weight:700">
                                📄 Invoice
                            </a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>
</div>

<footer>
    © 1996–2025  CartNova · Admin Panel · All rights reserved
</footer>

</body>
</html>