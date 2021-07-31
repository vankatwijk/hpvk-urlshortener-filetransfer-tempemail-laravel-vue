<h1>{{ $user->username }}</h1>

@foreach($user->links as $link)
    <p>{{ $link->original }}</p>
@endforeach