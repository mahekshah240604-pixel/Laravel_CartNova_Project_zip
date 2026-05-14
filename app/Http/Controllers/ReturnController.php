<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReturnRequest;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    // USER: submit return
    public function store(Request $request)
    {
        // ✅ Validation (IMPORTANT)
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reason' => 'required|string|max:255',
        ]);

        ReturnRequest::create([
            'order_id' => $request->order_id,
            'user_id' => Auth::id(),
            'order_item_id' => $request->order_item_id, // optional
            'reason' => $request->reason,
            'message' => $request->message,
            'pickup_address' => $request->pickup_address,
            'status' => 'pending', // ✅ ensure default
            'pickup_status' => 'pending',

        ]);

        return back()->with('success', 'Return request sent successfully');
    }

    // ADMIN: list all returns
    public function index()
    {
        $returns = ReturnRequest::with('order','user')->latest()->get();
        return view('admin.returns.index', compact('returns'));
    }

    // ADMIN: update status
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $return = ReturnRequest::findOrFail($id);
        $return->status = $request->status;
        $return->save();
         // ✅ ADD THIS (IMPORTANT)
    // ✅ ONLY when approved
    // if($request->status == 'approved'){

    //     // safety check
    //     if($return->order){
    //         $order = $return->order;

    //         // avoid duplicate update
    //         if($order->status !== 'returned'){
    //             $order->status = 'returned';
    //             $order->save();
    //         }
    //     }
    // }
    if($request->status == 'approved'){
    $return->pickup_status = 'scheduled';
    $return->pickup_date = now()->addDays(2); // 2 days later pickup
    $return->save();

    $order = $return->order;
    $order->status = 'returned';
    $order->save();
}

        return back()->with('success', 'Return updated');
    }
}