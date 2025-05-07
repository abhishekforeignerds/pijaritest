<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;

class WeeklyHoroscopeLivewire extends Component
{
    public $zodiac, $data, $week='thisweek';
    protected $queryString = [
        'zodiac'        => ['except' => ''],
    ];
    public function mount()
    {
        if(!$this->zodiac){
            $this->zodiac = 1;
        }
        $this->week = 'thisweek';
        $this->horoscopes($this->zodiac, $this->week);
    }

    public function render()
    {
        return view('frontend.weekly_horoscope')->layout('frontend.layouts.app');
    }

    public function submitData()
    {
        $this->horoscopes($this->zodiac, $this->week);
    }

    public function horoscopes($zodiac)
    {
        try {
            $this->zodiac = $zodiac;
            $lang = session()->get('locale') ?? 'en';
            if($this->zodiac && $this->week){
                $zodiac = $this->zodiac;
                $week = $this->week;

                    $client = new Client();
                    $response = $client->get(env('VEDIC_ASTRO_API').'/prediction/weekly-sun', [
                        'query' => [
                            'week'      => $week,
                            'zodiac'    => $zodiac,
                            'api_key'   => env('VEDIC_ASTRO_KEY'),
                            'lang'      => $lang,
                            'show_same' => true,
                            'split'     => true,
                            'type'      => 'big',
                        ]
                    ]);
                    $data = json_decode($response->getBody()->getContents(), true);

                    if($data['status'] == 402){
                        session()->flash('error', ucwords($data['response']));
                        return redirect()->route('index');
                    }
                    $this->data = $data['response'];
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Somthing went worng.');
        }
    }
}
