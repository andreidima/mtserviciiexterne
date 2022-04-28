@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    SSM - salariați
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/ssm/rapoarte-pentru-medicina-muncii/salariati">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_nume_client" name="search_nume_client" placeholder="Firma"
                                    value="{{ $search_nume_client }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm rounded-3" id="search_salariat" name="search_salariat" placeholder="Salariat"
                                    value="{{ $search_salariat }}">
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/ssm/rapoarte-pentru-medicina-muncii/salariati" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded">
                <table class="table table-striped table-hover rounded">
                    <thead class="text-white rounded" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Firma</th>
                            <th>Salariat</th>
                            <th>CNP</th>
                            <th>Funcția</th>
                            <th>Medicina Muncii</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($salariati as $salariat)
                            <tr>
                                <td align="">
                                    {{ ($salariati ->currentpage()-1) * $salariati ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $salariat->nume_client ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->salariat ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->cnp ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->functia ?? '' }}
                                </td>
                                <td>
                                    {{ $salariat->med_muncii ?? '' }}
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
                        {{$salariati->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>
        </div>
    </div>

@endsection
