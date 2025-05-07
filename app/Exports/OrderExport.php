<?php

namespace  App\Exports;



use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class OrderExport implements FromCollection, WithMapping, WithHeadings
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return Order::whereIn('id', $this->orders)->get();
    }

    public function headings(): array
    {
        return [
            'order_code',
            'customer',
            'date',
            'no_of_product',
            'amount',
            'payment_status',


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
            $data->created_at,
            count($data->order_detail),
            $data->grand_total,
            $data->payment_status=='paid'?'Paid':'To Pay',
        ];


    }
}
