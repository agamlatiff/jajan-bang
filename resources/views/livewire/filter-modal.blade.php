<div x-data="{ open: false }" @open-modal.window="if ($event.detail === 'filter-modal') open = true">
    <x-modal :title="'Filter'" :showClose="true">
        @section("content")
            <div class="space-y-6 pb-4 pt-2">
                @php
                    $foodCategories = $categories->filter(function ($category) {
                        return str_contains(strtolower($category->name), "food");
                    });
                @endphp

                @if ($foodCategories->isNotEmpty())
                    <div>
                        <p class="mb-3 font-medium text-gray-900 dark:text-white">Makanan Daerah</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($foodCategories as $category)
                                <label
                                    x-data="{
                                        checked:
                                            {{ in_array($category->id, $selectedCategories) ? "true" : "false" }},
                                    }"
                                    wire:key="category-food-{{ $category->id }}"
                                    class="cursor-pointer whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium transition-colors"
                                    :class="checked ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'"
                                >
                                    <input
                                        type="checkbox"
                                        class="hidden"
                                        wire:model="selectedCategories"
                                        value="{{ $category->id }}"
                                        x-on:change="checked = !checked"
                                    />
                                    <span>
                                        {{ $category->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                @php
                    $nonFoodCategories = $categories->filter(function ($category) {
                        return ! str_contains(strtolower($category->name), "food");
                    });
                @endphp

                @if ($nonFoodCategories->isNotEmpty())
                    <div>
                        <p class="mb-3 font-medium text-gray-900 dark:text-white">Type F&B</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($nonFoodCategories as $category)
                                <label
                                    x-data="{
                                        checked:
                                            {{ in_array($category->id, $selectedCategories) ? "true" : "false" }},
                                    }"
                                    wire:key="category-other-{{ $category->id }}"
                                    class="cursor-pointer whitespace-nowrap rounded-full px-4 py-2 text-sm font-medium transition-colors"
                                    :class="checked ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'"
                                >
                                    <input
                                        type="checkbox"
                                        class="hidden"
                                        wire:model="selectedCategories"
                                        value="{{ $category->id }}"
                                        x-on:change="checked = !checked"
                                    />
                                    <span>
                                        {{ $category->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-4 flex items-center justify-between gap-4">
                <button
                    type="button"
                    x-on:click="$wire.resetFilter()"
                    class="flex-1 cursor-pointer rounded-full bg-primary-50 px-5 py-3 font-semibold text-primary-600 outline-none hover:bg-primary-100 transition-colors"
                >
                    Reset
                </button>
                <button
                    x-on:click="
                        $wire.applyFilter()
                        open = false
                    "
                    type="button"
                    class="flex-2 cursor-pointer rounded-full bg-primary-600 px-5 py-3 font-semibold text-white hover:bg-primary-700 transition-colors shadow-lg shadow-primary-600/20"
                >
                    <div class="flex items-center justify-center gap-2">
                        <span>Terapkan</span>
                        <span class="material-icons text-sm">arrow_forward</span>
                    </div>
                </button>
            </div>
        @endsection
    </x-modal>
</div>
