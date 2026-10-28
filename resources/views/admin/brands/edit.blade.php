<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <i class="fa-solid fa-pen text-indigo-600 mr-2"></i>{{ __('Edit Brand') }}
            </h2>
            <p class="text-gray-500 text-sm mt-1">Modify brand details</p>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 uppercase mb-2">Brand Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition px-4 py-3 text-sm"
                            placeholder="e.g. Nike, Apple, Samsung" value="{{ old('name', $brand->name) }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 uppercase mb-2">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition px-4 py-3 text-sm"
                            placeholder="Brief description of the brand (optional)">{{ old('description', $brand->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.brands.index') }}" 
                            class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition-all">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-indigo-500/20 transition-all">
                            Update Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
