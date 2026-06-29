{{-- resources/views/product/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Product</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-lg font-semibold mb-4">Data Product</h3>

                    {{-- Tombol Tambah (Admin Only) --}}
                    <div class="flex justify-end mb-4 gap-3">
                        <a href="{{ route('product.create') }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                            &#43; Tambah Product
                        </a>
                        <a href="{{ route('product.cetakPdf') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                            &#128424; Cetak PDF
                        </a>
                    </div>

                    {{-- Notifikasi --}}
                    @if(session('Berhasil'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('Berhasil') }}
                        </div>
                    @endif

                    {{-- Tabel --}}
                    <table class="w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 border">No</th>
                                <th class="p-2 border">Nama</th>
                                <th class="p-2 border">Gambar</th>
                                <th class="p-2 border">Deskripsi</th>
                                <th class="p-2 border">Harga</th>
                                <th class="p-2 border">Stock</th>
                                <th class="p-2 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($product as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $row->name }}</td>

                            {{-- Gambar --}}
                            <td class="p-2 border text-center">
                                @if($row->image)
                                    <img src="{{ asset('storage/' . $row->image) }}"
                                            width="80" class="rounded shadow">
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>

                            {{-- Deskripsi --}}
                            <td class="p-2 border">{{ $row->descriptions }}</td>

                            {{-- Harga --}}
                            <td class="p-2 border">{{ number_format($row->price, 0, ',', '.') }}</td>

                            {{-- Stock --}}
                            <td class="p-2 border">{{ $row->stock ?? '-' }}</td>

                            {{-- Tombol Aksi --}}
                            <td class="p-2 border space-x-2">
                                <a href="{{ route('product.show', $row->id) }}"
                                    class="inline-block bg-gray-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                    Lihat
                                </a>

                                <a href="{{ route('product.edit', $row->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    Edit
                                </a>

                                <form action="{{ route('product.destroy', $row->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center p-4 text-gray-500">
                                Belum ada data product.
                            </td>
                        </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
