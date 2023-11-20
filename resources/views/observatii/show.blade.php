@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-2 my-0" style="color:white">
                        <i class="fas fa-comments me-1"></i>
                        Observații / {{ $observatie->nume ?? '' }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-striped table-hover"
                        >
                            <tr>
                                <td class="pe-4">
                                    Nume
                                </td>
                                <td>
                                    {{ $observatie->nume }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Firma
                                </td>
                                <td>
                                    {{ $observatie->firma->nume ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Data
                                </td>
                                <td>
                                    {{ $observatie->data ? \Carbon\Carbon::parse($observatie->data)->isoFormat('DD.MM.YYYY') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Descriere
                                </td>
                                <td>
                                    {{ $observatie->descriere }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Observații
                                </td>
                                <td>
                                    {{ $observatie->observatii }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="row mb-2 px-2">
                        @forelse ($observatie->poze as $poza)
                            <div class="col-lg-6 mb-2 justify-content-center">
                                <a href="{{ asset('storage/app/uploads/observatii/' . $observatie->id . '/' . $poza->nume) }}" target="_blank">
                                    <img
                                        src="{{ asset('storage/app/uploads/observatii/' . $observatie->id . '/' . $poza->nume) }}"
                                        alt=""
                                        width="100%"
                                    >
                                    <img
                                        src="{{ url('storage/app/uploads/observatii/' . $observatie->id . '/' . $poza->nume) }}"
                                        alt=""
                                        width="100%"
                                    >
                                    <img
                                        src="{{ asset('public/app/uploads/observatii/40/17004627811574029993665803840741.jpg') }}"
                                        alt=""
                                        width="100%"
                                    >

                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary text-white rounded-3" href="/observatii">Pagină Observații</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
