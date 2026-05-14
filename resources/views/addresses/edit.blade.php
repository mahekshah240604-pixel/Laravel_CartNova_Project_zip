{{-- resources/views/addresses/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon - Edit Address</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{--orange:#FF9900;--hdr:#131921;--text:#0F1111;--muted:#565959;--link:#007185;--border:#ddd;--bg:#EAEDED;--white:#fff;--error:#CC0C39;--green:#007600;}
        body{font-family:Arial,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh;display:flex;flex-direction:column}
        a{text-decoration:none;color:var(--link)}
        .hdr{background:var(--hdr);display:flex;align-items:center;justify-content:space-between;padding:10px 20px}
        .logo{font-size:1.6rem;font-weight:900;color:#fff;letter-spacing:-1px;font-family:Arial Black,sans-serif}
        .logo span{color:var(--orange)}
        .breadcrumb{background:var(--white);padding:8px 16px;font-size:.8rem;color:var(--muted);border-bottom:1px solid var(--border)}
        .breadcrumb a{color:var(--link)}
        .page{max-width:620px;margin:20px auto;padding:0 16px;flex:1;width:100%}
        .card{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:24px 28px}
        .card h1{font-size:1.3rem;font-weight:400;margin-bottom:20px;padding-bottom:12px;border-bottom:1px solid var(--border)}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px}
        .form-row.full{grid-template-columns:1fr}
        .form-row.three{grid-template-columns:1fr 1fr 1fr}
        .field{display:flex;flex-direction:column;gap:4px}
        .field label{font-size:.875rem;font-weight:700}
        .field input,.field select{border:1px solid #949494;border-radius:4px;padding:8px 10px;font-size:.9rem;font-family:inherit;color:var(--text);outline:none;width:100%;transition:border-color .12s,box-shadow .12s}
        .field input:focus,.field select:focus{border-color:#e77600;box-shadow:0 0 0 3px rgba(228,121,17,.2)}
        .field input.err,.field select.err{border-color:var(--error)}
        .ferr{font-size:.78rem;color:var(--error)}
        .hint{font-size:.75rem;color:var(--muted)}

        /* TYPE SELECTOR */
        .type-group{display:flex;gap:10px;flex-wrap:wrap}
        .type-option{flex:1;min-width:80px}
        .type-option input{display:none}
        .type-option label{display:flex;flex-direction:column;align-items:center;gap:4px;padding:10px;border:1px solid var(--border);border-radius:6px;cursor:pointer;font-size:.82rem;font-weight:700;color:var(--muted);transition:border-color .15s,color .15s,background .15s}
        .type-option input:checked + label{border-color:var(--orange);color:var(--orange);background:#fffdf7}
        .type-option label .icon{font-size:1.4rem}

        /* DEFAULT CHECKBOX */
        .check-row{display:flex;align-items:center;gap:8px;font-size:.875rem;margin-bottom:16px}
        .check-row input{width:16px;height:16px;accent-color:var(--orange)}

        /* BUTTONS */
        .btn-save{background:linear-gradient(to bottom,#f7dfa5,#f0c14b);border:1px solid #a88734;border-radius:4px;padding:10px 24px;font-size:.9rem;font-weight:700;cursor:pointer;font-family:inherit;color:var(--text)}
        .btn-save:hover{filter:brightness(1.04)}
        .btn-cancel{background:var(--white);border:1px solid var(--border);border-radius:4px;padding:10px 16px;font-size:.9rem;font-family:inherit;color:var(--text);margin-left:8px;text-decoration:none;display:inline-block}
        .btn-cancel:hover{background:#f7f7f7;text-decoration:none;color:var(--text)}

        .alert-error{background:#fff8f8;border:1px solid var(--error);color:var(--error);border-radius:4px;padding:10px 14px;margin-bottom:14px;font-size:.875rem}
        footer{background:var(--hdr);color:#ccc;text-align:center;padding:16px;margin-top:auto}
        .foot-copy{font-size:.75rem;color:#888}
        @media(max-width:480px){.form-row,.form-row.three{grid-template-columns:1fr}}
    </style>
</head>
<body>
<header class="hdr">
    <a href="{{ route('home') }}" style="text-decoration:none">
        <div class="logo">amazon<span>.</span></div>
    </a>
    <a href="{{ route('addresses.index') }}" style="color:#ccc;font-size:.85rem">← Your Addresses</a>
</header>
<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a> ›
    <a href="{{ route('addresses.index') }}">Your Addresses</a> ›
    Edit Address
</div>

<div class="page">

    @if($errors->any())
        <div class="alert-error">
            <strong>Please fix these errors:</strong>
            <ul style="padding-left:16px;margin-top:4px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <h1>Edit Address</h1>

        <form action="{{ route('addresses.update', $address->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            {{-- Address Type --}}
            <div style="margin-bottom:16px">
                <div style="font-size:.875rem;font-weight:700;margin-bottom:8px">Address Type</div>
                <div class="type-group">
                    <div class="type-option">
                        <input type="radio" id="type_home" name="type" value="home"
                               {{ old('type', \$address->type) == 'home' ? 'checked' : '' }}>
                        <label for="type_home"><span class="icon">🏠</span>Home</label>
                    </div>
                    <div class="type-option">
                        <input type="radio" id="type_work" name="type" value="work"
                               {{ old('type', \$address->type) == 'work' ? 'checked' : '' }}>
                        <label for="type_work"><span class="icon">💼</span>Work</label>
                    </div>
                    <div class="type-option">
                        <input type="radio" id="type_other" name="type" value="other"
                               {{ old('type', \$address->type) == 'other' ? 'checked' : '' }}>
                        <label for="type_other"><span class="icon">📍</span>Other</label>
                    </div>
                </div>
            </div>

            {{-- Name & Phone --}}
            <div class="form-row">
                <div class="field">
                    <label for="full_name">Full Name *</label>
                    <input type="text" id="full_name" name="full_name"
                           value="{{ old('full_name', \$address->full_name) }}"
                           placeholder="First and last name">
                    @error('full_name')<span class="ferr">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone"
                           value="{{ old('phone', \$address->phone) }}"
                           placeholder="10-digit mobile number" maxlength="10"
                           oninput="this.value=this.value.replace(/\D/g,'').substring(0,10)">
                    @error('phone')<span class="ferr">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Address Line 1 --}}
            <div class="form-row full">
                <div class="field">
                    <label for="address_line1">Address Line 1 *</label>
                    <input type="text" id="address_line1" name="address_line1"
                           value="{{ old('address_line1', \$address->address_line1) }}"
                           placeholder="House No., Building, Street, Area">
                    @error('address_line1')<span class="ferr">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Address Line 2 --}}
            <div class="form-row full">
                <div class="field">
                    <label for="address_line2">Address Line 2 <span style="font-weight:400;color:var(--muted)">(Optional)</span></label>
                    <input type="text" id="address_line2" name="address_line2"
                           value="{{ old('address_line2', \$address->address_line2) }}"
                           placeholder="Landmark, Colony, Nearby (optional)">
                </div>
            </div>

            {{-- City, State, Pincode --}}
            <div class="form-row three">
                <div class="field">
                    <label for="city">City *</label>
                    <input type="text" id="city" name="city"
                           value="{{ old('city', \$address->city) }}" placeholder="City">
                    @error('city')<span class="ferr">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="state">State *</label>
                    <select id="state" name="state">
                        <option value="">Select State</option>
                        @foreach(['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Delhi','Jammu & Kashmir','Ladakh','Puducherry'] as $state)
                            <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}</option>
                        @endforeach
                    </select>
                    @error('state')<span class="ferr">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="pincode">Pincode *</label>
                    <input type="text" id="pincode" name="pincode"
                           value="{{ old('pincode', \$address->pincode) }}" placeholder="6-digit pincode"
                           maxlength="6" oninput="this.value=this.value.replace(/\D/g,'').substring(0,6)">
                    @error('pincode')<span class="ferr">{{ $message }}</span>@enderror
                </div>
            </div>

            {{-- Default --}}
            <label class="check-row">
                <input type="checkbox" name="is_default" value="1"
                       {{ old('is_default', \$address->is_default) ? 'checked' : '' }}>
                Make this my default address
            </label>

            <div>
                <button type="submit" class="btn-save">Update Address</button>
                <a href="{{ route('addresses.index') }}" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</div>
<footer><p class="foot-copy">© 1996–2025, Amazon.com, Inc. or its affiliates</p></footer>
</body>
</html>