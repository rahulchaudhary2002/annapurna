<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    @php
        $statePath = $getStatePath();
        $state = $getState();
    @endphp

    <div
        x-data="{
            value: @js($state),
            statePath: @js($statePath),
            init() {
                window.addEventListener('image-selected', (e) => {
                    if (e.detail.statePath === this.statePath) {
                        this.value = e.detail.path;
                        $wire.set(this.statePath, e.detail.path);
                    }
                });
            },
            clear() {
                this.value = null;
                $wire.set(this.statePath, null);
            }
        }"
    >
        {{-- Current image preview --}}
        <template x-if="value">
            <div class="relative mb-3 inline-block">
                <img
                    :src="'/storage/' + value"
                    class="h-32 w-auto max-w-xs rounded-lg border border-gray-200 object-cover shadow-sm dark:border-white/10"
                    alt="Selected image"
                />
                <button
                    type="button"
                    @click="clear()"
                    class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-danger-500 text-white shadow hover:bg-danger-600 focus:outline-none"
                >
                    <x-heroicon-s-x-mark class="h-3 w-3" />
                </button>
            </div>
        </template>

        @livewire('media-library', ['statePath' => $statePath], key('mp-' . $statePath))
    </div>
</x-dynamic-component>
