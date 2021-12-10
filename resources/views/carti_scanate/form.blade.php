@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app1">
    <div class="col-lg-12 mb-0">

        <div class="row p-2 mb-0">
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="titlu" class="mb-0 ps-3">Titlu*:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('titlu') ? 'is-invalid' : '' }}"
                    name="titlu"
                    placeholder=""
                    value="{{ old('titlu', $carte_scanata->titlu) }}"
                    required>
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="autor" class="mb-0 ps-3">Autor:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('autor') ? 'is-invalid' : '' }}"
                    name="autor"
                    placeholder=""
                    value="{{ old('autor', $carte_scanata->autor) }}"
                    >
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="editura" class="mb-0 ps-3">Editura:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('editura') ? 'is-invalid' : '' }}"
                    name="editura"
                    placeholder=""
                    value="{{ old('editura', $carte_scanata->editura) }}"
                    >
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="anul" class="mb-0 ps-3">Anul:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('anul') ? 'is-invalid' : '' }}"
                    name="anul"
                    placeholder=""
                    value="{{ old('anul', $carte_scanata->anul) }}"
                    >
            </div>
            <div class="col-lg-10 mb-2 mx-auto">
                <label for="nr_pagini" class="mb-0 ps-3">Nr. pagini:</label>
                <input
                    type="text"
                    class="form-control form-control-sm rounded-pill {{ $errors->has('nr_pagini') ? 'is-invalid' : '' }}"
                    name="nr_pagini"
                    placeholder=""
                    value="{{ old('nr_pagini', $carte_scanata->nr_pagini) }}"
                    >
            </div>
        </div>

        <div class="row p-2">
            <div class="col-lg-12 py-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white btn-sm me-2 rounded-pill">{{ $buttonText }}</button>
                <a class="btn btn-secondary btn-sm rounded-pill" href="/carti-scanate">Renunță</a>
            </div>
        </div>
    </div>
</div>
