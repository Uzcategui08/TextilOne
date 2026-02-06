@props([
    'phone' => null,
    'message' => null,
    'label' => 'WhatsApp',
])

@php
    $settingsPhone = null;
    $settingsMessage = null;
    $settingsCtaUrl = null;
    $settingsCtaDropdownItems = null;
    try {
        $settings = \App\Models\HomeSetting::current();
        $settingsPhone = $settings->phone;
        $settingsMessage = $settings->whatsapp_message;
        $settingsCtaUrl = $settings->cta_url;
        $settingsCtaDropdownItems = $settings->cta_dropdown_items;
    } catch (\Throwable $e) {
        $settingsPhone = null;
        $settingsMessage = null;
        $settingsCtaUrl = null;
        $settingsCtaDropdownItems = null;
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
    } else {
        $candidateUrls = [];

        if (is_string($settingsCtaUrl) && trim($settingsCtaUrl) !== '') {
            $candidateUrls[] = trim($settingsCtaUrl);
        }

        if (is_array($settingsCtaDropdownItems)) {
            foreach ($settingsCtaDropdownItems as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $url = isset($item['url']) ? trim((string) $item['url']) : '';
                if ($url !== '') {
                    $candidateUrls[] = $url;
                }
            }
        }

        foreach ($candidateUrls as $url) {
            $urlLower = mb_strtolower($url);
            $isWhatsapp = str_contains($urlLower, 'wa.me/')
                || str_contains($urlLower, 'api.whatsapp.com/')
                || str_starts_with($urlLower, 'whatsapp://');

            if (!$isWhatsapp) {
                continue;
            }

            $href = $url;
            break;
        }

        if ($href && $messageText !== '' && !str_contains(mb_strtolower($href), 'text=')) {
            $href .= (str_contains($href, '?') ? '&' : '?') . 'text=' . rawurlencode($messageText);
        }
    }
@endphp

@if($href)
    <div
        class="fixed bottom-4 right-4 z-50"
        style="position: fixed; right: 16px; bottom: 16px; z-index: 9999;"
        aria-label="{{ $label }}"
    >
        <a
            class="w-14 h-14 rounded-full bg-white text-black border border-black flex items-center justify-center no-underline font-bold text-sm tracking-wide focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
            style="width: 56px; height: 56px; border-radius: 9999px; background: #25D366; color: #ffffff; border: 1px solid rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 700; font-size: 14px; line-height: 1; letter-spacing: 0.5px;"
            href="{{ $href }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="{{ $label }}"
            title="{{ $label }}"
        >
            <svg
                width="26"
                height="26"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
                focusable="false"
            >
                <path
                    d="M20.4 3.6C18.1 1.3 15.2 0 12 0C5.4 0 0 5.4 0 12c0 2.1.6 4.2 1.7 6L0 24l6.2-1.6c1.8 1 3.8 1.6 5.8 1.6c6.6 0 12-5.4 12-12c0-3.2-1.3-6.1-3.6-8.4ZM12 21.8c-1.9 0-3.7-.5-5.3-1.5l-.4-.2-3.7 1 1-3.6-.2-.4C2.5 15.6 2 13.8 2 12C2 6.5 6.5 2 12 2c2.6 0 5 .9 6.9 2.9C20.8 6.8 22 9.3 22 12c0 5.5-4.5 9.8-10 9.8Z"
                    fill="currentColor"
                    opacity="0.95"
                />
                <path
                    d="M17.3 14.5c-.3-.2-1.8-.9-2.1-1s-.5-.2-.7.2c-.2.3-.8 1-.9 1.2c-.2.2-.3.2-.6.1c-.3-.2-1.2-.4-2.2-1.3c-.8-.7-1.3-1.6-1.5-1.9c-.2-.3 0-.4.1-.6c.1-.1.3-.3.4-.5c.1-.2.2-.3.3-.5c.1-.2 0-.4 0-.6c0-.2-.7-1.7-1-2.3c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4c-.3.3-1.2 1.1-1.2 2.8s1.2 3.2 1.4 3.4c.2.2 2.3 3.5 5.6 4.9c.8.3 1.4.5 1.9.6c.8.2 1.6.2 2.2.1c.7-.1 1.8-.7 2-1.4c.2-.7.2-1.3.2-1.4c-.1-.1-.3-.2-.6-.3Z"
                    fill="currentColor"
                />
            </svg>
        </a>
    </div>
@endif
