@extends ('layouts.app')

@section('content')
<div class="container card" style="border-radius: 40px 40px 40px 40px;">
        <div class="row card-header align-items-center" style="border-radius: 40px 40px 0px 0px;">
            <div class="col-lg-3 mb-2">
                <h4 class="mb-0">
                    <a href="/observatii"><i class="fas fa-comments me-1"></i></a>
                    <a href="/observatii">Observații</a>
                </h4>
            </div>
            <div class="col-lg-6" id="app">
                <form class="needs-validation" novalidate method="GET" action="/observatii">
                    @csrf
                    <div class="row mb-2 input-group custom-search-form justify-content-center">
                        <input type="text" class="form-control form-control-sm col-md-4 me-3 border rounded-3" id="search_nume" name="search_nume" placeholder="Nume" autofocus
                                value="{{ $search_nume }}">
                        <input type="text" class="form-control form-control-sm col-md-4 border rounded-3" id="search_firma" name="search_firma" placeholder="Firma" autofocus
                                value="{{ $search_firma }}">
                    </div>
                    <div class="row input-group custom-search-form justify-content-center">
                        <button class="btn btn-sm btn-primary text-white col-md-4 mx-3 mb-2 border border-dark rounded-3" type="submit">
                            <i class="fas fa-search text-white me-1"></i>Caută
                        </button>
                        <a class="btn btn-sm bg-secondary text-white col-md-4 mx-3 mb-2 border border-dark rounded-3" href="/observatii" role="button">
                            <i class="far fa-trash-alt text-white me-1"></i>Resetează căutarea
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 text-center text-lg-end">
                <a class="btn btn-sm bg-success text-white border border-dark rounded-3 col-md-8" href="/observatii/adauga" role="button">
                    <i class="fas fa-plus-square text-white me-1"></i>Adaugă observație
                </a>
            </div>
        </div>

        <div class="card-body px-0 py-3">

            @include ('errors')

            <div class="table-responsive rounded-3">
                <table class="table table-striped table-hover rounded-3">
                    <thead class="text-white rounded-3" style="background-color:#e66800;">
                        <tr class="" style="padding:2rem">
                            <th>#</th>
                            <th>Firma / Observație</th>
                            <th class="text-center">Email</th>
                            <th class="text-end">Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($observatii as $observatie)
                            <tr>
                                <td align="">
                                    {{ ($observatii ->currentpage()-1) * $observatii ->perpage() + $loop->index + 1 }}
                                </td>
                                <td>
                                    {{ $observatie->firma->nume ?? '' }}
                                    <br>
                                    {{ $observatie->nume }}
                                </td>
                                <td class="text-center">
                                    @if ($observatie->nr_trimiteri == 0)
                                        <a
                                            href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#trimiteEmailObservatie{{ $observatie->id }}"
                                            title="Trimite Email Observație"
                                            >
                                                <span class="badge bg-success">Trimite</span>
                                        </a>
                                    @else
                                        <span class="badge bg-secondary">Trimis</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ $observatie->path() }}"
                                        class="flex"
                                    ><span class="badge bg-success">Vizualizează</span></a>
                                    <a href="{{ $observatie->path() }}/modifica"
                                        class="flex ms-1"
                                    ><span class="badge bg-primary">Modifică</span></a>
                                    <a
                                        href="#"
                                        class="ms-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#stergeObservatie{{ $observatie->id }}"
                                        title="Șterge Observație"
                                        ><span class="badge bg-danger">Șterge</span></a>
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
                        {{$observatii->appends(Request::except('page'))->links()}}
                    </ul>
                </nav>

        </div>
    </div>

    {{-- Modalele pentru trimitere email --}}
    @foreach ($observatii as $observatie)
        <div class="modal fade text-dark" id="trimiteEmailObservatie{{ $observatie->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Observație: <b>{{ $observatie->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să trimiți email cu acestă Observație?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $observatie->path() }}/trimite-email ">
                        @method('PATCH')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Trimite email
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modalele pentru stergere înregistrări --}}
    @foreach ($observatii as $observatie)
        <div class="modal fade text-dark" id="stergeObservatie{{ $observatie->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Observație: <b>{{ $observatie->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Observația?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $observatie->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Observația
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
