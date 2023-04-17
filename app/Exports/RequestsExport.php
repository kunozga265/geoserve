<?php

namespace App\Exports;

use App\Models\RequestForm;
use App\Http\Resources;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;

class RequestsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $requestForms;


    public function __construct($requestForms)
    {
        $this->requestForms=$requestForms;
    }
//
//    public function array(): array
//    {
//        // TODO: Implement array() method.
//        return $this->loans;
//    }

    public function collection()
    {
//        $loans=Loan::all();
        return collect($this->requestForms);
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return[
            'Code',
            'Approved Date',
            'Description',
            'Amount',
            'Project',
            'Vehicle',
            'Status',
            'Requested Date',
            'Requested By',
        ];
    }

    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return[
            AfterSheet::class => function(AfterSheet $event){
                $cellRange='A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
            }
        ];
    }


}
