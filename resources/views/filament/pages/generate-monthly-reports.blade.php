<x-filament-panels::page>

    <div class="space-y-6">

        {{-- Info card --}}
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-800 dark:border-amber-700 dark:bg-amber-900/20 dark:text-amber-300">
            <p class="font-semibold mb-1">About Monthly Reports</p>
            <ul class="list-disc list-inside space-y-1">
                <li>Each active business with an owner account will receive a performance snapshot.</li>
                <li>Reports include: profile views, package inquiries, post engagement, feed post CTR, and ranking change.</li>
                <li>Tick <strong>Send notifications</strong> to dispatch emails and in-dashboard alerts immediately after generating.</li>
                <li>Reports are automatically generated and sent on the <strong>1st of each month at 08:00</strong> via the scheduler.</li>
            </ul>
        </div>

        {{-- Form --}}
        <x-filament::section heading="Select Period">
            <form wire:submit="generate">
                {{ $this->form }}

                <div class="mt-6 flex items-center gap-3">
                    <x-filament::button type="submit" icon="heroicon-o-cog-6-tooth">
                        Generate Reports
                    </x-filament::button>
                    <span class="text-sm text-gray-500">This may take a few seconds for large numbers of businesses.</span>
                </div>
            </form>
        </x-filament::section>

        {{-- Quick stats --}}
        @php
            $pendingCount = \App\Models\MonthlyReport::where('status', 'pending')->count();
            $sentCount    = \App\Models\MonthlyReport::where('status', 'sent')->count();
            $failedCount  = \App\Models\MonthlyReport::where('status', 'failed')->count();
        @endphp

        <x-filament::section heading="Report Status Summary">
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="rounded-lg bg-amber-50 p-4 dark:bg-amber-900/20">
                    <div class="text-2xl font-bold text-amber-600">{{ $pendingCount }}</div>
                    <div class="text-xs text-gray-500 mt-1">Pending</div>
                </div>
                <div class="rounded-lg bg-green-50 p-4 dark:bg-green-900/20">
                    <div class="text-2xl font-bold text-green-600">{{ $sentCount }}</div>
                    <div class="text-xs text-gray-500 mt-1">Sent</div>
                </div>
                <div class="rounded-lg bg-red-50 p-4 dark:bg-red-900/20">
                    <div class="text-2xl font-bold text-red-500">{{ $failedCount }}</div>
                    <div class="text-xs text-gray-500 mt-1">Failed</div>
                </div>
            </div>
        </x-filament::section>

    </div>

</x-filament-panels::page>
