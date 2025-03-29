<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPerilaku;
use Illuminate\Http\Request;

class KategoriPerilakuController extends Controller
{
    public function index()
    {
        $kategoris = KategoriPerilaku::all();
        return view('admin.kategori-perilaku.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori-perilaku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'poin' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriPerilaku::create($request->all());

        return redirect()->route('admin.kategori-perilaku.index')
            ->with('success', 'Kategori perilaku berhasil ditambahkan');
    }

   /* public function edit(KategoriPerilaku $kategoriPerilaku)
    {
        return view('admin.kategori-perilaku.edit', compact('kategoriPerilaku'));
    }
*/

// app/Http/Controllers/Admin/KategoriPerilakuController.php
public function edit($id)
{
    $kategori = KategoriPerilaku::findOrFail($id);
    return view('admin.kategori-perilaku.edit', compact('kategori'));
}
    
    public function update(Request $request, KategoriPerilaku $kategoriPerilaku)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'poin' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $kategoriPerilaku->update($request->all());

        return redirect()->route('admin.kategori-perilaku.index')
            ->with('success', 'Kategori perilaku berhasil diperbarui');
    }

    public function destroy(KategoriPerilaku $kategoriPerilaku)
    {
        $kategoriPerilaku->delete();

        return redirect()->route('admin.kategori-perilaku.index')
            ->with('success', 'Kategori perilaku berhasil dihapus');
    }

    
}