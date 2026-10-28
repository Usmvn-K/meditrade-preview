<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b border-gray-100">
                <th class="pb-4 text-[10px] font-black text-gray-500 uppercase tracking-widest px-4">Client Entity</th>
                <th class="pb-4 text-[10px] font-black text-gray-500 uppercase tracking-widest px-4 text-center">Status</th>
                <th class="pb-4 text-[10px] font-black text-gray-500 uppercase tracking-widest px-4 text-right">Registered</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentClients as $client)
                <tr class="group hover:bg-gray-50 transition-all duration-300">
                    <td class="py-5 px-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl overflow-hidden border border-gray-200 group-hover:border-primary-300 transition-colors">
                                <img src="{{ $client->getAvatarUrl() }}" class="w-full h-full object-cover" alt="">
                            </div>
                            <div>
                                <p class="text-gray-900 font-bold text-sm leading-none">{{ $client->name }}</p>
                                <p class="text-gray-500 text-[10px] mt-1 font-medium tracking-tight">{{ $client->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-4 text-center">
                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-200">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            Active
                        </span>
                    </td>
                    <td class="py-5 px-4 text-right">
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">{{ $client->created_at->format('M d, Y') }}</p>
                        <p class="text-gray-400 text-[9px] mt-0.5">{{ $client->created_at->diffForHumans() }}</p>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-10 text-center text-gray-500 italic text-sm">No recent registrations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
