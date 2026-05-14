<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin - Edit Coupon</title>
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
        .main{flex:1;padding:20px;max-width:750px}
        .card{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:22px;margin-bottom:14px}
        .card h2{font-size:1rem;font-weight:700;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid var(--border)}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-grid.three{grid-template-columns:1fr 1fr 1fr}
        .form-grid.full{grid-template-columns:1fr}
        .field{display:flex;flex-direction:column;gap:4px}
        .field label{font-size:.82rem;font-weight:700}
        .field input,.field select,.field textarea{border:1px solid #949494;border-radius:4px;padding:8px 10px;font-size:.9rem;font-family:inherit;outline:none;width:100%;transition:border-color .12s,box-shadow .12s}
        .field input:focus,.field select:focus{border-color:#e77600;box-shadow:0 0 0 3px rgba(228,121,17,.2)}
        .field .hint{font-size:.75rem;color:var(--muted)}
        .ferr{font-size:.75rem;color:var(--error)}
        .check-row{display:flex;align-items:center;gap:8px;font-size:.875rem}
        .check-row input{width:16px;height:16px;accent-color:var(--orange)}
        .preview-box{background:linear-gradient(135deg,#131921,#232f3e);border-radius:8px;padding:20px;color:#fff;text-align:center;margin-bottom:14px}
        .preview-code{font-size:2rem;font-weight:900;letter-spacing:4px;color:var(--orange);font-family:monospace}
        .preview-label{font-size:1rem;margin-top:6px;color:#ccc}
        .preview-desc{font-size:.82rem;color:#888;margin-top:4px}
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
        <a href="/"><span class="icon">📊</span> Dashboard</a>
        <div class="sidebar-section">Catalog</div>
        <a href="/admin/products"><span class="icon">📦</span> Products</a>
        <a href="/admin/products/create"><span class="icon">➕</span> Add Product</a>
        <div class="sidebar-section">Sales</div>
        <a href="/admin/orders"><span class="icon">🛒</span> All Orders</a>
         <a href="{{ route('admin.returns') }}">🔁 Returns</a>
        <a href="{{ route('admin.coupons.index') }}" class="active"><span class="icon">🎟️</span> Coupons</a>
        <div class="sidebar-section">Users</div>
        <a href="/admin/users"><span class="icon">👥</span> All Users</a>
        <div class="sidebar-section">Store</div>
        <a href="{{ route('home') }}">🏠 View Store</a>
    </nav>
    <main class="main">
        <h1 style="font-size:1.3rem;font-weight:700;margin-bottom:16px">🎟️ Edit Coupon: {{ $coupon->code }}</h1>

        @if($errors->any())
            <div class="alert-error">
                <strong>Please fix these errors:</strong>
                <ul style="padding-left:16px;margin-top:4px">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        {{-- Live Preview --}}
        <div class="preview-box" id="previewBox">
            <div class="preview-code" id="previewCode">{{ $coupon->code }}</div>
            <div class="preview-label" id="previewLabel">
                @if($coupon->type == 'percentage')
                    {{ $coupon->value }}% OFF
                @else
                    ₹{{ number_format($coupon->value, 0) }} OFF
                @endif
            </div>
            <div class="preview-desc" id="previewDesc">{{ $coupon->description ?: 'Coupon preview' }}</div>
        </div>

        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Basic --}}
            <div class="card">
                <h2>📋 Coupon Details</h2>
                <div class="form-grid" style="margin-bottom:12px">
                    <div class="field">
                        <label>Coupon Code *</label>
                        <input type="text" name="code" id="codeInput"
                               value="{{ old('code', $coupon->code) }}"
                               placeholder="e.g. SAVE50"
                               oninput="this.value=this.value.toUpperCase();updatePreview()"
                               style="font-family:monospace;font-size:1rem;font-weight:700;letter-spacing:2px">
                        @error('code')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Description</label>
                        <input type="text" name="description" value="{{ old('description', $coupon->description) }}"
                               placeholder="e.g. Get 50% off on all orders"
                               oninput="document.getElementById('previewDesc').textContent=this.value||'Coupon preview'">
                        @error('description')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="form-grid three">
                    <div class="field">
                        <label>Discount Type *</label>
                        <select name="type" id="typeSelect" onchange="updatePreview()">
                            <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}">
                                Percentage (%)
                            </option>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}">
                                Fixed Amount (₹)
                            </option>
                        </select>
                        @error('type')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Discount Value *</label>
                        <input type="number" name="value" id="valueInput"
                               value="{{ old('value', $coupon->value) }}" min="1" step="0.01"
                               placeholder="e.g. 50"
                               oninput="updatePreview()">
                        @error('value')<span class="ferr">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Max Discount Cap (₹)</label>
                        <input type="number" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}"
                               min="0" step="0.01" placeholder="Leave blank = no cap">
                        <span class="hint">Only for % coupons</span>
                    </div>
                </div>
            </div>

            {{-- Restrictions --}}
            <div class="card">
                <h2>🔒 Restrictions & Limits</h2>
                <div class="form-grid three" style="margin-bottom:12px">
                    <div class="field">
                        <label>Min Order Amount (₹)</label>
                        <input type="number" name="min_order_amount"
                               value="{{ old('min_order_amount', $coupon->min_order_amount) }}" min="0" step="1" placeholder="0">
                        <span class="hint">0 = no minimum</span>
                    </div>
                    <div class="field">
                        <label>Total Usage Limit</label>
                        <input type="number" name="usage_limit"
                               value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1" placeholder="Leave blank = unlimited">
                        <span class="hint">Max total uses</span>
                    </div>
                    <div class="field">
                        <label>Per User Limit</label>
                        <input type="number" name="per_user_limit"
                               value="{{ old('per_user_limit', $coupon->per_user_limit) }}" min="1" placeholder="1">
                        <span class="hint">Uses per customer</span>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label>Start Date</label>
                        <input type="datetime-local" name="starts_at"
                               value="{{ old('starts_at', $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}">
                        <span class="hint">Leave blank = active immediately</span>
                    </div>
                    <div class="field">
                        <label>Expiry Date</label>
                        <input type="datetime-local" name="expires_at"
                               value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
                        <span class="hint">Leave blank = never expires</span>
                    </div>
                </div>
                <div style="margin-top:12px">
                    <label class="check-row">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                        Coupon is Active
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:10px">
                <button type="submit" class="btn btn-primary">💾 Update Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </main>
</div>
<footer>© 1996–2025, CartNova.com, Inc. Admin Panel</footer>
<script>
function updatePreview() {
    const code  = document.getElementById('codeInput').value || 'YOURCODE';
    const type  = document.getElementById('typeSelect').value;
    const value = document.getElementById('valueInput').value;

    document.getElementById('previewCode').textContent = code;

    if (value) {
        const label = type === 'percentage'
            ? value + '% OFF'
            : '₹' + parseInt(value).toLocaleString('en-IN') + ' OFF';
        document.getElementById('previewLabel').textContent = label;
    } else {
        document.getElementById('previewLabel').textContent = 'Enter discount value';
    }
}
</script>
</body>
</html>