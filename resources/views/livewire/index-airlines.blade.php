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
            </div>
            <div class="flex-1">
                <button wire:click="updateScales({{$airline}})" type="button" class="p-2 bg-blue-500 text-white rounded shadow-sm">RESEED SCALES</button>
            </div>
        </div>
    @endforeach
</div>