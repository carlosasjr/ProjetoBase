<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Softpro - Advogados</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/pricing/">


    <!-- BootStrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

</head>

<body>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">{{ session('company')['name'] }} </h5>
</div>

@include('tenants.includes.alerts')

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">ESCOLHA SEU PLANO</h1>
    <p class="lead">Nossos planos são flexíveis para se adequar a sua necessidade.</p>
</div>

<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Grátis</h4>
            </div>
            <div class="card-body">
                <h1 class="card-title pricing-card-title">R$ 0,00 <small class="text-muted"> 7 / dias</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                    <li>Acesso ilimitado por 7 dias</li>
                </ul>
                <button class="btn btn-lg btn-block btn-outline-primary disabled">Assinar</button>
            </div>
        </div>


        @foreach( $plans as $plan)
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">{{ $plan->description }}</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">R$ {{ $plan->price }} <small
                            class="text-muted">/ {{ $plan->periodic ?? 'Mês' }}</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        @foreach($plan->plan_details as $details)
                            <li>{{$details->description}}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('paypal.agreement', [session('company')['uuid'], $plan->key_paypal]) }}" class="btn btn-lg btn-block btn-primary">Assinar</a>
                </div>
            </div>
        @endforeach

    </div>

</div>


<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- BootStrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous">
</script>

<script>
    Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
    });
</script>
</body>
</html>
