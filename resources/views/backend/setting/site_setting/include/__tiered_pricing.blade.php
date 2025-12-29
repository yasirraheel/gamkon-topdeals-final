<div class="">
    <div class="site-card">
        <div class="site-card-header">
            <h3 class="title">{{ __($fields['title']) }}</h3>
            <p class="text-muted">{{ __('Configure country-based tiered pricing. Countries not assigned to any tier will default to Tier 1.') }}</p>
        </div>
        <div class="site-card-body">
            @include('backend.setting.site_setting.include.form.__open_action')

            {{-- Enable/Disable Toggle --}}
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Enable Tiered Pricing') }}</label>
                <div class="col-sm-8">
                    <div class="form-switch">
                        <div class="switch-field same-type m-0">
                            <input type="radio" id="tier-enable-{{ $section }}"
                                   name="tiered_pricing_enabled" value="1"
                                   @checked(oldSetting('tiered_pricing_enabled', $section) == '1') />
                            <label for="tier-enable-{{ $section }}">{{ __('Enable') }}</label>
                            <input type="radio" id="tier-disable-{{ $section }}"
                                   name="tiered_pricing_enabled" value="0"
                                   @checked(oldSetting('tiered_pricing_enabled', $section) == '0') />
                            <label for="tier-disable-{{ $section }}">{{ __('Disable') }}</label>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $allCountries = collect(getCountries())->pluck('name', 'name')->toArray();
            @endphp

            {{-- Tier 1 Configuration --}}
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 1 Percentage (%)') }}</label>
                <div class="col-sm-8">
                    <input type="number" name="tier_1_percentage" class="form-control"
                           value="{{ oldSetting('tier_1_percentage', $section) }}"
                           min="1" max="100" required />
                </div>
            </div>
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 1 Countries') }}</label>
                <div class="col-sm-8">
                    @php
                        $tier1Countries = oldSetting('tier_1_countries', $section);
                        $tier1Countries = is_string($tier1Countries) ? json_decode($tier1Countries, true) : $tier1Countries;
                        $tier1Countries = is_array($tier1Countries) ? $tier1Countries : [];
                    @endphp
                    <select name="tier_1_countries[]" id="tier-1-countries" class="form-select" multiple>
                        @foreach($allCountries as $country)
                            <option value="{{ $country }}" @selected(in_array($country, $tier1Countries))>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tier 2 Configuration --}}
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 2 Percentage (%)') }}</label>
                <div class="col-sm-8">
                    <input type="number" name="tier_2_percentage" class="form-control"
                           value="{{ oldSetting('tier_2_percentage', $section) }}"
                           min="1" max="100" required />
                </div>
            </div>
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 2 Countries') }}</label>
                <div class="col-sm-8">
                    @php
                        $tier2Countries = oldSetting('tier_2_countries', $section);
                        $tier2Countries = is_string($tier2Countries) ? json_decode($tier2Countries, true) : $tier2Countries;
                        $tier2Countries = is_array($tier2Countries) ? $tier2Countries : [];
                    @endphp
                    <select name="tier_2_countries[]" id="tier-2-countries" class="form-select" multiple>
                        @foreach($allCountries as $country)
                            <option value="{{ $country }}" @selected(in_array($country, $tier2Countries))>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tier 3 Configuration --}}
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 3 Percentage (%)') }}</label>
                <div class="col-sm-8">
                    <input type="number" name="tier_3_percentage" class="form-control"
                           value="{{ oldSetting('tier_3_percentage', $section) }}"
                           min="1" max="100" required />
                </div>
            </div>
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 3 Countries') }}</label>
                <div class="col-sm-8">
                    @php
                        $tier3Countries = oldSetting('tier_3_countries', $section);
                        $tier3Countries = is_string($tier3Countries) ? json_decode($tier3Countries, true) : $tier3Countries;
                        $tier3Countries = is_array($tier3Countries) ? $tier3Countries : [];
                    @endphp
                    <select name="tier_3_countries[]" id="tier-3-countries" class="form-select" multiple>
                        @foreach($allCountries as $country)
                            <option value="{{ $country }}" @selected(in_array($country, $tier3Countries))>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Tier 4 Configuration --}}
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 4 Percentage (%)') }}</label>
                <div class="col-sm-8">
                    <input type="number" name="tier_4_percentage" class="form-control"
                           value="{{ oldSetting('tier_4_percentage', $section) }}"
                           min="1" max="100" required />
                </div>
            </div>
            <div class="site-input-groups row">
                <label class="col-sm-4 col-label">{{ __('Tier 4 Countries') }}</label>
                <div class="col-sm-8">
                    @php
                        $tier4Countries = oldSetting('tier_4_countries', $section);
                        $tier4Countries = is_string($tier4Countries) ? json_decode($tier4Countries, true) : $tier4Countries;
                        $tier4Countries = is_array($tier4Countries) ? $tier4Countries : [];
                    @endphp
                    <select name="tier_4_countries[]" id="tier-4-countries" class="form-select" multiple>
                        @foreach($allCountries as $country)
                            <option value="{{ $country }}" @selected(in_array($country, $tier4Countries))>
                                {{ $country }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @include('backend.setting.site_setting.include.form.__close_action')
        </div>
    </div>
</div>

@push('single-script')
<script src="{{ asset('global/js/choices.min.js') }}"></script>
<script>
    "use strict";
    // Initialize Choices.js for multi-select country dropdowns
    @for($i = 1; $i <= 4; $i++)
        new Choices(document.getElementById('tier-{{ $i }}-countries'), {
            removeItems: true,
            removeItemButton: true,
            shouldSort: true,
            searchEnabled: true,
            searchPlaceholderValue: 'Search countries...'
        });
    @endfor
</script>
@endpush
