<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use Illuminate\Support\Facades\Auth;

class SavedItemController extends Controller
{
    // Save product
    public function store($productId)
    {
        SavedItem::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $productId
        ]);

        return back()->with('success', 'Product saved for later!');
    }

    // Show saved items
    public function index()
    {
        $savedItems = SavedItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('saved-items.index', compact('savedItems'));
    }

    // Remove saved item
    public function destroy($id)
    {
        SavedItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Removed from saved items');
    }
}