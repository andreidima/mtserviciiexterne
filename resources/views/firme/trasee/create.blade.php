@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-3 my-0" style="color:white">
                        <i class="fas fa-route me-1"></i>
                        @switch($serviciu)
                            @case('ssm')
                                Trasee SSM
                                @break
                            @case('stingatoare')
                                Trasee Stingătoare
                                @break
                            @default
                        @endswitch
                    </h6>
                </div>

                @include ('errors')

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >
                    <form  class="needs-validation" novalidate method="POST" action="/{{ $serviciu }}/firme/trasee">

                                @include ('firme.trasee.form', [
                                    'traseu' => new App\Models\FirmaTraseu,
                                    'buttonText' => 'Adaugă Traseu'
                                ])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
