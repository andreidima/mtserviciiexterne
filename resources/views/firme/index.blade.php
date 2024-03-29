@extends ('layouts.app')

@section('content')
<div class="card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center mx-1" style="border-radius: 40px 40px 0px 0px;">
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
                        <input type="text" class="form-control col-md-6 mx-1 rounded-3" id="search_firma" name="search_firma" placeholder="Firma sau Cod fiscal"
                                value="{{ $search_firma }}">
                        {{-- <input type="text" class="form-control col-md-3 mx-1 rounded-3" id="search_cod_fiscal" name="search_cod_fiscal" placeholder="Cod fiscal"
                                value="{{ $search_cod_fiscal }}"> --}}
                    </div>
                    @switch($serviciu)
                        @case('ssm')
                        @case('medicina-muncii')
                            <div class="row mb-1 input-group custom-search-form justify-content-center">
                                <input type="text" class="form-control col-md-3 mx-1 rounded-3" id="search_salariat_nume" name="search_salariat_nume" placeholder="Salariat"
                                        value="{{ $search_salariat_nume }}">
                                <input type="text" class="form-control col-md-3 mx-1 rounded-3" id="search_salariat_cnp" name="search_salariat_cnp" placeholder="CNP"
                                        value="{{ $search_salariat_cnp }}">
                            </div>
                            @break
                        @case('stingatoare')
                            @break
                        @default
                    @endswitch
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

        @switch($serviciu)
            @case('ssm')
            <div class="table-responsive rounded">
                <table class="table table-hover table-borderless rounded-3">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Firma / Telefon</th>
                            <th>Telefon</th>
                            <th>Traseu</th>
                            <th class="text-end">Acțiuni Firmă</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($firme as $firma)
                            <tr style="background-color:rgb(202, 202, 202); color:rgb(0, 0, 0)">
                                <td align="">
                                    {{ ($firme ->currentpage()-1) * $firme ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>
                                        {{ $firma->nume ?? '' }}
                                    </b>
                                </td>
                                <td>
                                    {{ $firma->telefon ?? '' }}
                                </td>
                                <td>
                                    {{ $firma->traseu->nume ?? '' }}
                                </td>
                                <td class="">
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
                            <tr>
                                <td colspan="5" class="text-center">
                                    @switch($serviciu)
                                        @case('ssm')
                                            <div class="table-responsive rounded text-center mx-auto" style="max-width:100%">
                                                <table class="table table-sm table-hover rounded border border-1">
                                                    {{-- <thead class="text-black rounded" style="background-color:#cecece;"> --}}
                                                        <tr class="" style="padding:2rem">
                                                            <th style="width: 1%; border:#000000 1px solid">#</th>
                                                            <th style="width: 20%; border:#000000 1px solid">Salariat</th>
                                                            <th style="width: 5%; border:#000000 1px solid">SSM/PSI</th>
                                                            <th style="width: 7%; border:#000000 1px solid">Anexa/EIP</th>
                                                            <th style="width: 12%; border:#000000 1px solid">CNP</th>
                                                            <th style="width: 15%; border:#000000 1px solid">Funcție</th>
                                                            <th class="text-end" style="width: 8%; border:#000000 1px solid">Acțiuni</th>
                                                        </tr>
                                                    {{-- </thead> --}}
                                                    @php
                                                            $salariati = $firma->salariati;

                                                            $salariati = $salariati->when($search_salariat_nume, function ($salariati) use ($search_salariat_nume) {
                                                                return $salariati->filter(function($item) use ($search_salariat_nume) {
                                                                    return stripos($item['nume'],$search_salariat_nume) !== false;
                                                                });
                                                            });

                                                            $salariati = $salariati->when($search_salariat_cnp, function ($salariati) use ($search_salariat_cnp) {
                                                                return $salariati->filter(function($item) use ($search_salariat_cnp) {
                                                                    return stripos($item['cnp'],$search_salariat_cnp) !== false;
                                                                });
                                                            });
                                                    @endphp
                                                    <tbody>
                                                    @forelse ($salariati as $salariat)
                                                        {{-- <tr style="background-color:wheat"> --}}
                                                        <tr>
                                                            <td class="text-start" style="width: 1%; border:#000000 1px solid">
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td class="text-start" style="width: 20%; border:#000000 1px solid">
                                                                {{ $salariat->nume }}
                                                                @if (isset($salariat->ssm_instructaj_la_nr_luni) && ($salariat->ssm_instructaj_la_nr_luni < 12))
                                                                    <span class="text-danger">
                                                                        {{ $salariat->ssm_instructaj_la_nr_luni }} LUNI
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center" style="width: 5%; border:#000000 1px solid">
                                                                {{ $salariat->ssm_data_instructaj ? \Carbon\Carbon::parse($salariat->ssm_data_instructaj)->isoFormat('MM') : '' }}
                                                                {{ $salariat->psi_data_instructaj ? ('/ ' . \Carbon\Carbon::parse($salariat->ssm_data_instructaj)->isoFormat('MM')) : '' }}
                                                            </td>
                                                            <td class="text-center " style="width: 7%; border:#000000 1px solid">
                                                                @switch($salariat->anexa_ssm)
                                                                    @case(1)
                                                                        <span class="text-danger">de s</span>
                                                                        @break
                                                                    @case(2)
                                                                        sem
                                                                        @break
                                                                    @default
                                                                        -
                                                                @endswitch
                                                                @switch($salariat->lista_eip)
                                                                    @case(1)
                                                                        / <span class="text-danger">de s</span>
                                                                        @break
                                                                    @case(2)
                                                                        / sem
                                                                        @break
                                                                    @default
                                                                        / -
                                                                @endswitch
                                                            </td>
                                                            <td class="text-start" style="width: 12%;  border:#000000 1px solid">
                                                                {{ $salariat->cnp }}
                                                            </td>
                                                            <td class="text-start" style="width: 15%;  border:#000000 1px solid">
                                                                {{ $salariat->functie }}
                                                            </td>
                                                            <td class="" style="width: 8%;  border:#000000 1px solid">
                                                                <div class="d-flex justify-content-end">
                                                                    {{-- <i class="fas fa-eye" data-bs-toggle="tooltip" data-bs-placement="top" title="CNP: {{ $salariat->cnp }}"></i> --}}
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
                                                            <td colspan="7">
                                                                <a href="/{{ $serviciu}}/{{ $firma->path() }}/salariati/adauga" class="flex me-1">
                                                                    <span class="badge bg-success">Adaugă salariat nou</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            @break
                                        @case('medicina-muncii')
                                            <div class="table-responsive rounded">
                                                <table class="table table-sm table-hover rounded border border-1">
                                                    @php
                                                            $salariati = $firma->salariati;

                                                            $salariati = $salariati->when($search_salariat_nume, function ($salariati) use ($search_salariat_nume) {
                                                                return $salariati->filter(function($item) use ($search_salariat_nume) {
                                                                    return stripos($item['nume'],$search_salariat_nume) !== false;
                                                                });
                                                            });

                                                            $salariati = $salariati->when($search_salariat_cnp, function ($salariati) use ($search_salariat_cnp) {
                                                                return $salariati->filter(function($item) use ($search_salariat_cnp) {
                                                                    return stripos($item['cnp'],$search_salariat_cnp) !== false;
                                                                });
                                                            });

                                                    @endphp
                                                    @forelse ($salariati->where('activ', 1)->sortBy('medicina_muncii_nr_inregistrare') as $salariat)
                                                        <tr style="background-color:wheat">
                                                            {{-- <td class="text-start w-25">
                                                                {{ $salariat->medicina_muncii_nr_inregistrare }}
                                                            </td> --}}
                                                            <td class="text-start" style="width: 45%">
                                                                {{ $salariat->medicina_muncii_nr_inregistrare }} | {{ $salariat->nume }}
                                                            </td>
                                                            {{-- <td class="text-center w-25">
                                                                {{ $salariat->medicina_muncii_examinare ?
                                                                    \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                            </td> --}}
                                                            <td class="text-center" style="width: 37%">
                                                                {{ $salariat->medicina_muncii_examinare ?
                                                                    \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                                |
                                                                {{ $salariat->medicina_muncii_expirare ?
                                                                    \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                            </td>
                                                            <td class="" style="width: 18%">
                                                                <div class="d-flex justify-content-end">
                                                                    <a href="/{{ $serviciu }}/firme/{{ $firma->id }}/salariati/{{ $salariat->id }}/modifica" class="flex me-1">
                                                                        <span class="badge bg-primary">Modifică</span>
                                                                    </a>
                                                                    <div style="" class="">
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
                                                    @forelse ($salariati->where('activ', 0)->sortBy('medicina_muncii_nr_inregistrare') as $salariat)
                                                        @if ($loop->iteration === 1)
                                                            <tr style="background-color:rgb(211, 191, 153)">
                                                                <td colspan="4">
                                                                    INACTIVI
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr style="background-color:rgb(211, 191, 153)">
                                                            <td class="text-start" style="width: 45%">
                                                                {{ $salariat->medicina_muncii_nr_inregistrare }} | {{ $salariat->nume }}
                                                            </td>
                                                            {{-- <td class="text-center w-25">
                                                                {{ $salariat->medicina_muncii_examinare ?
                                                                    \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                            </td> --}}
                                                            <td class="text-center" style="width: 37%">
                                                                {{ $salariat->medicina_muncii_examinare ?
                                                                    \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                                |
                                                                {{ $salariat->medicina_muncii_expirare ?
                                                                    \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                            </td>
                                                            <td class="" style="width: 18%">
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
                                                </table>
                                            </div>
                                            @break
                                        @case('stingatoare')
                                            <div class="px-2" style="background-color:wheat">
                                                @if (!$firma->stingator)
                                                    <a href="/{{ $serviciu}}/{{ $firma->path() }}/stingatoare/adauga" class="flex me-1">
                                                        <span class="badge bg-success">Adaugă</span>
                                                    </a>
                                                @else
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            Sting
                                                            <span class="badge bg-success">
                                                                {{
                                                                    $firma->stingator->p1 + $firma->stingator->p2 + $firma->stingator->p3 + $firma->stingator->p4 + $firma->stingator->p5 + $firma->stingator->p6 + $firma->stingator->p9 + $firma->stingator->p12 + $firma->stingator->p50 +
                                                                    $firma->stingator->p100 + $firma->stingator->sm3 + $firma->stingator->sm6 + $firma->stingator->sm9 + $firma->stingator->sm50 + $firma->stingator->sm100 + $firma->stingator->g2 + $firma->stingator->g5;
                                                                }}
                                                            </span>
                                                            /
                                                            Hidr
                                                            <span class="badge bg-success">
                                                                {{ $firma->stingator->hidranti + 0 }}
                                                            </span>
                                                        </div>
                                                        <div class="d-flex">
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
                                                    </div>
                                                @endif
                                            </div>
                                            @break
                                        @default
                                    @endswitch
                                    <br>
                                </td>
                                {{-- <td>
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
                                </td> --}}
                            </tr>
                            {{-- <tr></tr> --}}
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>
            @break
        @case('medicina-muncii')
            <div class="table-responsive rounded" id="medicinaMunciiIndexAxiosUpdate">
                <table class="table table-striped table-hover rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Firma</th>
                            <th>Telefon</th>
                            <th class="text-center">Nr. inregistrare | Nume | Data examinare | Următoarea examinare</th>
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
                                <td class="text-center">
                                    <div class="table-responsive rounded">
                                        <table class="table table-sm table-hover rounded border border-1">
                                            @php
                                                    $salariati = $firma->salariati;

                                                    $salariati = $salariati->when($search_salariat_nume, function ($salariati) use ($search_salariat_nume) {
                                                        return $salariati->filter(function($item) use ($search_salariat_nume) {
                                                            return stripos($item['nume'],$search_salariat_nume) !== false;
                                                        });
                                                    });

                                                    $salariati = $salariati->when($search_salariat_cnp, function ($salariati) use ($search_salariat_cnp) {
                                                        return $salariati->filter(function($item) use ($search_salariat_cnp) {
                                                            return stripos($item['cnp'],$search_salariat_cnp) !== false;
                                                        });
                                                    });

                                            @endphp
                                            @forelse ($salariati->where('activ', 1)->sortBy('medicina_muncii_nr_inregistrare') as $salariat)
                                                <tr style="background-color:wheat">
                                                    {{-- <td class="text-start w-25">
                                                        {{ $salariat->medicina_muncii_nr_inregistrare }}
                                                    </td> --}}
                                                    <td class="text-start" style="width: 45%">
                                                        {{-- {{ $salariat->medicina_muncii_nr_inregistrare }} | {{ $salariat->nume }} --}}
                                                        <div class="d-flex">
                                                            <div>
                                                                <input type="text"
                                                                    style="width: 70px; border: none; padding:0px;"
                                                                    id="medicina_muncii_nr_inregistrare" name="medicina_muncii_nr_inregistrare"
                                                                    value="{{ $salariat->medicina_muncii_nr_inregistrare }}"
                                                                    v-on:blur = "axiosActualizeazaSalariat({{ $salariat->id }}, 'medicina_muncii_nr_inregistrare', $event.target.value)"
                                                                    >
                                                                <div v-cloak v-if="(axiosActualizatSalariatId == {{ $salariat->id }}) && (axiosActualizatCamp == 'medicina_muncii_nr_inregistrare')" class="me-2 text-success">
                                                                    <i class="fas fa-thumbs-up"></i>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                | {{ $salariat->nume }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    {{-- <td class="text-center w-25">
                                                        {{ $salariat->medicina_muncii_examinare ?
                                                            \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                    </td> --}}
                                                    <td class="text-center" style="width: 37%">
                                                        {{-- {{ $salariat->medicina_muncii_examinare ?
                                                            \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                        |
                                                        {{ $salariat->medicina_muncii_expirare ?
                                                            \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }} --}}
                                                        <div class="d-flex">
                                                            <div style="margin-right: 10px">
                                                                <input type="text"
                                                                    style="width: 110px; border: none; padding:0px; text-align:center"
                                                                    id="medicina_muncii_examinare" name="medicina_muncii_examinare"
                                                                    value="{{ $salariat->medicina_muncii_examinare ? \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}"
                                                                    v-on:blur = "axiosActualizeazaSalariat({{ $salariat->id }}, 'medicina_muncii_examinare', $event.target.value)"
                                                                    >
                                                                <div v-cloak v-if="(axiosActualizatSalariatId == {{ $salariat->id }}) && (axiosActualizatCamp == 'medicina_muncii_examinare')">
                                                                    <div v-if="axiosMesaj" class="me-2 bg-danger text-white">
                                                                        @{{ axiosMesaj }}
                                                                    </div>
                                                                    <div v-else class="me-2 text-success">
                                                                        <i class="fas fa-thumbs-up"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <input type="text"
                                                                    style="width: 110px; border: none; padding:0px; text-align:center"
                                                                    id="medicina_muncii_expirare" name="medicina_muncii_expirare"
                                                                    value="{{ $salariat->medicina_muncii_expirare ? \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}"
                                                                    v-on:blur = "axiosActualizeazaSalariat({{ $salariat->id }}, 'medicina_muncii_expirare', $event.target.value)"
                                                                    >
                                                                <div v-cloak v-if="(axiosActualizatSalariatId == {{ $salariat->id }}) && (axiosActualizatCamp == 'medicina_muncii_expirare')">
                                                                    <div v-if="axiosMesaj" class="me-2 bg-danger text-white">
                                                                        @{{ axiosMesaj }}
                                                                    </div>
                                                                    <div v-else class="me-2 text-success">
                                                                        <i class="fas fa-thumbs-up"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="" style="width: 18%">
                                                        <div class="d-flex justify-content-end">
                                                            <a href="/{{ $serviciu }}/firme/{{ $firma->id }}/salariati/{{ $salariat->id }}/modifica" class="flex me-1">
                                                                <span class="badge bg-primary">Modifică</span>
                                                            </a>
                                                            <div style="" class="">
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
                                            @forelse ($salariati->where('activ', 0)->sortBy('medicina_muncii_nr_inregistrare') as $salariat)
                                                @if ($loop->iteration === 1)
                                                    <tr style="background-color:rgb(211, 191, 153)">
                                                        <td colspan="4">
                                                            INACTIVI
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr style="background-color:rgb(211, 191, 153)">
                                                    <td class="text-start" style="width: 45%">
                                                        {{ $salariat->medicina_muncii_nr_inregistrare }} | {{ $salariat->nume }}
                                                    </td>
                                                    {{-- <td class="text-center w-25">
                                                        {{ $salariat->medicina_muncii_examinare ?
                                                            \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                    </td> --}}
                                                    <td class="text-center" style="width: 37%">
                                                        {{ $salariat->medicina_muncii_examinare ?
                                                            \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                        |
                                                        {{ $salariat->medicina_muncii_expirare ?
                                                            \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                    </td>
                                                    <td class="" style="width: 18%">
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
                                        </table>
                                    </div>
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
            @break
        @case('stingatoare')
            <div class="table-responsive rounded">
                <table class="table table-striped table-hover table-borderless rounded-3">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Firma / Telefon</th>
                            <th class="text-center">Stingătoare/ Hidranți</th>
                            <th class="text-end">Acțiuni Firmă</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($firme as $firma)
                            <tr style="">
                                <td align="">
                                    {{ ($firme ->currentpage()-1) * $firme ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>
                                        {{ $firma->nume ?? '' }}
                                        {{ $firma->telefon ? ('/ ' . $firma->telefon) : '' }}
                                    </b>
                                </td>
                                <td class="text-center">
                                    {{-- <div class="table-responsive rounded text-center mx-auto" style="max-width:90%">
                                        <table class="table table-sm table-hover rounded border border-1"> --}}
                                            <div class="px-2" style="background-color:wheat">
                                                @if (!$firma->stingator)
                                                    <a href="/{{ $serviciu}}/{{ $firma->path() }}/stingatoare/adauga" class="flex me-1">
                                                        <span class="badge bg-success">Adaugă</span>
                                                    </a>
                                                @else
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            Sting
                                                            <span class="badge bg-success">
                                                                {{
                                                                    $firma->stingator->p1 + $firma->stingator->p2 + $firma->stingator->p3 + $firma->stingator->p4 + $firma->stingator->p5 + $firma->stingator->p6 + $firma->stingator->p9 + $firma->stingator->p12 + $firma->stingator->p50 +
                                                                    $firma->stingator->p100 + $firma->stingator->sm3 + $firma->stingator->sm6 + $firma->stingator->sm9 + $firma->stingator->sm50 + $firma->stingator->sm100 + $firma->stingator->g2 + $firma->stingator->g5;
                                                                }}
                                                            </span>
                                                            /
                                                            Hidr
                                                            <span class="badge bg-success">
                                                                {{ $firma->stingator->hidranti + 0 }}
                                                            </span>
                                                        </div>
                                                        <div class="d-flex">
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
                                                    </div>
                                                @endif
                                            </div>
                                </td>
                                <td class="">
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
            @break
            @default
        @endswitch

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
