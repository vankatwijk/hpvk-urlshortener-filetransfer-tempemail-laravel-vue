@extends('layouts.app')

@section('content')
    <login-form :errors="{{ $errors }}"></login-form>
@endsection
