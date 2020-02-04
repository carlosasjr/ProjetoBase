@if( isset($company) )
    {!! Form::model($company, ['route' => ['companies.update', $company->id], 'class' => 'form', 'method' => 'put' ]) !!}
@else
    {!! Form::open(['route' => 'companies.store', 'class' => 'form']) !!}
@endif

<div class="form-group">
    {!! Form::label('name', 'Nome', ['class' => 'control-label']); !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nome']) !!}
</div>


<div class="form-group">
    {!! Form::label('email', 'E-mail', ['class' => 'control-label']); !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'E-mail']) !!}
</div>


<div class="form-group">
    {!! Form::label('cellphone', 'Celular', ['class' => 'control-label']); !!}
    {!! Form::text('cellphone', null, ['class' => 'form-control', 'placeholder' => '(DDD) Celular']) !!}
</div>


<div class="form-group">
    {!! Form::label('cpf', 'CPF', ['class' => 'control-label']); !!}
    {!! Form::text('cpf', null, ['class' => 'form-control', 'placeholder' => 'CPF']) !!}
</div>

<div class="row">
    <div class="col-md-8 form-group">
        {!! Form::label('oab', 'OAB', ['class' => 'control-label']); !!}
        {!! Form::text('oab', null, ['class' => 'form-control', 'placeholder' => 'N° OAB']) !!}
    </div>

    <div class="col-md-4 form-group">
        {!! Form::label('uf_oab', 'UF OAB', ['class' => 'control-label']); !!}
        {!! Form::text('uf_oab', null, ['class' => 'form-control', 'placeholder' => 'UF OAB']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('qtd_processes', 'Quantidade de Processos', ['class' => 'control-label']); !!}
    {!! Form::select('qtd_processes', [
        "100" => 'Tenho até 100 Processos',
        "101-500" => 'Tenho 101 à 500 Processos',
        "501-2000" => 'Tenho 501 à 2.000 Processos',
        "2001-5000" => 'Tenho 2.001 à 5.000 Processos',
        "5001-10000" => 'Tenho 5.001 à 10.000 Processos',
        "+10.000" => 'Tenho +10.000 Processos',
        "consultivo" => 'Atuo no Consultivo',
        "departamento_juridico" => 'Atuo em Departamento Jurídico',
        "estudante" => 'Sou Estudante de Direito',
    ], null, ['class' => 'form-control']) !!}
</div>


<div class="form-group">
    {!! Form::label('subdomain', 'SubDomínio', ['class' => 'control-label']); !!}
    <div class="input-group mb-3">
        {!! Form::text('subdomain', null, ['class' => 'form-control', 'placeholder' => 'SubDomínio']) !!}

        <div class="input-group-append">
            <span class="input-group-text">{{ env('APP_SUBDOMAIN') }}</span>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('db_database', 'DataBase', ['class' => 'control-label']); !!}
    {!! Form::text('db_database', null, ['class' => 'form-control', 'placeholder' => 'DataBase']) !!}
</div>

<div class="form-group">
    {!! Form::label('db_host', 'Host', ['class' => 'control-label']); !!}
    {!! Form::text('db_host', null, ['class' => 'form-control', 'placeholder' => 'Host']) !!}
</div>


<div class="form-group">
    {!! Form::label('db_username', 'User Name', ['class' => 'control-label']); !!}
    {!! Form::text('db_username', null, ['class' => 'form-control', 'placeholder' => 'User Name']) !!}
</div>

<div class="form-group">
    <label for="db_password" class="control-label">Password</label>
    <input name="db_password" class="form-control" type="password"
           value="{{ $company->db_password ?? old('db_password') }}" id="db_password">
</div>

@if (!isset($company))
    <div class="form-group">
        {!! Form::checkbox('create_database', null, true) !!}
        {!! Form::label('create_database', 'Criar bando de dados?'); !!}
    </div>
@endif


{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

<br/>

