@if( isset($plan) )
    {!! Form::model($plan, ['route' => ['plans.update', $plan->id], 'class' => 'form', 'method' => 'put' ]) !!}
@else
    {!! Form::open(['route' => 'plans.store', 'class' => 'form']) !!}
@endif

<div class="form-group">
    {!! Form::label('description', 'Descrição', ['class' => 'control-label']); !!}
    {!! Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Descrição']) !!}
</div>


<div class="form-group">
    {!! Form::label('price', 'Preço', ['class' => 'control-label']); !!}
    {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Preço']) !!}
</div>


<div class="row">
    <div class="col-md-4 form-group">
        {!! Form::label('frequency', 'Frequência', ['class' => 'control-label']); !!}
        {!! Form::select('frequency', [
            'day' => 'Por Dia',
            'week' => 'Por Semana',
            'month' => 'Por Mês',
            'year' => 'Por Ano'
        ], null, ['class' => 'form-control']) !!}
    </div>


    <div class="col-md-4 form-group">
        {!! Form::label('frequency_interval', 'Intervalo', ['class' => 'control-label']); !!}
        {!! Form::text('frequency_interval', null, ['class' => 'form-control', 'placeholder' => 'Intervalo']) !!}
    </div>

    <div class="col-md-4 form-group">
        {!! Form::label('cycles', 'Ciclos', ['class' => 'control-label']); !!}
        {!! Form::text('cycles', null, ['class' => 'form-control', 'placeholder' => 'Ciclos']) !!}
    </div>
</div>

@if(isset($plan))
    <div class="row col-md-12">
        {!! Form::label('key_paypal', 'PayPal Key', ['class' => 'control-label']); !!}

        <div class="input-group">
            {!! Form::text('key_paypal', null, ['class' => 'form-control', 'placeholder' => 'PayPal Key', 'id' => 'key_paypal',
            'aria-label' =>"Key PayPal", 'aria-describedby' => "basic-addon2"]) !!}

            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btnKeyPayPal" data-id="{{ $plan->id }}">Gerar Key-PayPal</button>
            </div>
            @include('tenants.includes.load')
        </div>
    </div>

    <input type="hidden" name="state_paypal" id="state_paypal" value="{{$plan->state_paypal}}">
@endif

<br>


<div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Adicionar detalhes</h3>
    </div>
    <div class="card-body">
        <div class="row form-group">
            <div class="d-flex d-inline-block col-md-6">
                <input id="detail" type="text" class="form-control" placeholder="Detalhe">
                <button type="button" id="add_details" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="row">
            @include('tenants.includes.load')

            <table class="table table-striped" id="details_table">
                <thead>
                <tr>
                    <th>Detalhe</th>
                    <th>Ação</th>
                </tr>
                </thead>

                <tbody>
                @if(isset($plan))
                    @forelse($plan->plan_details as $details)
                        <tr data-plan="{{$plan->id}}" data-id="{{ $details->id }}">
                            <td>
                                <input type="hidden" name="details[{{ $details->id }}][id]" value="{{ $details->id }}">
                                <input class="form-control" type="text" name="details[{{ $details->id }}][description]"
                                       value="{{ $details->description }}">
                            </td>
                            <td><a class="btn btn-danger" href="javascript:;" onclick="removeDetail(this)">Excluir</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>Nenhum detalhe adicionado</td>
                        </tr>
                    @endforelse
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>


{!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

<br/>



