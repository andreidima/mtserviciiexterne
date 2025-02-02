@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app">
    <div class="col-lg-12 mb-0">

        <div class="row mb-2">
            <div class="col-lg-3 mb-3">
                <label for="nume" class="mb-0 ps-3">Nume client<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $firma->nume) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-3">
                <label for="cui" class="mb-0 ps-3">C.U.I.</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('cui') ? 'is-invalid' : '' }}"
                    name="cui"
                    placeholder=""
                    value="{{ old('cui', $firma->cui) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="j_seap_fact" class="mb-0 ps-3">J / Seap,Fact.</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('j_seap_fact') ? 'is-invalid' : '' }}"
                    name="j_seap_fact"
                    placeholder=""
                    value="{{ old('j_seap_fact', $firma->j_seap_fact) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="adresa" class="mb-0 ps-3">Adresa</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('adresa') ? 'is-invalid' : '' }}"
                    name="adresa"
                    placeholder=""
                    value="{{ old('adresa', $firma->adresa) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="doc" class="mb-0 ps-3">Doc.</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('doc') ? 'is-invalid' : '' }}"
                    name="doc"
                    placeholder=""
                    value="{{ old('doc', $firma->doc) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="perioada" class="mb-0 ps-3">Perioada</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('perioada') ? 'is-invalid' : '' }}"
                    name="perioada"
                    placeholder=""
                    value="{{ old('perioada', $firma->perioada) }}">
            </div>
            <div class="col-lg-1 mb-3">
                <label for="actionar" class="mb-0 ps-1">Acționar</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('actionar') ? 'is-invalid' : '' }}"
                    name="actionar"
                    placeholder=""
                    value="{{ old('actionar', $firma->actionar) }}">
            </div>
            <div class="col-lg-1 mb-3">
                <label for="tip" class="mb-0 ps-3">Tip</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('tip') ? 'is-invalid' : '' }}"
                    name="tip"
                    placeholder=""
                    value="{{ old('tip', $firma->tip) }}">
            </div>
            <div class="col-lg-3 mb-3 p-1 d-flex align-items-end justify-content-center">
                <div class="form-check">
                    <input class="form-check-input" type="hidden" name="activa" value="0" />
                    <input class="form-check-input" type="checkbox" value="1" name="activa" id="activa"
                        {{ old('activa', $firma->activa) == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="activa">
                        Activă
                    </label>
                </div>
            </div>
        </div>
        <div class="row mb-2 p-2 rounded-3" style="background-color: rgb(132, 236, 255)">
            <div class="col-lg-2 mb-2">
                <label for="ssm_luna" class="mb-0 ps-3">SSM luna</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('ssm_luna') ? 'is-invalid' : '' }}"
                    name="ssm_luna"
                    placeholder=""
                    value="{{ old('ssm_luna', $firma->ssm_luna) }}">
            </div>
            <div class="col-lg-2 mb-2">
                <label for="psi_luna" class="mb-0 ps-3">PSI luna</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('psi_luna') ? 'is-invalid' : '' }}"
                    name="psi_luna"
                    placeholder=""
                    value="{{ old('psi_luna', $firma->psi_luna) }}">
            </div>
            <div class="col-lg-3 mb-2">
                <label for="ssm_stare_fise" class="mb-0 ps-3">SSM stare fișe</label>
                <select name="ssm_stare_fise" class="form-select bg-white rounded-3 {{ $errors->has('ssm_stare_fise') ? 'is-invalid' : '' }}">
                    <option value='-' selected>-</option>
                    {{-- <option value="noi.p;de s.p" style="color:blueviolet" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi.p;de s.p' ? 'selected' : ''}}>noi.p;de s.p</option> --}}
                    <option value="noi.p;de s" style="color:blueviolet" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi.p;de s' ? 'selected' : ''}}>noi.p;de s</option>
                    <option value="noi;de s" style="color:blueviolet" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi;de s' ? 'selected' : ''}}>noi;de s</option>
                    <option value="noi" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi' ? 'selected' : ''}}>noi</option>
                    {{-- <option value="noi;s" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi;s' ? 'selected' : ''}}>noi;s</option> --}}
                    <option value="noi;s.p" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi;s.p' ? 'selected' : ''}}>noi;s.p</option>
                    {{-- <option value="noi.p;s.p" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi.p;s.p' ? 'selected' : ''}}>noi.p;s.p</option> --}}
                    <option value="noi.part." {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'noi.part.' ? 'selected' : ''}}>noi.part.</option>
                    <option value="comp.la cl." style="color:rgb(0, 145, 77)" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                    <option value="cl;de s" style="color:rgb(0, 96, 175)" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'cl;de s' ? 'selected' : ''}}>cl;de s</option>
                    <option value="cl.p;de s" style="color:rgb(0, 96, 175)" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'cl.p;de s' ? 'selected' : ''}}>cl.p;de s</option>
                    {{-- <option value="Fișe-C" style="color:rgb(0, 96, 175)" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'Fișe-C' ? 'selected' : ''}}>Fișe-C</option> --}}
                    <option value="cl;control" style="color:rgb(0, 96, 175)" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'cl;control' ? 'selected' : ''}}>cl;control</option>
                    <option value="Nu sal." {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'Nu sal.' ? 'selected' : ''}}>Nu sal.</option>
                    {{-- <option value="Activ.susp" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'Activ.susp' ? 'selected' : ''}}>Activ.susp</option> --}}
                    {{-- <option value="Firma inchisa" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'Firma inchisa' ? 'selected' : ''}}>Firma inchisa</option> --}}
                    <option value="de adus" style="color:rgb(204, 0, 0)" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'de adus' ? 'selected' : ''}}>de adus</option>
                    {{-- <option value="La anulate" style="color:rgb(94, 94, 94)" {{ old('ssm_stare_fise', $firma->ssm_stare_fise) === 'La anulate' ? 'selected' : ''}}>La anulate</option> --}}
                    @if (
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== '-') &&
                        // (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi.p;de s.p') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi.p;de s') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi;de s') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi') &&
                        // (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi;s') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi;s.p') &&
                        // (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi.p;s.p') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'noi.part.') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'comp.la cl.') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'cl;de s') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'cl.p;de s') &&
                        // (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'Fișe-C') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'cl;control') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'Nu sal.') &&
                        // (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'Activ.susp') &&
                        // (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'Firma inchisa') &&
                        (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'de adus')
                        // (old('ssm_stare_fise', $firma->ssm_stare_fise) !== 'La anulate')
                        )
                        <option value="{{ $firma->ssm_stare_fise }}" {{ (old('ssm_stare_fise', $firma->ssm_stare_fise) === $firma->ssm_stare_fise) ? 'selected' : ''}}>{{ $firma->ssm_stare_fise }}</option>
                    @endif
                </select>
            </div>
            <div class="col-lg-3 mb-2">
                <label for="psi_stare_fise" class="mb-0 ps-3">PSI stare fișe</label>
                <select name="psi_stare_fise" class="form-select bg-white rounded-3 {{ $errors->has('psi_stare_fise') ? 'is-invalid' : '' }}">
                    <option value='-' selected>-</option>
                    {{-- <option value="noi.p;de s.p" style="color:blueviolet" style="" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi.p;de s.p' ? 'selected' : ''}}>noi.p;de s.p</option> --}}
                    <option value="noi.p;de s" style="color:blueviolet" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi.p;de s' ? 'selected' : ''}}>noi.p;de s</option>
                    <option value="noi;de s" style="color:blueviolet" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi;de s' ? 'selected' : ''}}>noi;de s</option>
                    <option value="noi" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi' ? 'selected' : ''}}>noi</option>
                    {{-- <option value="noi;s" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi;s' ? 'selected' : ''}}>noi;s</option> --}}
                    <option value="noi;s.p" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi;s.p' ? 'selected' : ''}}>noi;s.p</option>
                    {{-- <option value="noi.p;s.p" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi.p;s.p' ? 'selected' : ''}}>noi.p;s.p</option> --}}
                    <option value="noi.part." {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'noi.part.' ? 'selected' : ''}}>noi.part.</option>
                    <option value="comp.la cl." style="color:rgb(0, 145, 77)" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                    <option value="cl;de s" style="color:rgb(0, 96, 175)" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'cl;de s' ? 'selected' : ''}}>cl;de s</option>
                    <option value="cl.p;de s" style="color:rgb(0, 96, 175)" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'cl.p;de s' ? 'selected' : ''}}>cl.p;de s</option>
                    {{-- <option value="Fișe-C" style="color:rgb(0, 96, 175)" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'Fișe-C' ? 'selected' : ''}}>Fișe-C</option> --}}
                    <option value="cl;control" style="color:rgb(0, 96, 175)" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'cl;control' ? 'selected' : ''}}>cl;control</option>
                    <option value="Nu sal." {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'Nu sal.' ? 'selected' : ''}}>Nu sal.</option>
                    {{-- <option value="Activ.susp" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'Activ.susp' ? 'selected' : ''}}>Activ.susp</option> --}}
                    {{-- <option value="Firma inchisa" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'Firma inchisa' ? 'selected' : ''}}>Firma inchisa</option> --}}
                    <option value="de adus" style="color:rgb(204, 0, 0)" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'de adus' ? 'selected' : ''}}>de adus</option>
                    {{-- <option value="La anulate" style="color:rgb(94, 94, 94)" {{ old('psi_stare_fise', $firma->psi_stare_fise) === 'La anulate' ? 'selected' : ''}}>La anulate</option> --}}
                    @if (
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== '-') &&
                        // (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi.p;de s.p') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi.p;de s') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi;de s') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi') &&
                        // (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi;s') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi;s.p') &&
                        // (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi.p;s.p') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'noi.part.') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'comp.la cl.') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'cl;de s') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'cl.p;de s') &&
                        // (old('psi_stare_fise', $firma->psi_stare_fise) !== 'Fișe-C') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'cl;control') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'Nu sal.') &&
                        // (old('psi_stare_fise', $firma->psi_stare_fise) !== 'Activ.susp') &&
                        // (old('psi_stare_fise', $firma->psi_stare_fise) !== 'Firma inchisa') &&
                        (old('psi_stare_fise', $firma->psi_stare_fise) !== 'de adus')
                        // (old('psi_stare_fise', $firma->psi_stare_fise) !== 'La anulate')
                        )
                        <option value="{{ $firma->psi_stare_fise }}" {{ (old('psi_stare_fise', $firma->psi_stare_fise) === $firma->psi_stare_fise) ? 'selected' : ''}}>{{ $firma->psi_stare_fise }}</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-3 mb-3">
                <label for="administrator" class="mb-0 ps-3">Administrator</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('administrator') ? 'is-invalid' : '' }}"
                    name="administrator"
                    placeholder=""
                    value="{{ old('administrator', $firma->administrator) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="persoana_desemnata" class="mb-0 ps-3">Persoana desemnată</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('persoana_desemnata') ? 'is-invalid' : '' }}"
                    name="persoana_desemnata"
                    placeholder=""
                    value="{{ old('persoana_desemnata', $firma->persoana_desemnata) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="traseu" class="mb-0 ps-3">Traseu</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('traseu') ? 'is-invalid' : '' }}"
                    name="traseu"
                    placeholder=""
                    value="{{ old('traseu', $firma->traseu) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="domeniu_de_activitate" class="mb-0 ps-3">Dom. activitate</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('domeniu_de_activitate') ? 'is-invalid' : '' }}"
                    name="domeniu_de_activitate"
                    placeholder=""
                    value="{{ old('domeniu_de_activitate', $firma->domeniu_de_activitate) }}">
            </div>
        </div>
        {{-- <div class="row mb-2">
            <div class="col-lg-2 mb-3">
                <label for="pram_zi" class="mb-0 ps-3">Pram ZI</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('pram_zi') ? 'is-invalid' : '' }}"
                    name="pram_zi"
                    placeholder=""
                    value="{{ old('pram_zi', $firma->pram_zi) }}">
            </div>
            <div class="col-lg-2 mb-3">
                <label for="pram_luna" class="mb-0 ps-3">Pram LUNA</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('pram_luna') ? 'is-invalid' : '' }}"
                    name="pram_luna"
                    placeholder=""
                    value="{{ old('pram_luna', $firma->pram_luna) }}">
            </div>
            <div class="col-lg-2 mb-3">
                <label for="pram_an" class="mb-0 ps-3">Pram AN</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('pram_an') ? 'is-invalid' : '' }}"
                    name="pram_an"
                    placeholder=""
                    value="{{ old('pram_an', $firma->pram_an) }}">
            </div>
        </div> --}}
        <div class="row mb-2">
            <div class="col-lg-3 mb-3">
                <label for="pram" class="mb-0 ps-3">Pram</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('pram') ? 'is-invalid' : '' }}"
                    name="pram"
                    placeholder=""
                    value="{{ old('pram', $firma->pram) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="contract_firma" class="mb-0 ps-3">Contract firma</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('contract_firma') ? 'is-invalid' : '' }}"
                    name="contract_firma"
                    placeholder=""
                    value="{{ old('contract_firma', $firma->contract_firma) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="contract_numar" class="mb-0 ps-3">Contract număr</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('contract_numar') ? 'is-invalid' : '' }}"
                    name="contract_numar"
                    placeholder=""
                    value="{{ old('contract_numar', $firma->contract_numar) }}">
            </div>
            <div class="col-lg-3 mb-3 p-1 d-flex align-items-end justify-content-center">
                <div class="form-check">
                    <input class="form-check-input" type="hidden" name="contract_semnat" value="0" />
                    <input class="form-check-input" type="checkbox" value="1" name="contract_semnat" id="contract_semnat"
                        {{ old('contract_semnat', $firma->contract_semnat) == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="contract_semnat">
                        Contract semnat
                    </label>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-3 mb-3">
                <label for="observatii_1" class="mb-0 ps-3">Tarif</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('observatii_1') ? 'is-invalid' : '' }}"
                    name="observatii_1"
                    placeholder=""
                    value="{{ old('observatii_1', $firma->observatii_1) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="observatii_2" class="mb-0 ps-3">Mail</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('observatii_2') ? 'is-invalid' : '' }}"
                    name="observatii_2"
                    placeholder=""
                    value="{{ old('observatii_2', $firma->observatii_2) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="observatii_3" class="mb-0 ps-3">Telefon</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('observatii_3') ? 'is-invalid' : '' }}"
                    name="observatii_3"
                    placeholder=""
                    value="{{ old('observatii_3', $firma->observatii_3) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="observatii_4" class="mb-0 ps-3">Observații</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('observatii_4') ? 'is-invalid' : '' }}"
                    name="observatii_4"
                    placeholder=""
                    value="{{ old('observatii_4', $firma->observatii_4) }}">
            </div>

            {{-- <div class="col-lg-6 mb-5 mx-auto">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="2">{{ old('observatii', $firma->observatii) }}</textarea>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('firma_return_url') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
