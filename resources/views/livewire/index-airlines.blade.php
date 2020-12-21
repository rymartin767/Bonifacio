<div>
    AIRLINES: {{ $airlines->count() }}
    @forelse($airlines as $airline)
        <div>
            <div>
                {{ $airline->name }}
            </div>
        </div>
    @empty  
        <div>EMPTY</div>
    @endforelse
</div>
