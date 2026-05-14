{{-- resources/views/admin/products/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin - Edit Product</title>
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
        .sidebar a{display:flex;align-items:center;gap:10px;padding:9px 16px;color:#bdc3c7;font-size:.875rem;border-left:3px solid transparent;transition:background .15s}
        .sidebar a:hover,.sidebar a.active{background:rgba(255,255,255,.08);color:#fff;border-left-color:var(--orange);text-decoration:none}
        .sidebar a .icon{font-size:1rem;width:20px;text-align:center}
        .main{flex:1;padding:20px;max-width:900px}
        .card{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:24px;margin-bottom:16px}
        .card h2{font-size:1rem;font-weight:700;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-grid.full{grid-template-columns:1fr}
        .form-grid.three{grid-template-columns:1fr 1fr 1fr}
        .field{display:flex;flex-direction:column;gap:4px}
        .field label{font-size:.82rem;font-weight:700;color:var(--text)}
        .field input,.field select,.field textarea{border:1px solid #949494;border-radius:4px;padding:8px 10px;font-size:.9rem;font-family:inherit;outline:none;width:100%;transition:border-color .12s,box-shadow .12s}
        .field input:focus,.field select:focus,.field textarea:focus{border-color:#e77600;box-shadow:0 0 0 3px rgba(228,121,17,.2)}
        .field textarea{min-height:80px;resize:vertical}
        .ferr{font-size:.75rem;color:var(--error)}
        .hint{font-size:.75rem;color:var(--muted)}
        .check-group{display:flex;align-items:center;gap:8px;font-size:.875rem}
        .check-group input{width:16px;height:16px;accent-color:var(--orange)}
        .img-preview{width:80px;height:80px;object-fit:contain;border:1px solid var(--border);border-radius:4px;background:#f9f9f9;padding:4px;margin-top:6px}
        .btn-row{display:flex;gap:10px;margin-top:8px}
        .btn{display:inline-block;padding:9px 20px;border-radius:4px;font-size:.875rem;cursor:pointer;font-family:inherit;border:1px solid;text-decoration:none}
        .btn-primary{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border-color:#a88734;color:var(--text);font-weight:700}
        .btn-primary:hover{filter:brightness(1.04)}
        .btn-cancel{background:var(--white);border-color:var(--border);color:var(--text)}
        .btn-cancel:hover{background:#f7f7f7;text-decoration:none;color:var(--text)}
        .alert-error{background:#fff8f8;border:1px solid var(--error);color:var(--error);border-radius:4px;padding:10px 14px;margin-bottom:14px;font-size:.875rem}
        footer{background:var(--hdr);color:#888;text-align:center;padding:12px;font-size:.75rem;margin-top:auto}
        @media(max-width:768px){.sidebar{display:none}.form-grid,.form-grid.three{grid-template-columns:1fr}}
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
        <a href="{{ route('admin.products.create') }}" class="active"><span class="icon">➕</span> Edit Product</a>
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
        <h1 style="font-size:1.3rem;font-weight:700;margin-bottom:16px">➕ Edit Product</h1>

        @if($errors->any())
            <div class="alert-error">
                <strong>Please fix these errors:</strong>
                <ul style="padding-left:16px;margin-top:6px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Basic Info --}}
            <div class="card">
                <h2>📋 Basic Information</h2>
                <div class="form-grid full" style="margin-bottom:12px">
                    <div class="field">
                        <label>Product Name *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="e.g. Apple iPhone 15 Pro Max">
                        @error('name')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-grid" style="margin-bottom:12px">
                    <div class="field">
                        <label>Category *</label>
                        <select name="category">
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $product->category)==$cat?'selected':'' }}>{{ $cat }}</option>
                            @endforeach
                            <option value="new_category">+ Add new category</option>
                        </select>
                        @error('category')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Brand</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" placeholder="e.g. Apple">
                    </div>
                </div>
                <div class="form-grid full">
                    <div class="field">
                        <label>Description</label>
                        <textarea name="description" placeholder="Product description...">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Pricing --}}
            <div class="card">
                <h2>💰 Pricing & Stock</h2>
                <div class="form-grid three" style="margin-bottom:12px">
                    <div class="field">
                        <label>Selling Price (₹) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="0.00" step="0.01" min="0">
                        @error('price')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Original Price (₹)</label>
                        <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" placeholder="0.00" step="0.01" min="0">
                        <span class="hint">MRP / crossed-out price</span>
                    </div>
                    <div class="field">
                        <label>Discount (%)</label>
                        <input type="number" name="discount" value="{{ old('discount', $product->discount) }}" min="0" max="100">
                    </div>
                </div>
                <div class="form-grid three">
                    <div class="field">
                        <label>Stock Quantity *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0">
                        @error('stock')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Rating (0-5)</label>
                        <input type="number" name="rating" value="{{ old('rating', $product->rating) }}" step="0.1" min="0" max="5">
                    </div>
                    <div class="field">
                        <label>Reviews Count</label>
                        <input type="number" name="reviews_count" value="{{ old('reviews_count', $product->reviews_count) }}" min="0">
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="card">
                <h2>🖼️ Product Image</h2>
                <div class="form-grid">
                    <div class="field">
                        <label>Upload Image File</label>
                        <input type="file" name="image_file" accept="image/*"
                               onchange="previewImg(this)">
                        <span class="hint">JPG/PNG, recommended 400×400px</span>
                        <img id="imgPreview" class="img-preview" style="display:none" alt="preview">
                    </div>
                    <div class="field">
                        <label>Or Image Path (if already in public folder)</label>
                        <input type="text" name="image" value="{{ old('image', $product->image) }}"
                               placeholder="images/products/filename.jpg">
                        <span class="hint">Relative to public/ folder</span>
                    </div>
                </div>
            </div>

            {{-- Options --}}
            <div class="card">
                <h2>⚙️ Options</h2>
                <div style="display:flex;gap:24px;flex-wrap:wrap">
                    <label class="check-group">
                        <input type="checkbox" name="is_prime" value="1" {{ old('is_prime', $product->is_prime) ? 'checked' : '' }}>
                        ⚡ Prime Eligible
                    </label>
                    <label class="check-group">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        ⭐ Featured Product
                    </label>
                </div>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn btn-primary">💾 Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </main>
</div>
<footer>© 1996–2025, CartNova.com, Inc. Admin Panel</footer>
<script>
function previewImg(input) {
    var preview = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
</body>
</html>