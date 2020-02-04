@extends('adminlte::page')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('title', 'Cadastrar Novo Plano')

@section('adminlte_css')
    <link rel="stylesheet" href={{ asset('vendor/alertify/css/alertify.core.css') }} />
    <link rel="stylesheet" href={{ asset('vendor/alertify/css/alertify.default.css') }} />
@stop

@section('content_header')
    <div class="container-fluid">
        @include('tenants.includes.breadcrumbs',  ['title' => 'Gestão de Planos',
                               'breadcrumbs' => [
                               'Planos' => route('plans.index'),
                                isset($plan->id) ? 'Editar' : 'Cadastrar', ]
                              ])
    </div><!-- /.container-fluid -->
@stop


@section('content')
    @include('tenants.includes.alerts')

    <div class="box box-success">
        <div class="box-body">
            @include('tenants.plans.partials.form')
        </div>
    </div>
@stop


@section('js')
    <script type="text/javascript" src={{ asset('vendor/alertify/js/alertify.min.js') }}></script>
    <script type="text/javascript" src={{ asset('assets/js/plans/script.js') }}></script>
@stop


