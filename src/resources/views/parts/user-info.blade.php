
@if($valid_user)
    <ul class="user-info {{ $class??null }}">
        @foreach($valid_user as $key=>$value)
            <li>{{ $key }} : {{$value}}</li>
        @endforeach
    </ul>
@endif