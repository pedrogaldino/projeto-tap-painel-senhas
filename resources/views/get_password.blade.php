@extends('layout')

@section('content')
    <get-password-component base-url="{{ config('app.url') }}"></get-password-component>
@endsection
