@props(['items' => []])
<nav class="flex items-center text-sm text-gray-500 py-2 px-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/home" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                <i class='bx bx-home-smile text-lg mr-1'></i> Home
            </a>
        </li>
        @foreach($items as $item)
            <li>
                <div class="flex items-center">
                    <i class='bx bx-chevron-right mx-1'></i>
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}" class="text-indigo-600 hover:text-indigo-800 font-medium">{{ $item['title'] }}</a>
                    @else
                        <span class="text-gray-700 font-semibold">{{ $item['title'] }}</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav> 