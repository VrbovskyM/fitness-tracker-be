<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header --}}
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ __('System Logs') }}</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('View and search through system logs and events') }}
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

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                {{-- General Search --}}
                <div>
                    <label for="search"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Search') }}</label>
                    <input type="text" id="search" wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search message, source, URL...') }}"
                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-800 dark:text-zinc-100 dark:placeholder-zinc-400" />
                </div>

                {{-- Level Filter --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Levels') }}</label>
                    <div class="space-y-2">
                        @foreach($logLevels as $level)
                            <label class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    wire:model.live="levelFilters" 
                                    value="{{ $level }}"
                                    class="rounded border-zinc-300 dark:border-zinc-600 text-zinc-600 shadow-sm focus:border-zinc-500 focus:ring-zinc-500 dark:bg-zinc-800 dark:focus:ring-offset-zinc-800"
                                />
                                <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">{{ ucfirst($level) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Source Filter --}}
                <div>
                    <label for="sourceFilter"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Source') }}</label>
                    <input type="text" id="sourceFilter" wire:model.live.debounce.300ms="sourceFilter"
                        placeholder="{{ __('Filter by source...') }}"
                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-800 dark:text-zinc-100 dark:placeholder-zinc-400" />
                </div>

                {{-- User ID Filter --}}
                <div>
                    <label for="userIdFilter"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('User ID') }}</label>
                    <input type="text" id="userIdFilter" wire:model.live.debounce.300ms="userIdFilter"
                        placeholder="{{ __('Filter by user ID...') }}"
                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-800 dark:text-zinc-100 dark:placeholder-zinc-400" />
                </div>

                {{-- Session ID Filter --}}
                <div>
                    <label for="sessionIdFilter"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Session ID') }}</label>
                    <input type="text" id="sessionIdFilter" wire:model.live.debounce.300ms="sessionIdFilter"
                        placeholder="{{ __('Filter by session...') }}"
                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-800 dark:text-zinc-100 dark:placeholder-zinc-400" />
                </div>

                {{-- Date From --}}
                <div>
                    <label for="dateFrom"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Date From') }}</label>
                    <input type="date" id="dateFrom" wire:model.live="dateFrom"
                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-800 dark:text-zinc-100" />
                </div>

                {{-- Date To --}}
                <div>
                    <label for="dateTo"
                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Date To') }}</label>
                    <input type="date" id="dateTo" wire:model.live="dateTo"
                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:border-zinc-500 dark:bg-zinc-800 dark:text-zinc-100" />
                </div>
            </div>
        </div>

        {{-- Active Filters --}}
        @if($search || count($levelFilters) > 0 || $sourceFilter || $userIdFilter || $sessionIdFilter || $dateFrom || $dateTo)
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

                @foreach($levelFilters as $level)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">
                        {{ __('Level: :level', ['level' => ucfirst($level)]) }}
                        <button wire:click="$set('levelFilters', {{ json_encode(array_values(array_diff($levelFilters, [$level]))) }})" class="ml-1 text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                @endforeach

                @if($sourceFilter)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                        {{ __('Source: :source', ['source' => $sourceFilter]) }}
                        <button wire:click="$set('sourceFilter', '')" class="ml-1 text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                @endif

                @if($userIdFilter)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300">
                        {{ __('User: :user', ['user' => $userIdFilter]) }}
                        <button wire:click="$set('userIdFilter', '')" class="ml-1 text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                @endif

                @if($sessionIdFilter)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300">
                        {{ __('Session: :session', ['session' => Str::limit($sessionIdFilter, 10)]) }}
                        <button wire:click="$set('sessionIdFilter', '')" class="ml-1 text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                @endif

                @if($dateFrom)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                        {{ __('From: :date', ['date' => $dateFrom]) }}
                        <button wire:click="$set('dateFrom', '')" class="ml-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>
                @endif

                @if($dateTo)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300">
                        {{ __('To: :date', ['date' => $dateTo]) }}
                        <button wire:click="$set('dateTo', '')" class="ml-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200">
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
    'from' => $logs->firstItem() ?? 0,
    'to' => $logs->lastItem() ?? 0,
    'total' => $logs->total()
]) }}
            </p>
        </div>

        {{-- Logs Table --}}
        <div
            class="relative overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('Level') }}
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                <button 
                                    wire:click="sortBy('timestamp')"
                                    class="flex items-center space-x-1 hover:text-zinc-700 dark:hover:text-zinc-200 focus:outline-none"
                                >
                                    <span>{{ __('Timestamp') }}</span>
                                    @if($sortField === 'timestamp')
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
                            <th
                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('Message') }}
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('Source') }}
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('User') }}
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('Session') }}
                            </th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($logs as $log)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50" wire:key="log-{{ $log->id }}">
                                {{-- Level Badge --}}
                                <td class="px-4 py-3">
                                    @php
                                        $levelClasses = [
                                            'debug' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300',
                                            'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                                            'warn' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                                            'error' => 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300'
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $levelClasses[$log->level] ?? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300' }}">
                                        {{ ucfirst($log->level) }}
                                    </span>
                                </td>

                                {{-- Timestamp --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                        {{ $log->timestamp->format('M j, Y') }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $log->timestamp->format('H:i:s') }}
                                    </div>
                                </td>

                                {{-- Message --}}
                                <td class="px-4 py-3">
                                    <div class="max-w-xs truncate text-sm text-zinc-900 dark:text-zinc-100"
                                        title="{{ $log->message }}">
                                        {{ $log->message }}
                                    </div>
                                </td>

                                {{-- Source --}}
                                <td class="px-4 py-3">
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $log->source ?? '-' }}
                                    </div>
                                </td>

                                {{-- User --}}
                                <td class="px-4 py-3">
                                    @if($log->user)
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ $log->user->name }}
                                        </div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                            ID: {{ $log->user_id }}
                                        </div>
                                    @elseif($log->user_id)
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                            ID: {{ $log->user_id }}
                                        </div>
                                    @else
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">-</div>
                                    @endif
                                </td>

                                {{-- Session --}}
                                <td class="px-4 py-3">
                                    @if($log->session_id)
                                        <div class="max-w-24 truncate font-mono text-xs text-zinc-500 dark:text-zinc-400"
                                            title="{{ $log->session_id }}">
                                            {{ $log->session_id }}
                                        </div>
                                    @else
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">-</div>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="px-4 py-3">
                                    <button
                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500"
                                        x-data="" x-on:click="$dispatch('open-log-details', { log: @js($log) })">
                                        {{ __('Details') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-zinc-400 dark:text-zinc-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-zinc-100">
                                            {{ __('No logs found') }}
                                        </h3>
                                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ __('Try adjusting your search criteria or filters.') }}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($logs->hasPages())
            <div class="flex justify-center">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    {{-- Log Details Modal --}}
    <div x-data="{ 
            showModal: false, 
            selectedLog: null,
            init() {
                this.$watch('showModal', value => {
                    if (value) {
                        document.body.classList.add('overflow-hidden');
                    } else {
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            }
        }" x-on:open-log-details.window="selectedLog = $event.detail.log; showModal = true">
        {{-- Modal Overlay --}}
        <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-zinc-500/40 z-50" x-on:click="showModal = false"></div>

        {{-- Modal Content --}}
        <div x-show="showModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white dark:bg-zinc-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl sm:p-6">
                    {{-- Modal Header --}}
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ __('Log Details') }}
                        </h3>
                        <button
                            class="rounded-md text-zinc-400 hover:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-500"
                            x-on:click="showModal = false">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div x-show="selectedLog" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            {{-- Basic Info --}}
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Level') }}</label>
                                    <input type="text" x-bind:value="selectedLog?.level" readonly
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" />
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Timestamp') }}</label>
                                    <input type="text" x-bind:value="selectedLog?.timestamp" readonly
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" />
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Source') }}</label>
                                    <input type="text" x-bind:value="selectedLog?.source || '-'" readonly
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" />
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('User ID') }}</label>
                                    <input type="text" x-bind:value="selectedLog?.user_id || '-'" readonly
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" />
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Session ID') }}</label>
                                    <input type="text" x-bind:value="selectedLog?.session_id || '-'" readonly
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100" />
                                </div>
                            </div>

                            {{-- Additional Info --}}
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('URL') }}</label>
                                    <textarea x-bind:value="selectedLog?.url || '-'" readonly rows="2"
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"></textarea>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('User Agent') }}</label>
                                    <textarea x-bind:value="selectedLog?.user_agent || '-'" readonly rows="3"
                                        class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label
                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Message') }}</label>
                            <textarea x-bind:value="selectedLog?.message" readonly rows="4"
                                class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"></textarea>
                        </div>

                        {{-- Stack Trace --}}
                        <div>
                            <label
                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Stack Trace') }}</label>
                            <textarea 
                                x-bind:value="selectedLog?.stack || '{{ __('No stack trace available') }}'" 
                                readonly 
                                rows="8"
                                class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-xs font-mono bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                x-bind:class="{ 'text-zinc-500 dark:text-zinc-400 italic': !selectedLog?.stack }"
                            ></textarea>
                        </div>

                        {{-- Additional Data --}}
                        <div>
                            <label
                                class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ __('Additional Data') }}</label>
                            <textarea 
                                x-bind:value="selectedLog?.additional_data && Object.keys(selectedLog.additional_data).length > 0 ? JSON.stringify(selectedLog.additional_data, null, 2) : '{{ __('No additional data available') }}'" 
                                readonly
                                rows="6"
                                class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-xs font-mono bg-zinc-50 dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100"
                                x-bind:class="{ 'text-zinc-500 dark:text-zinc-400 italic': !selectedLog?.additional_data || Object.keys(selectedLog.additional_data || {}).length === 0 }"
                            ></textarea>
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="mt-6 flex justify-end">
                        <button type="button" x-on:click="showModal = false"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-zinc-600 hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>