<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // ── Suggestions ─────────────────────────────
    public function suggestions(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '') {

            $popular = Product::select('category')
                ->distinct()
                ->limit(6)
                ->pluck('category')
                ->map(fn ($c) => [
                    'text' => $c,
                    'type' => 'category'
                ]);

            $topProducts = Product::orderBy('reviews_count', 'desc')
                ->limit(4)
                ->get(['id','name','image','price','rating']);

            return response()->json([
                'query' => '',
                'suggestions' => $popular,
                'products' => $topProducts,
                'popular' => true
            ]);
        }

        $nameSuggestions = Product::where('name', 'like', "%{$query}%")
            ->orWhere('brand', 'like', "%{$query}%")
            ->orWhere('category', 'like', "%{$query}%")
            ->limit(6)
            ->get(['id','name','brand','category','image','price','rating','discount']);

        $categories = Product::where('category', 'like', "%{$query}%")
            ->distinct()
            ->limit(3)
            ->pluck('category');

        $suggestions = [];

        foreach ($categories as $cat) {
            $suggestions[] = [
                'text' => $cat,
                'type' => 'category',
                'url'  => route('products.index', ['category' => $cat]),
            ];
        }

        foreach ($nameSuggestions as $p) {
            $suggestions[] = [
                'text' => $p->name,
                'sub'  => 'in ' . $p->category,
                'type' => 'product',
                'url'  => route('products.show', $p->id),
            ];
        }

        $products = $nameSuggestions->take(4)->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'image' => asset($p->image),
            'price' => '₹' . number_format($p->price, 0),
            'rating' => $p->rating,
            'discount' => $p->discount,
            'url' => route('products.show', $p->id),
        ]);

        return response()->json([
            'query' => $query,
            'suggestions' => array_slice($suggestions, 0, 8),
            'products' => $products,
            'popular' => false
        ]);
    }

    // ── Results ─────────────────────────────
    public function results(Request $request)
    {
        $query = trim($request->get('q', ''));

        if ($query === '') {
            return redirect()->route('products.index');
        }

        // ── SEARCH HISTORY (clean) ──
        $history = session('search_history', []);

        $history = array_values(array_filter($history, fn ($h) => $h !== $query));
        array_unshift($history, $query);

        session(['search_history' => array_slice($history, 0, 10)]);

        // ── BASE QUERY ──
        $products = Product::query()->where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('brand', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%")
              ->orWhere('category', 'like', "%{$query}%");
        });

        // ── FILTERS ──
        if ($request->filled('category') && $request->category !== 'All') {
            $products->where('category', $request->category);
        }

        if ($request->filled('min_price')) {
            $products->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $products->where('price', '<=', $request->max_price);
        }

        if ($request->filled('rating')) {
            $products->where('rating', '>=', $request->rating);
        }

        // ── SORT ──
        $sort = $request->get('sort', 'relevance');

        if ($sort === 'price_low') {
            $products->orderBy('price', 'asc');
        } elseif ($sort === 'price_high') {
            $products->orderBy('price', 'desc');
        } elseif ($sort === 'rating') {
            $products->orderBy('rating', 'desc');
        } elseif ($sort === 'newest') {
            $products->orderBy('created_at', 'desc');
        } else {
            $products->orderByRaw("
                CASE
                    WHEN name LIKE ? THEN 1
                    WHEN brand LIKE ? THEN 2
                    WHEN category LIKE ? THEN 3
                    ELSE 4
                END
            ", ["%{$query}%", "%{$query}%", "%{$query}%"])
            ->orderBy('reviews_count', 'desc');
        }

        $results = $products->paginate(12)->withQueryString();

        $categories = Product::distinct()->pluck('category')->sort()->values();

        return view('search.results', [
            'query' => $query,
            'results' => $results,
            'categories' => $categories,
            'sort' => $sort,
            'totalCount' => $results->total(),
        ]);
    }

    // ── Clear history ─────────────────────────────
    public function clearHistory()
    {
        session()->forget('search_history');

        return response()->json([
            'success' => true
        ]);
    }
}