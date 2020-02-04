@if (!empty($breadcrumbs))
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('tenants') }}">Home</a></li>

                    @foreach ($breadcrumbs as $label => $link)
                        <li class="breadcrumb-item">
                            @if (is_int($label) && ! is_int($link))
                                <a class="breadcrumbs-link">
                                    <span>{{ $link }}</span>
                                </a>
                            @else
                                <a href="{{ $link }}" class="breadcrumbs-link">
                                    <span class="breadcrumbs-link-text">{{ $label }}</span>
                                </a>
                            @endif
                        </li>
                    @endforeach

                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endif


