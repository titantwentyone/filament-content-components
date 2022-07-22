@props([
    'item'
])
<div>

    @if($item)
    @parseContentComponent($item)
    @endif
</div>