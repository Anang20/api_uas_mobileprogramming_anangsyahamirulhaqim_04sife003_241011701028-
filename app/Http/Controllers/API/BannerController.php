<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();

        $banners->each(function($banner) {
            $banner->image_url = $banner->image
                ? asset('storage/' . $banner->image)
                : null;
        });

        return response()->json([
            'success' => true,
            'data' => $banners,
            'message' => 'Data banner berhasil diambil'
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->is_active = $request->boolean('is_active', true);
        $banner->sort_order = $request->input('sort_order', 0);
        $banner->start_date = $request->start_date;
        $banner->end_date = $request->end_date;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        $banner->image_url = $banner->image
            ? asset('storage/' . $banner->image)
            : null;

        return response()->json([
            'success' => true,
            'data' => $banner,
            'message' => 'Banner created successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $banner->image_url = $banner->image
            ? asset('storage/' . $banner->image)
            : null;

        return response()->json([
            'success' => true,
            'data' => $banner
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->has('title')) $banner->title = $request->title;
        if ($request->has('description')) $banner->description = $request->description;
        if ($request->has('is_active')) $banner->is_active = $request->boolean('is_active');
        if ($request->has('sort_order')) $banner->sort_order = $request->sort_order;
        if ($request->has('start_date')) $banner->start_date = $request->start_date;
        if ($request->has('end_date')) $banner->end_date = $request->end_date;

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        $banner->image_url = $banner->image
            ? asset('storage/' . $banner->image)
            : null;

        return response()->json([
            'success' => true,
            'data' => $banner,
            'message' => 'Banner updated successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner deleted successfully'
        ], Response::HTTP_OK);
    }

    //Upload Image
    public function uploadImage(Request $request, $id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['message' => 'Banner not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $path = $request->file('image')->store('banners', 'public');
        $banner->image = $path;
        $banner->save();

        return response()->json([
            'success' => true,
            'image_url' => asset('storage/' . $path)
        ], Response::HTTP_OK);
    }
}
