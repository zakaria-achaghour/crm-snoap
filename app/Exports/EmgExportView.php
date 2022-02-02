<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class EmgExportView implements FromView, ShouldAutoSize, WithEvents
{
     
    public $visites;
    public $total;
   
    
    public function __construct($visites = null, $total = null)
    {

        $this->visites = $visites;
        $this->total = $total;
       
    }

    public function registerEvents(): array
    {
      return [
        AfterSheet::class => function(AfterSheet $event) {
         
          $event->sheet->getStyle('A1:D1')->applyFromArray([
            'font'=>[
              'bold'=>true,
            ], 
            'alignment' => [
              'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
          ],
          'borders' => [
            'allBorders' => [
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
              'color' => ['argb' => '666'],
          ],
  
          ],
          
          ]);
        
        }
        
      ];
    }


    public function view(): View
    {
        $a=$this->total;
       
        return view('rapports.tableEmg', ['visites'=>$this->visites,'total'=>$a])->with('message', 'Fichier Execl téléchargé avec succès ');
       
    
    }
}
