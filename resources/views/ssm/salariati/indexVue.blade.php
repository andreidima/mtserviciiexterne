@extends ('layouts.app')

        <script type="application/javascript">
            modificariGlobale = @json(old('modificariGlobale') ?? false);

            salariati={!! json_encode($salariati->items()) !!}
            salariatiSelectati={!! json_encode(old('salariati_selectati', [])) !!}
        </script>

@section('content')
<div class="card" style="border-radius: 40px 40px 40px 40px;" id="salariatiIndex">
    <form class="needs-validation mb-0" novalidate method="POST" action="/ssm/salariati-modifica-selectati">
        @csrf

        <div v-cloak v-if="modificari_globale" class="row justify-content-center">
            <div class="col-lg-8 mb-2 rounded-3" style="background-color:lightcyan">
                <div class="row justify-content-center">
                    <div class="col-md-3 mb-2">

                        {{-- Daca validarea da eroare, se intoarce inapoi cu modificariGlobale=true, ca sa nu fie ascunse optiunile de modificari globale --}}
                        <input
                            type="hidden"
                            name="modificariGlobale"
                            value="true">

                        {{-- Se trimit intr-un string toti salariatii care sunt selectati in tabel --}}
                        <input type="hidden"
                            name="salariati_selectati"
                            v-model="salariati_selectati">

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
                        <small for="modificariGlobaleObservatii" class="mb-0 ps-3">Observații</small>
                        <input
                            type="text"
                            class="form-control form-control-sm rounded-3 {{ $errors->has('modificariGlobaleObservatii') ? 'is-invalid' : '' }}"
                            name="modificariGlobaleObservatii"
                            value="{{ old('modificariGlobaleObservatii') }}">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-2 mb-2">
                        {{-- <label for="modificariGlobaleData_ssm_psi" class="mb-0 ps-1">Data SSM/PSI</label> --}}
                        <small for="modificariGlobaleData_ssm_psi" class="mb-0 ps-1">Data SSM/PSI</small>
                        <input
                            type="text"
                            class="form-control form-control-sm rounded-3 {{ $errors->has('modificariGlobaleData_ssm_psi') ? 'is-invalid' : '' }}"
                            name="modificariGlobaleData_ssm_psi"
                            value="{{ old('modificariGlobaleData_ssm_psi') }}">
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="modificariGlobaleSemnat_ssm" class="mb-0 ps-1">Semnat SSM</small>
                        <select name="modificariGlobaleSemnat_ssm" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('modificariGlobaleSemnat_ssm') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="client" style="color:rgb(0, 140, 255)" {{ old('modificariGlobaleSemnat_ssm') === 'client' ? 'selected' : ''}}>client</option>
                            <option value="Lipsa" style="color:rgb(255, 0, 0)" {{ old('modificariGlobaleSemnat_ssm') === 'Lipsa' ? 'selected' : ''}}>Lipsa</option>
                            <option value="comp.la cl." style="color:rgb(0, 180, 75)" {{ old('modificariGlobaleSemnat_ssm') === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('modificariGlobaleSemnat_ssm') === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                            <option value="noi s." style="" {{ old('modificariGlobaleSemnat_ssm') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="noi" style="" {{ old('modificariGlobaleSemnat_ssm') === 'noi' ? 'selected' : ''}}>noi</option>
                            {{-- <option value='-'>-</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('semnat_ssm') === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                            <option value="noi s." style="" {{ old('semnat_ssm') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="cl.de s" style="color:rgb(0, 96, 175)" {{ old('semnat_ssm') === 'cl.de s' ? 'selected' : ''}}>cl.de s</option> --}}
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="modificariGlobaleSemnat_psi" class="mb-0 ps-1">Semnat PSI</small>
                        <select name="modificariGlobaleSemnat_psi" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('modificariGlobaleSemnat_psi') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="client" style="color:rgb(0, 140, 255)" {{ old('modificariGlobaleSemnat_psi') === 'client' ? 'selected' : ''}}>client</option>
                            <option value="Lipsa" style="color:rgb(255, 0, 0)" {{ old('modificariGlobaleSemnat_psi') === 'Lipsa' ? 'selected' : ''}}>Lipsa</option>
                            <option value="comp.la cl." style="color:rgb(0, 180, 75)" {{ old('modificariGlobaleSemnat_psi') === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('modificariGlobaleSemnat_psi') === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                            <option value="noi s." style="" {{ old('modificariGlobaleSemnat_psi') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="noi" style="" {{ old('modificariGlobaleSemnat_psi') === 'noi' ? 'selected' : ''}}>noi</option>
                            {{-- <option value='-'>-</option>
                            <option value="n.de s" style="color:blueviolet" {{ old('semnat_psi') === 'n.de s' ? 'selected' : ''}}>n.de s</option>
                            <option value="noi s." style="" {{ old('semnat_psi') === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                            <option value="cl.de s" style="color:rgb(0, 96, 175)" {{ old('semnat_psi') === 'cl.de s' ? 'selected' : ''}}>cl.de s</option> --}}
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="modificariGlobaleSemnatAnexa" class="mb-0 ps-1">Semnat Anexa</small>
                        <select name="modificariGlobaleSemnatAnexa" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('modificariGlobaleSemnatAnexa') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="sem" style="" {{ old('modificariGlobaleSemnatAnexa') === 'sem' ? 'selected' : ''}}>sem</option>
                            <option value="de s" style="color:rgb(204, 0, 0)" {{ old('modificariGlobaleSemnatAnexa') === 'de s' ? 'selected' : ''}}>de s</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-2">
                        <small for="modificariGlobaleSemnatEip" class="mb-0 ps-1">Semnat E.I.P.</small>
                        <select name="modificariGlobaleSemnatEip" class="form-select form-select-sm bg-white rounded-3 {{ $errors->has('modificariGlobaleSemnatEip') ? 'is-invalid' : '' }}">
                            <option value="" selected></option>
                            <option value='-'>-</option>
                            <option value="sem" style="" {{ old('modificariGlobaleSemnatEip') === 'sem' ? 'selected' : ''}}>sem</option>
                            <option value="de s" style="color:rgb(204, 0, 0)" {{ old('modificariGlobaleSemnatEip') === 'de s' ? 'selected' : ''}}>de s</option>
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
    </form>
    <form class="needs-validation" novalidate method="GET" action="/ssm/salariati">
        @csrf
        <div class="row p-1 card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-2">
                <h4 class="mb-0">
                    <a href="/ssm/salariati">
                        <i class="fas fa-users me-1"></i>Salariați
                    </a>
                </h4>
            </div>
            <div class="col-lg-8">
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
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
                    </div>
            </div>
            <div class="col-lg-2 text-end">
                <a class="btn btn-sm mb-1 bg-success text-white border border-dark rounded-3" href="/ssm/salariati/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă
                </a>
                <div id="salariatiIndex">
                    <input class="btn btn-sm btn-primary" type="button" value="Modificări globale" v-on:click="modificari_globale = !modificari_globale">
                </div>
            </div>
        </div>

        <div class="card-body px-0 py-2">

            @include ('errors')




        <div class="table-responsive rounded">
            <table class="table table-striped table-hover table-bordered border-secondary rounded-3" style=" font-size: 5px !important">

                <form class="needs-validation" novalidate method="GET" action="/ssm/salariati">
                    @csrf
                <thead class="text-white rounded" style="background-color:#e66800; font-size: 5px !important">
                    <tr class="" style="padding:2rem; font-size: 5px">
                        <th rowspan="2" class="text-center m-0 p-0" style="font-size: 14px;">
                            {{-- # --}}
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="nr_crt.asc">
                                <i class='fas fa-sort-up'></i>
                            </button>
                            <br>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="nr_crt.desc">
                                <i class='fas fa-sort-down'></i>
                            </button>
                        </th>
                        <th rowspan="2" class="text-center" style=" font-size: 14px; padding:1px;">Acțiuni</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">
                            Nume client
                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">
                            Salariat
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="salariat.asc">
                                <i class='fas fa-sort-up'></i>
                            </button>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="salariat.desc">
                                <i class='fas fa-sort-down'></i>
                            </button>
                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">
                            Data<br>SSM/ PSI
                            <br>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="data_ssm_psi.asc">
                                <i class='fas fa-sort-up'></i>
                            </button>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="data_ssm_psi.desc">
                                <i class='fas fa-sort-down'></i>
                            </button>
                        </th>
                        <th colspan="2" class="text-center" style="font-size: 14px; padding:1px;">Semnat</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;" v-cloak v-if="modificari_globale">
                            <input type="checkbox"
                                class=""
                                id=""
                                style="padding:10px; width:20px; height:20px"
                                {{-- v-on:change="select({{ $categorie->id }})" --}}
                                v-on:change="select($event)"
                                >

                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">CNP</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">
                            Funcția
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="functia.asc">
                                <i class='fas fa-sort-up'></i>
                            </button>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="functia.desc">
                                <i class='fas fa-sort-down'></i>
                            </button>
                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;"></th>
                        <th rowspan="2" class="text-center" style=" font-size: 14px; padding:1px;">Data ang.</th>
                        <th rowspan="2" class="text-center" style=" font-size: 14px; padding:1px;">
                            Data înc.
                            <br>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="data_incetare.asc">
                                <i class='fas fa-sort-up'></i>
                            </button>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="data_incetare.desc">
                                <i class='fas fa-sort-down'></i>
                            </button>
                        </th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">Traseu</th>
                        <th rowspan="2" class="text-center" style="font-size: 14px; padding:1px;">
                            Observații
                            <br>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="observatii_1.asc">
                                <i class='fas fa-sort-up'></i>
                            </button>
                            <button class="btn btn-sm btn-primary text-white mx-0 py-0 px-1 border-0 rounded-3" type="submit" name="butonSortare" value="observatii_1.desc">
                                <i class='fas fa-sort-down'></i>
                            </button>
                        </th>
                        <th colspan="2" class="text-center" style="font-size: 14px; padding:1px;">Semnat</th>
                    </tr>
                    <tr class="">
                        <th class="text-center" style="font-size: 14px; padding:1px;">SSM</th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">PSI</th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">Anexa</th>
                        <th class="text-center" style="font-size: 14px; padding:1px;">E.I.P.</th>
                    </tr>
                </thead>
                </form>
                <tbody>
                    <tr v-for="salariat in salariati">
                    {{-- @forelse ($salariati as $salariat)
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
                        @endif --}}
                            <td style="font-size: 14px; padding:0px; width: 23px;">
                                {{-- {{ ($salariati ->currentpage()-1) * $salariati ->perpage() + $loop->index + 1 }} --}}
                                {{-- {{ $salariat->nr_crt }} --}}
                                <input type="text"
                                        style="width: 23px; border: none; padding:0px"
                                        id="nr_crt"
                                        {{-- name="nr_crt" --}}
                                        :value="salariat['nr_crt']"
                                        v-on:blur = "axiosActualizeazaSalariat( salariat['id'] , 'nr_crt', $event.target.value)"
                                        >
                                <div v-cloak v-if="(axiosActualizatSalariatId == salariat['id']) && (axiosActualizatCamp == 'nr_crt')" class="me-2 text-success">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                            </td>
                            <td></td>
                            <td style="font-size: 14px; padding:1px;" :title="salariat['nume_client']">
                                {{-- {{ substr($salariat->nume_client, 0, 20) }} --}}
                                @{{ salariat['nume_client'].slice(0,20) }}
                            </td>
                            <td style="font-size: 14px; padding:1px;">
                                {{-- <span v-if="(salariat['salariat'].search(3 luni) )"
                                @if (stripos($salariat->salariat, '3 luni') !== false)
                                    {!! str_replace("3 luni", "<span class='text-primary' style='font-size: 14px;'>3 luni</span>", $salariat->salariat) !!}
                                @elseif (stripos($salariat->salariat, '3luni') !== false)
                                    {!! str_replace("3luni", "<span class='text-primary' style='font-size: 14px;'>3luni</span>", $salariat->salariat) !!}
                                @elseif (stripos($salariat->salariat, '6 luni') !== false)
                                    {!! str_replace("6 luni", "<span class='text-primary' style='font-size: 14px;'>6 luni</span>", $salariat->salariat) !!}
                                @elseif (stripos($salariat->salariat, '6luni') !== false)
                                    {!! str_replace("6luni", "<span class='text-primary' style='font-size: 14px;'>6luni</span>", $salariat->salariat) !!}
                                @else --}}
                                    @{{ salariat['salariat'] }}
                                {{-- @endif --}}
                            </td>
                        </tr>
                    {{-- @empty --}}
                        {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                    {{-- @endforelse --}}
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
