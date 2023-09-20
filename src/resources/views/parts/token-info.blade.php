
@if($valid_token)
    <ul class="token-info {{ $class??null }}">
        @foreach($valid_token as $key=>$value)
            <li>{{ $key }} : {{$value}}</li>
        @endforeach
    </ul>
@endif