{{-- Loading Skeleton Component --}}
@props(['type' => 'card', 'count' => 1])

@for ($i = 0; $i < $count; $i++)
    @if ($type === 'card')
        <div class="animate-pulse">
            <div class="aspect-square w-full rounded-xl bg-gray-200"></div>
            <div class="py-2 space-y-2">
                <div class="h-4 w-3/4 rounded bg-gray-200"></div>
                <div class="h-4 w-1/2 rounded bg-gray-200"></div>
            </div>
        </div>
    @elseif ($type === 'list-item')
        <div class="animate-pulse flex items-center gap-4 p-4">
            <div class="h-16 w-16 rounded-xl bg-gray-200"></div>
            <div class="flex-1 space-y-2">
                <div class="h-4 w-3/4 rounded bg-gray-200"></div>
                <div class="h-3 w-1/2 rounded bg-gray-200"></div>
            </div>
            <div class="h-6 w-16 rounded bg-gray-200"></div>
        </div>
    @elseif ($type === 'text')
        <div class="animate-pulse space-y-2">
            <div class="h-4 w-full rounded bg-gray-200"></div>
            <div class="h-4 w-5/6 rounded bg-gray-200"></div>
            <div class="h-4 w-4/6 rounded bg-gray-200"></div>
        </div>
    @elseif ($type === 'detail')
        <div class="animate-pulse space-y-4">
            <div class="h-60 w-full rounded-2xl bg-gray-200"></div>
            <div class="space-y-2">
                <div class="h-6 w-3/4 rounded bg-gray-200"></div>
                <div class="h-4 w-1/2 rounded bg-gray-200"></div>
            </div>
            <div class="space-y-2">
                <div class="h-3 w-full rounded bg-gray-200"></div>
                <div class="h-3 w-5/6 rounded bg-gray-200"></div>
                <div class="h-3 w-4/6 rounded bg-gray-200"></div>
            </div>
        </div>
    @endif
@endfor
