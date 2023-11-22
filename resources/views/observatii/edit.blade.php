@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-3 my-0" style="color:white">
                        <i class="fas fa-comments me-1"></i>
                        Observații
                    </h6>
                </div>

                @include ('errors')

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                    id="formularObservatii"
                >

                        {{-- @if (count($observatie->poze))
                            <div class="mb-4 table-responsive rounded border border-secondary">
                                <table class="table table-striped table-hover rounded mb-0">
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Poze atașate
                                        </td>
                                    </tr>
                                    @forelse ($observatie->poze as $poza)
                                        <tr>
                                            <td>
                                                <a href="{{ $poza->path() }}" target="_blank">
                                                    <img
                                                        src="{{ $poza->path() }}"
                                                        alt=""
                                                        width="200"
                                                    >
                                                </a>
                                            </td>
                                            <td>
                                                {{ $poza->nume }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ '/observatii/file-download/' . $poza->id }}"
                                                        class="me-1"
                                                    >
                                                        <span class="badge bg-success">
                                                            Descarcă
                                                        </span>
                                                    </a>
                                                    <a
                                                        href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#stergePoza{{ $poza->id }}"
                                                        title="Șterge Poza"
                                                        >
                                                        <span class="badge bg-danger">Șterge</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </table>
                            </div>
                        @endif --}}

                        @if (count($observatie->poze))
                            <div class="row">
                                @forelse ($observatie->poze as $poza)
                                    <div class="col-lg-6 border border-2 pb-1 mb-1">
                                        <div>
                                            <a href="{{ $poza->path() }}" target="_blank">
                                                <img
                                                    src="{{ $poza->path() }}"
                                                    alt=""
                                                    {{-- style="max-width:150px; max-height:150px;" --}}
                                                    width="100%"
                                                >
                                            </a>
                                        </div>
                                        <div class="text-center">
                                            <a
                                                href="#"
                                                data-bs-toggle="modal"
                                                data-bs-target="#stergePoza{{ $poza->id }}"
                                                title="Șterge Poza"
                                                >
                                                <span class="badge bg-danger">Șterge</span>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>

                        @endif

                    <form ref="form" class="needs-validation" novalidate method="POST" action="{{ $observatie->path() }}" enctype="multipart/form-data">
                        @method('PATCH')

                                @include ('observatii.form', [
                                    'buttonText' => 'Modifică Observație'
                                ])

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



    {{-- Modalele pentru stergere --}}
    @forelse ($observatie->poze as $poza)
        <div class="modal fade text-dark" id="stergePoza{{ $poza->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Poza: <b>{{ $poza->nume ?? '' }}</b></h5>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align:left;">
                    Ești sigur ca vrei să ștergi Poza?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Renunță</button>

                    <form method="POST" action="{{ $poza->path() }}">
                        @method('DELETE')
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger text-white"
                            >
                            Șterge Poza
                        </button>
                    </form>

                </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
@endsection
