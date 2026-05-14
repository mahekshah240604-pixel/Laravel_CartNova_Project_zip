<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Address;
use App\Models\Wishlist;
use App\Models\GiftCard;
use App\Models\PaymentMethod;
use App\Models\CustomerSupport;
use App\Models\CustomerSupportNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\AddressSavedMail;
use App\Mail\PaymentMethodSavedMail;
use App\Mail\WishlistItemSavedMail;
use App\Mail\GiftCardSavedMail;
use App\Mail\CustomerSupportTicketMail;


class ProfileController extends Controller
{
    // ── Show Profile Dashboard ─────────────────────────────────
    // Route: GET /profile
    public function index()
    {
        $user   = Auth::user();
        $orders = \App\Models\Order::where('user_id', $user->id)
                    ->latest('placed_at')->limit(3)->get();

        return view('profile.index', compact('user', 'orders'));
    }

    // ── Edit Name ──────────────────────────────────────────────
    // Route: GET /profile/edit-name
    public function editName()
    {
        return view('profile.edit-name', ['user' => Auth::user()]);
    }

    // Route: POST /profile/edit-name
    public function updateName(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ], [
            'name.required' => 'Enter your name.',
            'name.min'      => 'Name must be at least 2 characters.',
        ]);

        // Auth::user()->update(['name' => $request->name]);
        //  $user = Auth::user();
        // $user->name = $request->name;
        // $user->save();
        // direct update (no save, no error)
          \App\Models\User::where('id', Auth::id())
        ->update(['name' => $request->name]);

        return redirect()->route('profile.index')
                         ->with('success', 'Your name has been updated successfully.');
    }

    // ── Edit Email ─────────────────────────────────────────────
    // Route: GET /profile/edit-email
    public function editEmail()
    {
        return view('profile.edit-email', ['user' => Auth::user()]);
    }

    // Route: POST /profile/edit-email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'password' => ['required', 'string'],
        ], [
            'email.required'  => 'Enter your email address.',
            'email.email'     => 'Enter a valid email address.',
            'email.unique'    => 'This email is already used by another account.',
            'password.required' => 'Enter your current password to confirm.',
        ]);

        // Verify current password
        if (!Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'Your current password is incorrect.'])
                         ->withInput();
        }

        // Auth::user()->update([
        //     'email'             => strtolower($request->email),
        //     'email_verified_at' => null, // reset verification
        // ]);
        \App\Models\User::where('id', Auth::id())
        ->update([
            'email' => strtolower($request->email),
            'email_verified_at' => null
        ]);

        return redirect()->route('profile.index')
                         ->with('success', 'Your email has been updated successfully.');
    }

    // ── Edit Password ──────────────────────────────────────────
    // Route: GET /profile/edit-password
    public function editPassword()
    {
        return view('profile.edit-password', ['user' => Auth::user()]);
    }

    // Route: POST /profile/edit-password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => ['required', 'string'],
            'password'              => ['required', 'confirmed', 'min:6',
                                        Password::min(6)->mixedCase()->numbers()],
            'password_confirmation' => ['required'],
        ], [
            'current_password.required' => 'Enter your current password.',
            'password.required'         => 'Enter your new password.',
            'password.confirmed'        => 'New passwords must match.',
            'password.min'              => 'Password must be at least 6 characters.',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        // Check new password is different from old
        if (Hash::check($request->password, Auth::user()->password)) {
            return back()->withErrors(['password' => 'New password must be different from current password.']);
        }

        // Auth::user()->update([
        //     'password' => Hash::make($request->password),
        // ]);
        \App\Models\User::where('id', Auth::id())
        ->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.index')
                         ->with('success', 'Your password has been changed successfully.');
    }

    // ── Edit Mobile Number ─────────────────────────────────────
    // Route: GET /profile/edit-mobile
    public function editMobile()
    {
        return view('profile.edit-mobile', ['user' => Auth::user()]);
    }

    // Route: POST /profile/edit-mobile
    public function updateMobile(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'digits:10'],
        ], [
            'phone.required' => 'Enter your mobile number.',
            'phone.digits'   => 'Enter a valid 10-digit mobile number.',
        ]);

        // Auth::user()->update(['phone' => $request->phone]);
        \App\Models\User::where('id', Auth::id())
        ->update(['phone' => $request->phone]);

        return redirect()->route('profile.index')
                         ->with('success', 'Your mobile number has been updated successfully.');
    }

    // public function addresses()
    // {
    //     $orders = \App\Models\Order::where('user_id', Auth::id())
    //                 ->latest()
    //                 ->get();

    //     return view('profile.addresses', compact('orders'));
    // }
    // public function addresses()
    //     {
    //         $orders = \App\Models\Order::where('user_id', Auth::id())
    //                     ->latest()
    //                     ->get()
    //                     ->unique(function ($order) {
    //                         return $order->full_name . $order->phone . $order->pincode;
    //                     });

    //         return view('profile.addresses', compact('orders'));
    //     }
    public function addresses()
{
    $addresses = \App\Models\Address::where('user_id', Auth::id())->get();

    return view('profile.addresses', compact('addresses'));
}

public function storeAddress(Request $request)
{
    $address=Address::create([
        'user_id' => Auth::id(),
        'full_name' => $request->full_name,
        'address_line1' => $request->address_line1,
        'address_line2' => $request->address_line2,
        'city' => $request->city,
        'state' => $request->state,
        'pincode' => $request->pincode,
        'phone' => $request->phone,
    ]);

    // ✅ EMAIL SEND
    Mail::to(Auth::user()->email)->send(new AddressSavedMail($address));

    return back()->with('success', 'Address saved + Email sent ✅');
    // return back()->with('success', 'Address added successfully');
}
public function payment()
    {
        $paymentMethods = PaymentMethod::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.payment', compact('paymentMethods'));
    }
    /**
     * Store a new payment method.
     */
    public function storePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:credit_card,debit_card,paypal,upi,net_banking,wallet',
            'nickname' => 'nullable|string|max:50',
            'is_default' => 'boolean',
            
            // Credit/Debit Card fields
            'card_number' => 'required_if:type,credit_card,debit_card|string|min:16|max:19',
            'cardholder_name' => 'required_if:type,credit_card,debit_card|string|max:100',
            'card_expiry_month' => 'required_if:type,credit_card,debit_card|string|min:2|max:2',
            'card_expiry_year' => 'required_if:type,credit_card,debit_card|string|min:4|max:4',
            'card_type' => 'required_if:type,credit_card,debit_card|in:visa,mastercard,amex,discover,rupay',
            
            // PayPal fields
            'paypal_email' => 'required_if:type,paypal|email|max:255',
            
            // UPI fields
            'upi_id' => 'required_if:type,upi|string|max:255',
            
            // Net Banking fields
            'bank_name' => 'required_if:type,net_banking|string|max:100',
            'bank_account_number' => 'required_if:type,net_banking|string|min:9|max:18',
            
            // Wallet fields
            'wallet_provider' => 'required_if:type,wallet|in:paytm,phonepe,googlepay,amazonpay,mobikwik',
            'wallet_number' => 'required_if:type,wallet|string|min:10|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Mask sensitive information
        if (in_array($data['type'], ['credit_card', 'debit_card'])) {
            $data['card_number'] = substr($data['card_number'], -4);
        }
        
        if ($data['type'] === 'net_banking') {
            $data['bank_account_number'] = substr($data['bank_account_number'], -4);
        }

        // Set as default if requested
        $data['is_default'] = $request->has('is_default');
        
        // Create payment method
        // $paymentMethod = Auth::user()->paymentMethods()->create($data);

        $paymentMethod = PaymentMethod::create(array_merge($data, ['user_id' => Auth::id()]));
        
        // Set as default and unset others
        if ($paymentMethod->is_default) {
            $paymentMethod->setAsDefault();
        }

         // ✅ EMAIL SEND
        Mail::to(Auth::user()->email)->send(new PaymentMethodSavedMail($paymentMethod, Auth::user()));

        return redirect()->route('profile.payment')
            ->with('success', 'Payment method added successfully!');
    }

    /**
     * Update payment method.
     */
    public function updatePayment(Request $request, PaymentMethod $paymentMethod)
    {
        // Check ownership
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'nickname' => 'nullable|string|max:50',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $data = $request->only(['nickname', 'is_default']);
        
        // Set as default if requested
        if ($request->has('is_default') && $request->is_default) {
            $paymentMethod->setAsDefault();
        } else {
            $paymentMethod->update($data);
        }

        return redirect()->route('profile.payment')
            ->with('success', 'Payment method updated successfully!');
    }

    /**
     * Delete payment method.
     */
    public function destroyPayment(PaymentMethod $paymentMethod)
    {
        // Check ownership
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $paymentMethod->delete();

        return redirect()->route('profile.payment')
            ->with('success', 'Payment method deleted successfully!');
    }

    /**
     * Set payment method as default.
     */
    public function setDefaultPayment(PaymentMethod $paymentMethod)
    {
        // Check ownership
        if ($paymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $paymentMethod->setAsDefault();

        return redirect()->route('profile.payment')
            ->with('success', 'Default payment method updated!');
    }

    public function wishlist()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.wishlist', compact('wishlistItems'));
    }

    /**
     * Add item to wishlist.
     */
    public function addToWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'product_price' => 'required|numeric|min:0',
            'product_image' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
            'priority' => 'nullable|in:low,medium,high',
            'notify_price_drop' => 'boolean',
            'target_price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if item already in wishlist
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'This item is already in your wishlist!');
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['priority'] = $data['priority'] ?? 'medium';
        $data['notify_price_drop'] = $request->has('notify_price_drop');

        Wishlist::create($data);

         // ✅ EMAIL SEND
        Mail::to(Auth::user()->email)->send(new WishlistItemSavedMail($data, Auth::user()));

        return redirect()->route('profile.wishlist')
            ->with('success', 'Item added to wishlist successfully!');
    }

    /**
     * Update wishlist item.
     */
    public function updateWishlist(Request $request, Wishlist $wishlist)
    {
        // Check ownership
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:500',
            'priority' => 'required|in:low,medium,high',
            'notify_price_drop' => 'boolean',
            'target_price' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $data = $request->only(['notes', 'priority', 'notify_price_drop', 'target_price']);
        $wishlist->update($data);

        return redirect()->route('profile.wishlist')
            ->with('success', 'Wishlist item updated successfully!');
    }

    /**
     * Remove item from wishlist.
     */
    public function removeFromWishlist(Wishlist $wishlist)
    {
        // Check ownership
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        $wishlist->delete();

        return redirect()->route('profile.wishlist')
            ->with('success', 'Item removed from wishlist successfully!');
    }

    /**
     * Move wishlist item to cart.
     */
    public function moveToCart(Wishlist $wishlist)
    {
        // Check ownership
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        // Add to cart logic here
        // Cart::create([...]);

        return redirect()->route('profile.wishlist')
            ->with('success', 'Item moved to cart successfully!');
    }

     public function giftCards()
    {
        $giftCards = GiftCard::where('user_id', Auth::id())
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.gift-cards', compact('giftCards'));
    }

    /**
     * Add new gift card.
     */
    public function addGiftCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_name' => 'required|string|max:255',
            'card_type' => 'required|in:amazon,flipkart,paypal,google_play,apple_itunes,starbucks,netflix,spotify,custom,other',
            'description' => 'nullable|string|max:1000',
            'initial_value' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:500',
            'priority' => 'nullable|in:low,medium,high',
            'notify_expiry' => 'boolean',
            'notify_low_balance' => 'boolean',
            'low_balance_threshold' => 'nullable|numeric|min:0',
            'purchase_source' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date|before_or_equal:today',
            'receipt_number' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['card_number'] = GiftCard::generateCardNumber();
        $data['card_code'] = GiftCard::generateCardCode();
        $data['priority'] = $data['priority'] ?? 'medium';
        $data['notify_expiry'] = $request->has('notify_expiry');
        $data['notify_low_balance'] = $request->has('notify_low_balance');
        $data['low_balance_threshold'] = $data['low_balance_threshold'] ?? 10.00;
        $data['status'] = 'active';
        $data['activated_at'] = now();

        $giftCard = GiftCard::create($data);

        // Email send
        Mail::to(Auth::user()->email)->send(new GiftCardSavedMail($giftCard, Auth::user()));

        return redirect()->route('profile.gift-cards')
            ->with('success', 'Gift card added and Email sent ');
    }

    /**
     * Update gift card.
     */
    public function updateGiftCard(Request $request, GiftCard $giftCard)
    {
        // Check ownership
        if ($giftCard->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'current_balance' => 'required|numeric|min:0',
            'status' => 'required|in:active,expired,used,inactive',
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:500',
            'priority' => 'required|in:low,medium,high',
            'notify_expiry' => 'boolean',
            'notify_low_balance' => 'boolean',
            'low_balance_threshold' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $data = $request->only(['current_balance', 'status', 'expiry_date', 'notes', 'priority', 'notify_expiry', 'notify_low_balance', 'low_balance_threshold']);
        
        // Update last used if balance changed
        if (isset($data['current_balance']) && $data['current_balance'] != $giftCard->current_balance) {
            $data['last_used_at'] = now();
        }
        
        $giftCard->update($data);

        return redirect()->route('profile.gift-cards')
            ->with('success', 'Gift card updated successfully!');
    }

    /**
     * Delete gift card.
     */
    public function deleteGiftCard(GiftCard $giftCard)
    {
        // Check ownership
        if ($giftCard->user_id !== Auth::id()) {
            abort(403);
        }

        $giftCard->delete();

        return redirect()->route('profile.gift-cards')
            ->with('success', 'Gift card deleted successfully!');
    }

     public function customerSupport()
    {
        // $supportTickets = CustomerSupport::where('user_id', Auth::id())
        $supportTickets = \App\Models\CustomerSupport::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.customer-support', compact('supportTickets'));
        // try {
        // $supportTickets = \App\Models\CustomerSupport::where('user_id', Auth::id())
        //     ->orderBy('created_at', 'desc')
        //     ->get();
 
        // return view('profile.customer-support', compact('supportTickets'));
        // } catch (\Exception $e) {
        //     return redirect()->route('profile.index')
        //         ->with('error', 'Unable to load support tickets: ' . $e->getMessage());
        // }

    }

    /**
     * Create new support ticket.
     */
    public function createSupportTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
            'category' => 'required|in:order_issue,payment_problem,product_inquiry,account_help,technical_support,refund_request,general_feedback,complaint,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'order_number' => 'nullable|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
            'product_id' => 'nullable|string|max:50',
            'email_notifications' => 'boolean',
            'contact_preference' => 'required|in:email,phone,both',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['ticket_number'] = CustomerSupport::generateTicketNumber();
        $data['status'] = 'open';
        $data['opened_at'] = now();
        $data['email_notifications'] = $request->has('email_notifications');

        $supportTicket = CustomerSupport::create($data);

         // Create notification
         CustomerSupportNotification::createNotification(
            Auth::id(),
            $supportTicket->id,
            'ticket_created',
            'Support Ticket Created',
            "Your support ticket #{$supportTicket->formatted_ticket_number} has been created successfully.",
            ['ticket_number' => $supportTicket->formatted_ticket_number]
        );

        // Email send
        Mail::to(Auth::user()->email)->send(new CustomerSupportTicketMail($supportTicket, Auth::user()));

        return redirect()->route('profile.customer-support')
            ->with('success', 'Support ticket created and Email sent ');
    }

    /**
     * Update support ticket.
     */
    public function updateSupportTicket(Request $request, CustomerSupport $supportTicket)
    {
        // Check ownership
        if ($supportTicket->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|min:10|max:2000',
            'satisfaction_rating' => 'nullable|integer|min:1|max:5',
            'feedback_comments' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        // Update ticket with new message
        $supportTicket->update([
            'message' => $supportTicket->message . "\n\n--- Customer Follow-up ---\n" . $request->message,
            'status' => 'pending_customer',
            'satisfaction_rating' => $request->satisfaction_rating,
            'feedback_comments' => $request->feedback_comments,
        ]);

        return redirect()->route('profile.customer-support')
            ->with('success', 'Support ticket updated successfully!');
    }

    /**
     * Close support ticket.
     */
    public function closeSupportTicket(CustomerSupport $supportTicket)
    {
        // Check ownership
        if ($supportTicket->user_id !== Auth::id()) {
            abort(403);
        }

        $supportTicket->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()->route('profile.customer-support')
            ->with('success', 'Support ticket closed successfully!');
    }

     public function customerSupportNotifications()
    {
        try {
            $notifications = \App\Models\CustomerSupportNotification::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

            $unreadCount = \App\Models\CustomerSupportNotification::getUnreadCount(Auth::id());

            return view('profile.customer-support-notifications', compact('notifications', 'unreadCount'));
        } catch (\Exception $e) {
            return redirect()->route('profile.index')
                ->with('error', 'Unable to load notifications: ' . $e->getMessage());
        }
    }

    /**
     * Mark notification as read.
     */
    public function markNotificationAsRead($notificationId)
    {
        try {
            $notification = \App\Models\CustomerSupportNotification::find($notificationId);
            
            if (!$notification || $notification->user_id !== Auth::id()) {
                return response()->json(['success' => false], 403);
            }

            $notification->markAsRead();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsAsRead()
    {
        try {
            $count = \App\Models\CustomerSupportNotification::markAllAsRead(Auth::id());
            
            return redirect()->route('profile.customer-support-notifications')
                ->with('success', "Marked {$count} notifications as read.");
        } catch (\Exception $e) {
            return redirect()->route('profile.customer-support-notifications')
                ->with('error', 'Unable to mark notifications as read.');
        }
    }

    /**
     * Delete notification.
     */
    public function deleteNotification($notificationId)
    {
        try {
            $notification = \App\Models\CustomerSupportNotification::find($notificationId);
            
            if (!$notification || $notification->user_id !== Auth::id()) {
                return response()->json(['success' => false], 403);
            }

            $notification->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function registry()
{
    // For now static data (later DB use karisu)
    $registries = [
        ['id' => 1, 'name' => 'Birthday Wishlist', 'desc' => 'For upcoming birthday'],
        ['id' => 2, 'name' => 'Wedding Registry', 'desc' => 'Wedding gifts'],
    ];

    return view('profile.registry', compact('registries'));
}

public function createRegistry()
{
    // later DB logic
    return back()->with('success', 'Registry created!');
}

public function deleteRegistry($id)
{
    // later DB delete
    return back()->with('success', 'Registry deleted!');
}

public function sell()
{
    return view('profile.sell');
}
public function storeProduct(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required',
        'category' => 'required',
        'image_file' => 'required|image'
    ]);

    $imagePath = null;

    // ✅ IMAGE UPLOAD LOGIC
    if ($request->hasFile('image_file')) {
        $file = $request->file('image_file');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('images/products'), $filename);

        $imagePath = 'images/products/'.$filename;
    }

    \App\Models\Product::create([
        'user_id' => Auth::id(),
    'name' => $request->name,
    'description' => $request->description,
    'category' => $request->category,
    'brand' => $request->brand,
    'price' => $request->price,
    'original_price' => $request->original_price,
    'discount' => $request->discount ?? 0,
    'stock' => $request->stock ?? 0,
    'rating' => $request->rating ?? 0,
    'reviews_count' => $request->reviews_count ?? 0,
    'is_prime' => $request->has('is_prime'),
    'is_featured' => $request->has('is_featured'),
    'image' => $imagePath,
    ]);

    return back()->with('success', 'Product added successfully!');
}
}