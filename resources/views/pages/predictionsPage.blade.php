@extends('layouts.layout')
@section('title')
    Гороскоп - база предсказаний
@endsection

@section('content')
    <predictions-page :authorized_user='{!! json_encode($user) !!}'
                      :predictions ='{!! json_encode($predictions) !!}'
                      :numbers_pages='{!! json_encode($count_all_pages) !!}'
                      :current_page='{!! json_encode($number_page) !!}'
                      ></predictions-page>

@endsection
