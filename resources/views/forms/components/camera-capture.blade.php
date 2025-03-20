<x-dynamic-component
    :component="$getFieldWrapperView()"
    :label="$getLabel()"
    :state-path="$getStatePath()">

    <div wire:ignore>
    @livewire('camera-capture', ['formComponentId' => $getId()])
    </div>
</x-dynamic-component>
