<div>
    <button wire:click="truncateAwards">TRUNCATE</button>
    <div>
        {{ \App\Models\Vacancy::count() }} Total
    </div>
    <div>
        UPGRADES: {{ $upgrades }}
    </div>
    <div>
        NEW HIRES: {{ $hires }}
    </div>
</div>
