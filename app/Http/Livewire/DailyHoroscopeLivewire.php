<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\DailyHoroscopes;

class DailyHoroscopeLivewire extends Component
{
    public $zodiac, $data, $date;
    protected $queryString = [
        'zodiac'        => ['except' => ''],
    ];
    public function mount()
    {
        if(!$this->zodiac){
            $this->zodiac = 1;
        }
        $this->date = date('Y-m-d');
        $this->dailyhoroscopes($this->zodiac, $this->date);
    }

    public function render()
    {
        return view('frontend.daily_horoscope')->layout('frontend.layouts.app');
    }

    public function submitDate()
    {
        $this->dailyhoroscopes($this->zodiac, $this->date);
    }

    public function dailyhoroscopes($zodiac)
    {
        try {
            $this->zodiac = $zodiac;
            $lang = session()->get('locale') ?? 'en';
            if($this->zodiac && $this->date){
                $date = Carbon::parse($this->date)->format('d/m/Y');
                $zodiac = $this->zodiac;

                // $data = DailyHoroscopes::where('date', $date)->where('zodiac', $zodiac)->where('lang', $lang)->first();
                // if(!$data){
                    $client = new Client();
                    $response = $client->get(env('VEDIC_ASTRO_API').'/prediction/daily-sun', [
                        'query' => [
                            'date'      => $date,
                            'zodiac'    => $zodiac,
                            'api_key'   => env('VEDIC_ASTRO_KEY'),
                            'lang'      => $lang,
                            'show_same' => true,
                            'split'     => true,
                            'type'      => 'big'
                        ]
                    ]);

                    $res = json_decode($response->getBody()->getContents(), true);
                    if($res['status'] == 402){
                        session()->flash('error', ucwords($res['response']));
                        return redirect()->route('index');
                    }
                    // $data = $res['response'];
                    // $data = new DailyHoroscopes;
                    // $data->date = $date;
                    // $data->zodiac = $zodiac;
                    // $data->response = $res;
                    // $data->lang = $lang;
                    // $data->save();
                // }
                $this->data = $res['response'];
                // dd($this->data);

            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Somthing went worng.');
        }
    }
}
