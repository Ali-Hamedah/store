<div>
    <!-- اختيار اللون -->
    <select wire:model="colorId">
        <option value="">اختار اللون</option>
        @foreach($colors as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
        @endforeach
    </select>

    <!-- اختيار المقاس -->
    <select wire:model="sizeId">
        <option value="">اختار المقاس</option>
        @foreach($sizes as $id => $size)
            <option value="{{ $id }}">{{ $size }}</option>
        @endforeach
    </select>
</div>
