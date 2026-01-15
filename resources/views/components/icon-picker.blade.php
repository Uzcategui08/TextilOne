@props([
    'name',
    'label' => 'Icono',
    'value' => '',
    'id' => null,
    'placeholder' => 'Selecciona un ícono...',
    'help' => null,
    'errorKey' => null,
])

@php
    $inputId = $id ?: preg_replace('/[^A-Za-z0-9_\-]/', '_', $name);
    $previewId = $inputId . '_preview';
    $icons = config('material-icons.icons', []);
    $errorBagKey = $errorKey ?: $name;
    $hasError = $errors->has($errorBagKey);
@endphp

@once
    @push('css')
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @endpush

    @push('js')
        <script>
            document.addEventListener('input', function (e) {
                const el = e.target;
                if (!el || !el.matches('input[data-icon-picker]')) return;

                const previewId = el.getAttribute('data-preview-id');
                const preview = previewId ? document.getElementById(previewId) : null;
                if (!preview) return;

                // Render icon name as Material Icon glyph
                preview.textContent = el.value || 'help_outline';
            });
        </script>
    @endpush

    <datalist id="material-icons-list">
        @foreach ($icons as $icon)
            <option value="{{ $icon }}"></option>
        @endforeach
    </datalist>
@endonce

<div class="form-group">
    <label for="{{ $inputId }}">{{ $label }}</label>

    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="material-icons" id="{{ $previewId }}">{{ $value ?: 'help_outline' }}</i>
            </span>
        </div>

        <input
            id="{{ $inputId }}"
            type="text"
            name="{{ $name }}"
            value="{{ $value }}"
            list="material-icons-list"
            class="form-control {{ $hasError ? 'is-invalid' : '' }}"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            data-icon-picker
            data-preview-id="{{ $previewId }}"
        >

        @if ($hasError)
            <div class="invalid-feedback">{{ $errors->first($errorBagKey) }}</div>
        @endif
    </div>

    @if ($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
</div>
