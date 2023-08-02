@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;" id="salariatiIndex">
        <div class="row p-1 card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <h4 class="mb-0">
                    <a href="/ssm/salariati">
                        <i class="fas fa-users me-1"></i>Salariați
                    </a>
                </h4>
            </div>
            <div class="col-lg-8">
                <form class="needs-validation" novalidate method="GET" action="/ssm/salariati">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        {{-- <div class="col-md-3">
                            <select class="form-select form-select-sm mb-1" id="search_firma" name="search_firma" >
                                    <option value="" selected>Firma</option>
                                @foreach ($lista_firma as $firma)
                                    <option value="{{ $firma->nume_client }}"
                                        {{ isset($firma->nume_client) ? ($firma->nume_client === $search_firma ? 'selected' : '') : '' }}
                                    >
                                    {{ $firma->nume_client }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-3 mb-1">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_firma_nume" name="search_firma_nume" placeholder="Firma"
                                    value="{{ $search_firma_nume }}">
                        </div>
                        <div class="col-md-3 mb-1">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_salariat" name="search_salariat" placeholder="Salariat"
                                    value="{{ $search_salariat }}">
                        </div>
                        <div class="col-md-3 mb-1">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_cnp" name="search_cnp" placeholder="CNP"
                                    value="{{ $search_cnp }}">
                        </div>
                        <div class="col-md-3 mb-1">
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
                        <div class="col-md-3 mb-1 d-flex justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="hidden" name="search_de_rezolvat" value="nu" />
                                <input class="form-check-input" type="checkbox" value="da" name="search_de_rezolvat" id="search_de_rezolvat"
                                    {{ $search_de_rezolvat == 'da' ? 'checked' : '' }}>
                                <label class="form-check-label small" for="search_de_rezolvat">
                                    De rezolvat ({{ $nrSalariatiDeRezolvat }})
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3 mb-1">
                            <input type="text" class="form-control form-control-sm rounded-3" id="searchDataSsmPsi" name="searchDataSsmPsi" placeholder="Data SSM/ PSI"
                                    value="{{ $searchDataSsmPsi }}">
                        </div>
                        <div class="col-md-2 mb-1">
                            <input type="text" class="form-control form-control-sm rounded-3" id="searchDataInc" name="searchDataInc" placeholder="Data înc"
                                    value="{{ $searchDataInc }}">
                        </div>
                        <div class="col-md-1 mb-1">
                            <input type="text" class="form-control form-control-sm rounded-3" id="searchActionar" name="searchActionar" placeholder="I / C"
                                    value="{{ $searchActionar }}">
                        </div>
                        <div class="col-md-3 mb-1">
                            <input type="text" class="form-control form-control-sm rounded-3" id="searchObservatii" name="searchObservatii" placeholder="Observații"
                                    value="{{ $searchObservatii }}">
                        </div>
                        {{-- <div class="col-md-3">
                        </div> --}}
                        <div class="col-md-3 mb-1">
                            <button class="btn btn-sm btn-primary text-white col-md-12 me-3 border border-dark rounded-3" type="submit">
                                <i class="fas fa-search text-white me-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-md-3 mb-1">
                            <a class="btn btn-sm bg-secondary text-white col-md-12 border border-dark rounded-3" href="/ssm/salariati" role="button">
                                <i class="far fa-trash-alt text-white me-1"></i>Resetează
                            </a>
                        </div>
                        {{-- <div class="col-lg-4 d-grid gap-5">
                            <button class="btn btn-sm btn-primary text-white border border-dark rounded-3" type="submit">
                                <i class="fas fa-search text-white me-1"></i>Caută
                            </button>
                        </div>
                        <div class="col-lg-4 d-grid gap-5">
                            <a class="btn btn-sm bg-secondary text-white border border-dark rounded-3" href="/ssm/salariati" role="button">
                                <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                            </a>
                        </div> --}}
                    </div>
                </form>
            </div>
            <div class="col-lg-2 text-end">
                <a class="btn btn-sm mb-1 bg-success text-white border border-dark rounded-3" href="/ssm/salariati/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă
                </a>
                <div id="salariatiIndex">
                    <input class="btn btn-sm btn-primary" type="button" value="Modificări globale" v-on:click="modificari_globale = !modificari_globale">
                </div>
            </div>
            {{-- <div class="col-lg-12">
                @if ($nrSalariatiDeRezolvat > 0)
                    <form class="needs-validation" novalidate method="GET" action="/ssm/salariati">
                        @csrf
                            <div class="col-md-12">
                                <input type="hidden" class="form-control form-control-sm rounded-3" id="search_de_rezolvat" name="search_de_rezolvat"
                                        value='da'>

                                <div class="">
                                    <button class="btn btn-sm btn-danger text-white border border-dark rounded-3" type="submit">
                                        Salariați - de rezolvat ({{ $nrSalariatiDeRezolvat }})
                                    </button>
                                </div>
                            </div>
                    </form>
                @endif
            </div> --}}
        </div>

        <div class="card-body px-0 py-2">

            @include ('errors')


    {{-- <form class="needs-validation" novalidate method="GET" action="/ssm/salariati-modifica-selectati"> --}}
    <form class="needs-validation" novalidate method="POST" action="/ssm/salariati-modifica-selectati">
        @csrf

        <script type="application/javascript">
            modificariGlobale = @json(old('modificariGlobale') ?? false);

            salariati={!! json_encode($salariati->items()) !!}
            salariatiSelectati={!! json_encode(old('salariati_selectati', [])) !!}
        </script>
        <div v-cloak v-if="modificari_globale" class="row justify-content-center">
            <div class="col-lg-8 mb-2 rounded-3" style="background-color:lightcyan">
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-2">

                        {{-- Daca validarea da eroare, se intoarce inapoi cu modificariGlobale=true, ca sa nu fie ascunse optiunile de modificari globale --}}
                        <input
                            type="hidden"
                            name="modificariGlobale"
                            value="true">

                        <small for="nume_client" class="mb-0 ps-3">Nume client</small>
                        <input
                            type="text"
                            class="form-control form-control-sm rounded-3 {{ $errors->has('nume_client') ? 'is-invalid' : '' }}"
                            name="nume_client"
                            value="{{ old('nume_client') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <small for="functia" class="mb-0 ps-3">Funcție</small>
                        <input
                            type="text"
                            class="form-control form-control-sm rounded-3 {{ $errors->has('functia') ? 'is-invalid' : '' }}"
                            name="functia"
                            value="{{ old('functia') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <small for="traseu" class="mb-0 ps-3">Traseu</small>
                        <input
                            type="text"
                            class="form-control form-control-sm rounded-3 {{ $errors->has('traseu') ? 'is-invalid' : '' }}"
                            name="traseu"
                            value="{{ old('traseu') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <small for="observatii" class="mb-0 ps-3">Observații</small>
                        <input
                            type="text"
                            class="form-control form-control-sm rounded-3 {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                            name="observatii"
                            value="{{ old('observatii') }}">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-2 mb-2">
                        {{-- <label for="data_ssm_psi" class="mb-0 ps-1">Data SSM/PSI</label> --}}
                        <small for="data_ssm_psi" class="mb-0 ps-1">Data SSM/PSI</small>
                        <input
                            type="text"
                            class="form-control form-control-sm rounded-3 {{ $errors->has('data_ssm_psi') ? 'is-invalid' : '' }}"
                            name="data_ssm_psi"
                            value="{{ old('data_ssm_psi') }}">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="semnat_ssm" class="mb-0 ps-1">Semnat SSM</small>
                        <select name="semnat_ssm" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('semnat_ssm') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="client" style="color:rgb(0, 140, 255)" {{ old('semnat_ssm') === 'client' ? 'selected' : ''}}>client</option>
                            <option value="Lipsa" style="color:rgb(255, 0, 0)" {{ old('semnat_ssm') === 'Lipsa' ? 'selected' : ''}}>Lipsa</option>
                            <option value="comp.la cl." style="color:rgb(0, 180, 75)" {{ old('semnat_ssm') === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('semnat_ssm') === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                            <option value="noi s." style="" {{ old('semnat_ssm') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="noi" style="" {{ old('semnat_ssm') === 'noi' ? 'selected' : ''}}>noi</option>
                            {{-- <option value='-'>-</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('semnat_ssm') === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                            <option value="noi s." style="" {{ old('semnat_ssm') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="cl.de s" style="color:rgb(0, 96, 175)" {{ old('semnat_ssm') === 'cl.de s' ? 'selected' : ''}}>cl.de s</option> --}}
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="semnat_psi" class="mb-0 ps-1">Semnat PSI</small>
                        <select name="semnat_psi" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('semnat_psi') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="client" style="color:rgb(0, 140, 255)" {{ old('semnat_psi') === 'client' ? 'selected' : ''}}>client</option>
                            <option value="Lipsa" style="color:rgb(255, 0, 0)" {{ old('semnat_psi') === 'Lipsa' ? 'selected' : ''}}>Lipsa</option>
                            <option value="comp.la cl." style="color:rgb(0, 180, 75)" {{ old('semnat_psi') === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('semnat_psi') === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                            <option value="noi s." style="" {{ old('semnat_psi') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="noi" style="" {{ old('semnat_psi') === 'noi' ? 'selected' : ''}}>noi</option>
                            {{-- <option value='-'>-</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('semnat_psi') === 'n.de s' ? 'selected' : ''}}>n.de s</option>
                            <option value="noi s." style="" {{ old('semnat_psi') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="cl.de s" style="color:rgb(0, 96, 175)" {{ old('semnat_psi') === 'cl.de s' ? 'selected' : ''}}>cl.de s</option> --}}
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="semnat_anexa" class="mb-0 ps-1">Semnat Anexa</small>
                        <select name="semnat_anexa" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('semnat_anexa') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="sem" style="" {{ old('semnat_anexa') === 'sem' ? 'selected' : ''}}>sem</option>
                            <option value="de s" style="color:rgb(204, 0, 0)" {{ old('semnat_anexa') === 'de s' ? 'selected' : ''}}>de s</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="semnat_eip" class="mb-0 ps-1">Semnat E.I.P.</small>
                        <select name="semnat_eip" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('semnat_eip') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="sem" style="" {{ old('semnat_eip') === 'sem' ? 'selected' : ''}}>sem</option>
                            <option value="de s" style="color:rgb(204, 0, 0)" {{ old('semnat_eip') === 'de s' ? 'selected' : ''}}>de s</option>
                        </select>
                    </div>

                    <div class="col-lg-12 mb-2 text-center">
                        <button class="btn btn-sm btn-primary text-white me-3 border border-dark rounded-3" type="submit">
                            Modifică toți salariații selectați
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered border-secondary rounded-3" style=" font-size: 5px !important">
                <thead class="text-white rounded" style="background-color:#e66800; font-size: 5px !important">

                    <tr class="" style="padding:2rem; font-size: 5px">
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">#</th>
                        <th rowspan="2" class="text-center" style=" font-size: 12px; padding:1px;">Acțiuni</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Nume client</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Salariat</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">
                            Data<br>SSM/ PSI
                        </th>
                        <th colspan="2" class="text-center" style="font-size: 12px; padding:1px;">Semnat</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">CNP</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Funcția</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;"></th>
                        <th rowspan="2" class="text-center" style=" font-size: 12px; padding:1px;">Data ang.</th>
                        <th rowspan="2" class="text-center" style=" font-size: 12px; padding:1px;">Data înc.</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Traseu</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;">Observații</th>
                        <th colspan="2" class="text-center" style="font-size: 12px; padding:1px;">Semnat</th>
                        <th rowspan="2" class="text-center" style="font-size: 12px; padding:1px;" v-cloak v-if="modificari_globale">
                            <input type="checkbox"
                                class="form-check-input"
                                id=""
                                style="padding:10px"
                                {{-- v-on:change="select({{ $categorie->id }})" --}}
                                v-on:change="select($event)"
                                >

                        </th>
                    </tr>
                    <tr class="">
                        <th class="text-center" style="font-size: 12px; padding:1px;">SSM</th>
                        <th class="text-center" style="font-size: 12px; padding:1px;">PSI</th>
                        <th class="text-center" style="font-size: 12px; padding:1px;">Anexa</th>
                        <th class="text-center" style="font-size: 12px; padding:1px;">E.I.P.</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salariati as $salariat)
                        @if ((stripos($salariat->salariat, 'revisal') !== false) || (stripos($salariat->salariat, 'Situatie') !== false))
                            <tr style="background-color:rgb(169, 212, 255)">
                        @elseif (($salariat->status === "CCC") || (stripos($salariat->data_incetare, 'c.c.c') !== false) || (stripos($salariat->data_incetare, 'CCC') !== false) || (stripos($salariat->data_incetare, 'CM') !== false))
                            <tr style="background-color:rgb(255, 184, 245)">
                        @elseif ((stripos($salariat->data_incetare, 'susp') !== false))
                            <tr style="background-color:rgb(205, 181, 219)">
                        @elseif (($salariat->status === "incetat") || ($salariat->status === "lipsa") ||
                            (stripos($salariat->data_incetare, 'înc') !== false) || (stripos($salariat->data_incetare, 'inc') !== false) || (stripos($salariat->data_incetare, 'lip') !== false))
                            <tr style="opacity: 0.5;">
                        @else
                            <tr style="">
                        @endif
                            <td style="font-size: 12px; padding:1px;">
                                {{ ($salariati ->currentpage()-1) * $salariati ->perpage() + $loop->index + 1 }}
                            </td>
                            <td class="p-0 text-center">
                                <div class="d-flex justify-content-end">
                                    {{-- <a href="{{ $firma->path() }}"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-success">Vizualizează</span>
                                    </a> --}}
                                    <a href="{{ $salariat->path() }}/modifica"
                                            class="me-1"
                                            title="Modifică Salariat"
                                        {{-- class="flex" --}}
                                    >
                                        <span class="badge bg-primary" style="font-size: 10px;">
                                            {{-- Modifică --}}
                                            <i class="fas fa-edit" style="font-size: 10px;"></i>
                                        </span>
                                    </a>
                                    <a href="{{ $salariat->path() }}/duplica"
                                            class="me-1"
                                            title="Duplică Salariat"
                                        {{-- class="flex" --}}
                                    >
                                        <span class="badge bg-success" style="font-size: 10px;">
                                            {{-- Modifică --}}
                                            <i class="fas fa-clone" style="font-size: 10px;"></i>
                                        </span>
                                    </a>
                                    {{-- <div style="flex" class=""> --}}
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeSalariat{{ $salariat->id }}"
                                            title="Șterge Salariat"
                                            >
                                            <span class="badge bg-danger" style="font-size: 10px;">
                                                {{-- Șterge --}}
                                                <i class="fas fa-trash" style="font-size: 10px;"></i>
                                            </span>
                                        </a>
                                    {{-- </div> --}}
                                </div>
                            </td>
                            <td style="font-size: 12px; padding:1px;" title="{{ $salariat->nume_client }}">
                                {{ substr($salariat->nume_client, 0, 20) }}
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                @if (stripos($salariat->salariat, '3 luni') !== false)
                                    {!! str_replace("3 luni", "<span class='text-primary' style='font-size: 12px;'>3 luni</span>", $salariat->salariat) !!}
                                @elseif (stripos($salariat->salariat, '3luni') !== false)
                                    {!! str_replace("3luni", "<span class='text-primary' style='font-size: 12px;'>3luni</span>", $salariat->salariat) !!}
                                @elseif (stripos($salariat->salariat, '6 luni') !== false)
                                    {!! str_replace("6 luni", "<span class='text-primary' style='font-size: 12px;'>6 luni</span>", $salariat->salariat) !!}
                                @elseif (stripos($salariat->salariat, '6luni') !== false)
                                    {!! str_replace("6luni", "<span class='text-primary' style='font-size: 12px;'>6luni</span>", $salariat->salariat) !!}
                                @else
                                    {!! $salariat->salariat !!}
                                @endif
                            </td>
                            <td style="font-size: 12px; padding:0px;">
                                <input type="text"
                                        style="width: 60px; border: none; padding:0px"
                                        id="data_ssm_psi" name="data_ssm_psi"
                                        value="{{ $salariat->data_ssm_psi }}"
                                        v-on:blur = "axiosActualizeazaSalariat({{ $salariat->id }}, 'data_ssm_psi', $event.target.value)"
                                        >
                                <div v-cloak v-if="(axiosActualizatSalariatId == {{ $salariat->id }}) && (axiosActualizatCamp == 'data_ssm_psi')" class="me-2 text-success">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                            </td>
                            <td style="font-size: 12px; padding:0px;">
                                {{-- @if (stripos($salariat->semnat_ssm, 'client') !== false)
                                    <span style="font-size: 12px; color:rgb(0, 140, 255)">
                                @elseif (stripos($salariat->semnat_ssm, 'Lipsa') !== false)
                                    <span style="font-size: 12px; color:rgb(255, 0, 0)">
                                @elseif (stripos($salariat->semnat_ssm, 'comp.la cl.') !== false)
                                    <span style="font-size: 12px; color:rgb(0, 180, 75)">
                                @elseif (stripos($salariat->semnat_ssm, 'n.de s') !== false)
                                    <span style="font-size: 12px; color:blueviolet">
                                @else
                                    <span style="font-size: 12px; color:rgb(0, 0, 0)">
                                @endif
                                        {{ $salariat->semnat_ssm }}
                                    </span> --}}
                                <input type="text"
                                        style="width: 60px; border: none; padding:0px;
                                            {{
                                                (stripos($salariat->semnat_ssm, 'client') !== false) ? 'color:rgb(0, 140, 255)' :
                                                (
                                                    (stripos($salariat->semnat_ssm, 'Lipsa') !== false) ? 'color:rgb(255, 0, 0)' :
                                                    (
                                                        (stripos($salariat->semnat_ssm, 'comp.la cl.') !== false) ? 'color:rgb(0, 180, 75)' :
                                                        (
                                                            (stripos($salariat->semnat_ssm, 'n.de s') !== false) ? 'color:blueviolet' :
                                                            (
                                                                (stripos($salariat->semnat_ssm, 'n.de s') !== false) ? 'color:blueviolet' : 'color:rgb(0, 0, 0)'
                                                            )
                                                        )
                                                    )
                                                )
                                            }}
                                        "
                                        id="semnat_ssm" name="semnat_ssm"
                                        value="{{ $salariat->semnat_ssm }}"
                                        v-on:blur = "axiosActualizeazaSalariat({{ $salariat->id }}, 'semnat_ssm', $event.target.value)"
                                        >
                                <div v-cloak v-if="(axiosActualizatSalariatId == {{ $salariat->id }}) && (axiosActualizatCamp == 'semnat_ssm')" class="me-2 text-success">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                            </td>
                            <td style="font-size: 12px; padding:0px;">
                                {{-- @if (stripos($salariat->semnat_psi, 'client') !== false)
                                    <span style="font-size: 12px; color:rgb(0, 140, 255)">
                                @elseif (stripos($salariat->semnat_psi, 'Lipsa') !== false)
                                    <span style="font-size: 12px; color:rgb(255, 0, 0)">
                                @elseif (stripos($salariat->semnat_psi, 'comp.la cl.') !== false)
                                    <span style="font-size: 12px; color:rgb(0, 180, 75)">
                                @elseif (stripos($salariat->semnat_psi, 'n.de s') !== false)
                                    <span style="font-size: 12px; color:blueviolet">
                                @else
                                    <span style="font-size: 12px; color:rgb(0, 0, 0)">
                                @endif
                                        {{ $salariat->semnat_psi }}
                                    </span> --}}
                                <input type="text"
                                        style="width: 60px; border: none; padding:0px;
                                            {{
                                                (stripos($salariat->semnat_psi, 'client') !== false) ? 'color:rgb(0, 140, 255)' :
                                                (
                                                    (stripos($salariat->semnat_psi, 'Lipsa') !== false) ? 'color:rgb(255, 0, 0)' :
                                                    (
                                                        (stripos($salariat->semnat_psi, 'comp.la cl.') !== false) ? 'color:rgb(0, 180, 75)' :
                                                        (
                                                            (stripos($salariat->semnat_psi, 'n.de s') !== false) ? 'color:blueviolet' :
                                                            (
                                                                (stripos($salariat->semnat_psi, 'n.de s') !== false) ? 'color:blueviolet' : 'color:rgb(0, 0, 0)'
                                                            )
                                                        )
                                                    )
                                                )
                                            }}
                                        "
                                        id="semnat_psi" name="semnat_psi"
                                        value="{{ $salariat->semnat_psi }}"
                                        v-on:blur = "axiosActualizeazaSalariat({{ $salariat->id }}, 'semnat_psi', $event.target.value)"
                                        >
                                <div v-cloak v-if="(axiosActualizatSalariatId == {{ $salariat->id }}) && (axiosActualizatCamp == 'semnat_psi')" class="me-2 text-success">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $salariat->cnp }}
                            </td>
                            <td style="font-size: 12px; padding:1px;" title="{{ $salariat->functia }}">
                                {{-- @php
                                $salariatFunctia = substr($salariat->functia, 0, 20);
                                    if (stripos($salariatFunctia, 'adm.') !== false){
                                        $salariatFunctia = str_replace("adm.", "<span style='font-size: 12px; color:blueviolet'>adm.</span>", $salariatFunctia);
                                    } elseif (stripos($salariatFunctia, 'adm') !== false){
                                        $salariatFunctia = str_replace("adm", "<span style='font-size: 12px; color:blueviolet'>adm</span>", $salariatFunctia);
                                    }
                                    $salariatFunctia = str_replace("pers. des.", "<span style='font-size: 12px; color:blueviolet'>pers. des.</span>", $salariatFunctia);
                                @endphp
                                {!! $salariatFunctia !!} --}}
                                @if ((stripos($salariat->functia, 'adm.') !== false) || (stripos($salariat->functia, 'adm') !== false) || (stripos($salariat->functia, 'pers. des.') !== false))
                                    <span style='font-size: 12px; color:blueviolet'>{{ substr($salariat->functia, 0, 20) }}</span>
                                @else
                                    {{ substr($salariat->functia, 0, 20) }}
                                @endif
                            </td>
                            <td class="text-center" style="font-size: 12px; padding:1px;">
                                {{ $salariat->actionar }}
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $salariat->data_angajare }}
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $salariat->data_incetare }}
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $salariat->traseu }}
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                {{ $salariat->observatii_1 ? ($salariat->observatii_1 . '.') : ''}}
                                {{ $salariat->observatii_2 ? ($salariat->observatii_2 . '.') : ''}}
                                {{-- {{ $salariat->observatii_3 ? ($salariat->observatii_3 . '') : ''}} --}}
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                @if ((strpos($salariat->semnat_anexa, 'de s') !== false))
                                    <span style="font-size: 12px; color:rgb(204, 0, 0)">
                                        {{ $salariat->semnat_anexa }}
                                    </span>
                                @else
                                    {{ $salariat->semnat_anexa }}
                                @endif
                            </td>
                            <td style="font-size: 12px; padding:1px;">
                                @if ((strpos($salariat->semnat_eip, 'de s') !== false))
                                    <span style="font-size: 12px; color:rgb(204, 0, 0)">
                                        {{ $salariat->semnat_eip }}
                                    </span>
                                @else
                                    {{ $salariat->semnat_eip }}
                                @endif
                            </td>
                            <td v-cloak v-if="modificari_globale" style="font-size: 10px; padding:1px; background-color:lightcyan">
                                <div class="form-check text-center">
                                    <input type="checkbox"
                                        class="form-check-input"
                                        name="salariati_selectati[]"
                                        v-model="salariati_selectati"
                                        value="{{ $salariat->id }}"
                                        style="padding:10px"
                                        id="{{ $salariat->id }}"
                                        {{-- @if (old("salariati_selectati"))
                                            {{ in_array($salariat->id, old("salariati_selectati")) ? "checked":"" }}
                                        @endif --}}
                                        >
                                    {{-- <label class="form-check-label" for="{{ $salariat->id }}">
                                        {{ $salariat->salariat }}
                                    </label> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                    @endforelse
                    </tbody>
            </table>
        </div>
    </form>
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
