{{-- resources/views/banner/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Banner</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- JUDUL --}}
                <div class="mb-4">
                    <label>Judul</label>
                    <input type="text"
                        name="title"
                        value="{{ old('title', $banner->title) }}"
                        class="w-full border rounded p-2">
                    @error('title')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- GAMBAR --}}
                <div class="mb-4">
                    <label>Gambar</label>
                    <input type="file"
                            name="image"
                            accept="image/*"
                            class="w-full border rounded p-2">
                    @error('image')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- TAMPILKAN GAMBAR SAAT INI --}}
                @if ($banner->image)
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Gambar saat ini:</p>
                    <img src="{{ asset('storage/'.$banner->image) }}"
                        alt="Banner Image" width="120"
                        class="rounded shadow">
                </div>
                @endif

                {{-- DESKRIPSI --}}
                <div class="mb-4">
                    <label>Deskripsi</label>
                    <textarea name="description"
                        class="w-full border rounded p-2">{{ old('description', $banner->description) }}</textarea>
                    @error('description')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $banner->is_active) ? 'checked' : '' }}
                            class="rounded border-gray-300">
                        <span class="ml-2">Aktifkan Banner</span>
                    </label>
                    @error('is_active')
                        <small class="text-red-600 block">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Urutan --}}
                <div class="mb-4">
                    <label>Urutan</label>
                    <input type="number"
                        name="sort_order"
                        value="{{ old('sort_order', $banner->sort_order) }}"
                        class="w-full border rounded p-2">
                    @error('sort_order')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="mb-4">
                    <label>Tanggal Mulai</label>
                    <input type="date"
                        name="start_date"
                        value="{{ old('start_date', optional($banner->start_date)->format('Y-m-d')) }}"
                        class="w-full border rounded p-2">
                    @error('start_date')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div class="mb-4">
                    <label>Tanggal Selesai</label>
                    <input type="date"
                        name="end_date"
                        value="{{ old('end_date', optional($banner->end_date)->format('Y-m-d')) }}"
                        class="w-full border rounded p-2">
                    @error('end_date')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                    <a href="{{ route('banner.index') }}" class="ml-2 text-gray-600">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
