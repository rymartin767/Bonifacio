<div class="max-w-7xl mx-auto mt-12">
    <div class="grid grid-cols-10">
        <div class="col-span-10 sm:col-span-2 bg-gray-200">
            <div class="flex flex-col">
                <div x-data="{ open:false }">
                    <button @click="open = !open" type="button" class="w-full inline-flex items-center px-4 py-2 text-sm font-medium text-white border-b border-gray-50 bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        <!-- Heroicon name: check -->
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Airlines
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 border-b border-gray-50 hover:bg-indigo-500"
                        wire:click="$set('selected', 'index-airlines')"
                    >
                        Airline Index
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 border-b border-gray-50 hover:bg-indigo-500"
                        wire:click="$set('selected', 'store-airlines')"
                    >
                        Add Airline
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 hover:bg-indigo-500"
                        wire:click="$set('selected', 'seed-airlines')"
                    >
                        Seed Airlines
                    </button>
                </div>
                <div x-data="{ open:false }">
                    <button @click="open = !open" type="button" class="w-full inline-flex items-center px-4 py-2 text-sm font-medium text-white border-b border-gray-50 bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        <!-- Heroicon name: check -->
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Seniority Lists
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 hover:bg-indigo-500 border-b border-gray-300"
                        wire:click="$set('selected', 'store-seniority')"
                    >
                        Add Seniority List
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 hover:bg-indigo-500"
                        wire:click="$set('selected', 'view-seniority')"
                    >
                        View Seniority List
                    </button>
                </div>
                <div x-data="{ open:false }">
                    <button @click="open = !open" type="button" class="w-full inline-flex items-center px-4 py-2 text-sm font-medium text-white border-b border-gray-50 bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        <!-- Heroicon name: check -->
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Vacancy Awards
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 hover:bg-indigo-500 border-b border-gray-300"
                        wire:click="$set('selected', 'store-vacancy')"
                    >
                    Store Vacancy Award
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 hover:bg-indigo-500"
                        wire:click="$set('selected', 'vacancy-details')"
                    >
                    Award Details
                    </button>
                </div>
                <div x-data="{ open:false }">
                    <button @click="open = !open" type="button" class="w-full inline-flex items-center px-4 py-2 text-sm font-medium text-white border-b border-gray-50 bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        <!-- Heroicon name: check -->
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Medical Examiners
                    </button>
                    <button 
                        x-show.transition="open" 
                        class="w-full px-4 py-2 text-right text-sm font-medium text-white focus:outline-none bg-indigo-300 hover:bg-indigo-500 border-b border-gray-300"
                        wire:click="$set('selected', 'index-ames')"
                    >
                    AME Index
                    </button>
                </div>
            </div>
        </div>
        <div class="col-span-10 sm:col-span-6 px-8">
            @if($selected === 'index-airlines')
                @livewire('index-airlines')
            @endif
            @if($selected === 'airlines')
                @livewire('store-airlines')
            @endif

            @if($selected === 'seed-airlines')
                @livewire('seed-airlines')
            @endif
            
            @if($selected === 'store-seniority')
                @livewire('store-seniority')
            @endif

            @if($selected === 'view-seniority')
                @livewire('view-seniority')
            @endif

            @if($selected === 'store-vacancy')
                @livewire('store-vacancy')
            @endif

            @if($selected === 'vacancy-details')
                @livewire('vacancy-details')
            @endif

            @if($selected === 'index-ames')
                @livewire('index-ames')
            @endif
        </div>
        <div class="col-span-10 sm:col-span-2">
            <div class="flex flex-col">
                <div class="bg-gray-200 min-h-screen">
                    SIDEBAR
                </div>
            </div>
        </div>
    </div>
</div>