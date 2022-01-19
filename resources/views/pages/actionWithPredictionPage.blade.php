@extends('layouts.layout')
@section('title')
    Гороскоп - предсказание
@endsection

@section('content')
    <action-prediction :authorized_user='{!! json_encode($user) !!}'
                       :type_action='{!! json_encode($type_action)  !!}'
                       :prediction = '{!! json_encode($prediction) !!}'></action-prediction>
@endsection
