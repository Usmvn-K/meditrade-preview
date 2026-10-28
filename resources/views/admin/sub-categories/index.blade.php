<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-sitemap text-orange-600 mr-2"></i>{{ __('Sub Category Management') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Manage product sub-categories under parent categories</p>
            </div>
            <a href="{{ route('admin.sub-categories.create') }}" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl text-sm font-bold shadow-lg shadow-orange-500/30 transition-all flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Add New Sub Category
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl relative mb-8 shadow-sm flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fa-solid fa-check text-green-600"></i>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fa-solid fa-folder-tree text-orange-500"></i> Sub Categories
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50/50 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-8 py-5">Sub Category Name</th>
                                <th class="px-6 py-5">Parent Category</th>
                                <th class="px-6 py-5 text-center">Icon</th>
                                <th class="px-6 py-5">Order</th>
                                <th class="px-8 py-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($subCategories as $sub)
                                <tr class="hover:bg-orange-50/30 transition-colors group">
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-gray-900">{{ $sub->name }}</div>
                                        <div class="text-xs text-gray-400 font-mono">{{ $sub->slug }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-800">
                                            <i class="fa-solid fa-folder mr-1.5"></i>
                                            {{ $sub->parent->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center mx-auto text-white" style="background-color: {{ $sub->color ?? '#6366f1' }}">
                                            <i class="fa-solid {{ $sub->icon ?? 'fa-tag' }}"></i>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-gray-500 font-medium">
                                        {{ $sub->sort_order }}
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-70 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.sub-categories.edit', $sub->id) }}" class="w-9 h-9 bg-yellow-50 hover:bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center transition-all" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.sub-categories.destroy', $sub->id) }}" onsubmit="return confirm('Are you sure you want to delete this sub category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-9 h-9 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg flex items-center justify-center transition-all" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fa-solid fa-sitemap text-gray-400 text-2xl"></i>
                                            </div>
                                            <p class="text-lg font-medium">No sub categories found</p>
                                            <p class="text-sm mt-1">Start by adding a new sub category.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($subCategories->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $subCategories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
