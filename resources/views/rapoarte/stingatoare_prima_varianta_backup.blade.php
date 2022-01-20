@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/rapoarte/stingatoare"><i class="fas fa-file-alt me-1"></i></a>
                    <a href="/rapoarte/stingatoare">Stingătoare</a>
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte/stingatoare">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <label for="search_data_inceput" class="mb-0 align-self-center me-1">Data început:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_inceput }}"
                                nume-camp-db="search_data_inceput"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD-MM-YYYY"
                                :latime="{ width: '125px' }"
                                style="margin-right: 20px;"
                            ></vue2-datepicker>
                            <label for="search_data_sfarsit" class="mb-0 align-self-center me-1">Data sfârșit:</label>
                            <vue2-datepicker
                                data-veche="{{ $search_data_sfarsit }}"
                                nume-camp-db="search_data_sfarsit"
                                tip="date"
                                value-type="YYYY-MM-DD"
                                format="DD-MM-YYYY"
                                :latime="{ width: '125px' }"
                            ></vue2-datepicker>
                        </div>
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/rapoarte/stingatoare" role="button">
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
                            <th>Nr. Crt.</th>
                            <th>Firma</th>
                            <th>Ordine expirare</th>
                            <th>Expirare stingătoare</th>
                            <th>Expirare hidranți</th>
                            {{-- <th class="text-end">Acțiuni</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // dd($stingatoare);
                        @endphp
                        @forelse ($stingatoare->groupBy('traseu_id', 'id') as $stingatoare_per_traseu)
                            <tr>
                                <td colspan="5">
                                    Traseu:
                                    <span class="badge bg-dark">
                                        {{ $stingatoare_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($stingatoare_per_traseu as $stingator)
                                <tr>
                                    <td align="">
                                        {{-- {{ ($stingatoare ->currentpage()-1) * $stingatoare ->perpage() + $loop->index + 1 }} --}}
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>{{ $stingator->firma->nume ?? '' }}</b> {{ $stingator->id }}
                                    </td>
                                    <td>
                                        {{ $stingator->data_expirare ? \Carbon\Carbon::parse($stingator->data_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                    </td>
                                    <td>
                                        {{ $stingator->stingatoare_expirare ? \Carbon\Carbon::parse($stingator->stingatoare_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                    </td>
                                    <td>
                                        {{ $stingator->hidranti_expirare ? \Carbon\Carbon::parse($stingator->hidranti_expirare)->isoFormat('DD.MM.YYYY') : '' }}
                                    </td>
                                    {{-- <td class="d-flex justify-content-end">
                                        <a href="{{ $stingator->path() }}"
                                            class="flex me-1"
                                        >
                                            <span class="badge bg-success">Vizualizează</span>
                                        </a>
                                        <a href="{{ $stingator->path() }}/modifica"
                                            class="flex me-1"
                                        >
                                            <span class="badge bg-primary">Modifică</span>
                                        </a>
                                        <div style="flex" class="">
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#stergeStingător{{ $stingator->id }}"
                                                title="Șterge Stingător"
                                                >
                                                <span class="badge bg-danger">Șterge</span>
                                            </a>
                                        </div>
                                    </td> --}}
                                </tr>
                            @empty
                                {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                            @endforelse
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>

                {{-- <nav>
                    <ul class="pagination justify-content-center">
                        {{$stingatoare->appends(Request::except('page'))->links()}}
                    </ul>
                </nav> --}}

        </div>
    </div>

    {{-- Modalele pentru stergere --}}
    {{-- @foreach ($stingatoare as $stingator)
        <div class="modal fade text-dark" id="stergeStingător{{ $stingator->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Stingător: <b>{{ $stingator->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Stingător?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $stingator->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Stingător
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach --}}

@endsection
