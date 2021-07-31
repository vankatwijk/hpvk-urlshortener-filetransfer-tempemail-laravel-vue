@extends('layouts.app')

@section('content')
    <register-form :errors="{{ $errors }}"></register-form>
@endsection
