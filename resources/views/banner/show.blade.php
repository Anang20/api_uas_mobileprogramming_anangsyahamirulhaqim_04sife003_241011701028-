{{-- resources/views/banner/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Banner
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            {{-- GAMBAR BANNER --}}
            @if($banner->image)
            <div class="mb-4 text-center">
                <img src="{{ asset('storage/' . $banner->image) }}"
                    alt="{{ $banner->title }}"
                    class="mx-auto w-64 h-64 object-cover rounded-lg shadow">
            </div>
            @endif

            {{-- DETAIL BANNER --}}
            <div class="space-y-2">
                <p><strong>Judul:</strong> {{ $banner->title }}</p>

                <p><strong>File Gambar:</strong>
                    <span class="text-gray-700">{{ $banner->image }}</span>
                </p>

                <p><strong>Deskripsi:</strong> {{ $banner->description }}</p>

                <p><strong>Status:</strong>
                    {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                </p>
                <p><strong>Urutan:</strong>
                    {{ $banner->sort_order }}
                </p>
                <p><strong>Tanggal Mulai:</strong>
                    {{ optional($banner->start_date)->format('d-m-Y') ?? '-' }}
                </p>
                <p><strong>Tanggal Selesai:</strong>
                    {{ optional($banner->end_date)->format('d-m-Y') ?? '-' }}
                </p>
            </div>

        <div class="mt-4">
            <a href="{{ route('banner.index') }}"
                class="text-blue-600 hover:text-blue-900">
                &larr; Kembali ke Daftar Banner
            </a>
        </div>

        </div>
    </div>
</x-app-layout>
