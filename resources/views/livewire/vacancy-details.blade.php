<div>
    <button wire:click="truncateAwards">TRUNCATE</button>
    {{ \App\Models\Vacancy::count() }} Total
</div>
