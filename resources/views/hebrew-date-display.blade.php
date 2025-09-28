@php
    $locale = $getLocale();
    $hebrewText = $getHebrewDateText();
    $showGregorian = $getShowGregorianDate();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        {{
            $attributes
                ->merge($getExtraAttributes(), escape: false)
                ->class([
                    'fi-fo-hebrew-date-display',
                    'text-right' => $locale === 'he',
                    'text-left' => $locale !== 'he',
                ])
        }}
    >
        @if($hebrewText)
            <div
                @class([
                    'hebrew-date-text text-sm text-gray-950 dark:text-white',
                    'font-hebrew' => $locale === 'he',
                ])
                dir="{{ $locale === 'he' ? 'rtl' : 'ltr' }}"
            >
                {{ $hebrewText }}
            </div>
        @else
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $locale === 'he' ? 'אין תאריך' : 'No date' }}
            </div>
        @endif
    </div>
</x-dynamic-component>

<style>
.font-hebrew {
    font-family: 'Segoe UI', 'Arial Hebrew', 'David', 'Times New Roman', serif;
    font-weight: 400;
}

.fi-fo-hebrew-date-display {
    min-height: 1.5rem;
    display: flex;
    align-items: center;
}

.hebrew-date-text {
    line-height: 1.5;
}

/* RTL support */
.fi-fo-hebrew-date-display[dir="rtl"] {
    text-align: right;
}

.fi-fo-hebrew-date-display[dir="ltr"] {
    text-align: left;
}
</style>
