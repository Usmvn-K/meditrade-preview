<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white border border-gray-100 rounded-xl flex items-center justify-center text-gray-500 hover:text-primary-600 hover:shadow-sm transition-all">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Create New Account') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Add a new account with custom role access and granular page permissions</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-slate-50 to-white min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <!-- Role Selection Cards -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Security Tier / Role Access <span class="text-xs font-normal text-gray-400">(Choose preset or custom role)</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="role" value="user" class="peer sr-only" {{ old('role', 'user') === 'user' ? 'checked' : '' }} onchange="handleRoleChange('user')">
                                    <div class="p-3.5 border-2 border-gray-100 rounded-2xl peer-checked:border-primary-500 peer-checked:bg-primary-50/50 hover:bg-gray-50 transition-all text-center">
                                        <div class="w-8 h-8 bg-gray-100 peer-checked:bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                            <i class="fa-solid fa-user text-gray-500 peer-checked:text-primary-600 text-sm"></i>
                                        </div>
                                        <span class="font-bold text-xs text-gray-700 block">User</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="role" value="vendor" class="peer sr-only" {{ old('role') === 'vendor' ? 'checked' : '' }} onchange="handleRoleChange('vendor')">
                                    <div class="p-3.5 border-2 border-gray-100 rounded-2xl peer-checked:border-secondary-500 peer-checked:bg-secondary-50/50 hover:bg-gray-50 transition-all text-center">
                                        <div class="w-8 h-8 bg-gray-100 peer-checked:bg-secondary-100 rounded-xl flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                            <i class="fa-solid fa-store text-gray-500 peer-checked:text-secondary-600 text-sm"></i>
                                        </div>
                                        <span class="font-bold text-xs text-gray-700 block">Vendor</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="role" value="corporate" class="peer sr-only" {{ old('role') === 'corporate' ? 'checked' : '' }} onchange="handleRoleChange('corporate')">
                                    <div class="p-3.5 border-2 border-gray-100 rounded-2xl peer-checked:border-purple-500 peer-checked:bg-purple-50/50 hover:bg-gray-50 transition-all text-center">
                                        <div class="w-8 h-8 bg-gray-100 peer-checked:bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                            <i class="fa-solid fa-building text-gray-500 peer-checked:text-purple-600 text-sm"></i>
                                        </div>
                                        <span class="font-bold text-xs text-gray-700 block">Corporate</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="role" value="admin" class="peer sr-only" {{ old('role') === 'admin' ? 'checked' : '' }} onchange="handleRoleChange('admin')">
                                    <div class="p-3.5 border-2 border-gray-100 rounded-2xl peer-checked:border-red-500 peer-checked:bg-red-50/50 hover:bg-gray-50 transition-all text-center">
                                        <div class="w-8 h-8 bg-gray-100 peer-checked:bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                            <i class="fa-solid fa-shield-halved text-gray-500 peer-checked:text-red-600 text-sm"></i>
                                        </div>
                                        <span class="font-bold text-xs text-gray-700 block">Admin</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="role" value="custom" id="role_custom_radio" class="peer sr-only" {{ old('role') === 'custom' || (!in_array(old('role'), ['user','vendor','corporate','admin']) && old('role')) ? 'checked' : '' }} onchange="handleRoleChange('custom')">
                                    <div class="p-3.5 border-2 border-gray-100 rounded-2xl peer-checked:border-amber-500 peer-checked:bg-amber-50/50 hover:bg-gray-50 transition-all text-center">
                                        <div class="w-8 h-8 bg-gray-100 peer-checked:bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-1.5 transition-colors">
                                            <i class="fa-solid fa-sliders text-gray-500 peer-checked:text-amber-600 text-sm"></i>
                                        </div>
                                        <span class="font-bold text-xs text-gray-700 block">Custom Role</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Custom Role Title & All Pages Permission Matrix -->
                        <div id="custom-role-container" class="{{ old('role') === 'custom' || (!in_array(old('role'), ['user','vendor','corporate','admin']) && old('role')) ? '' : 'hidden' }} space-y-6 bg-gradient-to-br from-amber-50/80 to-orange-50/50 p-6 md:p-8 rounded-3xl border border-amber-200">
                            <div>
                                <label for="custom_role" class="block text-sm font-bold text-amber-900 mb-1">Custom Role Title</label>
                                <input id="custom_role" type="text" name="custom_role" value="{{ old('custom_role') }}" placeholder="e.g. Manager, Accountant, Store Officer, Support Specialist"
                                    class="block w-full bg-white border-amber-300 rounded-xl focus:ring-amber-500 focus:border-amber-500 text-sm px-4 py-2.5">
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-4 pb-2 border-b border-amber-200">
                                    <div>
                                        <span class="block text-sm font-bold text-amber-900">Page & Module Permissions Matrix</span>
                                        <span class="text-xs text-amber-700">Check each page or section this user is authorized to access</span>
                                    </div>
                                    <button type="button" onclick="toggleAllPermissions()" class="px-4 py-1.5 bg-amber-200/80 hover:bg-amber-300 text-amber-900 text-xs font-bold rounded-lg transition-all">
                                        Select All / Clear
                                    </button>
                                </div>

                                @php
                                    $permissionGroups = [
                                        'Core Operations' => [
                                            ['key' => 'manage_dashboard',   'title' => 'Admin Dashboard',      'desc' => 'Access main admin analytics & overview dashboard', 'icon' => 'fa-chart-line'],
                                            ['key' => 'manage_services',    'title' => 'Add Product / Service', 'desc' => 'Create, edit & publish products and services',     'icon' => 'fa-boxes-stacked'],
                                            ['key' => 'manage_products',    'title' => 'Shop Products',         'desc' => 'Manage retail e-commerce products inventory',       'icon' => 'fa-box-open'],
                                            ['key' => 'manage_orders',      'title' => 'Shop Orders',           'desc' => 'View, update status & manage retail customer orders','icon' => 'fa-cart-shopping'],
                                            ['key' => 'manage_bookings',    'title' => 'Service Bookings',      'desc' => 'View and update service bookings & appointments',  'icon' => 'fa-calendar-check'],
                                            ['key' => 'manage_custom_packages','title' => 'Custom Packages',   'desc' => 'Manage custom package quotes & package bookings',  'icon' => 'fa-cubes'],
                                            ['key' => 'service_desk',       'title' => 'Service Desk',          'desc' => 'Handle customer support tickets & inquiries',      'icon' => 'fa-headset'],
                                        ],
                                        'Catalog & Categories' => [
                                            ['key' => 'manage_service_categories', 'title' => 'Service Categories', 'desc' => 'Manage main service categories tree',     'icon' => 'fa-list-check'],
                                            ['key' => 'manage_subcategories',       'title' => 'Sub Categories',    'desc' => 'Add and update service sub-categories',   'icon' => 'fa-sitemap'],
                                            ['key' => 'manage_categories',          'title' => 'Shop Categories',   'desc' => 'Manage retail shop product categories',   'icon' => 'fa-folder-tree'],
                                            ['key' => 'manage_brands',              'title' => 'Brands',            'desc' => 'Manage product manufacturer brands',      'icon' => 'fa-tag'],
                                            ['key' => 'manage_units',               'title' => 'Units of Measurement','desc' => 'Manage product units (kg, pcs, meters)', 'icon' => 'fa-scale-balanced'],
                                        ],
                                        'Users & Vendor Control' => [
                                            ['key' => 'manage_users',          'title' => 'User Management',   'desc' => 'Full access to user accounts, roles & permissions', 'icon' => 'fa-users'],
                                            ['key' => 'manage_vendors',        'title' => 'Vendor Management', 'desc' => 'View vendors, audit logs & verify accounts',    'icon' => 'fa-store'],
                                            ['key' => 'manage_budget_requests','title' => 'Budget Requests',   'desc' => 'View & respond to client budget planner requests','icon' => 'fa-file-invoice-dollar'],
                                        ],
                                        'Finance & System Setup' => [
                                            ['key' => 'manage_reports',     'title' => 'Reports & Chart of Accounts', 'desc' => 'Full financial hub, sales & performance reports', 'icon' => 'fa-chart-pie'],
                                            ['key' => 'manage_withdrawals', 'title' => 'Payments & Withdrawals',       'desc' => 'Approve/reject vendor payout & wallet requests',   'icon' => 'fa-wallet'],
                                            ['key' => 'manage_features',    'title' => 'Features & Highlights',       'desc' => 'Manage featured items & homepage highlights',       'icon' => 'fa-star'],
                                            ['key' => 'manage_testimonials','title' => 'Testimonials',                'desc' => 'Manage customer reviews & testimonials',            'icon' => 'fa-comment-dots'],
                                            ['key' => 'manage_cities',      'title' => 'Cities & Locations',          'desc' => 'Manage operational cities and regional branches',   'icon' => 'fa-city'],
                                            ['key' => 'manage_settings',    'title' => 'Website Settings',            'desc' => 'Branding, logo, slogan, contact info & SEO meta',   'icon' => 'fa-gear'],
                                        ],
                                    ];
                                    $oldPerms = old('permissions', []);
                                @endphp

                                <div class="space-y-6">
                                    @foreach($permissionGroups as $groupTitle => $perms)
                                        <div>
                                            <h5 class="text-xs font-black uppercase tracking-wider text-amber-900 mb-2.5 flex items-center gap-2">
                                                <span class="w-1.5 h-3 bg-amber-500 rounded-full"></span>
                                                {{ $groupTitle }}
                                            </h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                @foreach($perms as $p)
                                                <label class="flex items-start gap-3 p-3.5 bg-white rounded-2xl border border-amber-200/80 hover:border-amber-400 cursor-pointer transition-all shadow-sm group">
                                                    <input type="checkbox" name="permissions[]" value="{{ $p['key'] }}"
                                                        class="perm-checkbox mt-1 w-4 h-4 text-amber-600 border-amber-300 rounded focus:ring-amber-500"
                                                        {{ in_array($p['key'], $oldPerms) ? 'checked' : '' }}>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="font-bold text-xs text-gray-800 flex items-center gap-1.5 group-hover:text-amber-800 truncate">
                                                            <i class="fa-solid {{ $p['icon'] }} text-amber-600 text-xs shrink-0"></i>
                                                            <span class="truncate">{{ $p['title'] }}</span>
                                                        </div>
                                                        <div class="text-[11px] text-gray-500 font-medium leading-tight mt-0.5 line-clamp-2">{{ $p['desc'] }}</div>
                                                    </div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5">
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                                <input id="password" type="password" name="password" required
                                    class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5">
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5">
                            </div>
                        </div>

                        <!-- Verification Status -->
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-sm text-gray-800 block">Verified Status</span>
                                <span class="text-xs text-gray-500">Auto-verify account upon creation</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_verified" value="1" class="sr-only peer" {{ old('is_verified', 1) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>
                        </div>

                        <!-- Vendor Specific Fields -->
                        <div id="vendor-fields" class="{{ old('role') === 'vendor' ? '' : 'hidden' }} space-y-6 pt-6 border-t border-gray-100">
                            <h4 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-secondary-500"></i> Vendor Extra Details
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="city_id" class="block text-sm font-bold text-gray-700 mb-2">City</label>
                                    <select id="city_id" name="city_id" class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Service Category</label>
                                    <select id="category_id" name="category_id" class="block w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-primary-500 focus:border-primary-500 text-sm px-4 py-2.5">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700">Cancel</a>
                            <button type="submit" class="bg-gradient-to-r from-primary-600 to-primary-800 text-white font-bold px-8 py-3 rounded-xl shadow-lg hover:from-primary-700 hover:to-primary-900 transition-all">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleRoleChange(role) {
            const vendorFields = document.getElementById('vendor-fields');
            const customRoleContainer = document.getElementById('custom-role-container');

            if (role === 'vendor') {
                vendorFields.classList.remove('hidden');
            } else {
                vendorFields.classList.add('hidden');
            }

            if (role === 'custom') {
                customRoleContainer.classList.remove('hidden');
                document.getElementById('custom_role').focus();
            } else {
                customRoleContainer.classList.add('hidden');
            }
        }

        function toggleAllPermissions() {
            const boxes = document.querySelectorAll('.perm-checkbox');
            const allChecked = Array.from(boxes).every(b => b.checked);
            boxes.forEach(b => b.checked = !allChecked);
        }
    </script>
</x-app-layout>
