<x-app-layout>
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-black text-primary-900 tracking-tight uppercase">Notifications</h1>
                <p class="text-gray-500 mt-1 font-medium">Stay updated with your premium activity</p>
            </div>
            @if($notifications->where('is_read', false)->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-primary-900 hover:text-secondary-600 font-black uppercase text-xs tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Mark all as read
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifications List -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-gray-100 overflow-hidden">
            @forelse($notifications as $notification)
                <div class="flex items-start gap-4 p-6 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-primary-50/30' : '' }}">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        @php
                            $colors = [
                                'green' => 'from-emerald-500 to-green-600',
                                'primary' => 'from-primary-900 to-blue-800',
                                'secondary' => 'from-secondary-600 to-red-700',
                                'blue' => 'from-primary-900 to-blue-800',
                                'red' => 'from-secondary-600 to-red-700',
                                'orange' => 'from-amber-500 to-orange-600',
                            ];
                            $colorClass = $colors[$notification->color] ?? $colors['primary'];
                        @endphp
                        <div class="w-12 h-12 bg-gradient-to-br {{ $colorClass }} rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/10">
                            <i class="fa-solid {{ $notification->icon ?? 'fa-bell' }} text-white"></i>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-grow min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h4 class="font-black text-primary-900 {{ !$notification->is_read ? 'text-primary-900' : 'text-gray-700' }} uppercase text-sm tracking-tight">
                                    {{ $notification->title }}
                                </h4>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">{{ $notification->message }}</p>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2">
                                    <i class="fa-regular fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if(!$notification->is_read)
                                    <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-primary-900 hover:text-white p-2 hover:bg-primary-900 rounded-lg transition-all" title="Mark as read">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($notification->link)
                                    <a href="{{ $notification->link }}" class="text-primary-900 hover:text-white p-2 hover:bg-primary-900 rounded-lg transition-all" title="View">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @endif
                                
                                <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-secondary-600 hover:text-white p-2 hover:bg-secondary-600 rounded-lg transition-all" title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Unread Indicator -->
                    @if(!$notification->is_read)
                        <div class="w-2.5 h-2.5 bg-secondary-600 rounded-full flex-shrink-0 mt-2 shadow-sm shadow-red-500/50"></div>
                    @endif
                </div>
            @empty
                <div class="p-20 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-bell-slash text-gray-300 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-black text-primary-900 uppercase tracking-tight">No notifications yet</h3>
                    <p class="text-gray-400 mt-2 font-medium">We'll notify you when something elite happens.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
</x-app-layout>


