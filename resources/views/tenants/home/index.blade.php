@extends('adminlte::page')

@section('title_postfix', 'Dashboard')

@section('content_header')
    <h1>Home</h1>
@stop

@section('content')
    <p>{{ session('company')['name'] ?? '' }} Você está logado!</p>
@stop
