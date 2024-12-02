<div>
    <div>
        @foreach ($variants as $index => $variant)
          
                <div class="col-md-3">
                    <select wire:model="variants.{{ $index }}.size" class="form-select">
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select wire:model="variants.{{ $index }}.color" class="form-select">
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" wire:model="variants.{{ $index }}.quantity" class="form-control" placeholder="العدد" min="1">
                </div>
                <div class="col-md-3">
                    <button type="button" wire:click="removeVariant({{ $index }})" class="btn btn-danger">حذف</button>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" wire:click="addVariant" class="btn btn-primary">إضافة</button>
    <button type="button" wire:click="save" class="btn btn-primary">حفظ</button>
</div>
