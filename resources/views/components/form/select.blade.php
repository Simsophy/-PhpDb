@if($row == 'row')
<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-3 col-form-label">
        {{ $title }}
        @if($required === 'required')
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-sm-9">
        <select name="{{ $name }}" id="{{ $name }}" class="form-control" {{ $required }} {{ $disable }}>
            <option value="" disabled {{ $selected ? '' : 'selected' }}>-- Select {{ $title }} --</option>
            @foreach($data as $d)
                <option value="{{ $d->id }}" {{ $d->id == $selected ? 'selected' : '' }}>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>

        {{ $slot }}

        @error($name)
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
@else
<div class="form-group">
    <label for="{{ $name }}">
        {{ $title }}
        @if($required === 'required')
            <span class="text-danger">*</span>
        @endif
    </label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-control" {{ $required }}>
    <option value="">Select {{ $title }}</option>
    @foreach($data as $item)
        <option value="{{ $item->{$optionValue ?? 'id'} }}"
            {{ (isset($selected) && $selected == $item->{$optionValue ?? 'id'}) ? 'selected' : '' }}>
            {{ $item->{$optionLabel ?? 'name'} }}
        </option>
    @endforeach
</select>


    {{ $slot }}

    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
@endif
