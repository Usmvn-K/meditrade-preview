<x-app-layout>
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-primary-900 tracking-tight uppercase">My Wishlist</h1>
                <p class="text-slate-500 mt-2 font-medium">Your curated collection of premium products.</p>
            </div>
            <div class="hidden md:flex items-center gap-2 px-6 py-3 bg-white rounded-2xl border border-slate-200 shadow-sm">
                <i class="fa-solid fa-heart text-secondary-600"></i>
                <span class="text-xs font-black uppercase tracking-widest text-primary-900">{{ $favorites->total() }} Saved Items</span>
            </div>
        </div>

        @if($favorites->count() > 0)
            <!-- Reusing the services grid partial -->
            @include('partials.services-grid', ['services' => $favorites])
        @else
            <!-- Empty State -->
            <div class="text-center py-32 bg-white rounded-[3rem] border border-slate-100 shadow-xl">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-8 animate-pulse">
                    <i class="fa-solid fa-heart-crack text-secondary-600 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-black text-primary-900 tracking-tight">Your Wishlist is Empty</h3>
                <p class="text-slate-400 mt-3 font-medium max-w-sm mx-auto">Start exploring our premium catalog and save your favorite products here.</p>
                <a href="{{ route('home') }}" class="inline-flex mt-10 px-8 py-4 bg-primary-900 text-white rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-secondary-600 transition-all shadow-xl hover:shadow-2xl active:scale-95">
                    Explore Catalog
                </a>
            </div>
        @endif
    </div>
</div>
</x-app-layout>

