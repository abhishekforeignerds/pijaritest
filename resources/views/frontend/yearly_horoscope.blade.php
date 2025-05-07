<div>
    <x-loader />
    <div class="as_about_wrapper as_padderBottom40 as_padderTop60">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-12 col-md-12 text-center">
                    <h1>{{ trans('lang.yearly_horoscopes') }}</h1>
                    <p class="as_font14 text-center">{{ trans('lang.discover') }}</p>
                </div>
                <div class="col-lg-9"></div>
                <div class="col-lg-3 m-0 text-end">
                    <form id="submitForm">
                        <input type="number" name="year" placeholder="Enter Year" class="date-form" wire:model="year"
                            min="{{ date('Y') }}" max="{{ date('Y', strtotime('+2 years')) }}"
                            wire:change="submitYear()">
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
                <div class="col-lg-12 col-md-12 display-grid">
                    <div class="horoscope_box_new">
                        <div class="horoscope_details_new">
                            <div class="as_sign_box bg-horoscopes text-center mb-3">
                                <span class="as_sign p-0 ">
                                    <img src="{{ getHoroscopes($zodiac)['icon'] }}" alt="">
                                </span>
                                <h5 class="text-danger fw-bold">
                                    {{ getHoroscopes($zodiac)['name'] }} {{ trans('lang.horoscopes') }}</h5>
                            </div>
                            <div class="my-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>{{ isset($data['phase_1']['period']) ? $data['phase_1']['period'] : '--' }}
                                    </h5>
                                    <h6 class="f-right"> {{ trans('lang.score') }}
                                        :{{ isset($data['phase_1']['score']) ? $data['phase_1']['score'] : '--' }}</h6>
                                </div>
                                <div class="row g-2">
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/heartbeat.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.health') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['health']['prediction']) ? $data['phase_1']['health']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/family.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.family') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['family']['prediction']) ? $data['phase_1']['family']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/destination.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.travel') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['travel']['prediction']) ? $data['phase_1']['travel']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/carrer.png') }}"
                                                    width="30"><span>
                                                    {{ trans('lang.career') }} :</span></h5>
                                            <p>{{ isset($data['phase_1']['career']['prediction']) ? $data['phase_1']['career']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/relationship.png') }}"
                                                    width="30">
                                                <span>{{ trans('lang.relationship') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['relationship']['prediction']) ? $data['phase_1']['relationship']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/friends.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.friends') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['friends']['prediction']) ? $data['phase_1']['friends']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/economics.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.finances') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['finances']['prediction']) ? $data['phase_1']['finances']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/status.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.status') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['status']['prediction']) ? $data['phase_1']['status']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/scholarship.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.education') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_1']['education']['prediction']) ? $data['phase_1']['education']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>{{ isset($data['phase_2']['period']) ? $data['phase_2']['period'] : '--' }}
                                    </h5>
                                    <h6 class="f-right"> {{ trans('lang.score') }}
                                        :{{ isset($data['phase_2']['score']) ? $data['phase_2']['score'] : '--' }}</h6>
                                </div>
                                <div class="row g-2">
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/heartbeat.png') }}" width="30">
                                                <span>{{ trans('lang.health') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['health']['prediction']) ? $data['phase_2']['health']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/family.png') }}" width="30">
                                                <span>{{ trans('lang.family') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['family']['prediction']) ? $data['phase_2']['family']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/destination.png') }}"
                                                    width="30">
                                                <span>{{ trans('lang.travel') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['travel']['prediction']) ? $data['phase_2']['travel']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/carrer.png') }}"
                                                    width="30"><span>
                                                    {{ trans('lang.career') }} :</span></h5>
                                            <p>{{ isset($data['phase_2']['career']['prediction']) ? $data['phase_2']['career']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/relationship.png') }}"
                                                    width="30">
                                                <span>{{ trans('lang.relationship') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['relationship']['prediction']) ? $data['phase_2']['relationship']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/friends.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.friends') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['friends']['prediction']) ? $data['phase_2']['friends']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/economics.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.finances') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['finances']['prediction']) ? $data['phase_2']['finances']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/status.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.status') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['status']['prediction']) ? $data['phase_2']['status']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/scholarship.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.education') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_2']['education']['prediction']) ? $data['phase_2']['education']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>{{ isset($data['phase_3']['period']) ? $data['phase_3']['period'] : '--' }}
                                    </h5>
                                    <h6 class="f-right"> {{ trans('lang.score') }}
                                        :{{ isset($data['phase_3']['score']) ? $data['phase_3']['score'] : '--' }}</h6>
                                </div>
                                <div class="row g-2">
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/heartbeat.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.health') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['health']['prediction']) ? $data['phase_3']['health']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/family.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.family') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['family']['prediction']) ? $data['phase_3']['family']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/destination.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.travel') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['travel']['prediction']) ? $data['phase_3']['travel']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/carrer.png') }}"
                                                    width="30"><span>
                                                    {{ trans('lang.career') }} :</span></h5>
                                            <p>{{ isset($data['phase_3']['career']['prediction']) ? $data['phase_3']['career']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/relationship.png') }}"
                                                    width="30">
                                                <span>{{ trans('lang.relationship') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['relationship']['prediction']) ? $data['phase_3']['relationship']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/friends.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.friends') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['friends']['prediction']) ? $data['phase_3']['friends']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/economics.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.finances') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['finances']['prediction']) ? $data['phase_3']['finances']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/status.png') }}" width="30">
                                                <span>
                                                    {{ trans('lang.status') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['status']['prediction']) ? $data['phase_3']['status']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/scholarship.png') }}"
                                                    width="30">
                                                <span> {{ trans('lang.education') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_3']['education']['prediction']) ? $data['phase_3']['education']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>{{ isset($data['phase_4']['period']) ? $data['phase_4']['period'] : '--' }}
                                    </h5>
                                    <h6 class="f-right"> {{ trans('lang.score') }}
                                        :{{ isset($data['phase_4']['score']) ? $data['phase_4']['score'] : '--' }}
                                    </h6>
                                </div>
                                <div class="row g-2">
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/heartbeat.png') }}"
                                                    width="30">
                                                <span>{{ trans('lang.health') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['health']['prediction']) ? $data['phase_4']['health']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/family.png') }}" width="30">
                                                <span> {{ trans('lang.family') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['family']['prediction']) ? $data['phase_4']['family']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/destination.png') }}"
                                                    width="30">
                                                <span> {{ trans('lang.travel') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['travel']['prediction']) ? $data['phase_4']['travel']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/carrer.png') }}"
                                                    width="30"><span>
                                                    {{ trans('lang.career') }} :</span></h5>
                                            <p>{{ isset($data['phase_4']['career']['prediction']) ? $data['phase_4']['career']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/relationship.png') }}"
                                                    width="30">
                                                <span>{{ trans('lang.relationship') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['relationship']['prediction']) ? $data['phase_4']['relationship']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/friends.png') }}" width="30">
                                                <span> {{ trans('lang.friends') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['friends']['prediction']) ? $data['phase_4']['friends']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/economics.png') }}"
                                                    width="30">
                                                <span>
                                                    {{ trans('lang.finances') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['finances']['prediction']) ? $data['phase_4']['finances']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/status.png') }}" width="30">
                                                <span> {{ trans('lang.status') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['education']['prediction']) ? $data['phase_4']['education']['prediction'] : '--' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 px-1">
                                        <div class="card card-body">
                                            <h5><img src="{{ asset('frontend/icons/scholarship.png') }}"
                                                    width="30">
                                                <span> {{ trans('lang.education') }} :</span>
                                            </h5>
                                            <p>{{ isset($data['phase_4']['education']['prediction']) ? $data['phase_4']['education']['prediction'] : '--' }}
                                            </p>
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
