@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3">
                <h4 class="mb-0">
                    <a href="/firme/salariati"><i class="fas fa-users me-1"></i></a>
                    <a href="/firme/salariati">Salariați</a>
                </h4>
            </div>
            <div class="col-lg-6" id="app">
                <form class="needs-validation" novalidate method="GET" action="/firme/salariati">
                    @csrf
                    <div class="row mb-1 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 me-1 border rounded-3" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 me-3 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 border border-dark rounded-3" href="/firme/saliariati" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="/firme/salariati/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă salariat
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
                            <th>Nume</th>
                            <th>Funcția</th>
                            <th>Firma</th>
                            <th class="text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($salariati as $salariat)
                            <tr>
                                <td align="">
                                    {{ ($salariati ->currentpage()-1) * $salariati ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    <b>{{ $salariat->nume ?? '' }}</b>
                                </td>
                                <td>
                                    <b>{{ $salariat->functie ?? '' }}</b>
                                </td>
                                <td>
                                    <b>{{ $salariat->firma->nume ?? '' }}</b>
                                </td>
                                <td class="d-flex justify-content-end">
                                    <a href="{{ $salariat->path() }}"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-success">Vizualizează</span>
                                    </a>
                                    <a href="{{ $salariat->path() }}/modifica"
                                        class="flex me-1"
                                    >
                                        <span class="badge bg-primary">Modifică</span>
                                    </a>
                                    <div style="flex" class="">
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#stergeSalariat{{ $salariat->id }}"
                                            title="Șterge Salariat"
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
                        {{$salariati->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru stergere firma --}}
    @foreach ($salariati as $salariat)
        <div class="modal fade text-dark" id="stergeSalariat{{ $salariat->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Salariat: <b>{{ $salariat->nume ?? '' }}</b></h5>
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
                            Șterge Salariatul
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
