@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/firme/stingatoare"><i class="fas fa-fire-extinguisher me-1"></i></a>
                    <a href="/firme/stingatoare">Stingătoare</a>
                </h4>
            </div>
            <div class="col-lg-6" id="app">
                <form class="needs-validation" novalidate method="GET" action="/firme/stingatoare">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 me-1 border rounded-3" id="search_nume" name="search_nume" placeholder="Firma" autofocus
                                value="{{ $search_nume }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/firme/stingatoare" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="/firme/stingatoare/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă stingătoare
                </a>
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
                            <th>Stingătoare</th>
                            <th class="text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($stingatoare as $stingator)
                            <tr>
                                <td align="">
                                    {{ ($stingatoare ->currentpage()-1) * $stingatoare ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $stingator->firma->nume ?? '' }}</b>
                                </td>
                                <td>
                                    @if($stingator->p1 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->p1 }} P1
                                            </span>
                                    @endif
                                    @if($stingator->p2 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->p2 }} P2
                                            </span>
                                    @endif
                                    @if($stingator->p3 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->p3 }} P3
                                            </span>
                                    @endif
                                    @if($stingator->p6 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->p6 }} P6
                                            </span>
                                    @endif
                                    @if($stingator->p9 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->p9 }} P9
                                            </span>
                                    @endif
                                    @if($stingator->sm6 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->sm6 }} SM6
                                            </span>
                                    @endif
                                    @if($stingator->sm9 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->sm9 }} SM9
                                            </span>
                                    @endif
                                    @if($stingator->p50 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->p50 }} P50
                                            </span>
                                    @endif
                                    @if($stingator->p100 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->p100 }} P100
                                            </span>
                                    @endif
                                    @if($stingator->sm50 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->sm50 }} SM50
                                            </span>
                                    @endif
                                    @if($stingator->sm100 > 0)
                                            <span class="badge fs-6 bg-success">
                                            {{ $stingator->sm100 }} SM100
                                            </span>
                                    @endif
                                    @if($stingator->g2 > 0)
                                            <span class="badge text-black fs-6 bg-warning">
                                            {{ $stingator->g2 }} G2
                                            </span>
                                    @endif
                                    @if($stingator->g5 > 0)
                                            <span class="badge text-black fs-6 bg-warning">
                                            {{ $stingator->g5 }} G5
                                            </span>
                                    @endif
                                </td>
                                <td class="d-flex justify-content-end">
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
                        {{$stingatoare->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere firma --}}
    @foreach ($stingatoare as $stingator)
        <div class="modal fade text-dark" id="stergeStingător{{ $stingator->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Firma: <b>{{ $stingator->firma->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Stingătoarele?
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
                            Șterge Stingătoare
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
