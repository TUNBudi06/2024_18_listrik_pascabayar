<div>
    <button {{$attributes}}>
        <div wire:loading.remove> {{ $slot }}</div>
        <div wire:loading><span class="spinner-border-sm spinner-border"></span> Loading..</div>
    </button>
</div>
