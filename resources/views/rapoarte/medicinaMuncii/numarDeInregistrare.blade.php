@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    Medicina Muncii
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte/medicina-muncii/nr-de-inregistrare">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <label for="search_data" class="mb-0 align-self-center me-1">Data:</label>
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
                                *Selectează INCLUSIV ziua până la care dorești să vezi cel mai mare număr de înregistrare folosit
                            </small>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/rapoarte/medicina-muncii/nr-de-inregistrare" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="row">
                <div class="col-lg-7 mx-auto">
                    <div class="table-responsive rounded-3">
                        <table class="table table-striped table-hover rounded-3">
                            <thead class="text-white rounded-3" style="background-color:#e66800;">
                                <th>
                                    Nr. inregistrare
                                </th>
                                <th>
                                    Nume
                                </th>
                                <th>
                                    Data examinare
                                </th>
                                <th>
                                    Următoarea examinare
                                </th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ $salariat->medicina_muncii_nr_inregistrare }}
                                    </td>
                                    <td>
                                        {{ $salariat->nume }}
                                    </td>
                                    <td>
                                        {{ $salariat->medicina_muncii_examinare ?
                                            \Carbon\Carbon::parse($salariat->medicina_muncii_examinare)->isoFormat('DD.MM.YYYY') : '' }}
                                    </td>
                                    <td>
                                        {{ $salariat->medicina_muncii_expirare ?
                                            \Carbon\Carbon::parse($salariat->medicina_muncii_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                    </td>
                                </tr>
                            </tbody>
                </div>
            </div>

        </div>
    </div>

@endsection
