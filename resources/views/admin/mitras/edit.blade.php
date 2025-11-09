<x-admin-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-green-900 mb-6">Edit Mitra: {{ $mitra->name }}</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                    <div class="flex items-center">
                        <i data-feather="alert-circle" class="w-5 h-5 mr-3 text-red-600"></i>
                        <h4 class="font-semibold">Terjadi Kesalahan</h4>
                    </div>
                    <ul class="list-disc pl-10 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-lg rounded-lg p-6 md:p-8">
                <form action="{{ route('admin.mitras.update', $mitra) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $formInputClass = 'w-full p-1.5 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50';
                        $formLabelClass = 'block mb-1.5 text-sm font-medium text-gray-700';
                    @endphp

                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Nama Mitra *</label>
                        <input type="text" name="name" value="{{ old('name', $mitra->name) }}" class="{{ $formInputClass }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">URL Website</label>
                        <input type="url" name="url" value="{{ old('url', $mitra->url) }}" class="{{ $formInputClass }}" placeholder="https://contoh.com">
                    </div>

                    <div class="mb-4">
                        <label class="{{ $formLabelClass }}">Logo Mitra</label>
                        <input type="file" name="logo" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                                   file:rounded-full file:border-0 file:text-sm file:font-semibold 
                                   file:bg-green-50 file:text-green-700 hover:file:bg-green-100">

                        @if ($mitra->logo)
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 mb-1">Logo saat ini:</p>
                                <img src="{{ asset('storage/' . $mitra->logo) }}" alt="Logo Mitra" class="h-20 rounded shadow">
                            </div>
                        @endif
                    </div>

           
                    <div class="flex gap-3 border-t pt-6 justify-end">
                        <a href="{{ route('admin.mitras.index') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                            <i data-feather="x" class="w-4 h-4"></i>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                            <i data-feather="save" class="w-4 h-4"></i>
                            Perbarui Mitra
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
