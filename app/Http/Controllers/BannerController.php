<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::orderBy('sort_order')->get();
        return view('banner.index', compact('banner'));
    }

    public function create()
    {
        return view('banner.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'nullable|string|max:1000',
            'sort_order'  => 'nullable|integer|min:0',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $validate['image'] = $request->file('image')->store('banners', 'public');
        }

        $validate['is_active'] = $request->boolean('is_active');
        $validate['sort_order'] = $validate['sort_order'] ?? 0;

        Banner::create($validate);

        return redirect()->route('banner.index')
            ->with('success', 'Data Banner berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validate = $request->validate([
            'title'       => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'nullable|string|max:1000',
            'sort_order'  => 'nullable|integer|min:0',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        // Update file
        if ($request->hasFile('image')) {

            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $validate['image'] = $request->file('image')->store('banners', 'public');
        } else {
            $validate['image'] = $banner->image;
        }

        $validate['is_active'] = $request->boolean('is_active');
        $validate['sort_order'] = $validate['sort_order'] ?? 0;

        $banner->update($validate);

        return redirect()->route('banner.index')
            ->with('success', 'Data Banner berhasil diperbarui!');
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return view('banner.show', compact('banner'));
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && Storage::exists('public/' . $banner->image)) {
            Storage::delete('public/' . $banner->image);
        }

        $banner->delete();

        return redirect()->route('banner.index')
            ->with('success', 'Data Banner berhasil dihapus!');
    }
}
