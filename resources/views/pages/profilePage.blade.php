@extends('layouts.layout')
@section('title')
    Гороскоп - страница профиля
@endsection

@section('content')
    <profile-page :authorized_user='{!! json_encode($user) !!}'
                  :info_user='{!! json_encode($info_user) !!}'></profile-page>
@endsection
