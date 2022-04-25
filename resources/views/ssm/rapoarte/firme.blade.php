@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    SSM - Raport firme
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/ssm/rapoarte/firme">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
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
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            sau
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
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/ssm/rapoarte/firme" role="button">
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
                                    SSM luna <u>{!! $search_ssm_luna ?? '&nbsp&nbsp&nbsp&nbsp' !!}</u> /
                                    PSI luna <u>{!! $search_psi_luna ?? '&nbsp&nbsp&nbsp&nbsp' !!}</u> / Total firme =
                                        <span class="badge bg-success fs-6 border border-white">
                                            {{ $firme->count() }}
                                        </span>
                                    </div>


                                    <div>
                                        <a class="btn btn-sm btn-primary border border-light rounded-3"
                                            href="/ssm/rapoarte/firme/{{ $search_ssm_luna ?? 'search_ssm_luna' }}/{{ $search_psi_luna ?? 'search_psi_luna' }}/export-pdf" role="button">
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
                            <th rowspan="2">Firma</th>
                            <th rowspan="2">CUI</th>
                            <th colspan="2" class="text-center">Luna</th>
                            <th colspan="2" class="text-center">Stare fișe</th>
                        </tr>
                        <tr>
                            <th>SSM</th>
                            <th>PSI</th>
                            <th>SSM</th>
                            <th>PSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($firme->groupBy('traseu') as $firme_per_traseu)
                            <tr>
                                <td colspan="7">
                                    Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $firme_per_traseu->first()->traseu ?? '' }}
                                    </span>
                                    /
                                    Firme =
                                    <span class="badge bg-success fs-6">
                                        {{ $firme_per_traseu->count() }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($firme_per_traseu as $firma)
                                <tr>
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $firma->nume ?? '' }}
                                    </td>
                                    <td>
                                        {{ $firma->cui ?? '' }}
                                    </td>
                                    <td>
                                        {{ $firma->ssm_luna ?? '' }}
                                    </td>
                                    <td>
                                        {{ $firma->psi_luna ?? '' }}
                                    </td>
                                    <td>
                                        {{ $firma->ssm_stare_fise ?? '' }}
                                    </td>
                                    <td>
                                        {{ $firma->psi_stare_fise ?? '' }}
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
