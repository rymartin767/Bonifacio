<div>
    <button wire:click="truncateAwards">TRUNCATE</button>
    <button wire:click="seedAwards">SEED</button>
    <div>
        {{ \App\Models\Vacancy::count() }} Total
    </div>
    <div>
        UPGRADES: {{ $upgrades }}
    </div>
</div>
