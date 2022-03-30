@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <h4 class="mb-0">
                    <a href="/ssm/salariati">
                        <i class="fas fa-users me-1"></i>Salariați
                    </a>
                </h4>
            </div>
            <div class="col-lg-7" id="app">
                <form class="needs-validation" novalidate method="GET" action="/ssm/salariati">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-md-3">
                            <select class="form-select form-select-sm mb-1" id="search_firma" name="search_firma" >
                                    <option value="" selected>Alege Firma</option>
                                @foreach ($lista_firma as $firma)
                                    <option value="{{ $firma->nume_client }}"
                                        {{ isset($firma->nume_client) ? ($firma->nume_client === $search_firma ? 'selected' : '') : '' }}
                                    >
                                    {{ $firma->nume_client }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_firma_nume" name="search_firma_nume" placeholder="Firma"
                                    value="{{ $search_firma_nume }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_salariat" name="search_salariat" placeholder="Salariat"
                                    value="{{ $search_salariat }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_cnp" name="search_cnp" placeholder="CNP"
                                    value="{{ $search_cnp }}">
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/ssm/salariati" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="/ssm/salariati/adauga" role="button">
                {{-- <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8 mb-2" href="#" role="button"> --}}
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă salariat
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered border-secondary rounded-3" style=" font-size: 5px !important">
                <thead class="text-white rounded" style="background-color:#e66800; font-size: 5px !important">

                    <tr class="" style="padding:2rem; font-size: 5px">
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">#</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">Nume client</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">Salariat</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">
                            Data<br>SSM/ PSI
                        </th>
                        <th colspan="2" class="text-center" style="font-size: 14px; padding:1px;">Semnat</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">CNP</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">Funcția</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;"></th>
                        <th rowspan="2" class="text-center" style=" font-size: 14px; padding:1px;">Data ang.</th>
                        <th rowspan="2" class="text-center" style=" font-size: 14px; padding:1px;">Data înc.</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">Traseu</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">Observații</th>
                        <th colspan="2" class="text-center" style="font-size: 14px; padding:1px;">Semnat</th>
                        <th rowspan="2" class="text-center" style=" font-size: 14px; padding:1px;">Acțiuni</th>
                    </tr>
                    <tr class="">
                        <th class="text-center" style="font-size: 14px; padding:1px;">SSM</th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">PSI</th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">Anexa</th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">E.I.P.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salariati as $salariat)
                        @if ((strpos($salariat->salariat, 'revisal') !== false))
                            <tr style="background-color:rgb(169, 212, 255)">
                        @else
                            <tr style="">
                        @endif
                            <td style="font-size: 14px; padding:1px;">
                                {{ ($salariati ->currentpage()-1) * $salariati ->perpage() + $loop->index + 1 }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->nume_client }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->salariat }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->data_ssm_psi }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                @if ((strpos($salariat->semnat_ssm, 'n.de s') !== false))
                                    <span style="font-size: 14px; color:blueviolet">
                                        {{ $salariat->semnat_ssm }}
                                    </span>
                                @elseif ((strpos($salariat->semnat_ssm, 'cl.de s') !== false))
                                    <span style="font-size: 14px; color:rgb(0, 96, 175)">
                                        {{ $salariat->semnat_ssm }}
                                    </span>
                                @else
                                    {{ $salariat->semnat_ssm }}
                                @endif
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                @if ((strpos($salariat->semnat_psi, 'n.de s') !== false))
                                    <span style="font-size: 14px; color:blueviolet">
                                        {{ $salariat->semnat_psi }}
                                    </span>
                                @elseif ((strpos($salariat->semnat_psi, 'cl.de s') !== false))
                                    <span style="font-size: 14px; color:rgb(0, 96, 175)">
                                        {{ $salariat->semnat_psi }}
                                    </span>
                                @else
                                    {{ $salariat->semnat_psi }}
                                @endif
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->cnp }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->functia }}
                            </td>
                            <td class="text-center" style="font-size: 14px; padding:1px;">
                                {{ $salariat->actionar }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->data_angajare }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->data_incetare }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->traseu }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $salariat->observatii_1 ? ($salariat->observatii_1 . '.') : ''}}
                                {{ $salariat->observatii_2 ? ($salariat->observatii_2 . '.') : ''}}
                                {{ $salariat->observatii_3 ? ($salariat->observatii_3 . '') : ''}}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                @if ((strpos($salariat->semnat_anexa, 'de s') !== false))
                                    <span style="font-size: 14px; color:rgb(204, 0, 0)">
                                        {{ $salariat->semnat_anexa }}
                                    </span>
                                @else
                                    {{ $salariat->semnat_anexa }}
                                @endif
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                @if ((strpos($salariat->semnat_eip, 'de s') !== false))
                                    <span style="font-size: 14px; color:rgb(204, 0, 0)">
                                        {{ $salariat->semnat_eip }}
                                    </span>
                                @else
                                    {{ $salariat->semnat_eip }}
                                @endif
                            </td>
                            <td class="p-0 text-center">
                                {{-- <div class="d-flex justify-content-end"> --}}
                                    {{-- <a href="{{ $firma->path() }}"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-success">Vizualizează</span>
                                    </a> --}}
                                    <a href="{{ $salariat->path() }}/modifica"
                                        {{-- class="flex" --}}
                                    >
                                        <span class="badge bg-primary">Modifică</span>
                                    </a>
                                    {{-- <div style="flex" class=""> --}}
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeSalariat{{ $salariat->id }}"
                                            title="Șterge Salariat"
                                            >
                                            <span class="badge bg-danger">Șterge</span>
                                        </a>
                                    {{-- </div> --}}
                                {{-- </div> --}}
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
                        {{ $salariati->appends(Request::except('page'))->links() }}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere salariat --}}
    @forelse ($salariati as $salariat)
        <div class="modal fade text-dark" id="stergeSalariat{{ $salariat->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Salariat: <b>{{ $salariat->salariat ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Salariatul?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $salariat->path() }}">
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

@endsection
