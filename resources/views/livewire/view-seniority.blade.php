<div>
    <div class="text-4xl font-bold mb-8">
        View Seniority List
    </div>

    <div class="bg-white rounded-lg overflow-hidden shadow-xl">
        <div class="px-4 py-2">
            <label for="months" class="form-label">{{ __('Months In Database') }}</label>
            <div class="grid grid-cols-6 gap-3">
                @forelse($savedMonths as $month)
                    <div class="col-span-2 sm:col-span-1 bg-green-300 p-2 text-white text-sm text-center rounded shadow">
                        {{ \Carbon\Carbon::parse($month)->format('M Y') }}
                    </div>
                @empty
                    <div>NO DATA.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>