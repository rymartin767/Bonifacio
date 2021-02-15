{{ $trigger }}

<x-jet-dialog-modal wire:model="showModal">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        {{ $content }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-danger-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
            {{ __('Nevermind') }}
        </x-jet-danger-button>

        <x-jet-button class="ml-2" wire:click="modalAction" wire:loading.attr="disabled">
            {{ __('Submit') }}
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>