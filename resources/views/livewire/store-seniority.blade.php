<div class="max-w-xl">
    <div class="text-4xl font-bold mb-8">
        Add Seniority List
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
        <form wire:submit.prevent="submitForm">
            <div class="px-4 py-2">
                <label class="form-label">
                    AWS Files
                </label>
                <select wire:model="pathToCsv" class="form-input ">
                    <option value="">Select One...</option>
                    @foreach($files as $file)
                        <option value="{{ $file }}">{{ $file }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <div class="flex items-center justify-end px-4 py-3 bg-gray-100">
                    @isset($status)
                        <div x-data="{ shown: false, timeout: null }" x-init="() => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); }" x-show.transition.opacity.out.duration.1500ms="shown" class="text-sm text-green-400 mr-6 pt-1">{{ $status }}</div>
                    @endisset
                    <button type="submit" class="btn">
                        <svg wire:loading wire:target="submitForm" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Submit Form</span>
                    <button>
                </div>
            </div>
        </form>
    </div>
</div>