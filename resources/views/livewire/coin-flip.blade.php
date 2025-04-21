<div>
    {{ $coin }}
    <form wire:submit="flip">
        <button type="submit">Flip</button>
    </form>
    <ul>
        @foreach ($flips as $flip)
            <li>{{ $flip }}</li>
        @endforeach
    </ul>
</div>
