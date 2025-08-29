{{-- @php
use Illuminate\Support\Facades\Storage;
@endphp

<!-- Desktop Sidebar -->
<div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 z-50">
    <div class="flex flex-col flex-grow bg-white border-r border-gray-200 shadow-sm">
        <!-- Logo Section -->
        <div class="flex items-center flex-shrink-0 px-6 py-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                @if(isset($storeSettings) && $storeSettings->store_logo && Storage::disk('public')->exists($storeSettings->store_logo))
                    <img src="{{ Storage::url($storeSettings->store_logo) }}"
                         alt="{{ $storeSettings->store_name }}"
                         class="w-10 h-10 rounded-lg object-cover">
                @else
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-lg font-bold text-gray-900">{{ $storeSettings->store_name ?? 'Minimarket POS' }}</h1>
                    <p class="text-xs text-gray-500">Point of Sale System</p>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               data-tooltip="Dashboard">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- POS -->
            <a href="{{ route('pos.index') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('pos.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               data-tooltip="Point of Sale">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('pos.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                </svg>
                <span>Point of Sale</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Admin Section Divider -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Management</p>
                </div>

                <!-- Products -->
                <a href="{{ route('products.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Product Management">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('products.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Products</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('categories.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Categories">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('categories.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Categories</span>
                </a>

                <!-- Reports -->
                <a href="{{ route('reports.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Reports & Analytics">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('reports.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- System Section -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
                </div>

                <!-- Users -->
                <a href="{{ route('users.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="User Management">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('users.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span>Users</span>
                </a>


                <!-- Settings -->
                <a href="{{ route('settings.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Settings">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('settings.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            @endif
        </nav>

        <!-- User Profile Section -->
        <div class="flex-shrink-0 border-t border-gray-200 p-4">
            <div x-data="{ profileOpen: false }" class="relative">
                <button @click="profileOpen = !profileOpen"
                        class="w-full flex items-center px-3 py-2 text-sm rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 text-left flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="profileOpen"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     @click.away="profileOpen = false"
                     class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar -->
<div x-show="sidebarOpen"
     x-transition:enter="transition ease-in-out duration-300 transform"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in-out duration-300 transform"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 shadow-lg lg:hidden">
    <div class="flex flex-col h-full">
        <!-- Mobile Logo Section -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                @if(isset($storeSettings) && $storeSettings->store_logo && Storage::disk('public')->exists($storeSettings->store_logo))
                    <img src="{{ Storage::url($storeSettings->store_logo) }}"
                         alt="{{ $storeSettings->store_name }}"
                         class="w-8 h-8 rounded-lg object-cover">
                @else
                    <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-base font-bold text-gray-900">{{ $storeSettings->store_name ?? 'Minimarket POS' }}</h1>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               @click="sidebarOpen = false">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- POS -->
            <a href="{{ route('pos.index') }}"
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('pos.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               @click="sidebarOpen = false">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('pos.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                </svg>
                <span>Point of Sale</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Admin Section -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Management</p>
                </div>

                <a href="{{ route('products.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('products.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Products</span>
                </a>

                <a href="{{ route('categories.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('categories.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Categories</span>
                </a>

                <a href="{{ route('reports.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('reports.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- System Section -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">System</p>
                </div>

                <a href="{{ route('users.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('users.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span>Users</span>
                </a>

                <a href="{{ route('settings.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 {{ request()->routeIs('settings.*') ? 'text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            @endif
        </nav>

        <!-- Mobile User Profile -->
        <div class="flex-shrink-0 border-t border-gray-200 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50"
                   @click="sidebarOpen = false">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

@php
use Illuminate\Support\Facades\Storage;
@endphp

<!-- Desktop Sidebar -->
<div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 z-50">
    <div class="flex flex-col flex-grow bg-white border-r border-gray-200 shadow-sm">
        <!-- Logo Section -->
        <div class="flex items-center flex-shrink-0 px-6 py-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                @if(isset($storeSettings) && $storeSettings->store_logo && Storage::disk('public')->exists($storeSettings->store_logo))
                    <img src="{{ Storage::url($storeSettings->store_logo) }}"
                         alt="{{ $storeSettings->store_name }}"
                         class="w-10 h-10 rounded-lg object-cover">
                @else
                    <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-lg font-bold text-gray-900">{{ $storeSettings->store_name ?? 'Minimarket POS' }}</h1>
                    <p class="text-xs text-gray-500">Point of Sale System</p>
                </div>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               data-tooltip="Dashboard">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {{-- Icon diperbaiki: menggunakan ikon 'Home' --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- POS -->
            <a href="{{ route('pos.index') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('pos.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               data-tooltip="Point of Sale">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                </svg>
                <span>Point of Sale</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Admin Section Divider -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Management</p>
                </div>

                <!-- Products -->
                <a href="{{ route('products.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Product Management">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Products</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('categories.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Categories">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Categories</span>
                </a>

                <!-- Reports -->
                <a href="{{ route('reports.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Reports & Analytics">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- System Section -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p>
                </div>

                <!-- Users -->
                <a href="{{ route('users.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="User Management">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {{-- Icon diperbaiki: menggunakan ikon 'Users' yang benar --}}
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 5a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Users</span>
                </a>


                <!-- Settings -->
                <a href="{{ route('settings.index') }}"
                   class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 group {{ request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-700 border-r-2 border-indigo-500' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   data-tooltip="Settings">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            @endif
        </nav>

        <!-- User Profile Section -->
        <div class="flex-shrink-0 border-t border-gray-200 p-4">
            <div x-data="{ profileOpen: false }" class="relative">
                <button @click="profileOpen = !profileOpen"
                        class="w-full flex items-center px-3 py-2 text-sm rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 text-left flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="profileOpen"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     @click.away="profileOpen = false"
                     class="absolute bottom-full left-0 right-0 mb-2 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Sidebar -->
<div x-show="sidebarOpen"
     x-transition:enter="transition ease-in-out duration-300 transform"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in-out duration-300 transform"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 shadow-lg lg:hidden">
    <div class="flex flex-col h-full">
        <!-- Mobile Logo Section -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                @if(isset($storeSettings) && $storeSettings->store_logo && Storage::disk('public')->exists($storeSettings->store_logo))
                    <img src="{{ Storage::url($storeSettings->store_logo) }}"
                         alt="{{ $storeSettings->store_name }}"
                         class="w-8 h-8 rounded-lg object-cover">
                @else
                    <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h1 class="text-base font-bold text-gray-900">{{ $storeSettings->store_name ?? 'Minimarket POS' }}</h1>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               @click="sidebarOpen = false">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {{-- Icon diperbaiki: menggunakan ikon 'Home' --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- POS -->
            <a href="{{ route('pos.index') }}"
               class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('pos.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               @click="sidebarOpen = false">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 1.5M7 13l1.5 1.5M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                </svg>
                <span>Point of Sale</span>
            </a>

            @if(auth()->user()->role === 'admin')
                <!-- Admin Section -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Management</p>
                </div>

                <a href="{{ route('products.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Products</span>
                </a>

                <a href="{{ route('categories.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Categories</span>
                </a>

                <a href="{{ route('reports.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- System Section -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">System</p>
                </div>

                <a href="{{ route('users.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {{-- Icon diperbaiki: menggunakan ikon 'Users' yang benar --}}
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 5a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Users</span>
                </a>

                <a href="{{ route('settings.index') }}"
                   class="flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('settings.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
                   @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            @endif
        </nav>

        <!-- Mobile User Profile -->
        <div class="flex-shrink-0 border-t border-gray-200 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50"
                   @click="sidebarOpen = false">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
