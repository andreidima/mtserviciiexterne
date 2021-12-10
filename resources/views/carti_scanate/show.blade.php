@extends ('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow-lg" style="border-radius: 40px 40px 40px 40px;">
                <div class="border border-secondary p-2" style="border-radius: 40px 40px 0px 0px; background-color:#e66800">
                    <h6 class="ms-2 my-0" style="color:white">
                        <i class="fas fa-book me-1"></i>
                        Cărți scanate / {{ $carte_scanata->titlu ?? '' }}</h6>
                </div>

                <div class="card-body py-2 border border-secondary"
                    style="border-radius: 0px 0px 40px 40px;"
                >

            @include ('errors')

                    <div class="table-responsive col-md-12 mx-auto">
                        <table class="table table-sm table-striped table-hover"
                        >
                            <tr>
                                <td class="pe-4">
                                    Titlu
                                </td>
                                <td>
                                    {{ $carte_scanata->titlu }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Autor
                                </td>
                                <td>
                                    {{ $carte_scanata->autor }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Editura
                                </td>
                                <td>
                                    {{ $carte_scanata->editura }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Anul
                                </td>
                                <td>
                                    {{ $carte_scanata->anul }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Nr. pagini
                                </td>
                                <td>
                                    {{ $carte_scanata->nr_pagini }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pe-4">
                                    Utilizator
                                </td>
                                <td>
                                    {{ $carte_scanata->utilizator->name ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="form-row mb-2 px-2">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <a class="btn btn-primary text-white btn-sm rounded-pill" href="/carti-scanate">Pagină Cărți Scanate</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
