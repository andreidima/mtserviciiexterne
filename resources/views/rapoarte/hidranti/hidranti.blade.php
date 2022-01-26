@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/rapoarte/hidranti"><i class="fas fa-file-alt me-1"></i></a>
                    <a href="/rapoarte/hidranti">Hidranți</a>
                </h4>
            </div>
            <div class="col-lg-9" id="app">
                <form class="needs-validation" novalidate method="GET" action="/rapoarte/hidranti">
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
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/rapoarte/hidranti" role="button">
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
                                Luna {{ \Carbon\Carbon::parse($search_data)->isoFormat('MM.YYYY') }} / Total hidranți =
                                    <span class="badge bg-success fs-6 border border-white">
                                        {{ $hidranti->sum('hidranti') }}
                                    </span>
                                <br>
                                Luna precedentă {{ \Carbon\Carbon::parse($search_data_luna_precedenta)->isoFormat('MM.YYYY') }} / Total hidranți nerezolvați =
                                    <span class="badge bg-danger fs-6 border border-white">
                                        {{ $hidranti_luna_precedenta->sum('hidranti') }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th width="5%">#</th>
                            <th width="50%">Firma</th>
                            <th width="15%">Telefon</th>
                            <th width="30%">
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        Hidranți
                                    </div>
                                    <div>
                                        <a class="btn btn-sm btn-primary border border-light rounded-3"
                                            href="/rapoarte/hidranti/{{ $search_data->toDateString() }}/export-pdf" role="button">
                                            Export PDF
                                        </a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // dd($hidranti);
                        @endphp
                        @forelse ($hidranti->groupBy('firma.traseu_id') as $hidranti_per_traseu)
                            {{-- @php
                                $total_hidranti_per_traseu = 0;
                            @endphp --}}
                            <tr>
                                <td colspan="4">
                                    Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $hidranti_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                    /
                                    Hidranți =
                                    <span class="badge bg-success fs-6">
                                        {{ $hidranti_per_traseu->sum('hidranti') }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($hidranti_per_traseu as $hidrant)
                                <tr>
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>
                                            {{ $hidrant->firma->nume ?? '' }}
                                        </b>
                                    </td>
                                    <td>
                                        {{ $hidrant->firma->telefon ?? '' }}
                                    </td>
                                    <td>
                                        <span class="badge fs-6 bg-success">
                                            {{
                                                $hidrant->hidranti
                                            }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                            @endforelse
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
                        @empty
                            {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                        @endforelse
                        </tbody>
                </table>
            </div>


            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover rounded-3">
                    <thead class="text-white rounded-3" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th colspan="4" class="text-center">
                                Luna precedentă {{ \Carbon\Carbon::parse($search_data_luna_precedenta)->isoFormat('MM.YYYY') }} / Total hidranți nerezolvați =
                                    <span class="badge bg-danger fs-6 border border-white">
                                        {{ $hidranti_luna_precedenta->sum('hidranti') }}
                                    </span>
                            </th>
                        </tr>
                        <tr class="" style="padding:2rem">
                            <th width="5%">#</th>
                            <th width="50%">Firma</th>
                            <th width="15%">Telefon</th>
                            <th width="30%">Hidranți</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            // dd($hidranti);
                        @endphp
                        @forelse ($hidranti_luna_precedenta->groupBy('firma.traseu_id') as $hidranti_per_traseu)
                            {{-- @php
                                $total_hidranti_per_traseu = 0;
                            @endphp --}}
                            <tr>
                                <td colspan="4">
                                    Traseu:
                                    <span class="badge bg-dark fs-6">
                                        {{ $hidranti_per_traseu->first()->firma->traseu->nume ?? '' }}
                                    </span>
                                    /
                                    Hidranți =
                                    <span class="badge bg-success fs-6">
                                        {{ $hidranti_per_traseu->sum('hidranti') }}
                                    </span>
                                </td>
                            </tr>
                            @forelse ($hidranti_per_traseu as $hidrant)
                                <tr>
                                    <td align="">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <b>
                                            {{ $hidrant->firma->nume ?? '' }}
                                        </b>
                                    </td>
                                    <td>
                                        {{ $hidrant->firma->telefon ?? '' }}
                                    </td>
                                    <td>
                                        <span class="badge fs-6 bg-success">
                                            {{
                                                $hidrant->hidranti
                                            }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                {{-- <div>Nu s-au gasit rezervări în baza de date. Încearcă alte date de căutare</div> --}}
                            @endforelse
                            <tr>
                                <td colspan="4">
                                    &nbsp;
                                </td>
                            </tr>
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
