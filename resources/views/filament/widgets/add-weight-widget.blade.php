<x-filament-widgets::widget>
    <x-filament::section>
        @if (!$weight)
        <form wire:submit="addWeight">
            @csrf
            <x-filament::input.wrapper for="weight" label="Weight" class="mb-2">
                <x-slot name="label">
                    Weight
                </x-slot>
                <x-filament::input id="weight" wire:model="inputWeight" />
            </x-filament::input.wrapper>        
            <x-filament::button type="submit">Add Weight</x-filament::button>
        </form>
        @else   
            <div class="grid gap-y-2">
            <div class="flex items-center gap-x-2">
                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                <span class="fi-wi-stats-overview-stat-label text-sm font-medium text-gray-500 dark:text-gray-400">
                    Weight
                </span>
            </div>

            <div class="fi-wi-stats-overview-stat-value text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{ $weight->weight }}kg
            </div>

            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
        </div>
        @endif
       
    </x-filament::section>
</x-filament-widgets::widget>
