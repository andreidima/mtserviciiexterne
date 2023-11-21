@csrf

<script type="application/javascript">
    firme = {!! json_encode($firme) !!}
    firmaIdVechi = {!! json_encode(old('firma_id', ($observatie->firma_id ?? "")) ?? "") !!}
</script>

<div class="row mb-0 p-3 d-flex border-radius: 0px 0px 40px 40px" id="formularObservatii">
    <div class="col-lg-12 mb-0">

        <div class="row mb-0">
            <div class="col-lg-5 mb-5 mx-auto">
                <label for="nume" class="mb-0 ps-3">Nume<span class="text-danger">*</span></label>
                <input
                    type="text"
                    class="form-control bg-white rounded-3 {{ $errors->has('nume') ? 'is-invalid' : '' }}"
                    name="nume"
                    placeholder=""
                    value="{{ old('nume', $observatie->nume) }}"
                    required>
            </div>
            {{-- <div class="col-lg-5 mb-5">
                <label for="firma_id" class="mb-0 ps-3">Firma<span class="text-danger">*</span></label>
                <select name="firma_id"
                    class="form-select bg-white rounded-3 {{ $errors->has('firma_id') ? 'is-invalid' : '' }}"
                >
                        <option value='' selected>Selectează</option>
                    @foreach ($firme as $firma)
                        <option
                            value='{{ $firma->id }}'
                            {{ ($firma->id == old('firma_id', ($observatie->firma->id ?? ''))) ? 'selected' : '' }}
                        >{{ $firma->nume }} </option>
                    @endforeach
                </select>
            </div> --}}
            <div class="col-lg-5 mb-4" style="position:relative;" v-click-outside="golesteFirmeListaAutocomplete">
                <label for="firma_id" class="mb-0 ps-3">Firma<span class="text-danger">*</span></label>
                <input
                    type="hidden"
                    v-model="firmaId"
                    name="firma_id">

                <div class="input-group">
                    <div class="input-group-prepend d-flex align-items-center">
                        <div v-if="!firmaId" class="input-group-text" id="firmaNume">?</div>
                        <div v-if="firmaId" class="input-group-text p-2 bg-success text-white" id="firmaNume"><i class="fas fa-check" style="height:100%"></i></div>
                    </div>
                    <input
                        type="text"
                        v-model="firmaNume"
                        v-on:focus="autocompleteFirme();"
                        v-on:keyup="autocompleteFirme(); this.firmaId = '';"
                        class="form-control bg-white rounded-3 {{ $errors->has('firma_id') ? 'is-invalid' : '' }}"
                        {{-- name="firmaNume" --}}
                        placeholder=""
                        autocomplete="off"
                        aria-describedby="firmaNume"
                        required>
                    <div class="input-group-prepend d-flex align-items-center">
                        <div v-if="firmaId" class="input-group-text p-2 text-danger" id="firmaNume" v-on:click="firmaId = null; firmaNume = ''"><i class="fas fa-times"></i></div>
                    </div>
                </div>
                <div v-cloak v-if="firmeListaAutocomplete && firmeListaAutocomplete.length" class="panel-footer" style="width:100%; position:absolute; z-index: 1000;">
                    <div class="list-group" style="max-height: 218px; overflow:auto;">
                        <button class="list-group-item list-group-item-action py-0"
                            v-for="firma in firmeListaAutocomplete"
                            v-on:click="
                                firmaId = firma.id;
                                firmaNume = firma.nume;

                                firmeListaAutocomplete = ''
                            ">
                                @{{ firma.nume }}
                        </button>
                    </div>
                </div>
                <small v-if="!firmaId" class="ps-3">*Selectați o firmă</small>
                <small v-else class="ps-3 text-success">*Ați selectat firma</small>
            </div>
            <div class="col-lg-2 mb-5">
                <label for="data" class="mb-0 ps-3 pe-3">Data</label>
                <vue2-datepicker
                    data-veche="{{ old('data', ($observatie->data ?? '')) }}"
                    nume-camp-db="data"
                    tip="date"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    :latime="{ width: '125px' }"
                ></vue2-datepicker>
            </div>
            <div class="col-lg-12 mb-5">
                <label for="file" class="form-label mb-0 ps-3">Adaugă poze</label>
                <input type="file" accept="image/*" name="poze[]" class="form-control rounded-3" multiple>
                @if($errors->has('poze'))
                <span class="help-block text-danger">{{ $errors->first('poze') }}</span>
                @endif
            </div>
            <div class="col-lg-6 mb-5 mx-auto">
                <label for="descriere" class="form-label mb-0 ps-3">Descriere</label>
                <textarea class="form-control bg-white {{ $errors->has('descriere') ? 'is-invalid' : '' }}"
                    name="descriere" rows="3">{{ old('descriere', $observatie->descriere) }}</textarea>
            </div>
            <div class="col-lg-6 mb-5">
                <label for="observatii" class="form-label mb-0 ps-3">Observații</label>
                <textarea class="form-control bg-white {{ $errors->has('observatii') ? 'is-invalid' : '' }}"
                    name="observatii" rows="3">{{ old('observatii', $observatie->observatii) }}</textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-2 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary text-white me-3 rounded-3">{{ $buttonText }}</button>
                <a class="btn btn-secondary rounded-3" href="/observatii">Renunță</a>
            </div>
        </div>
    </div>
</div>
