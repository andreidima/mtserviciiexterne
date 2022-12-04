@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            {{-- <div class="col-lg-2">
                <h4 class="mb-0">
                    <a href="/ssm/firme">
                        <i class="fas fa-building me-1"></i>Firme
                    </a>
                </h4>
            </div> --}}
            <div class="col-lg-10" id="app">
                <form class="needs-validation" novalidate method="GET" action="/ssm/firme">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_firma_si_cui" name="search_firma_si_cui" placeholder="Firma, CUI"
                                    value="{{ $search_firma_si_cui }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_adresa_observatii" name="search_adresa_si_observatii" placeholder="Adresa, Observații"
                                    value="{{ $search_adresa_si_observatii }}">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm mb-1" id="search_traseu" name="search_traseu" >
                                    <option value="" selected>Traseu</option>
                                @foreach ($lista_traseu as $traseu)
                                    <option value="{{ $traseu->traseu }}"
                                        {{ isset($traseu->traseu) ? ($traseu->traseu === $search_traseu ? 'selected' : '') : '' }}
                                    >
                                    {{ $traseu->traseu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm mb-1" id="search_actionar" name="search_actionar" >
                                    <option value="" selected>Acționar</option>
                                @foreach ($lista_actionar as $actionar)
                                    <option value="{{ $actionar->actionar }}"
                                        {{ isset($actionar->actionar) ? ($actionar->actionar === $search_actionar ? 'selected' : '') : '' }}
                                    >
                                    {{ $actionar->actionar }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm mb-1" id="search_ssm_luna" name="search_ssm_luna" >
                                    <option value="" selected>Luna SSM</option>
                                @foreach ($lista_ssm_luna as $ssm_luna)
                                    <option value="{{ $ssm_luna->ssm_luna }}"
                                        {{ isset($ssm_luna->ssm_luna) ? ($ssm_luna->ssm_luna === $search_ssm_luna ? 'selected' : '') : '' }}
                                    >
                                    {{ $ssm_luna->ssm_luna }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm mb-1" id="search_psi_luna" name="search_psi_luna">
                                    <option value="" selected>Luna PSI</option>
                                @foreach ($lista_psi_luna as $psi_luna)
                                    <option value="{{ $psi_luna->psi_luna }}"
                                        {{ isset($psi_luna->psi_luna) ?  ($psi_luna->psi_luna === $search_psi_luna ? 'selected' : '') : '' }}
                                    >
                                    {{ $psi_luna->psi_luna }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_administrator_si_pers_desemnata" name="search_administrator_si_pers_desemnata" placeholder="Adm., Pers. desem."
                                    value="{{ $search_administrator_si_pers_desemnata}}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_domeniu_de_activitate" name="search_domeniu_de_activitate" placeholder="Domeniu activitate"
                                    value="{{ $search_domeniu_de_activitate}}">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm mb-1" id="search_perioada" name="search_perioada">
                                    <option value="" selected>Perioada</option>
                                @foreach ($lista_perioada as $perioada)
                                    <option value="{{ $perioada->perioada }}"
                                        {{ isset($perioada->perioada) ?  ($perioada->perioada === $search_perioada ? 'selected' : '') : '' }}
                                    >
                                    {{ $perioada->perioada }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select form-select-sm mb-1" id="search_contract_firma" name="search_contract_firma">
                                    <option value="" selected>Contract</option>
                                @foreach ($lista_contract_firma as $contract_firma)
                                    <option value="{{ $contract_firma->contract_firma }}"
                                        {{ isset($contract_firma->contract_firma) ?  ($contract_firma->contract_firma === $search_contract_firma ? 'selected' : '') : '' }}
                                    >
                                    {{ $contract_firma->contract_firma }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_contract_numar" name="search_contract_numar" placeholder="Contract număr"
                                    value="{{ $search_contract_numar}}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_observatii" name="search_observatii" placeholder="Observații"
                                    value="{{ $search_observatii}}">
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
            <div class="col-lg-2 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="/ssm/firme/adauga" role="button">
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
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">#</th>
                        <th rowspan="2" class="text-center" style=" font-size: 12px; padding:1px;">Acțiuni</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">
                            Firma
                            <br>
                            CUI
                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">
                            Adresa
                            <br>
                            Traseu
                        </th>
                        {{-- <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Doc</th> --}}
                        {{-- <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;"></th> --}}
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;"></th>
                        <th colspan="2" class="text-center" style=" font-size: 12px; padding:1px;">Luna</th>
                        <th colspan="2" class="text-center" style=" font-size: 12px; padding:1px;">Stare fișe</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">
                            Administrator
                            <br>
                            Pers. desem.
                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">
                            Dom. activ.
                            <br>
                            PRAM
                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Contract</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Observații</th>
                    </tr>
                    <tr class="">
                        <th class="text-center" style="font-size: 12px; padding:1px;">
                            SSM
                        </th>
                        <th class="text-center" style="font-size: 12px; padding:1px;">
                            PSI
                        </th>
                        <th class="text-center" style="font-size: 12px; padding:1px;">
                            SSM
                        </th>
                        <th class="text-center" style="font-size: 12px; padding:1px;">
                            PSI
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $lunaCurenta = \Carbon\Carbon::now()->month // Folosita la inrosirea textului din Luna SSM si PSI
                    @endphp
                    @forelse ($firme as $firma)
                        @if ((strpos($firma->nume, 'incetat') !== false))
                            <tr style="opacity: 0.5;">
                        @else
                            <tr style="">
                        @endif
                        {{-- <tr style=""> --}}
                            <td style="font-size: 12px; padding:1px;">
                                {{ ($firme ->currentpage()-1) * $firme ->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="p-0 text-center">
                                <div class="d-flex justify-content-end">
                                    {{-- <a href="{{ $firma->path() }}"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-success">Vizualizează</span>
                                    </a> --}}
                                    <a href="{{ $firma->path() }}/modifica"
                                        class="me-1"
                                    >
                                        <span class="badge bg-primary" style="font-size: 10px;">
                                            {{-- Modifică --}}
                                            <i class="fas fa-edit" style="font-size: 10px;"></i>
                                        </span>
                                    </a>
                                    {{-- <div style="flex" class=""> --}}
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeFirma{{ $firma->id }}"
                                            title="Șterge Firma"
                                            >
                                            <span class="badge bg-danger" style="font-size: 10px;">
                                                {{-- Șterge --}}
                                                <i class="fas fa-trash" style="font-size: 10px;"></i>
                                            </span>
                                        </a>
                                    {{-- </div> --}}
                                </div>
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $firma->nume ?? '' }}
                                <br>
                                {{ $firma->cui }}
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $firma->adresa }}
                                <br>
                                {{ $firma->traseu }}
                            </td>
                            {{-- <td style="font-size: 12px; padding:1px;">
                                {{ $firma->doc }}
                            </td> --}}
                            {{-- <td style="font-size: 12px; padding:1px;" class="text-center">
                                {{ $firma->perioada }}
                            </td> --}}
                            <td style="font-size: 12px; padding:1px;" class="text-center">
                                {{ $firma->actionar }}
                            </td>
                            <td style="font-size: 12px; padding:1px; font-weight:bold" class="text-center">
                                @php
                                    $ultimulNumarDinPerioada = null;
                                    if(preg_match_all('/\d+/', $firma->ssm_luna, $numere)){
                                        $ultimulNumarDinPerioada = (int)end($numere[0]);
                                    }
                                    // echo ($ultimulNumarDinPerioada + 3)%12;
                                @endphp
                                @isset ($ultimulNumarDinPerioada)
                                    @if ($firma->perioada === 'LUNAR')
                                        @if ($ultimulNumarDinPerioada !== $lunaCurenta)
                                            <span class="text-danger" style="font-size: 12px;">{{ $firma->ssm_luna }}</span>
                                        @else
                                            {{ $firma->ssm_luna }}
                                        @endif
                                    @elseif (($firma->perioada === 'TRI') || ($firma->perioada === 'TRI.'))
                                        @if (
                                                (
                                                    ($ultimulNumarDinPerioada < 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                    &&
                                                    (
                                                        ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                        ||
                                                        ( ($ultimulNumarDinPerioada + 3) <= $lunaCurenta ) // au trecut minim 3 luni
                                                    )
                                                )
                                                ||
                                                (
                                                    ($ultimulNumarDinPerioada >= 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                    &&
                                                    ( ($ultimulNumarDinPerioada + 3)%12 <= $lunaCurenta ) // au trecut minim 3 luni
                                                )
                                            )
                                            <span class="text-danger" style="font-size: 12px;">{{ $firma->ssm_luna }}</span>
                                        @else
                                            {{ $firma->ssm_luna }}
                                        @endif
                                    @elseif (($firma->perioada === 'SEM') || ($firma->perioada === 'SEM.'))
                                        @if (
                                                (
                                                    ($ultimulNumarDinPerioada < 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                    &&
                                                    (
                                                        ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                        ||
                                                        ( ($ultimulNumarDinPerioada + 6) <= $lunaCurenta ) // au trecut minim 6 luni
                                                    )
                                                )
                                                ||
                                                (
                                                    ($ultimulNumarDinPerioada >= 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                    &&
                                                    ( ($ultimulNumarDinPerioada + 6)%12 <= $lunaCurenta ) // au trecut minim 6 luni
                                                )
                                            )
                                            <span class="text-danger" style="font-size: 12px;">{{ $firma->ssm_luna }}</span>
                                        @else
                                            {{ $firma->ssm_luna }}
                                        @endif
                                    @else
                                        {{ $firma->ssm_luna }}
                                    @endif
                                @endisset
                            </td>
                            <td style="font-size: 12px; padding:1px; font-weight:bold" class="text-center">
                                @php
                                    $ultimulNumarDinPerioada = null;
                                    if(preg_match_all('/\d+/', $firma->psi_luna, $numere)){
                                        $ultimulNumarDinPerioada = (int)end($numere[0]);
                                    }
                                @endphp
                                @isset ($ultimulNumarDinPerioada)
                                    @if ($firma->perioada === 'LUNAR')
                                        @if ($ultimulNumarDinPerioada !== $lunaCurenta)
                                            <span class="text-danger" style="font-size: 12px;">{{ $firma->psi_luna }}</span>
                                        @else
                                            {{ $firma->psi_luna }}
                                        @endif
                                    @elseif (($firma->perioada === 'TRI') || ($firma->perioada === 'TRI.'))
                                        @if (
                                                (
                                                    ($ultimulNumarDinPerioada < 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                    &&
                                                    (
                                                        ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                        ||
                                                        ( ($ultimulNumarDinPerioada + 3) <= $lunaCurenta ) // au trecut minim 3 luni
                                                    )
                                                )
                                                ||
                                                (
                                                    ($ultimulNumarDinPerioada >= 10) // fiind perioada TRI, se calculeaza la 3 luni
                                                    &&
                                                    ( ($ultimulNumarDinPerioada + 3)%12 <= $lunaCurenta ) // au trecut minim 3 luni
                                                )
                                            )
                                            <span class="text-danger" style="font-size: 12px;">{{ $firma->psi_luna }}</span>
                                        @else
                                            {{ $firma->psi_luna }}
                                        @endif
                                    @elseif (($firma->perioada === 'SEM') || ($firma->perioada === 'SEM.'))
                                        @if (
                                                (
                                                    ($ultimulNumarDinPerioada < 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                    &&
                                                    (
                                                        ( $ultimulNumarDinPerioada > $lunaCurenta ) // este cel putin de anul trecut
                                                        ||
                                                        ( ($ultimulNumarDinPerioada + 6) <= $lunaCurenta ) // au trecut minim 6 luni
                                                    )
                                                )
                                                ||
                                                (
                                                    ($ultimulNumarDinPerioada >= 7) // fiind perioada SEM, se calculeaza la 6 luni
                                                    &&
                                                    ( ($ultimulNumarDinPerioada + 6)%12 <= $lunaCurenta ) // au trecut minim 6 luni
                                                )
                                            )
                                            <span class="text-danger" style="font-size: 12px;">{{ $firma->psi_luna }}</span>
                                        @else
                                            {{ $firma->psi_luna }}
                                        @endif
                                    @else
                                        {{ $firma->psi_luna }}
                                    @endif
                                @else
                                    {{ $firma->psi_luna }}
                                @endisset
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                @if ((strpos($firma->ssm_stare_fise, 'noi.p;de s.p') !== false) ||
                                        (strpos($firma->ssm_stare_fise, 'noi.p;de s') !== false) ||
                                        (strpos($firma->ssm_stare_fise, 'noi;de s') !== false))
                                    <span style="font-size: 12px; color:blueviolet">
                                @elseif ((strpos($firma->ssm_stare_fise, 'comp.la cl.') !== false))
                                    <span style="font-size: 12px; color:rgb(0, 145, 77)">
                                @elseif ((strpos($firma->ssm_stare_fise, 'cl;de s') !== false) ||
                                        (strpos($firma->ssm_stare_fise, 'cl.p;de s') !== false) ||
                                        (strpos($firma->ssm_stare_fise, 'Fișe-C') !== false) ||
                                        (strpos($firma->ssm_stare_fise, 'cl;control') !== false))
                                    <span style="font-size: 12px; color:rgb(0, 96, 175)">
                                @elseif ((strpos($firma->ssm_stare_fise, 'de adus') !== false))
                                    <span style="font-size: 12px; color:rgb(204, 0, 0)">
                                @elseif ((strpos($firma->ssm_stare_fise, 'La anulate') !== false))
                                    <span style="font-size: 12px; color:rgb(94, 94, 94)">
                                @else
                                    <span style="font-size: 12px;">
                                @endif
                                    {{ $firma->ssm_stare_fise }}
                                    </span>
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                @if ((strpos($firma->psi_stare_fise, 'noi.p;de s.p') !== false) ||
                                        (strpos($firma->psi_stare_fise, 'noi.p;de s') !== false) ||
                                        (strpos($firma->psi_stare_fise, 'noi;de s') !== false))
                                    <span style="font-size: 12px; color:blueviolet">
                                @elseif ((strpos($firma->psi_stare_fise, 'comp.la cl.') !== false))
                                    <span style="font-size: 12px; color:rgb(0, 145, 77)">
                                @elseif ((strpos($firma->psi_stare_fise, 'cl;de s') !== false) ||
                                        (strpos($firma->psi_stare_fise, 'cl.p;de s') !== false) ||
                                        (strpos($firma->psi_stare_fise, 'Fișe-C') !== false) ||
                                        (strpos($firma->psi_stare_fise, 'cl;control') !== false))
                                    <span style="font-size: 12px; color:rgb(0, 96, 175)">
                                @elseif ((strpos($firma->psi_stare_fise, 'de adus') !== false))
                                    <span style="font-size: 12px; color:rgb(204, 0, 0)">
                                @elseif ((strpos($firma->psi_stare_fise, 'La anulate') !== false))
                                    <span style="font-size: 12px; color:rgb(94, 94, 94)">
                                @else
                                    <span style="font-size: 12px;">
                                @endif
                                    {{ $firma->psi_stare_fise }}
                                    </span>
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                 {{ $firma->administrator }}
                                 <br>
                                 {{ $firma->persoana_desemnata }}
                            </td>
                            <td class="text-center" style="font-size: 12px; padding:1px;">
                                 {{ $firma->domeniu_de_activitate }}
                                 <br>
                                 {{-- {{ $firma->pram_zi }}
                                 .
                                 {{ $firma->pram_luna }}
                                 .
                                 {{ $firma->pram_an }} --}}
                                 {{ $firma->pram }}
                            </td>
                            <td style="font-size: 12px; padding:1px;" class="text-center">
                                {{ $firma->contract_firma }}
                                <br>
                                @if ($firma->contract_semnat === 0)
                                    <span style="font-size: 12px; color:red">
                                @else
                                    <span style="font-size: 12px;">
                                @endif
                                        {{ $firma->contract_numar }}
                                    </span>
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $firma->observatii_1 ? ($firma->observatii_1 . '.') : ''}}
                                {{ $firma->observatii_2 ? ($firma->observatii_2 . '.') : ''}}
                                {{ $firma->observatii_3 ? ($firma->observatii_3 . '.') : ''}}
                                {{-- {{ $firma->observatii_4 ? ($firma->observatii_4 . '') : ''}} --}}
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
