@extends('layouts.layout')
@section('title')
    Гороскоп - информация о новом пользователе
@endsection

@section('content')
    <info-about-new-user-page :authorized_user='{!! json_encode($user) !!}'></info-about-new-user-page>
@endsection
