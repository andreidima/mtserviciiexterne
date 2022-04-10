@csrf

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="app">
    <div class="col-lg-12 mb-0">

        <div class="row mb-2">
            <div class="col-lg-3 mb-2">
                <label for="nume_client" class="mb-0 ps-3">Nume client<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume_client') ? 'is-invalid' : '' }}"
                    name="nume_client"
                    placeholder=""
                    value="{{ old('nume_client', $salariat->nume_client) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-2">
                <label for="salariat" class="mb-0 ps-3">Salariat<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('salariat') ? 'is-invalid' : '' }}"
                    name="salariat"
                    placeholder=""
                    value="{{ old('salariat', $salariat->salariat) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-2">
                <label for="cnp" class="mb-0 ps-3">CNP</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('cnp') ? 'is-invalid' : '' }}"
                    name="cnp"
                    placeholder=""
                    value="{{ old('cnp', $salariat->cnp) }}"
                    required>
            </div>
            <div class="col-lg-3 mb-2">
                <label for="functia" class="mb-0 ps-3">Funcția</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('functia') ? 'is-invalid' : '' }}"
                    name="functia"
                    placeholder=""
                    value="{{ old('functia', $salariat->functia) }}"
                    required>
            </div>
        </div>
        <div class="row mb-2 p-2 rounded-3" style="background-color: rgb(132, 236, 255)">
            <div class="col-lg-2 mb-2">
                <label for="data_ssm_psi" class="mb-0 ps-3">Data SSM/PSI</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('data_ssm_psi') ? 'is-invalid' : '' }}"
                    name="data_ssm_psi"
                    placeholder=""
                    value="{{ old('data_ssm_psi', $salariat->data_ssm_psi) }}">
            </div>
            <div class="col-lg-2 mb-2">
                <label for="semnat_ssm" class="mb-0 ps-3">Semnat SSM</label>
                <select name="semnat_ssm" class="form-select bg-white rounded-3 {{ $errors->has('semnat_ssm') ? 'is-invalid' : '' }}">
                    <option value='-' selected>-</option>
                    <option value="client" style="color:rgb(0, 140, 255)" {{ old('semnat_ssm', $salariat->semnat_ssm) === 'client' ? 'selected' : ''}}>client</option>
                    <option value="Lipsa" style="color:rgb(255, 0, 0)" {{ old('semnat_ssm', $salariat->semnat_ssm) === 'Lipsa' ? 'selected' : ''}}>Lipsa</option>
                    <option value="comp.la cl." style="color:rgb(0, 180, 75)" {{ old('semnat_ssm', $salariat->semnat_ssm) === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                    <option value="n.de s" style="color:blueviolet" {{ old('semnat_ssm', $salariat->semnat_ssm) === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                    <option value="noi s." style="" {{ old('semnat_ssm', $salariat->semnat_ssm) === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                    <option value="noi s." style="" {{ old('semnat_ssm', $salariat->semnat_ssm) === 'noi' ? 'selected' : ''}}>noi</option>
                    @if (
                        (old('semnat_ssm', $salariat->semnat_ssm) !== '-') &&
                        (old('semnat_ssm', $salariat->semnat_ssm) !== 'client') &&
                        (old('semnat_ssm', $salariat->semnat_ssm) !== 'Lipsa') &&
                        (old('semnat_ssm', $salariat->semnat_ssm) !== 'comp.la cl.') &&
                        (old('semnat_ssm', $salariat->semnat_ssm) !== 'n.de s') &&
                        (old('semnat_ssm', $salariat->semnat_ssm) !== 'noi s.') &&
                        (old('semnat_ssm', $salariat->semnat_ssm) !== 'noi')
                        )
                        <option value="{{ $salariat->semnat_ssm }}" {{ (old('semnat_ssm', $salariat->semnat_ssm) === $salariat->semnat_ssm) ? 'selected' : ''}}>{{ $salariat->semnat_ssm }}</option>
                    @endif
                </select>
            </div>
            <div class="col-lg-2 mb-2">
                <label for="semnat_psi" class="mb-0 ps-3">Semnat PSI</label>
                <select name="semnat_psi" class="form-select bg-white rounded-3 {{ $errors->has('semnat_psi') ? 'is-invalid' : '' }}">
                    <option value='-' selected>-</option>
                    <option value="client" style="color:rgb(0, 140, 255)" {{ old('semnat_psi', $salariat->semnat_psi) === 'client' ? 'selected' : ''}}>client</option>
                    <option value="Lipsa" style="color:rgb(255, 0, 0)" {{ old('semnat_psi', $salariat->semnat_psi) === 'Lipsa' ? 'selected' : ''}}>Lipsa</option>
                    <option value="comp.la cl." style="color:rgb(0, 180, 75)" {{ old('semnat_psi', $salariat->semnat_psi) === 'comp.la cl.' ? 'selected' : ''}}>comp.la cl.</option>
                    <option value="n.de s" style="color:blueviolet" {{ old('semnat_psi', $salariat->semnat_psi) === 'n.de s' ? 'selected' : ''}}>n. de s</option>
                    <option value="noi s." style="" {{ old('semnat_psi', $salariat->semnat_psi) === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                    <option value="noi s." style="" {{ old('semnat_psi', $salariat->semnat_psi) === 'noi' ? 'selected' : ''}}>noi</option>
                    @if (
                        (old('semnat_psi', $salariat->semnat_psi) !== '-') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'client') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'Lipsa') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'comp.la cl.') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'n.de s') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'noi s.') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'noi')
                        )
                        <option value="{{ $salariat->semnat_psi }}" {{ (old('semnat_psi', $salariat->semnat_psi) === $salariat->semnat_psi) ? 'selected' : ''}}>{{ $salariat->semnat_psi }}</option>
                    @endif
                </select>
            </div>
            <div class="col-lg-2 mb-2">
                <label for="semnat_anexa" class="mb-0 ps-3">Semnat Anexa</label>
                <select name="semnat_anexa" class="form-select bg-white rounded-3 {{ $errors->has('semnat_anexa') ? 'is-invalid' : '' }}">
                    <option value='-' selected>-</option>
                    <option value="sem" style="" {{ old('semnat_anexa', $salariat->semnat_anexa) === 'sem' ? 'selected' : ''}}>sem</option>
                    <option value="de s" style="color:rgb(204, 0, 0)" {{ old('semnat_anexa', $salariat->semnat_anexa) === 'de s' ? 'selected' : ''}}>de s</option>
                    @if (
                        (old('semnat_anexa', $salariat->semnat_anexa) !== '-') &&
                        (old('semnat_anexa', $salariat->semnat_anexa) !== 'sem') &&
                        (old('semnat_anexa', $salariat->semnat_anexa) !== 'de s')
                        )
                        <option value="{{ $salariat->semnat_anexa }}" {{ (old('semnat_anexa', $salariat->semnat_anexa) === $salariat->semnat_anexa) ? 'selected' : ''}}>{{ $salariat->semnat_anexa }}</option>
                    @endif
                </select>
            </div>
            <div class="col-lg-2 mb-2">
                <label for="semnat_eip" class="mb-0 ps-3">Semnat E.I.P.</label>
                <select name="semnat_eip" class="form-select bg-white rounded-3 {{ $errors->has('semnat_eip') ? 'is-invalid' : '' }}">
                    <option value='-' selected>-</option>
                    <option value="sem" style="" {{ old('semnat_eip', $salariat->semnat_eip) === 'sem' ? 'selected' : ''}}>sem</option>
                    <option value="de s" style="color:rgb(204, 0, 0)" {{ old('semnat_eip', $salariat->semnat_eip) === 'de s' ? 'selected' : ''}}>de s</option>
                    @if (
                        (old('semnat_eip', $salariat->semnat_eip) !== '-') &&
                        (old('semnat_eip', $salariat->semnat_eip) !== 'sem') &&
                        (old('semnat_eip', $salariat->semnat_eip) !== 'de s')
                        )
                        <option value="{{ $salariat->semnat_eip }}" {{ (old('semnat_eip', $salariat->semnat_eip) === $salariat->semnat_eip) ? 'selected' : ''}}>{{ $salariat->semnat_eip }}</option>
                    @endif
                </select>
            </div>
            {{-- <div class="col-lg-2 mb-2">
                <label for="semnat_psi" class="mb-0 ps-3">Semnat PSI</label>
                <select name="semnat_psi" class="form-select bg-white rounded-3 {{ $errors->has('semnat_psi') ? 'is-invalid' : '' }}">
                    <option value='-' selected>-</option>
                    <option value="n.de s" style="color:blueviolet" {{ old('semnat_psi', $salariat->semnat_psi) === 'n.de s' ? 'selected' : ''}}>n.de s</option>
                    <option value="noi s." style="" {{ old('semnat_psi', $salariat->semnat_psi) === 'noi s.' ? 'selected' : ''}}>noi s.</option>
                    <option value="cl.de s" style="color:rgb(0, 96, 175)" {{ old('semnat_psi', $salariat->semnat_psi) === 'cl.de s' ? 'selected' : ''}}>cl.de s</option>
                    @if (
                        (old('semnat_psi', $salariat->semnat_psi) !== '-') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'n.de s') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'noi s.') &&
                        (old('semnat_psi', $salariat->semnat_psi) !== 'cl.de s')
                        )
                        <option value="{{ $salariat->semnat_psi }}" {{ (old('semnat_psi', $salariat->semnat_psi) === $salariat->semnat_psi) ? 'selected' : ''}}>{{ $salariat->semnat_psi }}</option>
                    @endif
                </select>
            </div> --}}
        </div>
        <div class="row mb-2">
            <div class="col-lg-2 mb-3">
                <label for="med_muncii_zi" class="mb-0 ps-3">Med. Muncii ZI</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('med_muncii_zi') ? 'is-invalid' : '' }}"
                    name="med_muncii_zi"
                    placeholder=""
                    value="{{ old('med_muncii_zi', $salariat->med_muncii_zi) }}">
            </div>
            <div class="col-lg-2 mb-3">
                <label for="med_muncii_luna" class="mb-0 ps-3">Med. Muncii LUNA</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('med_muncii_luna') ? 'is-invalid' : '' }}"
                    name="med_muncii_luna"
                    placeholder=""
                    value="{{ old('med_muncii_luna', $salariat->med_muncii_luna) }}">
            </div>
            <div class="col-lg-2 mb-3">
                <label for="med_muncii_an" class="mb-0 ps-3">Med. Muncii AN</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('med_muncii_an') ? 'is-invalid' : '' }}"
                    name="med_muncii_an"
                    placeholder=""
                    value="{{ old('med_muncii_an', $salariat->med_muncii_an) }}">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-2 mb-3">
                <label for="actionar" class="mb-0 ps-3">Acționar</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('actionar') ? 'is-invalid' : '' }}"
                    name="actionar"
                    placeholder=""
                    value="{{ old('actionar', $salariat->actionar) }}"
                    required>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="data_angajare" class="mb-0 ps-3">Data angajare</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('data_angajare') ? 'is-invalid' : '' }}"
                    name="data_angajare"
                    placeholder=""
                    value="{{ old('data_angajare', $salariat->data_angajare) }}"
                    required>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="data_incetare" class="mb-0 ps-3">Data încetare</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('data_incetare') ? 'is-invalid' : '' }}"
                    name="data_incetare"
                    placeholder=""
                    value="{{ old('data_incetare', $salariat->data_incetare) }}"
                    required>
            </div>
            <div class="col-lg-2 mb-2">
                <label for="status" class="mb-0 ps-3">Status</label>
                <select name="status" class="form-select bg-white rounded-3 {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <option value="activ" style="" {{ old('status', $salariat->status) === 'activ' ? 'selected' : ''}}>Activ</option>
                    <option value="susp" style="color:blueviolet" {{ old('status', $salariat->status) === 'susp' ? 'selected' : ''}}>Susp</option>
                    <option value="CCC" style="color:rgb(252, 73, 252)" {{ old('status', $salariat->status) === 'CCC' ? 'selected' : ''}}>CCC</option>
                    <option value="incetat" style="color:rgb(207, 153, 2)" {{ old('status', $salariat->status) === 'incetat' ? 'selected' : ''}}>Încetat</option>
                </select>
            </div>
            <div class="col-lg-2 mb-3">
                <label for="traseu" class="mb-0 ps-3">Traseu</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('traseu') ? 'is-invalid' : '' }}"
                    name="traseu"
                    placeholder=""
                    value="{{ old('traseu', $salariat->traseu) }}"
                    required>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-lg-3 mb-3">
                <label for="observatii_1" class="mb-0 ps-3">Observații 1</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('observatii_1') ? 'is-invalid' : '' }}"
                    name="observatii_1"
                    placeholder=""
                    value="{{ old('observatii_1', $salariat->observatii_1) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="observatii_2" class="mb-0 ps-3">Observații 2</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('observatii_2') ? 'is-invalid' : '' }}"
                    name="observatii_2"
                    placeholder=""
                    value="{{ old('observatii_2', $salariat->observatii_2) }}">
            </div>
            <div class="col-lg-3 mb-3">
                <label for="observatii_3" class="mb-0 ps-3">Observații 3</label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('observatii_3') ? 'is-invalid' : '' }}"
                    name="observatii_3"
                    placeholder=""
                    value="{{ old('observatii_3', $salariat->observatii_3) }}">
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-lg btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-lg btn-secondary rounded-3" href="{{ Session::get('salariat_return_url') }}">Renunță</a>
            </div>
        </div>
    </div>
</div>
