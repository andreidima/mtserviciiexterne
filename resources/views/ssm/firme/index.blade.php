@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <h4 class="mb-0">
                    <a href="/ssm/firme">
                        <i class="fas fa-building me-1"></i>Firme
                    </a>
                </h4>
            </div>
            <div class="col-lg-7" id="app">
                <form class="needs-validation" novalidate method="GET" action="/ssm/firme">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_firma" name="search_firma" placeholder="Firma"
                                    value="{{ $search_firma }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_cod_fiscal" name="search_cod_fiscal" placeholder="Cod fiscal"
                                    value="{{ $search_cod_fiscal }}">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm mb-1" id="search_ssm_luna" name="search_ssm_luna" >
                                    <option value="" selected>Alege Luna SSM</option>
                                @foreach ($lista_ssm_luna as $ssm_luna)
                                    <option value="{{ $ssm_luna->ssm_luna }}"
                                        {{ isset($ssm_luna->ssm_luna) ? ($ssm_luna->ssm_luna === $search_ssm_luna ? 'selected' : '') : '' }}
                                    >
                                    {{ $ssm_luna->ssm_luna }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm mb-1" id="search_psi_luna" name="search_psi_luna">
                                    <option value="" selected>Alege Luna PSI</option>
                                @foreach ($lista_psi_luna as $psi_luna)
                                    <option value="{{ $psi_luna->psi_luna }}"
                                        {{ isset($psi_luna->psi_luna) ?  ($psi_luna->psi_luna === $search_psi_luna ? 'selected' : '') : '' }}
                                    >
                                    {{ $psi_luna->psi_luna }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/ssm/firme" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                {{-- <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="/ssm/firme/adauga" role="button"> --}}
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="#" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă firmă
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered border-secondary rounded-3" style=" font-size: 5px !important">
                <thead class="text-white rounded" style="background-color:#e66800; font-size: 5px !important">

                    <tr class="" style="padding:2rem; font-size: 5px">
                        <th rowspan="2" style="font-size: 14px; padding:1px;">#</th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;">Firma</th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;">Adresa</th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;">Doc</th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;"></th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;"></th>
                        <th colspan="2" class="text-center" style=" font-size: 14px; padding:1px;">Luna</th>
                        <th colspan="2" class="text-center" style=" font-size: 14px; padding:1px;">Stare fișe</th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;">Traseu</th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;"></th>
                        <th rowspan="2" style="font-size: 14px; padding:1px;">Observații</th>
                        <th rowspan="2" class="text-end" style=" font-size: 14px; padding:1px;">Acțiuni Firmă</th>
                    </tr>
                    <tr class="">
                        <th class="text-center" style="font-size: 14px; padding:1px;">
                            SSM
                        </th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">
                            PSI
                        </th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">
                            SSM
                        </th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">
                            PSI
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($firme as $firma)
                        <tr style="">
                            <td style="font-size: 14px; padding:1px;">
                                {{ ($firme ->currentpage()-1) * $firme ->perpage() + $loop->index + 1 }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $firma->nume ?? '' }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $firma->adresa }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $firma->doc }}
                            </td>
                            <td style="font-size: 14px; padding:1px;" class="text-center">
                                {{ $firma->perioada }}
                            </td>
                            <td style="font-size: 14px; padding:1px;" class="text-center">
                                {{ $firma->actionar }}
                            </td>
                            <td style="font-size: 14px; padding:1px; font-weight:bold" class="text-center">
                                {{ $firma->ssm_luna }}
                            </td>
                            <td style="font-size: 14px; padding:1px; font-weight:bold" class="text-center">
                                {{ $firma->psi_luna }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $firma->ssm_stare_fise }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                 {{ $firma->psi_stare_fise }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                 {{ $firma->traseu }}
                            </td>
                            <td style="font-size: 14px; padding:1px;" class="text-center">
                                 {{ $firma->firma_mt }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{ $firma->observatii_1 ? ($firma->observatii_1 . '.') : ''}}
                                {{ $firma->observatii_2 ? ($firma->observatii_2 . '.') : ''}}
                                {{ $firma->observatii_3 ? ($firma->observatii_3 . '.') : ''}}
                                {{ $firma->observatii_4 ? ($firma->observatii_4 . '') : ''}}
                            </td>
                            <td class="p-0">
                                <div class="d-flex justify-content-end">
                                    {{-- <a href="{{ $firma->path() }}"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-success">Vizualizează</span>
                                    </a> --}}
                                    {{-- <a href="{{ $firma->path() }}/modifica" --}}
                                    <a href="#"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            {{-- data-bs-toggle="modal"
                                            data-bs-target="#stergeFirma{{ $firma->id }}" --}}
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

@endsection
