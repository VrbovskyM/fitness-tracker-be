<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header --}}
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Users') }}</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('Manage and view all users in the system') }}
                </p>
            </div>
            <button wire:click="clearFilters"
                class="inline-flex items-center px-3 py-2 border border-zinc-300 dark:border-zinc-600 shadow-sm text-sm leading-4 font-medium rounded-md text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500">
                {{ __('Clear Filters') }}
            </button>
        </div>

        <div class="border-t border-zinc-200 dark:border-zinc-700"></div>

        {{-- Search and Filters --}}
        <div class="space-y-4">
            <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ __('Filters') }}</h2>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                {{-- General Search --}}
                <div>
                    <label for="search"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Search') }}</label>
                    <input type="text" id="search" wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search by name or email...') }}"
                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-800 dark:text-zinc-100 dark:placeholder-zinc-400" />
                </div>
            </div>
        </div>

        {{-- Active Filters --}}
        @if($search)
            <div class="flex flex-wrap gap-2">
                <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Active filters:') }}</span>
                
                @if($search)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                        {{ __('Search: :search', ['search' => $search]) }}
                        <button wire:click="$set('search', '')" class="ml-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                @endif
            </div>
        @endif

        {{-- Results Count --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Showing :from to :to of :total results', [
                    'from' => $users->firstItem() ?? 0,
                    'to' => $users->lastItem() ?? 0,
                    'total' => $users->total()
                ]) }}
            </p>
        </div>

        {{-- Users Table --}}
        <div class="relative overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                <button 
                                    wire:click="sortBy('id')"
                                    class="flex items-center space-x-1 hover:text-zinc-700 dark:hover:text-zinc-200 focus:outline-none"
                                >
                                    <span>{{ __('ID') }}</span>
                                    @if($sortField === 'id')
                                        @if($sortDirection === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                <button 
                                    wire:click="sortBy('name')"
                                    class="flex items-center space-x-1 hover:text-zinc-700 dark:hover:text-zinc-200 focus:outline-none"
                                >
                                    <span>{{ __('Name') }}</span>
                                    @if($sortField === 'name')
                                        @if($sortDirection === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                <button 
                                    wire:click="sortBy('email')"
                                    class="flex items-center space-x-1 hover:text-zinc-700 dark:hover:text-zinc-200 focus:outline-none"
                                >
                                    <span>{{ __('Email') }}</span>
                                    @if($sortField === 'email')
                                        @if($sortDirection === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('Email Verified') }}
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                <button 
                                    wire:click="sortBy('created_at')"
                                    class="flex items-center space-x-1 hover:text-zinc-700 dark:hover:text-zinc-200 focus:outline-none"
                                >
                                    <span>{{ __('Joined') }}</span>
                                    @if($sortField === 'created_at')
                                        @if($sortDirection === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                <button 
                                    wire:click="sortBy('updated_at')"
                                    class="flex items-center space-x-1 hover:text-zinc-700 dark:hover:text-zinc-200 focus:outline-none"
                                >
                                    <span>{{ __('Last Updated') }}</span>
                                    @if($sortField === 'updated_at')
                                        @if($sortDirection === 'asc')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        @endif
                                    @else
                                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    @endif
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50" wire:key="user-{{ $user->id }}">
                                {{-- ID --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $user->id }}
                                    </div>
                                </td>

                                {{-- Name --}}
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                                <span class="text-xs font-medium text-zinc-700 dark:text-zinc-300">
                                                    {{ $user->initials() }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $user->email }}
                                    </div>
                                </td>

                                {{-- Email Verified --}}
                                <td class="px-4 py-3">
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                            {{ __('Verified') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                                            {{ __('Unverified') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Joined Date --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $user->created_at->format('M j, Y') }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $user->created_at->format('H:i:s') }}
                                    </div>
                                </td>

                                {{-- Last Updated --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-900 dark:text-zinc-100">
                                        {{ $user->updated_at->format('M j, Y') }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $user->updated_at->format('H:i:s') }}
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3">
                                    <button 
                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500"
                                        x-data=""
                                        x-on:click="$dispatch('open-user-details', { user: @js($user) })"
                                    >
                                        {{ __('View') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ __('No users found') }}</h3>
                                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Try adjusting your search criteria.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
            <div class="flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- User Details Modal --}}
    <div 
        x-data="{ 
            showModal: false, 
            selectedUser: null,
            init() {
                this.$watch('showModal', value => {
                    if (value) {
                        document.body.classList.add('overflow-hidden');
                    } else {
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            }
        }" 
        x-on:open-user-details.window="selectedUser = $event.detail.user; showModal = true"
    >
        {{-- Modal Overlay --}}
        <div 
            x-show="showModal" 
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-zinc-500/40 z-50"
            x-on:click="showModal = false"
        ></div>

        {{-- Modal Content --}}
        <div 
            x-show="showModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-50 overflow-y-auto"
        >
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-zinc-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6">
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ __('User Details') }}</h3>
                        <button 
                            class="rounded-md text-zinc-400 hover:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-500"
                            x-on:click="showModal = false"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div x-show="selectedUser" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- Basic Info --}}
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('ID') }}</label>
                                    <input 
                                        type="text" 
                                        x-bind:value="selectedUser?.id" 
                                        readonly 
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                    />
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Name') }}</label>
                                    <input 
                                        type="text" 
                                        x-bind:value="selectedUser?.name" 
                                        readonly 
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                    />
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Email') }}</label>
                                    <input 
                                        type="text" 
                                        x-bind:value="selectedUser?.email" 
                                        readonly 
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                    />
                                </div>
                            </div>

                            {{-- Additional Info --}}
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Email Verified At') }}</label>
                                    <input 
                                        type="text" 
                                        x-bind:value="selectedUser?.email_verified_at || '{{ __('Not verified') }}'" 
                                        readonly 
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                    />
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Created At') }}</label>
                                    <input 
                                        type="text" 
                                        x-bind:value="selectedUser?.created_at" 
                                        readonly 
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                    />
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Updated At') }}</label>
                                    <input 
                                        type="text" 
                                        x-bind:value="selectedUser?.updated_at" 
                                        readonly 
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="mt-6 flex justify-end">
                        <button 
                            type="button" 
                            x-on:click="showModal = false"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-zinc-600 hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500"
                        >
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
