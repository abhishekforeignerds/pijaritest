<div>
    <x-loader />
    <div class="panchang">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card panchang-heading">
                        <div class="card-body">
                            <form wire:submit.prevent="setData()">
                                <div class="row">
                                    <div class="col-md-5 form-group" wire:ignore>
                                        <label class="form-label">{{ trans('lang.place_details') }}<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2" name="place" id="place"
                                            wire:model="place" data-live-search="true" wire:change="setData">
                                            <option value="{{ $place }}" disabled selected>
                                                {{ trans('lang.find_place') }}
                                            </option>
                                        </select>
                                        @error('place')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-5 form-group">
                                        <label class="form-label">{{ trans('lang.date') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date" placeholder=""
                                            wire:model="date" value="{{ $date }}" wire:change="setData">
                                        @error('date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <select class="select-form" id="language" wire:model.defer="lang"
                                            wire:change="switchLanguage('{{ $lang == 'hi' ? 'en' : 'hi' }}')">
                                            <option value="hi">हिन्दी</option>
                                            <option value="en">English</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row panchang-bg">
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Daily Panchang</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($panchang_response as $key => $value)
                                <div>
                                    <strong>{{ $key }}:</strong>
                                    @if (is_array($value))
                                        @foreach ($value as $sub_key => $sub_value)
                                            <div>{{ $sub_key }} =>
                                                {{ is_array($sub_value) ? json_encode($sub_value) : $sub_value }}</div>
                                        @endforeach
                                    @else
                                        <div>{{ $value }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Choghadiya Response</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($choghadiya_response as $key => $value)
                                <div>
                                    <strong>{{ $key }}:</strong>
                                    @if (is_array($value))
                                        @foreach ($value as $sub_key => $sub_value)
                                            @if (is_array($sub_value))
                                                <div>
                                                    @foreach ($sub_value as $inner_key => $inner_value)
                                                        <div>{{ $inner_key }} => {{ $inner_value }}</div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div>{{ $sub_key }} => {{ $sub_value }}</div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div>{{ $value }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Hora Response</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($hora_response as $key => $value)
                                <div>
                                    <strong>{{ $key }}:</strong>
                                    @if (is_array($value))
                                        @foreach ($value as $sub_key => $sub_value)
                                            @if (is_array($sub_value))
                                                <div>
                                                    @foreach ($sub_value as $inner_key => $inner_value)
                                                        <div>{{ $inner_key }} => {{ $inner_value }}</div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div>{{ $sub_key }} => {{ $sub_value }}</div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div>{{ $value }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Moon Calendar</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($moon_calendar as $key => $value)
                                <div>
                                    <strong>{{ $key }}:</strong>
                                    @if (is_array($value))
                                        @foreach ($value as $sub_key => $sub_value)
                                            @if (is_array($sub_value))
                                                <div>
                                                    @foreach ($sub_value as $inner_key => $inner_value)
                                                        <div>{{ $inner_key }} => {{ $inner_value }}</div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div>{{ $sub_key }} => {{ $sub_value }}</div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div>{{ $value }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Moon Phase</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($moon_phase_response as $key => $value)
                                <div>{{ $key }} => {{ $value }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Moon Rise</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($moon_rise_response as $key => $value)
                                <div>{{ $key }} => {{ $value }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Moon Set</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($moon_set_response as $key => $value)
                                <div>{{ $key }} => {{ $value }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Solar Noon</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($solar_noon_response as $key => $value)
                                <div>{{ $key }} => {{ $value }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sun Rise</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($sun_rise_response as $key => $value)
                                <div>{{ $key }} => {{ $value }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sun Set</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($sun_set_response as $key => $value)
                                <div>{{ $key }} => {{ $value }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Retrogrades</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($retrogrades_response as $key => $value)
                                <strong>{{ getPlanets($key)['key'] }}:</strong>
                                @if (isset($value['response']['bot_response']))
                                    <div>{{ $value['response']['bot_response'] }}</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Grah Transit</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @for ($i = 1; $i <= 9; $i++)
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <h5>{{ getPlanets($i)['key'] }}</h5>
                                            @foreach ($grah_transit_response[$i]['response'] as $transit)
                                                <div class="col-2">
                                                    <div class="transit-item">
                                                        <p>Start Date: {{ $transit['start_date'] }}</p>
                                                        <p>End Date: {{ $transit['end_date'] }}</p>
                                                        <p>Zodiac: {{ $transit['zodiac'] }}</p>
                                                        <p>Retro: {{ $transit['retro'] ? 'Yes' : 'No' }}</p>
                                                        <p>Rasi No: {{ $transit['rasi_no'] }}</p>
                                                        <p>Strength: {{ $transit['strength'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#place').select2({
                    placeholder: 'Find Place',
                    minimumInputLength: 3,
                    ajax: {
                        url: '{{ route('search.place') }}',
                        dataType: 'json',
                        delay: 0,
                        data: function(params) {
                            return {
                                query: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results.map(function(option) {
                                    return {
                                        id: option.id,
                                        text: option.text
                                    };
                                })
                            };
                        },
                        cache: true,
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#place').on('change', function(e) {
                    let elementName = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(elementName, data);
                });
            });
        </script>
    @endpush
</div>
