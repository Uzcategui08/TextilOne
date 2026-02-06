@props([
    'phone' => null,
    'message' => null,
    'label' => 'WhatsApp',
])

@php
    $settingsPhone = null;
    $settingsMessage = null;
    try {
        $settings = \App\Models\HomeSetting::current();
        $settingsPhone = $settings->phone;
        $settingsMessage = $settings->whatsapp_message;
    } catch (\Throwable $e) {
        $settingsPhone = null;
        $settingsMessage = null;
    }

    $resolvedPhone = $phone ?? $settingsPhone ?? config('services.whatsapp.phone');
    $resolvedMessage = $message ?? $settingsMessage ?? config('services.whatsapp.message');

    $phoneRaw = (string) ($resolvedPhone ?? '');
    $phoneDigits = preg_replace('/\D+/', '', $phoneRaw);

    $messageText = is_null($resolvedMessage) ? '' : (string) $resolvedMessage;

    $href = null;
    if (!empty($phoneDigits)) {
        $href = 'https://wa.me/' . $phoneDigits;
        if ($messageText !== '') {
            $href .= '?text=' . rawurlencode($messageText);
        }
    }
@endphp

@if($href)
    <div class="fixed bottom-4 right-4 z-50" aria-label="{{ $label }}">
        <a
            class="w-14 h-14 rounded-full bg-white text-black border border-black flex items-center justify-center no-underline font-bold text-sm tracking-wide focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
            href="{{ $href }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="{{ $label }}"
            title="{{ $label }}"
        >
            WA
        </a>
    </div>
@endif
