<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        // Query dasar dengan relasi kategori agar efisien (Eager Loading)
        $query = Artikel::with('kategori')->latest();

        // 1. Logika Pencarian
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                  ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }

        // 2. Logika Filter Kategori
        if ($request->filled('category')) {
            $categoryName = $request->category;
            $query->whereHas('kategori', function ($q) use ($categoryName) {
                $q->where('kategori', $categoryName);
            });
        }
        $articles = $query->paginate(9)->withQueryString();

        $categories = KategoriArtikel::all();

        return view('artikel.index', compact('articles', 'categories'));
    }

    // Halaman Detail Baca Artikel
    public function show($id)
    {
        $article = Artikel::with('kategori')->findOrFail($id);

        $related = Artikel::whereHas('kategori', function($q) use ($article) {

            $q->whereIn('kategori_artikel.id', $article->kategori->pluck('id'));
        })
        ->where('id', '!=', $article->id)
        ->latest()
        ->take(3)
        ->get();


        return view('artikel.show', compact('article', 'related'));
    }
}
