<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FicheExportView implements FromView, ShouldAutoSize, WithEvents
{
     
    public $visites;
   
    
    public function __construct($visites = null)
    {

        $this->visites = $visites;
       
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

       
        return view('rapports.tableFiche', ['visites'=>$this->visites])->with('message', 'Fichier Execl téléchargé avec succès ');
       
    
    }
}
