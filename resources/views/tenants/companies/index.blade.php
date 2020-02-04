@extends('adminlte::page')

@include('tenants.includes.dataTableCss')

@section('title_postfix', 'Empresas')

@section('content_header')

    @include('tenants.includes.breadcrumbs',  ['title' => 'Empresas',
                                               'breadcrumbs' => [
                                               'Empresas', ]
                                              ])
@stop

@section('content')

    @include('tenants.includes.alerts')

    <div class="content">
        <p>
            <a href="{{route('companies.create')}}" class="btn btn-primary">
                <span class="glyphicon glyphicon-plus"></span>
                Adicionar
            </a>
        </p>

        <!--TABELA -->
    @include('tenants.companies.partials.table')
    <!--TABELA -->
    </div>
@stop

@section('js')
    @include('tenants.includes.dataTableJs')

    <script type="text/javascript" src={{ asset('assets/js/companies.js') }}></script>
@stop




