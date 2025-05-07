<?php

namespace App\Http\Livewire;
use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class YearlyHoroscopeLivewire extends Component
{
    public $zodiac, $data, $year;
    protected $queryString = [
        'zodiac'        => ['except' => ''],
    ];

    public function mount()
    {
        if(!$this->zodiac){
            $this->zodiac = 1;
        }
        $this->year = date('Y');
        $this->horoscopes($this->zodiac, $this->year);
    }

    public function render()
    {
        return view('frontend.yearly_horoscope')->layout('frontend.layouts.app');
    }

    public function submitYear()
    {
        $this->horoscopes($this->zodiac, $this->year);
    }

    public function horoscopes($zodiac)
    {
        try {
            $this->zodiac = $zodiac;
            $this->year = $this->year;
            $lang = session()->get('locale');
            if($this->zodiac && $this->year){
                $year = $this->year;
                $zodiac = $this->zodiac;

                // $data = Horoscopes::where('year', $year)->where('zodiac', $zodiac)->where('lang', $lang)->first();
                // if(!$data){

                    $client = new Client();
                    $response = $client->get(env('VEDIC_ASTRO_API').'/prediction/yearly', [
                        'query' => [
                            'year'    => $year,
                            'zodiac'  => $zodiac,
                            'api_key' => env('VEDIC_ASTRO_KEY'),
                            'lang'    => $lang,
                        ]
                    ]);

                    $res = json_decode($response->getBody()->getContents(), true);

                    if($res['status'] == 402){
                        session()->flash('error', ucwords($res['response']));
                        return redirect()->route('index');
                    }
                    // $data = $res['response'];
                    // $data = new Horoscopes;
                    // $data->year = $year;
                    // $data->zodiac = $zodiac;
                    // $data->response = $res;
                    // $data->lang = $lang;
                    // $data->save();
                // }

                $this->data = $res['response'];
            }

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Somthing went worng.');
        }
    }
}
