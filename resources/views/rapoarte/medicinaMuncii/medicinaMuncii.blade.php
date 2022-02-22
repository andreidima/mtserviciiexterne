@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/rapoarte/medicina-muncii"><i class="fas fa-clinic-medical me-1"></i></a>
                    <a href="/rapoarte/medicina-muncii">Medicina Muncii</a>
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte/medicina-muncii">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <label for="search_data" class="mb-0 align-self-center me-1">Luna:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data }}"
                                nume-camp-db="search_data"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD-MM-YYYY"
                                :latime="{ width: '125px' }"
                                style="margin-right: 20px;"
                            ></vue2-datepicker>
                            <small class="align-self-center">
                                *Selectează orice zi din luna dorită
                            </small>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/rapoarte/medicina-muncii" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover rounded-3">
                    <thead class="text-white rounded-3" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th colspan="4" class="text-center">
                                Luna {{ \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') }} / Total salariați =
                                    <span class="badge bg-success fs-6 border border-white">
                                        {{ $salariati->count() }}
                                    </span>
                                <br>
                                Luna precedentă {{ \Carbon\Carbon::parse($search_data_luna_precedenta)->isoFormat('MM.YYYY') }} / Total salariați nerezolvați =
                                    <span class="badge bg-danger fs-6 border border-white">
                                        {{ $salariati_luna_precedenta->count() }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            {{-- <th width="5%">#</th> --}}
                            <th width="30%">Firma/ Telefon/ Acționar/ Salariați</th>
                            {{-- <th width="15%">Telefon</th> --}}
                            <th width="70%">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        Nr. inregistrare / Nume / Data examinare / Următoarea examinare
                                    </div>
                                    <div>
                                        <a class="btn btn-sm btn-primary border border-light rounded-3"
                                            href="/rapoarte/medicina-muncii/{{ $search_data->toDateString() }}/export-pdf" role="button">
                                            Export PDF
                                        </a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse ($salariati->groupBy('firma.traseu_id') as $salariati_per_traseu) --}}
                            {{-- <tr>
                                <td colspan="4">
                                    Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $salariati_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                    /
                                    Salariați =
                                    <span class="badge bg-success fs-6">
                                        {{ $salariati_per_traseu->count() }}
                                    </span>
                                </td>
                            </tr> --}}
                            @forelse ($salariati->groupBy('firma_id') as $salariati_per_firma)
                                <tr>
                                    {{-- <td align="">
                                        {{ $loop->iteration }}
                                    </td> --}}
                                    <td>
                                        <b>
                                            <form class="needs-validation" novalidate method="GET" action="/medicina-muncii/firme">
                                                {{ $loop->iteration }}
                                                .
                                                    @csrf
                                                    <input type="hidden" class="form-control col-md-3 mx-1 rounded-3" id="search_firma" name="search_firma" placeholder="Firma"
                                                                value="{{ $salariati_per_firma->first()->firma->nume ?? '' }}">
                                                    <button class="btn btn-link p-0" type="submit">
                                                        <b>{{ $salariati_per_firma->first()->firma->nume ?? '' }}</b>
                                                    </button>
                                                /
                                                {{ $salariati_per_firma->first()->firma->telefon ?? '' }}
                                                /
                                                {{-- {{ $salariati_per_firma->first()->firma->actionar ?? '' }} --}}
                                                @switch($salariati_per_firma->first()->firma->actionar)
                                                    @case(1)
                                                        Ionuț
                                                        @break
                                                    @case(2)
                                                        Cătălin
                                                        @break
                                                    @default

                                                @endswitch
                                                /
                                                Salariați =
                                                <span class="badge bg-success fs-6">
                                                    {{ $salariati_per_firma->count() }}
                                                </span>
                                            </form>
                                        </b>
                                    </td>
                                    {{-- <td>
                                        {{ $salariati_per_firma->first()->firma->telefon ?? '' }}
                                    </td> --}}
                                    <td>
                                        <div class="table-responsive rounded">
                                            <table class="table table-sm table-hover rounded border border-1">
                                                @forelse ($salariati_per_firma->sortBy('medicina_muncii_nr_inregistrare') as $salariat)
                                                    <tr style="background-color:wheat">
                                                        {{-- <td width="10%" class="text-start border border-light">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td width="65%" class="text-start border border-light">
                                                            {{ $salariat->nume }}
                                                        </td>
                                                        <td width="25%" class="text-center border border-light">
                                                            {{ $salariat->medicina_muncii_expirare ?
                                                                \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                        </td> --}}
                                                        <td class="text-start" style="width: 45%">
                                                            {{ $salariat->medicina_muncii_nr_inregistrare }} / {{ $salariat->nume }}
                                                        </td>
                                                        <td class="text-center" style="width: 37%">
                                                            {{ $salariat->medicina_muncii_examinare ?
                                                                \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                            /
                                                            {{ $salariat->medicina_muncii_expirare ?
                                                                \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                        </td>
                                                        <td class="" style="width: 18%">
                                                            <div class="d-flex justify-content-end">
                                                                <a href="/medicina-muncii/firme/{{ $salariat->firma->id }}/salariati/{{ $salariat->id }}/modifica" class="flex me-1">
                                                                    <span class="badge bg-primary">Modifică</span>
                                                                </a>
                                                                {{-- <div style="flex" class="">
                                                                    <a
                                                                        href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#stergeSalariat{{ $salariat->id }}"
                                                                        title="Șterge Salariat"
                                                                        >
                                                                        <span class="badge bg-danger">Șterge</span>
                                                                    </a>
                                                                </div> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                        {{-- @empty
                        @endforelse --}}
                    </tbody>
                </table>
            </div>


            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover rounded-3">
                    <thead class="text-white rounded-3" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th colspan="4" class="text-center">
                                Luna precedentă {{ \Carbon\Carbon::parse($search_data_luna_precedenta)->isoFormat('MM.YYYY') }} / Total salariați nerezolvați =
                                    <span class="badge bg-danger fs-6 border border-white">
                                        {{ $salariati_luna_precedenta->count() }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            {{-- <th width="5%">#</th> --}}
                            <th width="30%">Firma/ Telefon/ Acționar/ Salariați</th>
                            {{-- <th width="15%">Telefon</th> --}}
                            <th width="70%">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        Nr. inregistrare / Nume / Data examinare / Următoarea examinare
                                    </div>
                                    <div>
                                        <a class="btn btn-sm btn-primary border border-light rounded-3"
                                            href="/rapoarte/stingatoare/{{ $search_data->toDateString() }}/export-pdf" role="button">
                                            Export PDF
                                        </a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse ($salariati_luna_precedenta->groupBy('firma.traseu_id') as $salariati_per_traseu) --}}
                            {{-- <tr>
                                <td colspan="4">
                                    Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $salariati_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                    /
                                    Salariați =
                                    <span class="badge bg-success fs-6">
                                        {{ $salariati_per_traseu->count() }}
                                    </span>
                                </td>
                            </tr> --}}
                            @forelse ($salariati_luna_precedenta->groupBy('firma_id') as $salariati_per_firma)
                                <tr>
                                    {{-- <td align="">
                                        {{ $loop->iteration }}
                                    </td> --}}
                                    <td>
                                        <b>
                                            <form class="needs-validation" novalidate method="GET" action="/medicina-muncii/firme">
                                                {{ $loop->iteration }}
                                                .
                                                    @csrf
                                                    <input type="hidden" class="form-control col-md-3 mx-1 rounded-3" id="search_firma" name="search_firma" placeholder="Firma"
                                                                value="{{ $salariati_per_firma->first()->firma->nume ?? '' }}">
                                                    <button class="btn btn-link p-0" type="submit">
                                                        <b>{{ $salariati_per_firma->first()->firma->nume ?? '' }}</b>
                                                    </button>
                                                /
                                                {{ $salariati_per_firma->first()->firma->telefon ?? '' }}
                                                /
                                                {{-- {{ $salariati_per_firma->first()->firma->actionar ?? '' }} --}}
                                                @switch($salariati_per_firma->first()->firma->actionar)
                                                    @case(1)
                                                        Ionuț
                                                        @break
                                                    @case(2)
                                                        Cătălin
                                                        @break
                                                    @default

                                                @endswitch
                                                /
                                                Salariați =
                                                <span class="badge bg-success fs-6">
                                                    {{ $salariati_per_firma->count() }}
                                                </span>
                                            </form>
                                        </b>
                                    </td>
                                    {{-- <td>
                                        {{ $salariati_per_firma->first()->firma->telefon ?? '' }}
                                    </td> --}}
                                    <td>
                                        <div class="table-responsive rounded">
                                            <table class="table table-sm table-hover rounded border border-1">
                                                @forelse ($salariati_per_firma as $salariat)
                                                    <tr style="background-color:wheat">
                                                        {{-- <td width="10%" class="text-start border border-light">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td width="65%" class="text-start border border-light">
                                                            {{ $salariat->nume }}
                                                        </td>
                                                        <td width="25%" class="text-center border border-light">
                                                            {{ $salariat->medicina_muncii_expirare ?
                                                                \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                        </td> --}}
                                                        <td class="text-start" style="width: 45%">
                                                            {{ $salariat->medicina_muncii_nr_inregistrare }} / {{ $salariat->nume }}
                                                        </td>
                                                        <td class="text-center" style="width: 37%">
                                                            {{ $salariat->medicina_muncii_examinare ?
                                                                \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                                            /
                                                            {{ $salariat->medicina_muncii_expirare ?
                                                                \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                                        </td>
                                                        <td class="" style="width: 18%">
                                                            <div class="d-flex justify-content-end">
                                                                <a href="/medicina-muncii/firme/{{ $salariat->firma->id }}/salariati/{{ $salariat->id }}/modifica" class="flex me-1">
                                                                    <span class="badge bg-primary">Modifică</span>
                                                                </a>
                                                                {{-- <div style="flex" class="">
                                                                    <a
                                                                        href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#stergeSalariat{{ $salariat->id }}"
                                                                        title="Șterge Salariat"
                                                                        >
                                                                        <span class="badge bg-danger">Șterge</span>
                                                                    </a>
                                                                </div> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                @endforelse
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                        {{-- @empty
                        @endforelse --}}
                    </tbody>
                </table>
            </div>




        </div>
    </div>

@endsection
