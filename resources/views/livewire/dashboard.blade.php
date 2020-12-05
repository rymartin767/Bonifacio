<div class="max-w-3xl mx-auto mt-12">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="bg-blue-800 text-white text-md text-center py-4">
            NEW AIRLINE FORM
        </div>
        <form wire:submit.prevent="submitForm">
            <div class="form-group">
                <label class="form-label">
                    Airline Sector
                </label>
                <select wire:model.lazy="sector" class="form-input">
                    <option value="">Select One</option>
                    <option value="cargo">Cargo</option>
                    <option value="legacy">Legacy</option>
                    <option value="major">Major</option>
                </select>
                @error('sector')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">
                    Airline Name
                </label>
                <input wire:model.lazy="name" type="string" class="form-input" autocomplete="name">
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">
                    Airline ICAO
                </label>
                <input wire:model.lazy="icao" type="string" class="form-input" autocomplete="icao">
                @error('icao')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">
                    Airline IATA
                </label>
                <input wire:model.lazy="iata" type="string" class="form-input" autocomplete="iata">
                @error('iata')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">
                    Airline Union
                </label>
                <select wire:model.lazy="union" class="form-input" autocomplete="union">
                    <option value="">Select One</option>
                    <option value="alpa">ALPA</option>
                    <option value="apa">American Pilots Association</option>
                    <option value="ipa">Independent Pilots (UPS)</option>
                    <option value="sapa">SWA Pilots Association</option>
                    <option value="ibt">Teamsters</option>
                    <option value="none">None</option>
                </select>
                @error('union')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">
                    Pilots
                </label>
                <input wire:model.lazy="pilots" type="number" class="form-input " autocomplete="pilots">
                @error('pilots')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="hiring_status" class="form-label">Hiring Status</label>
            
                <select wire:model.lazy="hiring" class="form-input" autocomplete="hiring">
                    <option value="">Select One</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
                @error('hiring')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4 flex items-center justify-end px-4 py-3 bg-gray-100 text-right sm:px-6">
                @isset($status)
                    <div x-data="{ shown: false, timeout: null }" x-init="() => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); }" x-show.transition.opacity.out.duration.1500ms="shown" class="text-sm text-green-400 mr-6 pt-1">{{ $status }}</div>
                @endisset
                <button type="submit">
                    <svg wire:loading wire:target="submitForm" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span>Submit Form</span>
                </button>
            </div>
        </form>
    </div>
</div>