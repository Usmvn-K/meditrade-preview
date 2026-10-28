<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="pb-4 text-[10px] font-black text-gray-500 uppercase tracking-widest px-4">Entity Identity</th>
                <th class="pb-4 text-[10px] font-black text-gray-500 uppercase tracking-widest px-4 text-center">Protocol</th>
                <th class="pb-4 text-[10px] font-black text-gray-500 uppercase tracking-widest px-4 text-right">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendingVendors as $vendor)
                <tr class="group hover:bg-gray-50 transition-all duration-300">
                    <td class="py-5 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden border border-gray-200 group-hover:border-amber-300 transition-colors bg-gray-100 flex items-center justify-center">
                                <i class="fa-solid fa-store text-gray-500 group-hover:text-amber-600 transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-gray-900 font-bold text-sm leading-none">{{ $vendor->name }}</p>
                                <p class="text-gray-500 text-[10px] mt-1 font-medium tracking-tight">{{ $vendor->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-4 text-center">
                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-200">
                            Verification Pending
                        </span>
                    </td>
                    <td class="py-5 px-4 text-right">
                        <a href="{{ route('admin.vendors.show', $vendor) }}" class="inline-flex items-center justify-center w-8 h-8 bg-white hover:bg-primary-50 text-gray-400 hover:text-primary-600 rounded-lg transition-all border border-gray-200 shadow-sm">
                            <i class="fa-solid fa-arrow-right-long text-xs"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-10 text-center text-gray-500 italic text-sm">Clear queue. No entities awaiting verification.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
