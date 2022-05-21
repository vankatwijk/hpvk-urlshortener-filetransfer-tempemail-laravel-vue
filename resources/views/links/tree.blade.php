@extends('../layouts.tree')

@section('content')
    <links-tree-list-dashboard
    :user="{{$user}}"
    :links="{{$links}}"
    ></links-tree-list-dashboard>
@endsection
