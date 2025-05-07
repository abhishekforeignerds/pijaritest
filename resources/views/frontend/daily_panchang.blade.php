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
            <!-- panchang start-->
            <div class="row panchang-bg">
                <div class="col-lg-12 mt-4">
                    <div class="row panchang">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h6 class="as_heading d-flex justify-content-between align-items-center">
                                        @if ($date == date('Y-m-d'))
                                            {{ trans('lang.today_panchang') }}
                                        @else
                                            {{ date('d', strtotime($date)) }}
                                            {{ trans('lang.' . date('M', strtotime($date))) }}
                                            {{ trans('lang.date_panchang') }}
                                        @endif
                                        <img src="{{ asset('frontend/assets/images/swastik.png') }}"
                                            class="img-fluid panchang-icon" alt="Icon">
                                    </h6>
                                    <div class="panchang-details">
                                        <div class="row g-3">
                                            <div class="col-lg-6 col-12">
                                                <div class="card faded-card h-100">
                                                    <div class="card-body">
                                                        <div class="col-12">
                                                            <strong class="text-danger">{{ trans('lang.tithi') }}:
                                                            </strong>
                                                            <span>{{ $panchang_response['tithi']['name'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.start') }}: </strong>
                                                            <span>{{ $panchang_response['tithi']['start'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.end') }}: </strong>
                                                            <span>{{ $panchang_response['tithi']['end'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.meaning') }}: </strong>
                                                            <span>{{ $panchang_response['tithi']['meaning'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.special') }}: </strong>
                                                            <span>{{ $panchang_response['tithi']['special'] ?? '--' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="card faded-card h-100">
                                                    <div class="card-body">
                                                        <div class="col-12">
                                                            <strong class="text-primary">{{ trans('lang.yoga') }}:
                                                            </strong>
                                                            <span>{{ $panchang_response['yoga']['name'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.start') }}: </strong>
                                                            <span>{{ $panchang_response['yoga']['start'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.end') }}: </strong>
                                                            <span>{{ $panchang_response['yoga']['end'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.meaning') }}: </strong>
                                                            <span>{{ $panchang_response['yoga']['meaning'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.special') }}: </strong>
                                                            <span>{{ $panchang_response['yoga']['special'] ?? '--' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="card faded-card h-100">
                                                    <div class="card-body">
                                                        <div class="col-12">
                                                            <strong class="text-danger">{{ trans('lang.karan') }}:
                                                            </strong>
                                                            <span>{{ $panchang_response['karana']['name'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.type') }}: </strong>
                                                            <span>{{ $panchang_response['karana']['type'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.lord') }}: </strong>
                                                            <span>{{ $panchang_response['karana']['lord'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.deity') }}: </strong>
                                                            <span>{{ $panchang_response['karana']['diety'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.special') }}: </strong>
                                                            <span>{{ $panchang_response['karana']['special'] ?? '--' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="card faded-card h-100">
                                                    <div class="card-body">
                                                        <div class="col-12">
                                                            <strong class="text-primary">{{ trans('lang.nakshatra') }}:
                                                            </strong>
                                                            <span>{{ $panchang_response['nakshatra']['name'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.start') }}: </strong>
                                                            <span>{{ $panchang_response['nakshatra']['start'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.end') }}: </strong>
                                                            <span>{{ $panchang_response['nakshatra']['end'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.meaning') }}: </strong>
                                                            <span>{{ $panchang_response['nakshatra']['meaning'] ?? '--' }}</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <strong>{{ trans('lang.special') }}: </strong>
                                                            <span>{{ $panchang_response['nakshatra']['special'] ?? '--' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="card faded-card h-100">
                                                    <div class="card-body">
                                                        <div class="col-12 col-md-6">
                                                            <strong class="text-danger">{{ trans('lang.paksha') }}:
                                                            </strong>
                                                            <span>{{ $panchang_response['advanced_details']['masa']['paksha'] ?? '--' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-12">
                                                <div class="card faded-card h-100">
                                                    <div class="card-body">
                                                        <div class="col-12 col-md-6">
                                                            <strong class="text-primary">{{ trans('lang.day') }}:
                                                            </strong>
                                                            <span>{{ $panchang_response['day']['name'] ?? '--' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="card faded-card">
                                        <div class="card-body">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="as_heading">
                                                        {{ trans('lang.sun_and_moon_calculation') }}
                                                    </h6>
                                                    <img src="{{ asset('frontend/assets/images/sun.png') }}"
                                                        class="img-fluid panchang-icon">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-danger fw-bold">{{ trans('lang.sunrise') }}
                                                    </p>
                                                    <p>{{ isset($panchang_response['advanced_details']['sun_rise']) ? $panchang_response['advanced_details']['sun_rise'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-primary fw-bold">{{ trans('lang.sunset') }}
                                                    </p>
                                                    <p>{{ isset($panchang_response['advanced_details']['sun_set']) ? $panchang_response['advanced_details']['sun_set'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-danger fw-bold">
                                                        {{ trans('lang.moon_rise') }}</p>
                                                    <p>{{ isset($panchang_response['advanced_details']['moon_rise']) ? $panchang_response['advanced_details']['moon_rise'] : '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-primary fw-bold">
                                                        {{ trans('lang.moon_set') }}</p>
                                                    <p>{{ isset($panchang_response['advanced_details']['moon_set']) ? $panchang_response['advanced_details']['moon_set'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-danger fw-bold">{{ trans('lang.ritu') }}</p>
                                                    <p>{{ isset($panchang_response['advanced_details']['masa']['ritu']) ? $panchang_response['advanced_details']['masa']['ritu'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-primary fw-bold">
                                                        {{ trans('lang.moon_sign') }}</p>
                                                    <p>{{ isset($panchang_response['rasi']['name']) ? $panchang_response['rasi']['name'] : '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="card faded-card">
                                        <div class="card-body">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="as_heading">{{ trans('lang.hindu_month_and_year') }}
                                                    </h6>
                                                    <img src="{{ asset('frontend/assets/images/calendar.png') }}"
                                                        class="img-fluid panchang-icon">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-danger fw-bold">{{ trans('lang.shaka_samvat') }}
                                                    </p>
                                                    <p>{{ isset($panchang_response['advanced_details']['years']['saka']) ? $panchang_response['advanced_details']['years']['saka'] : '--' }}
                                                        {{ isset($panchang_response['advanced_details']['years']['saka_samvaat_name']) ? $panchang_response['advanced_details']['years']['saka_samvaat_name'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-primary fw-bold">{{ trans('lang.day_duration') }}
                                                    </p>
                                                    <p>{{ isset($panchang_response['day']['name']) ? $panchang_response['day']['name'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-danger fw-bold">{{ trans('lang.ayan') }}</p>
                                                    <p>{{ isset($panchang_response['advanced_details']['masa']['ayana']) ? $panchang_response['advanced_details']['masa']['ayana'] : '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-primary fw-bold">
                                                        {{ trans('lang.hindi_month_name') }}
                                                    </p>
                                                    <p>{{ isset($panchang_response['advanced_details']['masa']['amanta_name']) ? $panchang_response['advanced_details']['masa']['amanta_name'] : '--' }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-danger fw-bold">{{ trans('lang.kali_samvat') }}</p>
                                                    <p>
                                                        {{ isset($panchang_response['advanced_details']['years']['kali_samvaat_name']) ? $panchang_response['advanced_details']['years']['kali_samvaat_name'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <p class="text-primary fw-bold">{{ trans('lang.vikram_samwat') }}
                                                    </p>
                                                    <p>{{ isset($panchang_response['advanced_details']['years']['vikram_samvaat']) ? $panchang_response['advanced_details']['years']['vikram_samvaat'] : '--' }}
                                                        {{ isset($panchang_response['advanced_details']['years']['vikram_samvaat_name']) ? $panchang_response['advanced_details']['years']['vikram_samvaat_name'] : '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <div class="card faded-card">
                                        <div class="card-body">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="as_heading">
                                                        {{ trans('lang.auspicious_inauspicious_timings') }}
                                                    </h6>
                                                    <img src="{{ asset('frontend/assets/images/esoteric.png') }}"
                                                        class="img-fluid panchang-icon">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-danger fw-bold">{{ trans('lang.abhijit') }}</p>
                                                    <p>{{ isset($panchang_response['advanced_details']['abhijit_muhurta']['start']) ? $panchang_response['advanced_details']['abhijit_muhurta']['start'] : '--' }} - {{ isset($panchang_response['advanced_details']['abhijit_muhurta']['end']) ? $panchang_response['advanced_details']['abhijit_muhurta']['end'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-primary fw-bold">{{ trans('lang.disha_shool') }}
                                                    </p>
                                                    <p> {{ isset($panchang_response['advanced_details']['disha_shool']) ? $panchang_response['advanced_details']['disha_shool'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-danger fw-bold">{{ trans('lang.rahu_kaal') }}</p>
                                                    <p>{{ isset($panchang_response['rahukaal']) ? $panchang_response['rahukaal'] : '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-primary fw-bold">{{ trans('lang.gulika') }}</p>
                                                    <p>{{ isset($panchang_response['gulika']) ? $panchang_response['gulika'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-danger fw-bold">{{ trans('lang.yamakanta') }}</p>
                                                    <p>{{ isset($panchang_response['yamakanta']) ? $panchang_response['yamakanta'] : '--' }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="text-primary fw-bold">{{ trans('lang.date') }}</p>
                                                    <p>{{ isset($panchang_response['date']) ? $panchang_response['date'] : '--' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row rashi">
                                <div class="col-lg-12">
                                    <div class="card faded-card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <p class="text-danger mb-0 fw-bold">{{ trans('lang.rashi') }}</p>
                                                <p>{{ isset($panchang_response['rasi']['name']) ? $panchang_response['rasi']['name'] : '--' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 retrogrades">
                                <div class="col-lg-12">
                                    <div class="card faded-card h-100">
                                        <div class="card-body">
                                            <h5 class="as_heading"> {{ trans('lang.retrogrades') }}</h5>
                                            @for ($i = 1; $i <= 9; $i++)
                                                <div class="col-lg-12 border-bottom">
                                                    <div class="d-flex flex-row">
                                                        <span class="planet-icon">
                                                            <img src="{{ getPlanets($i)['icon'] }}" alt="">
                                                        </span>
                                                        <p class="text-danger fw-bold m-0">
                                                            {{ str_replace('lang.', '', getPlanets($i)['name']) }}
                                                        </p>
                                                    </div>
                                                    <p>{{ isset($retrogrades_response[$i]['response']['bot_response']) ? $retrogrades_response[$i]['response']['bot_response'] : '' }}
                                                    </p>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row chaoghadiya">
                        <div class="col-lg-6 my-2">
                            <div class="card faded-card h-100">
                                <div class="card-body">
                                    <table class="table">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="as_heading2">{{ trans('lang.day_choghadiya') }}</h5>
                                            <img src="{{ asset('frontend/images/sunrise.png') }}"
                                                class="img-fluid panchang-icon">
                                        </div>
                                        <thead>
                                            <tr>
                                                <th>{{trans('lang.muhurat')}}</th>
                                                <th>{{trans('lang.time')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($choghadiya_response['day'] as $day)
                                                <tr>
                                                    <td>
                                                        {{ isset($day['muhurat']) ? $day['muhurat'] : '--' }}
                                                        <small>({{ isset($day['type']) ? $day['type'] : '--' }})</small>
                                                    </td>
                                                    <td>
                                                         {{ $day['start'] }} - {{ $day['end'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 my-2">
                            <div class="card faded-card h-100">
                                <div class="card-body">
                                    <table class="table">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="as_heading2">{{ trans('lang.night_choghadiya') }}</h5>
                                            <img src="{{ asset('frontend/images/moon-and-stars.png') }}"
                                                class="img-fluid panchang-icon">
                                        </div>
                                        <thead>
                                            <tr>
                                                <th>{{trans('lang.muhurat')}}</th>
                                                <th>{{trans('lang.time')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($choghadiya_response['night'] as $night)
                                                <tr>
                                                    <td>
                                                        {{ isset($night['muhurat']) ? $night['muhurat'] : '--' }}
                                                        <small>({{ isset($night['type']) ? $night['type'] : '--' }})</small>
                                                    </td>
                                                    <td>
                                                        {{ $night['start'] }} - {{ $night['end'] }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row horo-details">
                        <h5 class="as_heading ms-3 mt-2">{{ trans('lang.hora_details') }}</h5>
                        <div class="col-12">
                            <div class="card faded-card">
                                <div class="card-body responsive-table">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('lang.hora') }}</th>
                                                <th>{{ trans('lang.start') }}</th>
                                                <th>{{ trans('lang.end') }}</th>
                                                <th>{{ trans('lang.lucky_gem') }}</th>
                                                <th>{{ trans('lang.benefit') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($hora_response)
                                                @foreach ($hora_response as $key => $value)
                                                    @if (is_array($value))
                                                        @foreach ($value as $sub_key => $sub_value)
                                                            @if (is_array($sub_value))
                                                                <tr>
                                                                    <td>{{ $sub_value['hora'] ?? 'N/A' }}</td>
                                                                    <td>{{ $sub_value['start'] ?? 'N/A' }}</td>
                                                                    <td>{{ $sub_value['end'] ?? 'N/A' }}</td>
                                                                    <td>{{ $sub_value['lucky_gem'] ?? 'N/A' }}</td>
                                                                    <td>{{ $sub_value['benefits'] ?? 'N/A' }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-2 grah-transit">
                        <div class="col-lg-12">
                            <div class="grah-card">
                                <div class="card-body">
                                    <h5 class="as_heading">{{ trans('lang.grah_transit') }}</h5>
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        @for ($i = 1; $i <= 9; $i++)
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link {{ $i == 1 ? 'active' : '' }}"
                                                    id="pills_{{ $i }}_tab" data-bs-toggle="pill"
                                                    data-bs-target="#pills_{{ $i }}" type="button"
                                                    role="tab" aria-controls="pills_{{ $i }}"
                                                    aria-selected="true">{{ getPlanets($i)['name'] }}</button>
                                            </li>
                                        @endfor
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        @for ($i = 1; $i <= 9; $i++)
                                            <div class="tab-pane fade {{ $i == 1 ? 'active' : '' }}"
                                                id="pills_{{ $i }}" role="tabpanel"
                                                aria-labelledby="pills_{{ $i }}_tab">
                                                @if (isset($grah_transit_response[$i]['response']))
                                                    <div class="transit-item">
                                                        <div class="row">
                                                            @foreach ($grah_transit_response[$i]['response'] as $transit)
                                                                <div class="col-lg-3 col-12">
                                                                    <div class="panchang-card px-2">
                                                                        <p class="text-danger">
                                                                            {{ trans('lang.start') }} : <span
                                                                                class="text-secondary">{{ $transit['start_date'] }}</span>
                                                                        </p>
                                                                        <p class="text-primary">
                                                                            {{ trans('lang.end') }} : <span
                                                                                class="text-secondary">{{ $transit['end_date'] }}</span>
                                                                        </p>
                                                                        <p class="text-info">
                                                                            {{ trans('lang.zodiac') }} : <span
                                                                                class="text-secondary">{{ $transit['zodiac'] }}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @else
                                                    <p>No transit data available.</p>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- panchang End-->
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
        <script>
            // Tab-Pane change function
            function tabChange() {
                var tabs = $('.nav-tabs > li');
                var active = tabs.filter('.active');
                var next = active.next('li').length ? active.next('li').find('a') : tabs.filter(':first-child').find('a');
                next.tab('show');
            }

            $('.tab-pane').hover(function() {
                clearInterval(tabCycle);
            }, function() {
                tabCycle = setInterval(tabChange, 5000);
            });

            // Tab Cycle function
            var tabCycle = setInterval(tabChange, 5000)

            // Tab click event handler
            $(function() {
                $('.nav-tabs a').click(function(e) {
                    e.preventDefault();
                    clearInterval(tabCycle);
                    $(this).tab('show')
                    tabCycle = setInterval(tabChange, 5000);
                });
            });
        </script>
    @endpush
</div>
