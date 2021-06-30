<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\PageMargins;


class ExcelExport implements FromView, WithDrawings, WithEvents, WithTitle
{
    private $data;
    private $type_name;
    private $type;
    private $customer;
    private $department;

    public function __construct($data = null, $type = null, $type_name = null, $customer = null, $department = null)
    {
        $this->data = $data;
        $this->type = $type;
        $this->type_name = $type_name;
        $this->customer = $customer;
        $this->department = $department;
        set_time_limit(8000000);
    }

    /**
     * @return \Illuminate\Support\View
     */
    public function view(): View
    {
//        {type: 1, text: 'Photo Offer CM'},
//        {type: 2, text: 'Photo Offer INCH'}
//        {type: 3, text: 'Photo Offer CM & INCH'},
        $data = $this->data;
        $view = 'exports.export_type' . $this->type;
        return view($view, ['data' => $data['data'], 'products_price' => $data['products_price'], 'customer' => $this->customer, 'department' => $this->department]);
    }

    public function registerEvents(): array
    {
        if ($this->type == 2) {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    // All headers - set font size to 14
                    $margin = new PageMargins();
                    $margin->setRight(0.15);
                    $margin->setBottom(0.15);
                    $margin->setFooter(0.18);
                    $margin->setHeader(0.17);
                    $margin->setTop(0.25);
                    $margin->setLeft(0.15);
                    $event->sheet->getDelegate()->getPageSetup()->setPrintArea('A1:W' . $event->sheet->getHighestRow());
//                    $event->sheet->getDelegate()->getPageSetup()->setFitToPage(true);
                    $event->sheet->getDelegate()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2, 4);
                    $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                    $event->sheet->getDelegate()->getPageSetup()->setFitToWidth(1);
                    $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                    $event->sheet->getDelegate()->getPageSetup()->setScale(70);
                    $event->sheet->getDelegate()->setPageMargins($margin);
                    $event->sheet->getDelegate()->getSheetView()->setView('pageBreakPreview');
                    $event->sheet->getDelegate()->getSheetView()->setZoomScale(85);
                    $event->sheet->getDelegate()->getPageSetup()->setPaperSize(9);
                    $event->sheet->getDelegate()->getPageSetup()->setOrientation('landscape');
                    $event->sheet->getDelegate()->getStyle('A2:W' . $event->sheet->getHighestRow())->getFont()->setName('Arial Narrow');
                    $event->sheet->getDelegate()->getStyle('A2:W' . $event->sheet->getHighestRow())->getFont()->setSize(12);
                    $event->sheet->getDelegate()->getStyle('A3:W4')->getFont()->setSize(11);

                    $columns = ['D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N', 'O', 'P'];
                    foreach ($columns as $column) {
                        $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(6);
                    }
                    $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(17.7);
                    $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(22.5);
                    $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(35);
                    $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(5);
                    $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(6);
                    $columns2 = ['R', 'S', 'U', 'T', 'V'];
                    foreach ($columns2 as $column) {
                        $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(7.6);
                    }
                    $event->sheet->getDelegate()->getColumnDimension('W')->setWidth(13.5);
                    $event->sheet->getDelegate()->getStyle('A2')->getFont()->setUnderline(true);
                    $event->sheet->getDelegate()->getStyle('C2')->getFont()->setUnderline(true);
                    $event->sheet->getDelegate()->getStyle('D2')->getFont()->setUnderline(true);
                    $event->sheet->getDelegate()->getStyle('A3:Q4')->getFont()->setBold(true);
                    $event->sheet->getDelegate()->getStyle('A3:W4')->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => 'center',
                            'vertical' => 'center'
                        )
                    );
                    $event->sheet->getDelegate()->getStyle('A2:W' . $event->sheet->getHighestRow())->getAlignment()->applyFromArray(
                        array(
                            'vertical' => 'center'
                        )
                    );
                    $event->sheet->getDelegate()->getStyle('B3:B' . $event->sheet->getHighestRow())->getAlignment()->applyFromArray(
                        array('horizontal' => 'center', 'vertical' => 'center')
                    );

                    $event->sheet->getDelegate()->getStyle('A5:W' . $event->sheet->getHighestRow())
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
                    $event->sheet->getDelegate()->getStyle('A3:W4')
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffff99');
                    $event->sheet->getDelegate()->getStyle('G3:I' . $event->sheet->getHighestRow())
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
                    $event->sheet->getDelegate()->getStyle('N3:P' . $event->sheet->getHighestRow())
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('daeef3');
                    $event->sheet->getDelegate()->getStyle('A2:V2')
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
                },
            ];

        } else {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $margin = new PageMargins();
                    $margin->setRight(0.15);
                    $margin->setBottom(0.15);
                    $margin->setFooter(0.18);
                    $margin->setHeader(0.17);
                    $margin->setTop(0.25);
                    $margin->setLeft(0.15);
                    // All headers - set font size to 14
                    $event->sheet->getDelegate()->getPageSetup()->setPrintArea('A1:Q' . $event->sheet->getHighestRow());
//                    $event->sheet->getDelegate()->getPageSetup()->setFitToPage(true);
                    $event->sheet->getDelegate()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(2, 4);
                    $event->sheet->getDelegate()->getPageSetup()->setFitToHeight(0);
                    $event->sheet->getDelegate()->getPageSetup()->setFitToWidth(1);
                    $event->sheet->getDelegate()->getPageSetup()->setHorizontalCentered(true);
                    $event->sheet->getDelegate()->getPageSetup()->setScale(80);
                    $event->sheet->getDelegate()->setPageMargins($margin);
                    $event->sheet->getDelegate()->getSheetView()->setView('pageBreakPreview');
                    $event->sheet->getDelegate()->getPageSetup()->setPaperSize(9);
                    $event->sheet->getDelegate()->getSheetView()->setZoomScale(85);
                    $event->sheet->getDelegate()->getPageSetup()->setOrientation('landscape');
                    $event->sheet->getDelegate()->getStyle('A2:Q' . $event->sheet->getHighestRow())->getFont()->setName('Arial Narrow');
                    $event->sheet->getDelegate()->getStyle('A2:Q' . $event->sheet->getHighestRow())->getFont()->setSize(12);
                    $event->sheet->getDelegate()->getStyle('A3:Q4')->getFont()->setSize(11);

                    $columns = ['D', 'E', 'F', 'H', 'I', 'J'];
                    foreach ($columns as $column) {
                        $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(6);
                    }
                    $columns2 = ['L', 'M', 'N', 'O', 'P'];
                    foreach ($columns2 as $column) {
                        $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(8.6);
                    }
                    $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(17.7);
                    $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(23.5);
                    $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(40);
                    $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(5);
                    $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(6);
                    $event->sheet->getDelegate()->getColumnDimension('Q')->setWidth(13.5);


                    $event->sheet->getDelegate()->getStyle('A2')->getFont()->setUnderline(true);
                    $event->sheet->getDelegate()->getStyle('C2')->getFont()->setUnderline(true);
                    $event->sheet->getDelegate()->getStyle('D2')->getFont()->setUnderline(true);
//                $event->sheet->getColumnDimension('B')->setWidth(20);
                    $event->sheet->getDelegate()->getStyle('A3:Q4')->getFont()->setBold(true);
                    $event->sheet->getDelegate()->getStyle('A3:Q4')->getAlignment()->applyFromArray(
                        array(
                            'horizontal' => 'center',
                            'vertical' => 'center'
                        )
                    );
                    $event->sheet->getDelegate()->getStyle('A2:Q' . $event->sheet->getHighestRow())->getAlignment()->applyFromArray(
                        array(
                            'vertical' => 'center'
                        )
                    );
                    $event->sheet->getDelegate()->getStyle('B3:B' . $event->sheet->getHighestRow())->getAlignment()->applyFromArray(
                        array('horizontal' => 'center', 'vertical' => 'center')
                    );
                    $event->sheet->getDelegate()->getStyle('A3:Q4')
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffff99');
                    $event->sheet->getDelegate()->getStyle('A5:Q' . $event->sheet->getHighestRow())
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
                    $event->sheet->getDelegate()->getStyle('A2:P2')
                        ->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
                },
            ];

        }
    }


    /**
     * @return string
     */
    public function title(): string
    {
        return 'Photo Offers ' . $this->type_name;
    }


    public function drawings()
    {
        $drawing = [];

        $drawing[0] = new Drawing();
        $drawing[0]->setPath(public_path('/export/title-excel.jpg'));
        $drawing[0]->setOffsetX(15);
        $drawing[0]->setOffsetY(20);
        $drawing[0]->setHeight(72);
        $drawing[0]->setWidth(1160);
//        if ($this->type == 2) {
//            $drawing[0]->setWidth(1800);
//        } else {
//            $drawing[0]->setWidth(1400);
//        }

        $items = $this->data;
        foreach ($items['data'] as $k => $item) {
            $drawing[$k + 1] = new Drawing();
            $drawing[$k + 1]->setPath(public_path($item['images'][0]->url));
            $drawing[$k + 1]->setHeight(105);
            $drawing[$k + 1]->setWidth(155);
            $drawing[$k + 1]->setOffsetX(5);
            $drawing[$k + 1]->setOffsetY(5);
            $drawing[$k + 1]->setCoordinates('B' . (5 + $k * 5));
        }
        return $drawing;
    }
}
