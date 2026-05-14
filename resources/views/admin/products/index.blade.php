{{-- resources/views/admin/products/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CartNova Admin — Products</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--sidebar:#1a252f;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#f0f2f5;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
        .topbar{background:var(--hdr);display:flex;align-items:center;padding:10px 20px;gap:16px}
        .logo{font-size:1.3rem;font-weight:900;color:#fff;font-family:Arial Black,sans-serif}
        .logo span{color:var(--orange)}
        .admin-badge{background:var(--orange);color:var(--hdr);font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:3px;margin-left:4px}
        .topbar-right{margin-left:auto;display:flex;align-items:center;gap:12px}
        .topbar-right a{color:#ccc;font-size:.85rem}
        .layout{display:flex;flex:1}
        .sidebar{width:220px;background:var(--sidebar);flex-shrink:0;padding:16px 0}
        .sidebar-section{padding:6px 16px;font-size:.7rem;color:#7f8c8d;text-transform:uppercase;letter-spacing:.5px;margin-top:12px;margin-bottom:4px}
        .sidebar a{display:flex;align-items:center;gap:10px;padding:9px 16px;color:#bdc3c7;font-size:.875rem;transition:background .15s;border-left:3px solid transparent}
        .sidebar a:hover,.sidebar a.active{background:rgba(255,255,255,.08);color:#fff;border-left-color:var(--orange);text-decoration:none}
        .sidebar a .icon{font-size:1rem;width:20px;text-align:center}
        .main{flex:1;padding:20px;overflow-x:hidden}
        .alert{padding:10px 16px;border-radius:4px;margin-bottom:14px;font-size:.875rem;border:1px solid}
        .alert-success{background:#f0fff4;border-color:var(--green);color:var(--green)}
        .alert-error{background:#fff8f8;border-color:var(--error);color:var(--error)}
        .toolbar{display:flex;align-items:center;gap:10px;margin-bottom:14px;flex-wrap:wrap}
        .toolbar h1{font-size:1.3rem;font-weight:700;margin-right:auto}
        .toolbar input,.toolbar select{border:1px solid var(--border);border-radius:4px;padding:7px 10px;font-size:.85rem;outline:none}
        .toolbar input:focus,.toolbar select:focus{border-color:var(--orange)}
        .btn{display:inline-block;padding:7px 14px;border-radius:4px;font-size:.85rem;cursor:pointer;font-family:inherit;border:1px solid;text-decoration:none;transition:filter .12s}
        .btn:hover{filter:brightness(1.04);text-decoration:none}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border-color:#a88734;color:var(--text);font-weight:700}
        .btn-danger{background:#fff;border-color:var(--error);color:var(--error)}
        .btn-danger:hover{background:#fff8f8}
        .btn-sm{padding:4px 10px;font-size:.78rem}
        .btn-edit{background:#fff;border-color:var(--link);color:var(--link)}
        table{width:100%;border-collapse:collapse;font-size:.85rem;background:var(--white);border:1px solid var(--border);border-radius:8px;overflow:hidden}
        th{background:#f7f8f8;padding:10px 12px;text-align:left;font-weight:700;color:var(--muted);border-bottom:2px solid var(--border)}
        td{padding:9px 12px;border-bottom:1px solid #f5f5f5;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#fafafa}
        .product-img{width:44px;height:44px;object-fit:contain;border:1px solid var(--border);border-radius:4px;background:#fff;padding:2px}
        .stock-low{color:var(--error);font-weight:700}
        .stock-ok{color:var(--green)}
        .badge{display:inline-block;padding:2px 8px;border-radius:10px;font-size:.72rem;font-weight:700}
        .badge-yes{background:#d4edda;color:#155724}
        .badge-no{background:#f5f5f5;color:#888}
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
        <a href="{{ route('admin.products.index') }}" class="active"><span class="icon">📦</span> Products</a>
        <a href="{{ route('admin.products.create') }}"><span class="icon">➕</span> Add Product</a>
        <div class="sidebar-section">Sales</div>
        <a href="{{ route('admin.orders.index') }}"><span class="icon">🛒</span> All Orders</a>
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

        <div class="toolbar">
            <h1>📦 Products ({{ $products->total() }})</h1>
            <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or brand...">
                <select name="category" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Search</button>
                @if(request('search')||request('category'))
                    <a href="{{ route('admin.products.index') }}" class="btn" style="border-color:var(--border)">Clear</a>
                @endif
            </form>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Add Product</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Rating</th>
                    <th>Prime</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <img class="product-img" src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                             onerror="this.src='https://placehold.co/44x44?text=?'">
                    </td>
                    <td style="max-width:180px">
                        <div style="font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $product->name }}</div>
                        @if($product->discount > 0)<div style="font-size:.72rem;color:var(--green)">-{{ $product->discount }}% off</div>@endif
                    </td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->brand }}</td>
                    <td style="white-space:nowrap">
                        <strong>₹{{ number_format($product->price,0) }}</strong>
                        @if($product->original_price)
                            <div style="font-size:.72rem;color:var(--muted);text-decoration:line-through">₹{{ number_format($product->original_price,0) }}</div>
                        @endif
                    </td>
                    <td class="{{ $product->stock <= 5 ? 'stock-low' : 'stock-ok' }}">{{ $product->stock }}</td>
                    <td>⭐ {{ $product->rating }}</td>
                    <td><span class="badge {{ $product->is_prime ? 'badge-yes' : 'badge-no' }}">{{ $product->is_prime ? 'Yes' : 'No' }}</span></td>
                    <td><span class="badge {{ $product->is_featured ? 'badge-yes' : 'badge-no' }}">{{ $product->is_featured ? 'Yes' : 'No' }}</span></td>
                    <td style="white-space:nowrap">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-edit btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline"
                              onsubmit="return confirm('Delete {{ addslashes($product->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination">
            @if($products->onFirstPage())<span class="disabled">← Prev</span>@else<a href="{{ $products->previousPageUrl() }}">← Prev</a>@endif
            @foreach(range(1,$products->lastPage()) as $p)
                @if($p==$products->currentPage())<span class="active">{{ $p }}</span>
                @else<a href="{{ $products->url($p) }}">{{ $p }}</a>@endif
            @endforeach
            @if($products->hasMorePages())<a href="{{ $products->nextPageUrl() }}">Next →</a>@else<span class="disabled">Next →</span>@endif
        </div>
    </main>
</div>
<footer>© 1996–2025, CartNova · Admin Panel · All rights reserved</footer>
</body>
</html>