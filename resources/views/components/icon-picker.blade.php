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

        <style>
            .icon-picker-modal[hidden] { display: none; }
            .icon-picker-modal {
                position: fixed;
                inset: 0;
                z-index: 20000;
                background: rgba(0,0,0,0.55);
                display: grid;
                place-items: center;
                padding: 16px;
            }
            .icon-picker-dialog {
                width: min(920px, 96vw);
                max-height: min(80vh, 720px);
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 18px 60px rgba(0,0,0,0.35);
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }
            .icon-picker-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 12px 14px;
                border-bottom: 1px solid rgba(0,0,0,0.08);
            }
            .icon-picker-header strong { font-weight: 700; }
            .icon-picker-close {
                background: transparent;
                border: 0;
                cursor: pointer;
                padding: 4px;
                line-height: 0;
                color: #111;
            }
            .icon-picker-search {
                padding: 10px 14px;
                border-bottom: 1px solid rgba(0,0,0,0.08);
            }
            .icon-picker-search input {
                width: 100%;
                border: 1px solid rgba(0,0,0,0.2);
                border-radius: 8px;
                padding: 10px 12px;
                outline: none;
            }
            .icon-picker-grid {
                padding: 12px;
                overflow: auto;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 10px;
            }
            .icon-picker-item {
                border: 1px solid rgba(0,0,0,0.10);
                background: #fff;
                border-radius: 10px;
                padding: 10px;
                cursor: pointer;
                text-align: left;
                display: flex;
                align-items: center;
                gap: 10px;
                transition: transform 0.12s ease, box-shadow 0.12s ease, border-color 0.12s ease;
            }
            .icon-picker-item:hover {
                transform: translateY(-1px);
                border-color: rgba(0,0,0,0.18);
                box-shadow: 0 10px 20px rgba(0,0,0,0.12);
            }
            .icon-picker-item .material-icons { font-size: 22px; }
            .icon-picker-item span {
                font-size: 12px;
                color: #111;
                word-break: break-word;
            }
        </style>
    @endpush

    @push('js')
        <script>
            window.__materialIcons = window.__materialIcons || @json($icons);

            document.addEventListener('input', function (e) {
                const el = e.target;
                if (!el || !el.matches('input[data-icon-picker]')) return;

                const previewId = el.getAttribute('data-preview-id');
                const preview = previewId ? document.getElementById(previewId) : null;
                if (!preview) return;

                // Render icon name as Material Icon glyph
                preview.textContent = el.value || 'help_outline';
            });

            (function () {
                const modal = document.getElementById('iconPickerModal');
                const grid = document.getElementById('iconPickerGrid');
                const search = document.getElementById('iconPickerSearch');
                const closeBtn = document.getElementById('iconPickerClose');

                if (!modal || !grid || !search) return;

                const icons = Array.isArray(window.__materialIcons) ? window.__materialIcons : [];
                let activeInput = null;

                function render(filter) {
                    const q = (filter || '').trim().toLowerCase();
                    const list = q ? icons.filter(i => String(i).toLowerCase().includes(q)) : icons;

                    grid.innerHTML = '';

                    const max = 240;
                    for (let i = 0; i < list.length && i < max; i++) {
                        const name = String(list[i]);
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'icon-picker-item';
                        btn.setAttribute('data-icon-item', '1');
                        btn.setAttribute('data-icon', name);
                        btn.innerHTML = '<i class="material-icons">' + name + '</i><span>' + name + '</span>';
                        grid.appendChild(btn);
                    }
                }

                function open(forInput) {
                    activeInput = forInput;
                    modal.hidden = false;
                    search.value = '';
                    render('');
                    setTimeout(() => search.focus(), 0);
                }

                function close() {
                    modal.hidden = true;
                    activeInput = null;
                }

                document.addEventListener('click', function (e) {
                    const browse = e.target.closest('[data-icon-browse]');
                    if (browse) {
                        const inputId = browse.getAttribute('data-input-id');
                        const input = inputId ? document.getElementById(inputId) : null;
                        if (input) open(input);
                        return;
                    }

                    if (e.target === modal) {
                        close();
                        return;
                    }

                    const item = e.target.closest('[data-icon-item]');
                    if (item && activeInput) {
                        const iconName = item.getAttribute('data-icon') || '';
                        activeInput.value = iconName;
                        activeInput.dispatchEvent(new Event('input', { bubbles: true }));
                        close();
                        return;
                    }
                });

                if (closeBtn) {
                    closeBtn.addEventListener('click', close);
                }

                document.addEventListener('keydown', function (e) {
                    if (!modal.hidden && e.key === 'Escape') close();
                });

                search.addEventListener('input', function () {
                    render(search.value);
                });
            })();
        </script>
    @endpush

    <datalist id="material-icons-list">
        @foreach ($icons as $icon)
            <option value="{{ $icon }}"></option>
        @endforeach
    </datalist>

    <div id="iconPickerModal" class="icon-picker-modal" hidden>
        <div class="icon-picker-dialog" role="dialog" aria-modal="true" aria-label="Seleccionar ícono">
            <div class="icon-picker-header">
                <strong>Seleccionar ícono</strong>
                <button id="iconPickerClose" type="button" class="icon-picker-close" aria-label="Cerrar">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <div class="icon-picker-search">
                <input id="iconPickerSearch" type="text" placeholder="Buscar ícono... (ej: local_shipping, palette, verified)" autocomplete="off">
            </div>
            <div id="iconPickerGrid" class="icon-picker-grid"></div>
        </div>
    </div>
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

        <div class="input-group-append">
            <button
                class="btn btn-outline-secondary"
                type="button"
                data-icon-browse
                data-input-id="{{ $inputId }}"
                aria-label="Ver iconos">
                <i class="material-icons">apps</i>
            </button>
        </div>

        @if ($hasError)
            <div class="invalid-feedback">{{ $errors->first($errorBagKey) }}</div>
        @endif
    </div>

    @if ($help)
        <small class="form-text text-muted">{{ $help }}</small>
    @endif
</div>
