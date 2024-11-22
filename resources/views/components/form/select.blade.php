@props([
   'name', 'selected' => '', 'label' => false, 'options'
])

@if($label)
<label for="">{{ $label }}</label>
@endif

<select 
style="width: 100%; border-radius: 5px;" 
    name="{{ $name }}"
    {{ $attributes->class([
        'form-control',
        'form-select',
        'is-invalid' => $errors->has($name)
    ]) }}
>
    @foreach($options as $value => $text)
    <option value="{{ $value }}" @selected($value == $selected)>{{ $text }}</option>
    @endforeach
        </select>