<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class PanchangLivewire extends Component
{
    public $data, $date, $latitude, $longitude, $lang, $place;
    public $panchang_response, $choghadiya_response, $hora_response, $moon_calendar, $moon_phase_response, $moon_rise_response, $moon_set_response, $solar_noon_response, $sun_rise_response, $sun_set_response, $retrogrades_response, $grah_transit_response;
    public $mode = false;

    public function mount()
    {
        $this->lang = 'hi';

        Session::forget('panchang_data');
        $form_data = Session::get('panchang_data');

        if(!$form_data){

            $this->place = 'ChIJTc_rb7ctjjkRtfA_hRAXE2g';
            $location = getLatLongFromPlaceId($this->place);
            $this->latitude  = $location->latitude;
            $this->longitude = $location->longitude;

            $form_data = [
                'date'      => date('Y-m-d'),
                'place_id'  => $this->place,
                'latitude'  => $this->latitude,
                'longitude' => $this->longitude,
            ];
            Session::put('panchang_data', $form_data);
        }
        if ($form_data) {
            $this->date      = $form_data['date'];
            $this->latitude  = $form_data['latitude'];
            $this->longitude = $form_data['longitude'];
        }
        $this->switchLanguage($this->lang);
        $this->getPanchang();

    }

    public function switchLanguage($lang)
    {
        $this->lang = $lang;
        App::setLocale($lang);
        session()->put('locale', $lang);
        Artisan::call('config:clear');
        $this->getPanchang();
    }

    public function render()
    {
        return view('frontend.daily_panchang')->layout('frontend.layouts.app');
    }

    public function setData()
    {
        $form_data = Session::get('panchang_data', []);

        $this->place = $this->place ? $this->place : $form_data['place_id'];
        $this->date = $this->date ? $this->date : $form_data['date'];

        Session::forget('panchang_data');

        $location = getLatLongFromPlaceId($this->place);
        $this->latitude  = $location->latitude;
        $this->longitude = $location->longitude;

        $form_data = [
            'date'      => $this->date,
            'place_id'  => $this->place,
            'latitude'  => $this->latitude,
            'longitude' => $this->longitude,
        ];
        Session::put('panchang_data', $form_data);

        if ($form_data) {
            $this->date      = $form_data['date'];
            $this->latitude  = $form_data['latitude'];
            $this->longitude = $form_data['longitude'];
        }

        $this->getPanchang();
    }

    public function getPanchang()
    {
        $client = new Client();
        $this->lang = session()->get('locale');
        $panchang_response = $client->get(env('VEDIC_ASTRO_API').'/panchang/panchang', [
            'query' => [
                'api_key'   => env('VEDIC_ASTRO_KEY'),
                'date'      => Carbon::parse($this->date)->format('d/m/Y'),
                'tz'        => '5.5',
                'lat'       => $this->latitude,
                'lon'       => $this->longitude,
                'time'      => '05:00',
                'lang'      => $this->lang,
            ]
        ]);

        $panchang_response = json_decode($panchang_response->getBody()->getContents(), true);

        if($panchang_response['status'] == 402){
            session()->flash('error', ucwords($panchang_response['response']));
            return redirect()->route('index');
        }

        $this->panchang_response = $panchang_response['response'];

        $choghadiya_response = $client->get(env('VEDIC_ASTRO_API').'/panchang/choghadiya-muhurta', [
            'query' => [
                'date'       => Carbon::parse($this->date)->format('d/m/Y'),
                'tz'         => '5.5',
                'lat'        => $this->latitude,
                'lon'        => $this->longitude,
                'api_key'    => env('VEDIC_ASTRO_KEY'),
                'time'       => '05:00',
                'lang'       => $this->lang,
            ]
        ]);

        $choghadiya_response = json_decode($choghadiya_response->getBody()->getContents(), true);

        if($choghadiya_response['status'] == 402){
            session()->flash('error', ucwords($choghadiya_response['response']));
            return redirect()->route('index');
        }
        $this->choghadiya_response = $choghadiya_response['response'];

        $hora_response = $client->get(env('VEDIC_ASTRO_API').'/panchang/hora-muhurta', [
            'query' => [
                'date'       => Carbon::parse($this->date)->format('d/m/Y'),
                'tz'         => '5.5',
                'lat'        => $this->latitude,
                'lon'        => $this->longitude,
                'api_key'    => env('VEDIC_ASTRO_KEY'),
                'time'       => '05:00',
                'lang'       => $this->lang,
            ]
        ]);

        $hora_response = json_decode($hora_response->getBody()->getContents(), true);

        if($hora_response['status'] == 402){
            session()->flash('error', ucwords($hora_response['response']));
            return redirect()->route('index');
        }
        if($hora_response['status'] == 200){
            $this->hora_response = $hora_response['response'];
        }

        $transit_arr = [];
        for ($i=1; $i <=9 ; $i++) {
            $grah_transit_response = $client->get(env('VEDIC_ASTRO_API').'/panchang/transit-dates', [
                'query' => [
                    'api_key'    => env('VEDIC_ASTRO_KEY'),
                    'planet'     => getPlanets($i)['key'],
                    'year'       => Carbon::parse($this->date)->format('Y'),
                    'lang'       => $this->lang,
                ]
            ]);
            $grah_transit_response = json_decode($grah_transit_response->getBody()->getContents(), true);
            $transit_arr[$i] = $grah_transit_response;
        }
        $this->grah_transit_response = $transit_arr;
        // dd($this->grah_transit_response);

        $retrogrades_arr = [];
        for ($i=1; $i <=9 ; $i++) {
            $retrogrades = $client->get(env('VEDIC_ASTRO_API').'/panchang/retrogrades', [
                'query' => [
                    'api_key'    => env('VEDIC_ASTRO_KEY'),
                    'year'       => Carbon::parse($this->date)->format('Y'),
                    'planet'     => getPlanets($i)['key'],
                    'lang'       => $this->lang,
                ]
            ]);

            $retrogrades = json_decode($retrogrades->getBody()->getContents(), true);
            $retrogrades_arr[$i] = $retrogrades;
        }
        $this->retrogrades_response = $retrogrades_arr;

        // $this->mode = true;

    }
}
