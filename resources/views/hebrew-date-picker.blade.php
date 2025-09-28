@php
    use Filament\Support\Facades\FilamentView;

    $datalistOptions = $getDatalistOptions();
    $extraAlpineAttributes = $getExtraAlpineAttributes();
    $hasTime = $getHasTime();
    $id = $getId();
    $isDisabled = $isDisabled();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $maxDate = $getMaxDate();
    $minDate = $getMinDate();
    $prefixActions = $getPrefixActions();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
    $locale = $getLocale();
    $placeholder = $getPlaceholder();
    $disabledDates = $getDisabledDates();
    $closeOnDateSelection = $getCloseOnDateSelection();
    $firstDayOfWeek = $getFirstDayOfWeek();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :inline-label-vertical-alignment="\Filament\Support\Enums\VerticalAlignment::Center"
>
    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :prefix-icon-color="$getPrefixIconColor()"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :suffix-icon-color="$getSuffixIconColor()"
        :valid="! $errors->has($statePath)"
        :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())"
    >
        <div
            x-ignore
            @if (FilamentView::hasSpaMode())
                {{-- format-ignore-start --}}ax-load="visible || event (ax-modal-opened)"{{-- format-ignore-end --}}
            @else
                ax-load
            @endif
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('hebrew-date-picker', 'hebrew-date-picker') }}"
            x-data="hebrewDatePickerFormComponent({
                        locale: @js($locale),
                        isAutofocused: @js($isAutofocused()),
                        shouldCloseOnDateSelection: @js($closeOnDateSelection),
                        state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
                        firstDayOfWeek: @js($firstDayOfWeek),
                        hasTime: @js($hasTime),
                        hasSeconds: @js($getHasSeconds()),
                    })"
            x-on:keydown.esc="isOpen() && $event.stopPropagation()"
            {{
                $attributes
                    ->merge($getExtraAttributes(), escape: false)
                    ->merge($getExtraAlpineAttributes(), escape: false)
                    ->class(['fi-fo-hebrew-date-picker'])
            }}
        >
            <input x-ref="maxDate" type="hidden" value="{{ $maxDate }}" />
            <input x-ref="minDate" type="hidden" value="{{ $minDate }}" />
            <input
                x-ref="disabledDates"
                type="hidden"
                value="{{ json_encode($disabledDates) }}"
            />

            <button
                x-ref="button"
                x-on:click="togglePanelVisibility()"
                x-on:keydown.enter.stop.prevent="
                    if (! $el.disabled) {
                        isOpen() ? selectDate() : togglePanelVisibility()
                    }
                "
                x-on:keydown.arrow-left.stop.prevent="if (! $el.disabled) focusPreviousDay()"
                x-on:keydown.arrow-right.stop.prevent="if (! $el.disabled) focusNextDay()"
                x-on:keydown.arrow-up.stop.prevent="if (! $el.disabled) focusPreviousWeek()"
                x-on:keydown.arrow-down.stop.prevent="if (! $el.disabled) focusNextWeek()"
                x-on:keydown.backspace.stop.prevent="if (! $el.disabled) clearState()"
                x-on:keydown.clear.stop.prevent="if (! $el.disabled) clearState()"
                x-on:keydown.delete.stop.prevent="if (! $el.disabled) clearState()"
                aria-label="{{ $placeholder }}"
                type="button"
                tabindex="-1"
                @disabled($isDisabled || $isReadOnly())
                {{
                    $getExtraTriggerAttributeBag()->class([
                        'w-full',
                    ])
                }}
            >
                <input
                    @disabled($isDisabled)
                    readonly
                    placeholder="{{ $placeholder }}"
                    wire:key="{{ $this->getId() }}.{{ $statePath }}.{{ $field::class }}.display-text"
                    x-model="displayText"
                    @if ($id = $getId()) id="{{ $id }}" @endif
                    @class([
                        'fi-fo-hebrew-date-picker-display-text-input w-full border-none bg-transparent px-3 py-1.5 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] sm:text-sm sm:leading-6',
                        'text-right' => $locale === 'he',
                    ])
                />
            </button>

            <div
                x-ref="panel"
                x-cloak
                x-float.placement.bottom-start.offset.flip.shift="{ offset: 8 }"
                wire:ignore
                wire:key="{{ $this->getId() }}.{{ $statePath }}.{{ $field::class }}.panel"
                @class([
                    'fi-fo-hebrew-date-picker-panel absolute z-10 rounded-lg bg-white p-4 shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10',
                    'min-w-[280px]' => $locale === 'he',
                ])
            >
                <div class="grid gap-y-3">
                    {{-- Header with month/year selectors --}}
                    <div class="flex items-center justify-between" :class="{ 'flex-row-reverse': locale === 'he' }">
                        <select
                            x-model="focusedMonth"
                            class="grow cursor-pointer border-none bg-transparent p-0 text-sm font-medium text-gray-950 focus:ring-0 dark:bg-gray-900 dark:text-white"
                            :class="{ 'text-right': locale === 'he' }"
                        >
                            <template x-for="(month, index) in hebrewMonths">
                                <option
                                    x-bind:value="index + 1"
                                    x-text="month"
                                ></option>
                            </template>
                        </select>

                        <input
                            type="number"
                            inputmode="numeric"
                            x-model.debounce="focusedYear"
                            class="w-20 border-none bg-transparent p-0 text-sm text-gray-950 focus:ring-0 dark:text-white"
                            :class="{ 'text-right': locale === 'he', 'text-left': locale !== 'he' }"
                        />
                    </div>

                    {{-- Day labels --}}
                    <div class="grid grid-cols-7 gap-1" :class="{ 'direction-rtl': locale === 'he' }">
                        <template x-for="(day, index) in dayLabels" x-bind:key="index">
                            <div
                                x-text="day"
                                class="text-center text-xs font-medium text-gray-500 dark:text-gray-400"
                            ></div>
                        </template>
                    </div>

                    {{-- Calendar grid --}}
                    <div
                        role="grid"
                        class="grid grid-cols-[repeat(7,minmax(theme(spacing.7),1fr))] gap-1"
                        :class="{ 'direction-rtl': locale === 'he' }"
                    >
                        {{-- Empty days --}}
                        <template x-for="day in emptyDaysInFocusedMonth" x-bind:key="'empty-' + day">
                            <div></div>
                        </template>

                        {{-- Calendar days --}}
                        <template x-for="day in daysInFocusedMonth" x-bind:key="'day-' + day">
                            <div
                                x-text="day"
                                x-on:click="dayIsDisabled(day) || selectDate(day)"
                                x-on:mouseenter="setFocusedDay(day)"
                                role="option"
                                x-bind:aria-selected="focusedDate && focusedDate.getDate() === day"
                                x-bind:class="{
                                    'text-gray-950 dark:text-white': ! dayIsToday(day) && ! dayIsSelected(day),
                                    'cursor-pointer': ! dayIsDisabled(day),
                                    'text-primary-600 dark:text-primary-400':
                                        dayIsToday(day) &&
                                        ! dayIsSelected(day) &&
                                        (! focusedDate || focusedDate.getDate() !== day) &&
                                        ! dayIsDisabled(day),
                                    'bg-gray-50 dark:bg-white/5':
                                        focusedDate && focusedDate.getDate() === day &&
                                        ! dayIsSelected(day) &&
                                        ! dayIsDisabled(day),
                                    'text-primary-600 bg-gray-50 dark:bg-white/5 dark:text-primary-400':
                                        dayIsSelected(day),
                                    'pointer-events-none': dayIsDisabled(day),
                                    'opacity-50': dayIsDisabled(day),
                                }"
                                class="rounded-full text-center text-sm leading-loose transition duration-75"
                            ></div>
                        </template>
                    </div>

                    {{-- Time selector (if enabled) --}}
                    <template x-if="hasTime">
                        <div class="flex items-center justify-center rtl:flex-row-reverse">
                            <input
                                max="23"
                                min="0"
                                step="1"
                                type="number"
                                inputmode="numeric"
                                x-model.debounce="hour"
                                class="me-1 w-10 border-none bg-transparent p-0 text-center text-sm text-gray-950 focus:ring-0 dark:text-white"
                            />

                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">:</span>

                            <input
                                max="59"
                                min="0"
                                step="1"
                                type="number"
                                inputmode="numeric"
                                x-model.debounce="minute"
                                class="me-1 w-10 border-none bg-transparent p-0 text-center text-sm text-gray-950 focus:ring-0 dark:text-white"
                            />

                            <template x-if="hasSeconds">
                                <template>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">:</span>
                                    <input
                                        max="59"
                                        min="0"
                                        step="1"
                                        type="number"
                                        inputmode="numeric"
                                        x-model.debounce="second"
                                        class="me-1 w-10 border-none bg-transparent p-0 text-center text-sm text-gray-950 focus:ring-0 dark:text-white"
                                    />
                                </template>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </x-filament::input.wrapper>

    @if ($datalistOptions)
        <datalist id="{{ $id }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>
