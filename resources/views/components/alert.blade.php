@if(session()->has('status'))
<div class="alert alert-success">
    {{ session()->get('status') }}
</div>
@endif
{{--
<div class="alert alert-{{ $type }}">
    Message for: {{ $name }}
    {{ $slot }}
</div>
--}}