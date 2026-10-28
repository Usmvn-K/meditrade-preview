<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:text-primary-600 hover:shadow-sm transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    User Details: {{ $user->name }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Full profile, security role, and activity history</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Summary Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden border-4 border-slate-50 shadow-md">
                        <img src="{{ $user->getAvatarUrl() }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider
                                {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' :
                                   ($user->role === 'vendor' ? 'bg-amber-100 text-amber-700' :
                                   ($user->role === 'corporate' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700')) }}">
                                {{ ucfirst($user->role) }}
                            </span>
                            @if($user->is_verified)
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold uppercase tracking-wider">
                                    <i class="fa-solid fa-check-circle"></i> Verified
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-bold uppercase tracking-wider">
                                    Unverified
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="px-5 py-2.5 bg-primary-900 text-white font-bold text-sm rounded-xl hover:bg-primary-800 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-pen"></i> Edit Profile
                    </a>
                </div>
            </div>

            <!-- Profile Details Grid -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h4 class="font-bold text-gray-800 text-lg mb-6 border-b border-gray-100 pb-3">Account Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">User ID</p>
                        <p class="font-bold text-gray-800 text-base mt-1">#{{ $user->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Joined Date</p>
                        <p class="font-bold text-gray-800 text-base mt-1">{{ $user->created_at ? $user->created_at->format('M d, Y - h:i A') : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">City</p>
                        <p class="font-bold text-gray-800 text-base mt-1">{{ $user->city ? $user->city->name : 'Not Specified' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Category</p>
                        <p class="font-bold text-gray-800 text-base mt-1">{{ $user->category ? $user->category->name : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Wallet Balance</p>
                        <p class="font-bold text-emerald-600 text-base mt-1">Rs. {{ number_format($user->balance ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- User Bookings History -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h4 class="font-bold text-gray-800 text-lg mb-6 border-b border-gray-100 pb-3">Bookings History</h4>
                @if(isset($bookings) && $bookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Booking ID</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Service</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Date</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Amount</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($bookings as $booking)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-6 py-4 font-bold text-gray-800">#{{ $booking->id }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $booking->service->title ?? 'Custom Package' }}</td>
                                    <td class="px-6 py-4 text-gray-500 text-sm">{{ $booking->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900">Rs. {{ number_format($booking->total_price ?? 0) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            {{ $booking->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800' : 
                                               ($booking->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-400 text-sm py-4">No bookings found for this user.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
