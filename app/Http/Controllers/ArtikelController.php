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

        // Ambil data dengan pagination (9 per halaman)
        $articles = $query->paginate(9)->withQueryString();

        // Ambil semua kategori untuk filter di view
        $categories = KategoriArtikel::all();

        // Return ke view (pastikan folder views bernama 'articles')
        return view('artikel.index', compact('articles', 'categories'));
    }

    // Halaman Detail Baca Artikel
    public function show($id)
    {
        $article = Artikel::with('kategori')->findOrFail($id);

        $related = [];
        // $related = Artikel::whereHas('kategori', function($q) use ($article) {
        //     $q->whereIn('id', $article->kategori->pluck('id'));
        // })
        // ->where('id', '!=', $article->id) // Jangan tampilkan artikel yang sedang dibaca
        // ->latest()
        // ->take(3)
        // ->get();

        return view('artikel.show', compact('article', 'related'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
