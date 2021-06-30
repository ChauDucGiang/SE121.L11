<?php

namespace App\Exports\Export;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;

class PdfExport implements FromView, WithEvents
{
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\View
     */
    public function view(): View
    {
        return view('exports.pdf-export', $this->data);
    }
}
