<div>
    <button wire:click="truncateAwards">TRUNCATE</button>
    <div>
        {{ \App\Models\Vacancy::count() }} Total
    </div>
    <div>
        @foreach($awards as $v)
            <div>
                {{ $v->emp }}
            </div>
        @endforeach
    </div>
    <div>
        UPGRADES: {{ $upgrades }}
    </div>
    <div>
        NEW HIRES: {{ $hires }}
    </div>
</div>
