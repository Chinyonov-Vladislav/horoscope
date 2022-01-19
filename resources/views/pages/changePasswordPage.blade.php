@extends('layouts.layout')
@section('title')
    Гороскоп - смена пароля
@endsection

@section('content')
    <change-password-page :authorized_user='{!! json_encode($user) !!}'></change-password-page>
@endsection
