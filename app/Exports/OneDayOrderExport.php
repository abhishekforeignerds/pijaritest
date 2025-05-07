<?php

namespace  App\Exports;



use App\Models\Order;
use App\Models\OneDayOrder;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class OneDayOrderExport implements FromCollection, WithMapping, WithHeadings
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return OneDayOrder::whereIn('id', $this->orders)->get();
    }

    public function headings(): array
    {
        return [
            'order_code',
            'customer',
            'people',
            'date',
            'amount',
            'product_name',
            'package_name',
            'dakshina',
            'phone',
            'alternate_contact',
            'gotra',
            'address'

        ];
    }

    /**
    * @var Product $product
    */
    public function map($data): array
    {

        return [
            $data->code,
            $data->user->name,
            implode(',',json_decode($data->name)),
            $data->created_at,
            $data->grand_total,
            $data->product_name,
            $data->package_name,
            $data->dakshina,
            $data->phone,
            $data->alternate_contact,
            $data->gotra,
            json_decode($data->shipping_address)->state .','.json_decode($data->shipping_address)->city .','.json_decode($data->shipping_address)->pincode .','. json_decode($data->shipping_address)->house_no .','.json_decode($data->shipping_address)->landmark .','.json_decode($data->shipping_address)->area
        ];


    }
}
