<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\ExcelExport;


class ExportPdfMutiple implements WithMultipleSheets
{
    use Exportable;

    protected $data;
    protected $type;
    protected $customer;
    protected $department;

    public function __construct($data = null, $type = null, $customer = null, $department = null)
    {
        $this->data = $data;
        $this->type = $type;
        $this->department = $department;
        $this->customer = $customer;
        set_time_limit(8000000);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {

        $sheets = [];
        $type_name = 'CM';
        $type_excel = 1;
        if ($this->type == 3) {
            for ($i = 1; $i <= 2; $i++) {
                if ($i == 2) $type_name = 'INCH';
                $sheets[] = new ExcelExport($this->data, $i, $type_name, $this->customer, $this->department);
            }
        } else {
            if ($this->type == 2) {
                $type_name = 'INCH';
                $type_excel = 2;
            };
            $sheets[] = new ExcelExport($this->data, $type_excel, $type_name, $this->customer, $this->department);
        }
        return $sheets;
    }
}
