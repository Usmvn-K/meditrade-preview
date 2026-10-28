<x-app-layout>
    <style>
        /* Chart of Accounts Custom Styles */
        .coa-fade-in { animation: coaFadeIn 0.4s ease-out forwards; opacity: 0; }
        @keyframes coaFadeIn { to { opacity: 1; transform: translateY(0); } from { opacity: 0; transform: translateY(12px); } }

        .coa-group-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .coa-group-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.06); }

        .coa-row { transition: all 0.2s ease; cursor: pointer; }
        .coa-row:hover { transform: translateX(4px); }

        .coa-chevron { transition: transform 0.3s ease; }
        .coa-chevron.open { transform: rotate(180deg); }

        .coa-expand-body {
            max-height: 0; overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease, padding 0.3s ease;
            opacity: 0; padding-top: 0; padding-bottom: 0;
        }
        .coa-expand-body.open {
            max-height: 2000px; opacity: 1;
            padding-top: 0.5rem; padding-bottom: 0.5rem;
        }

        .coa-detail-drawer {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(100%); opacity: 0;
        }
        .coa-detail-drawer.open {
            transform: translateX(0); opacity: 1;
        }

        .coa-badge { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.15rem 0.6rem; border-radius: 9999px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; }

        .coa-progress-bar { height: 6px; border-radius: 999px; transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1); }

        .coa-pulse { animation: coaPulse 2s infinite; }
        @keyframes coaPulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }

        .coa-hover-glow:hover { box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); }

        /* Scrollbar for detail drawer */
        .coa-scroll::-webkit-scrollbar { width: 4px; }
        .coa-scroll::-webkit-scrollbar-track { background: transparent; }
        .coa-scroll::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 999px; }
    </style>

    <div class="min-h-screen bg-gray-50 text-gray-900 py-10" x-data="chartOfAccountsApp()">
        <div class="max-w-7xl mx-auto px-6 sm:px-10">

            {{-- Header --}}
            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 coa-fade-in">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Chart of Accounts</h1>
                    <p class="text-gray-500 text-sm mt-1">Complete double-entry ledger structure &mdash; click any account to drill down</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.reports.index') }}" class="bg-white border border-gray-200 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-50 transition-all shadow-sm font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i> Reports
                    </a>
                </div>
            </div>

            {{-- Filter Tabs --}}
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-4 mb-8 coa-fade-in" style="animation-delay: 0.05s;">
                <div class="flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center">
                    <div class="flex flex-col sm:flex-row gap-1.5 bg-gray-100 p-1 rounded-xl w-full md:w-auto">
                        <button @click="setLevel('consolidated')"
                                :class="level === 'consolidated' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 text-center">
                            <i class="fa-solid fa-store mr-1.5"></i> Consolidated
                        </button>
                        <button @click="setLevel('category')"
                                :class="level === 'category' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 text-center">
                            <i class="fa-solid fa-layer-group mr-1.5"></i> By Category
                        </button>
                        <button @click="setLevel('order')"
                                :class="level === 'order' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-lg transition-all duration-200 text-center">
                            <i class="fa-solid fa-receipt mr-1.5"></i> By Order
                        </button>
                    </div>

                    {{-- Dynamic Selector --}}
                    <div class="flex-1 max-w-sm w-full">
                        <div x-show="level === 'category'" x-cloak>
                            <select x-model="selectedCategory"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <template x-for="cat in categoryReports" :key="cat.id">
                                    <option :value="cat.id" x-text="cat.name"></option>
                                </template>
                            </select>
                        </div>
                        <div x-show="level === 'order'" x-cloak>
                            <select x-model="selectedOrder"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <template x-for="ord in orderReports" :key="ord.id">
                                    <option :value="ord.id" x-text="ord.name"></option>
                                </template>
                            </select>
                        </div>
                        <div x-show="level === 'consolidated'" class="text-right hidden md:block">
                            <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full coa-pulse"></span>
                                Live Store Ledger
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary Stat Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 coa-fade-in" style="animation-delay: 0.1s;">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Gross Sales</p>
                    <p class="text-xl font-black text-gray-800 mt-1" x-text="fmt(summary.total_sales)"></p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Net Profit</p>
                    <p class="text-xl font-black mt-1" :class="summary.net_profit >= 0 ? 'text-emerald-600' : 'text-red-600'" x-text="fmt(summary.net_profit)"></p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Revenue</p>
                    <p class="text-xl font-black text-blue-600 mt-1" x-text="fmt(summary.revenue)"></p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Gross Margin</p>
                    <p class="text-xl font-black text-amber-600 mt-1" x-text="summary.margin.toFixed(1) + '%'"></p>
                </div>
            </div>

            {{-- Main Content Area --}}
            <div class="relative">

                {{-- Account Groups --}}
                <div class="space-y-4 coa-fade-in" style="animation-delay: 0.15s;">

                    {{-- Account Group Template --}}
                    <template x-for="(group, gKey) in accountGroups" :key="gKey">
                        <div class="coa-group-card bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                            {{-- Group Header (clickable to expand/collapse) --}}
                            <button @click="toggleGroup(gKey)"
                                    class="w-full flex items-center justify-between px-6 py-5 hover:bg-gray-50/50 transition-colors text-left">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center"
                                         :class="groupStyles[gKey].bgLight">
                                        <i :class="groupStyles[gKey].icon + ' ' + groupStyles[gKey].textColor"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-black text-gray-900 text-base uppercase tracking-tight" x-text="group.name"></h3>
                                        <p class="text-gray-400 text-xs mt-0.5">
                                            <span x-text="group.children ? group.children.length : 0"></span> sub-accounts
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Balance</p>
                                        <p class="font-black text-lg" :class="groupStyles[gKey].textColor" x-text="fmt(group.balance)"></p>
                                    </div>
                                    {{-- % of total bar --}}
                                    <div class="hidden sm:block w-24">
                                        <div class="bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="coa-progress-bar"
                                                 :class="groupStyles[gKey].bgSolid"
                                                 :style="'width:' + getPercent(group.balance) + '%'"></div>
                                        </div>
                                        <p class="text-[9px] text-gray-400 font-bold mt-0.5 text-right" x-text="getPercent(group.balance).toFixed(1) + '% of total'"></p>
                                    </div>
                                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs coa-chevron"
                                       :class="openGroups[gKey] ? 'open' : ''"></i>
                                </div>
                            </button>

                            {{-- Sub-accounts (expandable) --}}
                            <div class="coa-expand-body" :class="openGroups[gKey] ? 'open' : ''">
                                <div class="border-t border-gray-100">

                                    {{-- Table Header --}}
                                    <div class="grid grid-cols-12 gap-2 px-6 py-3 bg-gray-50/70 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        <div class="col-span-1">#</div>
                                        <div class="col-span-5">Account Name</div>
                                        <div class="col-span-2 text-right">Debit</div>
                                        <div class="col-span-2 text-right">Credit</div>
                                        <div class="col-span-2 text-right">Balance</div>
                                    </div>

                                    {{-- Sub-account Rows --}}
                                    <template x-for="(child, idx) in (group.children || [])" :key="idx">
                                        <div @click="openDetail(gKey, idx, child)"
                                             class="coa-row grid grid-cols-12 gap-2 px-6 py-3.5 border-t border-gray-50 items-center group coa-hover-glow rounded-lg mx-2 my-0.5"
                                             :class="activeDetail && activeDetail.gKey === gKey && activeDetail.idx === idx ? 'bg-indigo-50/60 border-indigo-100' : 'hover:bg-gray-50'">
                                            <div class="col-span-1">
                                                <span class="w-6 h-6 rounded-lg text-[10px] font-black flex items-center justify-center"
                                                      :class="groupStyles[gKey].bgLight + ' ' + groupStyles[gKey].textColor"
                                                      x-text="(gKey === 'assets' ? '1' : gKey === 'liabilities' ? '2' : gKey === 'income' ? '4' : '5') + '0' + (idx + 1)">
                                                </span>
                                            </div>
                                            <div class="col-span-5">
                                                <p class="font-bold text-sm text-gray-800 group-hover:text-indigo-700 transition-colors flex items-center gap-2" x-text="child.name">
                                                </p>
                                            </div>
                                            <div class="col-span-2 text-right">
                                                <span class="text-sm font-bold text-gray-600" x-text="isDebitNormal(gKey) ? fmt(child.balance) : '—'"></span>
                                            </div>
                                            <div class="col-span-2 text-right">
                                                <span class="text-sm font-bold text-gray-600" x-text="!isDebitNormal(gKey) ? fmt(child.balance) : '—'"></span>
                                            </div>
                                            <div class="col-span-2 text-right flex items-center justify-end gap-2">
                                                <span class="font-black text-sm" :class="groupStyles[gKey].textColor" x-text="fmt(child.balance)"></span>
                                                <i class="fa-solid fa-arrow-right text-[9px] text-gray-300 group-hover:text-indigo-400 transition-colors"></i>
                                            </div>
                                        </div>
                                    </template>

                                    {{-- Group Total Footer --}}
                                    <div class="grid grid-cols-12 gap-2 px-6 py-3 bg-gray-50 border-t border-gray-100 text-sm">
                                        <div class="col-span-1"></div>
                                        <div class="col-span-5">
                                            <span class="font-black text-gray-600 uppercase text-xs tracking-wider">Total <span x-text="group.name"></span></span>
                                        </div>
                                        <div class="col-span-2 text-right">
                                            <span class="font-black text-gray-700" x-text="isDebitNormal(gKey) ? fmt(group.balance) : ''"></span>
                                        </div>
                                        <div class="col-span-2 text-right">
                                            <span class="font-black text-gray-700" x-text="!isDebitNormal(gKey) ? fmt(group.balance) : ''"></span>
                                        </div>
                                        <div class="col-span-2 text-right">
                                            <span class="font-black" :class="groupStyles[gKey].textColor" x-text="fmt(group.balance)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Trial Balance Summary --}}
                    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl p-6 shadow-lg coa-fade-in" style="animation-delay: 0.25s;">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h3 class="text-white font-black uppercase tracking-tight text-lg">Trial Balance Check</h3>
                                <p class="text-gray-400 text-xs mt-1">Total Debits must equal Total Credits (Accounting Equation)</p>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="text-right">
                                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Debits</p>
                                    <p class="text-white font-black text-lg" x-text="fmt(totalDebits())"></p>
                                </div>
                                <div class="text-gray-600 font-black text-xl">=</div>
                                <div class="text-right">
                                    <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Credits</p>
                                    <p class="text-white font-black text-lg" x-text="fmt(totalCredits())"></p>
                                </div>
                                <div class="ml-2">
                                    <template x-if="Math.abs(totalDebits() - totalCredits()) < 0.01">
                                        <span class="coa-badge bg-emerald-500/20 text-emerald-400">
                                            <i class="fa-solid fa-circle-check"></i> Balanced
                                        </span>
                                    </template>
                                    <template x-if="Math.abs(totalDebits() - totalCredits()) >= 0.01">
                                        <span class="coa-badge bg-red-500/20 text-red-400">
                                            <i class="fa-solid fa-triangle-exclamation"></i> Imbalanced
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detail Drawer (slides from right when an account row is clicked) --}}
                <div x-show="activeDetail"
                     x-cloak
                     @click.away="activeDetail = null"
                     class="fixed top-0 right-0 w-full sm:w-[420px] h-full bg-white shadow-2xl border-l border-gray-200 z-50 coa-detail-drawer coa-scroll overflow-y-auto"
                     :class="activeDetail ? 'open' : ''">

                    <div class="p-6" x-show="activeDetail">
                        {{-- Close button --}}
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                     :class="activeDetail ? groupStyles[activeDetail.gKey]?.bgLight : ''">
                                    <i :class="activeDetail ? groupStyles[activeDetail.gKey]?.icon + ' ' + groupStyles[activeDetail.gKey]?.textColor : ''" class="text-sm"></i>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400" x-text="activeDetail ? activeDetail.groupName : ''"></span>
                            </div>
                            <button @click="activeDetail = null" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition-colors">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </div>

                        {{-- Account Info --}}
                        <div class="mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight" x-text="activeDetail ? activeDetail.account.name : ''"></h3>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="coa-badge"
                                      :class="activeDetail ? groupStyles[activeDetail.gKey]?.bgLight + ' ' + groupStyles[activeDetail.gKey]?.textColor : ''"
                                      x-text="activeDetail ? (activeDetail.gKey === 'assets' ? '1' : activeDetail.gKey === 'liabilities' ? '2' : activeDetail.gKey === 'income' ? '4' : '5') + '0' + (activeDetail.idx + 1) : ''">
                                </span>
                                <span class="coa-badge bg-gray-100 text-gray-600" x-text="activeDetail ? (isDebitNormal(activeDetail.gKey) ? 'Debit Normal' : 'Credit Normal') : ''"></span>
                            </div>
                        </div>

                        {{-- Balance Display --}}
                        <div class="bg-gray-50 rounded-2xl p-5 mb-6">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Current Balance</p>
                            <p class="text-3xl font-black" :class="activeDetail ? groupStyles[activeDetail.gKey]?.textColor : ''" x-text="activeDetail ? fmt(activeDetail.account.balance) : ''"></p>
                            <div class="mt-3 bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="coa-progress-bar h-full"
                                     :class="activeDetail ? groupStyles[activeDetail.gKey]?.bgSolid : ''"
                                     :style="activeDetail ? 'width:' + getPercentOfGroup(activeDetail.gKey, activeDetail.account.balance) + '%' : 'width:0%'"></div>
                            </div>
                            <p class="text-[10px] text-gray-400 font-bold mt-1.5" x-text="activeDetail ? getPercentOfGroup(activeDetail.gKey, activeDetail.account.balance).toFixed(1) + '% of ' + activeDetail.groupName : ''"></p>
                        </div>

                        {{-- T-Account Visualization --}}
                        <div class="mb-6">
                            <h4 class="text-xs font-black uppercase text-gray-400 tracking-wider mb-3">T-Account</h4>
                            <div class="border border-gray-200 rounded-xl overflow-hidden">
                                <div class="grid grid-cols-2 text-center">
                                    <div class="p-4 border-r border-b border-gray-200 bg-gray-50">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Debit (Dr)</p>
                                    </div>
                                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Credit (Cr)</p>
                                    </div>
                                    <div class="p-4 border-r border-gray-200">
                                        <p class="font-black text-lg" :class="activeDetail && isDebitNormal(activeDetail.gKey) ? 'text-gray-900' : 'text-gray-300'"
                                           x-text="activeDetail && isDebitNormal(activeDetail.gKey) ? fmt(activeDetail.account.balance) : '—'"></p>
                                    </div>
                                    <div class="p-4">
                                        <p class="font-black text-lg" :class="activeDetail && !isDebitNormal(activeDetail.gKey) ? 'text-gray-900' : 'text-gray-300'"
                                           x-text="activeDetail && !isDebitNormal(activeDetail.gKey) ? fmt(activeDetail.account.balance) : '—'"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Account Details --}}
                        <div class="mb-6">
                            <h4 class="text-xs font-black uppercase text-gray-400 tracking-wider mb-3">Account Details</h4>
                            <div class="space-y-2.5">
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-gray-500 text-sm">Account Type</span>
                                    <span class="font-bold text-sm text-gray-800" x-text="activeDetail ? activeDetail.groupName : ''"></span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-gray-500 text-sm">Normal Balance</span>
                                    <span class="font-bold text-sm text-gray-800" x-text="activeDetail ? (isDebitNormal(activeDetail.gKey) ? 'Debit' : 'Credit') : ''"></span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-gray-500 text-sm">Report Scope</span>
                                    <span class="font-bold text-sm text-gray-800" x-text="level === 'consolidated' ? 'Consolidated' : level === 'category' ? 'Category' : 'Single Order'"></span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-gray-500 text-sm">Financial Statement</span>
                                    <span class="font-bold text-sm text-gray-800" x-text="activeDetail ? (activeDetail.gKey === 'assets' || activeDetail.gKey === 'liabilities' ? 'Balance Sheet' : 'Income Statement') : ''"></span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-500 text-sm">Status</span>
                                    <span class="coa-badge bg-emerald-50 text-emerald-700">
                                        <i class="fa-solid fa-circle text-[5px]"></i> Active
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Order-level metadata if on order mode --}}
                        <div x-show="level === 'order' && orderMeta" class="mb-6">
                            <h4 class="text-xs font-black uppercase text-gray-400 tracking-wider mb-3">Order Info</h4>
                            <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Customer</span>
                                    <span class="font-bold text-gray-800" x-text="orderMeta ? orderMeta.customer : ''"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Product</span>
                                    <span class="font-bold text-gray-800 text-right max-w-[180px] truncate" x-text="orderMeta ? orderMeta.service : ''"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Category</span>
                                    <span class="font-bold text-gray-800" x-text="orderMeta ? orderMeta.event_type : ''"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Date</span>
                                    <span class="font-bold text-gray-800" x-text="orderMeta ? orderMeta.booking_date : ''"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Close button at bottom --}}
                        <button @click="activeDetail = null" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs uppercase tracking-widest py-3 rounded-xl transition-colors">
                            Close Detail
                        </button>
                    </div>
                </div>

                {{-- Backdrop --}}
                <div x-show="activeDetail" x-cloak
                     @click="activeDetail = null"
                     class="fixed inset-0 bg-black/20 backdrop-blur-sm z-40 transition-opacity"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                </div>
            </div>

        </div>
    </div>

    <script>
        function chartOfAccountsApp() {
            return {
                level: 'consolidated',
                selectedCategory: '',
                selectedOrder: '',
                activeDetail: null,
                orderMeta: null,

                // Open/close state per group
                openGroups: { assets: true, liabilities: true, income: true, expenses: true },

                // Styling map
                groupStyles: {
                    assets: {
                        bgLight: 'bg-emerald-50',
                        bgSolid: 'bg-emerald-500',
                        textColor: 'text-emerald-600',
                        icon: 'fa-solid fa-vault'
                    },
                    liabilities: {
                        bgLight: 'bg-red-50',
                        bgSolid: 'bg-red-500',
                        textColor: 'text-red-600',
                        icon: 'fa-solid fa-file-invoice-dollar'
                    },
                    income: {
                        bgLight: 'bg-blue-50',
                        bgSolid: 'bg-blue-500',
                        textColor: 'text-blue-600',
                        icon: 'fa-solid fa-arrow-trend-up'
                    },
                    expenses: {
                        bgLight: 'bg-amber-50',
                        bgSolid: 'bg-amber-500',
                        textColor: 'text-amber-600',
                        icon: 'fa-solid fa-money-bill-transfer'
                    }
                },

                // Raw data from backend
                consolidatedData: @json($accounts),
                categoryReports: @json($eventTypeReports),
                orderReports: @json($projectReports),

                // Computed active accounts
                get accountGroups() {
                    return this.getActiveAccounts();
                },

                get summary() {
                    const accts = this.getActiveAccounts();
                    const revenue = parseFloat(accts.income?.balance || 0);
                    const expenses = parseFloat(accts.expenses?.balance || 0);
                    const netProfit = revenue - expenses;

                    let totalSales = 0;
                    if (this.level === 'consolidated') {
                        totalSales = this.orderReports
                            .filter(p => p.status === 'Completed' || p.status === 'Confirmed')
                            .reduce((s, p) => s + parseFloat(p.total_price), 0);
                    } else if (this.level === 'category') {
                        const cat = this.categoryReports.find(c => c.id === this.selectedCategory);
                        totalSales = cat ? parseFloat(cat.total_sales) : 0;
                    } else {
                        const ord = this.orderReports.find(o => o.id == this.selectedOrder);
                        totalSales = ord ? parseFloat(ord.total_price) : 0;
                    }

                    const margin = totalSales > 0 ? (netProfit / totalSales) * 100 : 0;
                    return { total_sales: totalSales, net_profit: netProfit, revenue, margin };
                },

                init() {
                    if (this.categoryReports.length > 0) this.selectedCategory = this.categoryReports[0].id;
                    if (this.orderReports.length > 0) this.selectedOrder = this.orderReports[0].id;

                    this.$watch('level', () => { this.activeDetail = null; });
                    this.$watch('selectedCategory', () => { this.activeDetail = null; });
                    this.$watch('selectedOrder', () => { this.activeDetail = null; this.updateOrderMeta(); });
                    this.updateOrderMeta();
                },

                setLevel(l) {
                    this.level = l;
                },

                getActiveAccounts() {
                    if (this.level === 'consolidated') return this.consolidatedData;
                    if (this.level === 'category') {
                        const cat = this.categoryReports.find(c => c.id === this.selectedCategory);
                        return cat ? cat.accounts : this.consolidatedData;
                    }
                    if (this.level === 'order') {
                        const ord = this.orderReports.find(o => o.id == this.selectedOrder);
                        return ord ? ord.accounts : this.consolidatedData;
                    }
                    return this.consolidatedData;
                },

                updateOrderMeta() {
                    if (this.level === 'order') {
                        const ord = this.orderReports.find(o => o.id == this.selectedOrder);
                        this.orderMeta = ord || null;
                    }
                },

                toggleGroup(gKey) {
                    this.openGroups[gKey] = !this.openGroups[gKey];
                },

                openDetail(gKey, idx, account) {
                    const accts = this.getActiveAccounts();
                    this.activeDetail = {
                        gKey,
                        idx,
                        account,
                        groupName: accts[gKey]?.name || gKey
                    };
                    if (this.level === 'order') this.updateOrderMeta();
                },

                isDebitNormal(gKey) {
                    return gKey === 'assets' || gKey === 'expenses';
                },

                totalDebits() {
                    const accts = this.getActiveAccounts();
                    return parseFloat(accts.assets?.balance || 0) + parseFloat(accts.expenses?.balance || 0);
                },

                totalCredits() {
                    const accts = this.getActiveAccounts();
                    return parseFloat(accts.liabilities?.balance || 0) + parseFloat(accts.income?.balance || 0);
                },

                getPercent(val) {
                    const accts = this.getActiveAccounts();
                    const total = Object.values(accts).reduce((s, g) => s + Math.abs(parseFloat(g.balance || 0)), 0);
                    return total > 0 ? (Math.abs(parseFloat(val)) / total) * 100 : 0;
                },

                getPercentOfGroup(gKey, val) {
                    const accts = this.getActiveAccounts();
                    const groupBal = Math.abs(parseFloat(accts[gKey]?.balance || 0));
                    return groupBal > 0 ? (Math.abs(parseFloat(val)) / groupBal) * 100 : 0;
                },

                fmt(value) {
                    return 'PKR ' + parseFloat(value || 0).toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            };
        }
    </script>
</x-app-layout>
