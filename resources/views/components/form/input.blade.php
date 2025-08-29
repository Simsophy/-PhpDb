@if($row == 'row')
<div class="form-group row">
    <label for="{{ $name }}" class="col-sm-3 col-form-label">
        {{ $title }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <div class="col-sm-9">
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            class="form-control" 
            @if($required) required @endif 
            @if($disable) disabled @endif
            {{ $slot }}
        >
        @error($name)
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
@else
<div class="form-group">
    <label for="{{ $name }}">
        {{ $title }}
        @if($required) <span class="text-danger">*</span> @endif
    </label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        class="form-control" 
        @if($required) required @endif 
        @if($disable) disabled @endif
        {{ $slot }}
    >
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
@endif
