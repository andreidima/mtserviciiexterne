@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/{{ $serviciu }}/firme">
                        <i class="fas fa-building me-1"></i>
                        @switch($serviciu)
                            @case('ssm')
                                SSM
                                @break
                            @case('medicina-muncii')
                                Medicina muncii
                                @break
                            @case('stingatoare')
                                Stingătoare și hidranți
                                @break
                            @default
                        @endswitch
                    </a>
                </h4>
            </div>
            <div class="col-lg-6" id="app">
                <form class="needs-validation" novalidate method="GET" action="/{{ $serviciu }}/firme">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 me-3 rounded-3" id="search_nume" name="search_nume" placeholder="Firma" autofocus
                                value="{{ $search_nume }}">
                        <input type="text" class="form-control form-control-sm col-md-4 rounded-3" id="search_cod_fiscal" name="search_cod_fiscal" placeholder="Cod fiscal" autofocus
                                value="{{ $search_cod_fiscal }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/{{ $serviciu }}/firme" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="/{{ $serviciu }}/firme/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă firmă
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Firma</th>
                            <th>Telefon</th>
                            {{-- <th>Angajat desemnat</th> --}}
                            <th>Localitate</th>
                            <th class="text-center">
                                @switch($serviciu)
                                    @case('ssm')
                                        Salariați
                                        @break
                                    @case('medicina-muncii')
                                        Salariați - următoarea examinare
                                        @break
                                    @case('stingatoare')
                                        Stingătoare
                                        @break
                                    @default
                                @endswitch
                            </th>
                            <th class="text-end">Acțiuni Firmă</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($firme as $firma)
                            <tr>
                                <td align="">
                                    {{ ($firme ->currentpage()-1) * $firme ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $firma->nume ?? '' }}</b>
                                </td>
                                <td>
                                    <b>{{ $firma->telefon ?? '' }}</b>
                                </td>
                                {{-- <td>
                                    <b>{{ $firma->angajat_desemnat ?? '' }}</b>
                                </td> --}}
                                <td>
                                    <b>{{ $firma->localitate ?? '' }}</b>
                                </td>
                                <td class="text-center">
                                    @switch($serviciu)
                                        @case('ssm')
                                            @if (!$firma->salariati)
                                                Adauga
                                            @else
                                                Modifică
                                            @endif
                                            @break
                                        @case('medicina-muncii')
                                            <div class="table-responsive rounded">
                                                <table class="table table-sm table-hover rounded border border-1">
                                                    @forelse ($firma->salariati as $salariat)
                                                        <tr style="background-color:wheat">
                                                            <td class="text-start w-50">
                                                                {{ $salariat->nume }}
                                                            </td>
                                                            <td class="text-center w-25">
                                                                {{ $salariat->medicina_muncii_expirare ?
                                                                    \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                            </td>
                                                            <td class="w-25">
                                                                <div class="d-flex justify-content-end">
                                                                    <a href="/{{ $serviciu }}/firme/{{ $firma->id }}/salariati/{{ $salariat->id }}/modifica" class="flex me-1">
                                                                        <span class="badge bg-primary">Modifică</span>
                                                                    </a>
                                                                    <div style="flex" class="">
                                                                        <a
                                                                            href="#"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#stergeSalariat{{ $salariat->id }}"
                                                                            title="Șterge Salariat"
                                                                            >
                                                                            <span class="badge bg-danger">Șterge</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                        <tr>
                                                            <td colspan="3">
                                                                <a href="/{{ $serviciu}}/{{ $firma->path() }}/salariati/adauga" class="flex me-1">
                                                                    <span class="badge bg-success">Adaugă salariat nou</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                </table>
                                            </div>
                                            @break
                                        @case('stingatoare')
                                            @if (!$firma->stingator)
                                                <a href="/{{ $serviciu}}/{{ $firma->path() }}/stingatoare/adauga" class="flex me-1">
                                                    <span class="badge bg-success">Adaugă</span>
                                                </a>
                                            @else
                                                <div class="d-flex justify-content-center">
                                                    <a href="/{{ $serviciu}}/firme/{{ $firma->id }}/stingatoare/{{ $firma->stingator->id }}/modifica" class="flex me-1">
                                                        <span class="badge bg-primary">Modifică</span>
                                                    </a>
                                                    <div style="flex" class="">
                                                        <a
                                                            href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#stergeStingator{{ $firma->stingator->id }}"
                                                            title="Șterge Stingator"
                                                            >
                                                            <span class="badge bg-danger">Șterge</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                            @break
                                        @default
                                    @endswitch
                                </td>
                                <td>
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ $firma->path() }}"
                                            class="flex me-1"
                                        >
                                            <span class="badge bg-success">Vizualizează</span>
                                        </a>
                                        <a href="/{{ $serviciu}}/{{ $firma->path() }}/modifica"
                                            class="flex me-1"
                                        >
                                            <span class="badge bg-primary">Modifică</span>
                                        </a>
                                        <div style="flex" class="">
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#stergeFirma{{ $firma->id }}"
                                                title="Șterge Firma"
                                                >
                                                <span class="badge bg-danger">Șterge</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                <nav>
                    <ul class="pagination justify-content-center">
                        {{$firme->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere firma --}}
    @foreach ($firme as $firma)
        <div class="modal fade text-dark" id="stergeFirma{{ $firma->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Firma: <b>{{ $firma->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Firma?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $firma->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Firma
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach


    @switch($serviciu)
        @case('ssm')
            SSM
            @break
        @case('medicina-muncii')
            {{-- Modalele pentru stergere salariati --}}
            @foreach ($firme as $firma)
                @forelse ($firma->salariati as $salariat)
                    <div class="modal fade text-dark" id="stergeSalariat{{ $salariat->id ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Salariat: <b>{{ $salariat->nume ?? '' }}</b></h5>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="text-align:left;">
                                Ești sigur ca vrei să ștergi salariatul?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                                <form method="POST" action="/{{ $serviciu }}/firme/{{ $firma->id }}/salariati/{{ $salariat->id ?? '' }}">
                                    @method('DELETE')
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-danger text-white"
                                        >
                                        Șterge Salariat
                                    </button>
                                </form>

                            </div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            @endforeach
            @break
        @case('stingatoare')
            {{-- Modalele pentru stergere stingator --}}
            @foreach ($firme as $firma)
                @if ($firma->stingator)
                    <div class="modal fade text-dark" id="stergeStingator{{ $firma->stingator->id ?? '' }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h5 class="modal-title text-white" id="exampleModalLabel">Firma: <b>{{ $firma->nume ?? '' }}</b></h5>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="text-align:left;">
                                Ești sigur ca vrei să ștergi stingătoarele firmei?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                                <form method="POST" action="/{{ $serviciu }}/firme/{{ $firma->id }}/stingatoare/{{ $firma->stingator->id ?? '' }}">
                                    @method('DELETE')
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-danger text-white"
                                        >
                                        Șterge Stingătoare
                                    </button>
                                </form>

                            </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            @break
        @default
    @endswitch

@endsection
