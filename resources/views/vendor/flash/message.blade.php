@if(session()->has('flash_notification'))
    @php($flash = session('flash_notification'))
    <div class="alert alert-{{ $flash['level'] }}">
        {{ $flash['message'] }}
    </div>
@endif
