@extends('adminlte::page')

@include('tenants.includes.dataTableCss')

@section('title_postfix', 'Planos')

@section('content_header')
    @include('tenants.includes.breadcrumbs',  ['title' => 'Planos',
                                               'breadcrumbs' => [
                                               'Planos', ]
                                              ])
@stop

@section('content')

    @include('tenants.includes.alerts')

    <div class="content">
        <p>
            <a href="{{route('plans.create')}}" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span>
                Adicionar
            </a>
        </p>

        <!--TABELA -->
            @include('tenants.plans.partials.table')
        <!--TABELA -->
    </div>
@stop


@section('js')
    @include('tenants.includes.dataTableJs')

    <script type="text/javascript" src={{ asset('assets/js/plans/table.js') }}></script>
@stop






