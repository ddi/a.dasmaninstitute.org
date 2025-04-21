<a href="{{ $href }}" class="btn btn-sm btn-{{ $type }} shadow-sm radius-2px px-25 py-1" target="_blank">
    {{ $text }}
    @isset($icon)
        <i class="fa fa-{{ $icon }} text-110 ml-2"></i>
    @endisset
</a>
