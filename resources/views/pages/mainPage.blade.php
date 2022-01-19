@extends('layouts.layout')
@section('title')
    Гороскоп - главная страница
@endsection

@section('content')
    <main-page :authorized_user='{!! json_encode($user) !!}'
               :info_about_zodiac_znak='{!! json_encode($all_info_signs_today) !!}'
               ></main-page>
@endsection
