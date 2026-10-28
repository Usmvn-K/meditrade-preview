<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-primary-900 leading-tight uppercase tracking-tighter">
                    User Management
                </h2>
                <p class="text-gray-500 text-sm mt-1">Create, edit, assign roles and manage all accounts</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="bg-primary-900 hover:bg-secondary-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transition-all flex items-center gap-2 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-user-plus"></i> Add New User
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-5 py-3 rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-300 text-red-800 px-5 py-3 rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Search & Filter Bar --}}
            <form method="GET" action="{{ route('admin.users.index') }}"
                class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by name or email..."
                        class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500">
                </div>
                <select name="role"
                    class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500 min-w-[160px]">
                    <option value="">All Roles</option>
                    @if(isset($allRoles))
                        @foreach($allRoles as $r)
                            <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                        @endforeach
                    @else
                        <option value="admin"     {{ request('role') === 'admin'     ? 'selected' : '' }}>Admin</option>
                        <option value="vendor"    {{ request('role') === 'vendor'    ? 'selected' : '' }}>Vendor</option>
                        <option value="user"      {{ request('role') === 'user'      ? 'selected' : '' }}>User</option>
                        <option value="corporate" {{ request('role') === 'corporate' ? 'selected' : '' }}>Corporate</option>
                    @endif
                </select>
                <button type="submit"
                    class="px-6 py-2.5 bg-primary-900 text-white text-sm font-semibold rounded-xl hover:bg-primary-800 transition-all">
                    Filter
                </button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}"
                        class="px-5 py-2.5 border border-gray-200 text-gray-500 text-sm font-medium rounded-xl hover:bg-gray-50 transition-all">
                        Clear
                    </a>
                @endif
            </form>

            {{-- Users Table --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Role</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Joined</th>
                                <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($users as $user)
                            <tr class="hover:bg-primary-50/30 transition-colors group">
                                {{-- User Profile --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 rounded-2xl overflow-hidden border-2 border-white shadow-sm group-hover:scale-105 transition-transform shrink-0">
                                            <img src="{{ $user->getAvatarUrl() }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                                        </div>
                                        <div>
                                            <div class="font-black text-primary-900 text-sm uppercase tracking-tight flex items-center gap-2">
                                                {{ $user->name }}
                                                @if($user->id === auth()->id())
                                                    <span class="text-[9px] bg-primary-100 text-primary-700 px-2 py-0.5 rounded-full font-bold">You</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Role Badge --}}
                                <td class="px-6 py-4">
                                    @php
                                        $roleColors = [
                                            'admin'     => 'bg-red-100 text-red-700',
                                            'vendor'    => 'bg-secondary-100 text-secondary-700',
                                            'user'      => 'bg-primary-100 text-primary-700',
                                            'corporate' => 'bg-purple-100 text-purple-700',
                                        ];
                                        $roleIcons = [
                                            'admin'     => 'fa-shield-halved',
                                            'vendor'    => 'fa-store',
                                            'user'      => 'fa-user',
                                            'corporate' => 'fa-building',
                                        ];
                                        $color = $roleColors[$user->role] ?? 'bg-amber-100 text-amber-800';
                                        $icon  = $roleIcons[$user->role]  ?? 'fa-sliders';
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $color }}">
                                        <i class="fa-solid {{ $icon }} text-[9px]"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                {{-- Verified Status --}}
                                <td class="px-6 py-4">
                                    @if($user->is_verified)
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                            Verified
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[10px] font-black text-amber-500 uppercase tracking-widest">
                                            <span class="w-2 h-2 bg-amber-400 rounded-full"></span>
                                            Unverified
                                        </span>
                                    @endif
                                </td>

                                {{-- Joined Date --}}
                                <td class="px-6 py-4">
                                    <div class="text-xs font-bold text-slate-500">{{ $user->created_at->format('M d, Y') }}</div>
                                    <div class="text-[10px] text-slate-300">{{ $user->created_at->diffForHumans() }}</div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        {{-- View --}}
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            title="View Details"
                                            class="w-9 h-9 bg-slate-50 hover:bg-primary-900 hover:text-white text-slate-400 rounded-xl flex items-center justify-center transition-all shadow-sm">
                                            <i class="fa-solid fa-eye text-xs"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            title="Edit User"
                                            class="w-9 h-9 bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-400 rounded-xl flex items-center justify-center transition-all shadow-sm">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        {{-- Delete --}}
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Delete {{ $user->name }}? This cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Delete"
                                                class="w-9 h-9 bg-slate-50 hover:bg-red-600 hover:text-white text-slate-400 rounded-xl flex items-center justify-center transition-all shadow-sm">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                    <i class="fa-solid fa-users text-4xl mb-3 block opacity-30"></i>
                                    <p class="font-semibold">No users found</p>
                                    <p class="text-sm mt-1">Try adjusting your search or filter</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($users->hasPages())
                    <div class="p-5 bg-slate-50 border-t border-slate-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

            {{-- Summary Bar --}}
            <div class="text-center text-xs text-slate-400">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
            </div>

        </div>
    </div>
</x-app-layout>
