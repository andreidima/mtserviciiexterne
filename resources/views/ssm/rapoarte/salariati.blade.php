@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    SSM - Raport salariati
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/ssm/rapoarte/salariati">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-md-3">
                            <select class="form-select form-select-sm mb-1" id="search_data_ssm_psi" name="search_data_ssm_psi" >
                                    <option value="" selected>Data SSM/ PSI</option>
                                @foreach ($lista_data_ssm_psi as $data_ssm_psi)
                                    <option value="{{ $data_ssm_psi->data_ssm_psi }}"
                                        {{ isset($data_ssm_psi->data_ssm_psi) ? ($data_ssm_psi->data_ssm_psi === $search_data_ssm_psi ? 'selected' : '') : '' }}
                                    >
                                    {{ $data_ssm_psi->data_ssm_psi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm mb-1" id="search_semnat_ssm" name="search_semnat_ssm">
                                    <option value="" selected>Semnat SSM</option>
                                @foreach ($lista_semnat_ssm as $semnat_ssm)
                                    <option value="{{ $semnat_ssm->semnat_ssm }}"
                                        {{ isset($semnat_ssm->semnat_ssm) ?  ($semnat_ssm->semnat_ssm === $search_semnat_ssm ? 'selected' : '') : '' }}
                                    >
                                    {{ $semnat_ssm->semnat_ssm }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select form-select-sm mb-1" id="search_semnat_psi" name="search_semnat_psi">
                                    <option value="" selected>Semnat PSI</option>
                                @foreach ($lista_semnat_psi as $semnat_psi)
                                    <option value="{{ $semnat_psi->semnat_psi }}"
                                        {{ isset($semnat_psi->semnat_psi) ?  ($semnat_psi->semnat_psi === $search_semnat_psi ? 'selected' : '') : '' }}
                                    >
                                    {{ $semnat_psi->semnat_psi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 text-center">
                            <small>
                                * Câmpul „Data SSM/ PSI” este obligatoriu de selectat.
                            </small>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/ssm/rapoarte/salariati" role="button">
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
                            <th colspan="7" class="text-center">
                                <div class="d-flex justify-content-between">
                                    <div>

                                    </div>
                                    <div>
                                    Data SSM/ PSI <u>{!! $search_data_ssm_psi ?? '&nbsp&nbsp&nbsp&nbsp' !!}</u> /
                                    Semnat SSM <u>{!! $search_semnat_ssm ?? '&nbsp&nbsp&nbsp&nbsp' !!}</u> /
                                    Semnat PSI <u>{!! $search_semnat_psi ?? '&nbsp&nbsp&nbsp&nbsp' !!}</u> /
                                    Total salariati =
                                        <span class="badge bg-success fs-6 border border-white">
                                            {{ $salariati->count() }}
                                        </span>
                                    </div>


                                    <div>
                                        <a class="btn btn-sm btn-primary border border-light rounded-3"
                                            href="/ssm/rapoarte/salariati/{{ $search_data_ssm_psi ?? 'search_data_ssm_psi' }}/{{ $search_semnat_ssm ?? 'search_semnat_ssm' }}/{{ $search_semnat_psi ?? 'search_semnat_psi' }}/export-pdf" role="button">
                                            Export PDF
                                        </a>
                                    </div>
                                {{-- Luna precedentă {{ ($search_data_luna_precedenta)->isoFormat('MM.YYYY') }} / Total salariați nerezolvați =
                                    <span class="badge bg-danger fs-6 border border-white">
                                        {{ $salariati_luna_precedenta->count() }}
                                    </span> --}}
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th rowspan="2">#</th>
                            <th rowspan="2">Salariat</th>
                            <th rowspan="2">Funcția</th>
                            <th rowspan="2">Data angajării</th>
                            <th rowspan="2">Data SSM/ PSI</th>
                            <th colspan="2" class="text-center">Semnat</th>
                        </tr>
                        <tr>
                            <th>SSM</th>
                            <th>PSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($salariati->groupBy('nume_client') as $salariati_per_nume_client)
                            <tr>
                                <td colspan="7">
                                    Firma:
                                    <span class="badge bg-dark fs-6">
                                        {{ $salariati_per_nume_client->first()->nume_client ?? '' }}
                                    </span>
                                    /
                                    Salariați =
                                    <span class="badge bg-success fs-6">
                                        {{ $salariati_per_nume_client->count() }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($salariati_per_nume_client as $salariat)
                                <tr>
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $salariat->salariat ?? '' }}
                                    </td>
                                    <td>
                                        {{ $salariat->functia ?? '' }}
                                    </td>
                                    <td>
                                        {{ $salariat->data_angajare ?? '' }}
                                    </td>
                                    <td>
                                        {{ $salariat->data_ssm_psi ?? '' }}
                                    </td>
                                    <td>
                                        {{ $salariat->semnat_ssm ?? '' }}
                                    </td>
                                    <td>
                                        {{ $salariat->semnat_psi ?? '' }}
                                    </td>
                                </tr>
                            @empty
                                {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                            @endforelse
                            <tr>
                                <td colspan="7">
                                    &nbsp;
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                    </tbody>
                </table>
            </div>






        </div>
    </div>

@endsection
