<?php

namespace App\Exports;

use App\products_invoices;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize,WithEvents
{
    use Exportable;

    private $employeeID;
    private $employeeName;
    private $startDate = null;
    private $endDate = null;

    public function __construct( $employeeID,$employeeName, $startDate,$endDate)
    {
        $this->employeeID = $employeeID;
        $this->employeeName = $employeeName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
    public function headings() :array
    {
        return [
            '#',
            'البائع',
            'اسم المنتج',
            'العيار',
            'الوزن',
            'العدد',
            'السعر',
            'من ريون',
        ];
    }
    public function collection()
    {
        return products_invoices::query()

            ->with(['owner:name,id','product:name,id'])
            ->whereHas('invoice',function ($query){
                $query->where('employee_id',$this->employeeID)
                        ->when( ( !is_null(\request('StartDate') ) && \request('StartDate') != '' ),function($query){
                            $query->whereRaw('invoices.created_at >= ? ',[\request('StartDate')] );
                        })
                        ->when( ( !is_null(\request('EndDate') ) && \request('EndDate') != '' ),function($query){
                            $query->whereRaw('invoices.created_at <= ? ',[\request('EndDate')] );
                        });
            })->get();
    }
    public function map($products_details): array {
        return [
            (int) $products_details->total_price < 0 ? 'كسر' : ' ',
            $this->employeeName,
            $products_details->product ? $products_details->product->name : '',
            $products_details->weight_type,
            $products_details->weight,
            $products_details->number_of_items,
            $products_details->total_price ? abs($products_details->total_price) : '0',
            $products_details->is_bracelet ? 'البترينة' : ($products_details->owner ? $products_details->owner->name : ''),
        ] ;
    }


}
