<div class="sm:rounded-lg sm:shadow overflow-hidden">
    <div class="flex bg-gray-50 text-gray-500 uppercase px-6 py-3">
        <div class="flex-1">{{ __('airline name') }}</div>
        <div class="flex-1">{{ __('hiring?') }}</div>
        <div class="flex-1">{{ __('scales') }}</div>
    </div>
    @foreach($airlines as $airline)
        <div class="flex items-center {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} px-6 py-3">
            <div class="flex-1">{{ $airline->name }}</div>
            <div class="flex-1">
                <button wire:click="toggleHiring({{$airline}})" type="button" class="p-2 {{ $airline->hiring ? 'bg-green-400' : 'bg-red-400'}} text-white rounded shadow-sm">HIRING?</button>
                <x-modal>
                    <x-slot name="title">Hiring URL</x-slot>
                    <x-slot name="trigger">
                        <x-jet-button wire:click="modalDisplayed({{$airline}})">URL</x-jet-button>
                    </x-slot>
                    <x-slot name="content">
                        {{ __('Update URL') }}
                
                        <div class="mt-4" x-data="{}" x-on:confirming-modal-event.window="setTimeout(() => refs.url.focus(), 250)">
                            <x-jet-input type="text" class="mt-1 block w-3/4" placeholder="{{ __('Hiring URL') }}" x-ref="url" wire:model.lazy="url"/>
                            <x-jet-input-error for="url" class="mt-2" />
                        </div>
                    </x-slot>
                </x-modal>
            </div>
            <div class="flex-1">
                <button wire:click="updateScales({{$airline}})" type="button" class="p-2 bg-blue-500 text-white rounded shadow-sm">RESEED SCALES</button>
            </div>
        </div>
    @endforeach
</div>