<div>
    <x-loader/>
    <div class="as_about_wrapper as_padderBottom40 as_padderTop60">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-12 col-md-12 text-center">
                    <h1>{{ trans('lang.weekly_horoscopes') }}</h1>
                    <p class="as_font14 text-center">{{ trans('lang.discover') }}</p>
                </div>
                <div class="col-lg-9"></div>
                <div class="col-lg-3 m-0 text-end">
                    <form id="submitForm">
                        <select class="date-form" wire:model="week" name="week" wire:change="submitData()">
                            <option value="thisweek">{{trans('lang.this_week')}}</option>
                            <option value="nextweek">{{trans('lang.next_week')}}</option>
                        </select>
                    </form>
                </div>
                <div class="col-lg-12">
                    <div class="horoscope_icon_group">
                        @for ($i = 1; $i <= 12; $i++)
                            <div class="horoscope_icon">
                                <div wire:click="horoscopes({{ $i }})">
                                    <span class="icon">
                                        <img src="{{ getHoroscopes($i)['icon'] }}" alt="">
                                    </span>
                                    <p class="title">{{ getHoroscopes($i)['name'] }}</p>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-lg-12 col-md-12">
                    <div class="horoscope_box_new">
                        <div class="horoscope_details_new">
                            <div class="as_sign_box bg-horoscopes text-center">
                                <span class="as_sign p-0">
                                    <img src="{{ getHoroscopes($zodiac)['icon'] }}" alt="">
                                </span>
                                <h5 class="text-danger fw-bold">
                                    {{ getHoroscopes($zodiac)['name'] }} {{ trans('lang.horoscopes') }}</h5>
                            </div>
                            <div class="my-3">
                                <div class="row g-2">
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/status.png') }}" width="25">
                                                    <span> {{ trans('lang.status') }} :</span>
                                                </h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['status']['score']) ? $data['bot_response']['status']['score'] : '--' }}%</span>
                                                </h5>
                                            </div>
                                            <p>{{ isset($data['bot_response']['status']['split_response']) ? $data['bot_response']['status']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/economics.png') }}"
                                                        width="30">
                                                    <span>{{ trans('lang.finances') }}:</span>
                                                </h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['finances']['score']) ? $data['bot_response']['finances']['score'] : '--' }}%</span>
                                                </h5>
                                            </div>
                                            <p>{{ isset($data['bot_response']['finances']['split_response']) ? $data['bot_response']['finances']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/relationship.png') }}"
                                                        width="30">
                                                    <span>{{ trans('lang.relationship') }} :</span>
                                                </h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['relationship']['score']) ? $data['bot_response']['relationship']['score'] : '--' }}%</span>
                                                </h5>
                                            </div>
                                            <p>{{ isset($data['bot_response']['relationship']['split_response']) ? $data['bot_response']['relationship']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/carrer.png') }}"
                                                        width="30"><span>
                                                        {{ trans('lang.career') }} :</span></h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['career']['score']) ? $data['bot_response']['career']['score'] : '--' }}%</span>
                                                </h5>

                                            </div>
                                            <p>{{ isset($data['bot_response']['career']['split_response']) ? $data['bot_response']['career']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/destination.png') }}"
                                                        width="30">
                                                    <span> {{ trans('lang.travel') }} :</span>
                                                </h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['travel']['score']) ? $data['bot_response']['travel']['score'] : '--' }}%</span>
                                                </h5>

                                            </div>
                                            <p>{{ isset($data['bot_response']['travel']['split_response']) ? $data['bot_response']['travel']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/family.png') }}" width="30">
                                                    <span> {{ trans('lang.family') }} :</span>
                                                </h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['family']['score']) ? $data['bot_response']['family']['score'] : '--' }}%</span>
                                                </h5>

                                            </div>
                                            <p>{{ isset($data['bot_response']['family']['split_response']) ? $data['bot_response']['family']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/friends.png') }}"
                                                        width="30">
                                                    <span> {{ trans('lang.friends') }} :</span>
                                                </h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['friends']['score']) ? $data['bot_response']['friends']['score'] : '--' }}%</span>
                                                </h5>
                                            </div>
                                            <p>{{ isset($data['bot_response']['friends']['split_response']) ? $data['bot_response']['friends']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><img src="{{ asset('frontend/icons/heartbeat.png') }}"
                                                        width="30">
                                                    <span>
                                                        {{ trans('lang.health') }} :</span>
                                                </h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['health']['score']) ? $data['bot_response']['health']['score'] : '--' }}%</span>
                                                </h5>

                                            </div>
                                            <p>{{ isset($data['bot_response']['health']['split_response']) ? $data['bot_response']['health']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="fw-bold">{{ trans('lang.total_score') }} :</h5>
                                                <h5><span class="f-right"> {{ trans('lang.score') }}
                                                        :{{ isset($data['bot_response']['total_score']['score']) ? $data['bot_response']['total_score']['score'] : '--' }}%</span>
                                                </h5>
                                            </div>
                                            <p>{{ isset($data['bot_response']['total_score']['split_response']) ? $data['bot_response']['total_score']['split_response'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 px-1">
                                        <div class="card card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5><span> {{ trans('lang.lucky_color') }}: </h5>
                                                <p>{{ isset($data['lucky_color']) ? $data['lucky_color'] : '--' }}</span>
                                                </p>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5> {{ trans('lang.lucky_number') }}:</h5>
                                                @if (count($data['lucky_number']) > 1)
                                                    <p>({{ implode(' , ', $data['lucky_number']) }})</p>
                                                @else
                                                    @foreach ($data['lucky_number'] as $luckyNumber)
                                                        <p>{{ $luckyNumber }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5>{{ trans('lang.week_number') }}: </h5>
                                                <p>{{ isset($data['week_number']) ? $data['week_number'] : '--' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
