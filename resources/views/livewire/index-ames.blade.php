<div class="sm:rounded-lg sm:shadow overflow-hidden">
    <div class="flex bg-gray-50 text-sm text-gray-500 uppercase px-6 py-3">
        <div class="flex-1">{{ __('ame') }}</div>
        <div class="flex-1">{{ __('location') }}</div>
        <div class="flex-1">{{ __('delete') }}</div>
    </div>
    @forelse($ames as $ame)
        <div class="flex items-center {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} px-6 py-3">
            <div class="flex-1">{{ $ame->name }}</div>
            <div class="flex-1">{{ $ame->city }}, {{ $ame->state }}</div>
            <div class="flex-1">
                <button wire:click="deleteAme({{$ame->id}})" type="button" class="px-2 py-1 bg-blue-500 text-white rounded shadow-sm">DELETE</button>
            </div>
        </div>
    @empty
        <div>No Records Found.</div>
    @endforelse
</div>