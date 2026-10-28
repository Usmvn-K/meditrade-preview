<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-plus text-teal-600 mr-2"></i>{{ __('Add New Unit') }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">Create a measurement unit for pricing structures</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('admin.units.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 uppercase mb-2">Unit Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition px-4 py-3 text-sm"
                            placeholder="e.g. Kilogram, Pieces, Liters, Box" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="symbol" class="block text-sm font-bold text-gray-700 uppercase mb-2">Symbol / Abbreviation</label>
                        <input type="text" name="symbol" id="symbol" required
                            class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 transition px-4 py-3 text-sm"
                            placeholder="e.g. kg, pcs, L, box" value="{{ old('symbol') }}">
                        @error('symbol')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.units.index') }}" 
                            class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition-all">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="px-5 py-3 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-teal-500/20 transition-all">
                            Save Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
