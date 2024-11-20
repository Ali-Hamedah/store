@props(['value' => ''])

<div class="date-container" onclick="document.getElementById('birthday').showPicker()">
    <input type="date" class="date mt-1 block w-full" id="birthday" name="birthday"
        max="{{ now()->subYears(14)->toDateString() }}" value="{{ old('birthday', $value) }}"  style="width: 100%; border-radius: 5px;"  required>
</div>

