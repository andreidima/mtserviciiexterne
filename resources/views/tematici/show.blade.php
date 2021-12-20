@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-2 my-0" style="color:white">
                        <i class="fas fa-file-pdf me-1"></i>
                        Tematici / {{ $tematica->nume }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-striped table-hover"
                        >
                            <tr>
                                <td class="pe-4">
                                    Nume
                                </td>
                                <td>
                                    {{ $tematica->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Descriere
                                </td>
                                <td>
                                    {{ $tematica->descriere }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Fișiere
                                </td>
                                <td>
                                    <div>
                                        @foreach ($tematica->fisiere as $fisier)
                                            {{ $fisier->nume }}
                                            @if (!$loop->last)
                                                <br>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Observații
                                </td>
                                <td>
                                    {{ $tematica->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary text-white rounded-3" href="/tematici">Pagină Tematici</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
