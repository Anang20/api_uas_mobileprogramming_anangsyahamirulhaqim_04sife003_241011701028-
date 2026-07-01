{{-- resources/views/banner/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Banner</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul --}}
                <div class="mb-4">
                    <label class="block mb-1">Judul</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full border rounded p-2">
                    @error('title')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-4">
                    <label class="block mb-1">Gambar</label>
                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="w-full border rounded p-2"
                    >
                    @error('image')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label class="block mb-1">Deskripsi</label>
                    <textarea
                        name="description"
                        class="w-full border rounded p-2">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Status Aktif --}}
                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="rounded border-gray-300">
                        <span class="ml-2">Aktifkan Banner</span>
                    </label>
                    @error('is_active')
                        <small class="text-red-600 block">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Urutan --}}
                <div class="mb-4">
                    <label class="block mb-1">Urutan</label>
                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old('sort_order', 0) }}"
                        class="w-full border rounded p-2">
                    @error('sort_order')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="mb-4">
                    <label class="block mb-1">Tanggal Mulai</label>
                    <input
                        type="date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        class="w-full border rounded p-2">
                    @error('start_date')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div class="mb-4">
                    <label class="block mb-1">Tanggal Selesai</label>
                    <input
                        type="date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        class="w-full border rounded p-2">
                    @error('end_date')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Buttons --}}
                <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                <a href="{{ route('banner.index') }}" class="ml-2 text-gray-600">Batal</a>

            </form>

        </div>
    </div>
</x-app-layout>
