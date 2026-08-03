<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        $wargas = Warga::latest()->paginate(10);

        return view('admin.index', compact('wargas'));
    }

    public function create(): View
    {
        return view('admin.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        Warga::create($validated);

        return redirect()->route('admin.index')
            ->with('success', 'Data warga berhasil ditambahkan.')
            ->with('success_create', 'Data warga berhasil ditambahkan.');
    }

    public function edit(Warga $warga): View
    {
        return view('admin.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga): RedirectResponse
    {
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $warga->update($validated);

        return redirect()->route('admin.index')
            ->with('success', 'Data warga berhasil diperbarui.')
            ->with('success_edit', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga): RedirectResponse
    {
        $warga->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Data warga berhasil dihapus.')
            ->with('success_delete', 'Data warga berhasil dihapus.');
    }

    public function map()
    {
        return view('admin.map');
    }
}
