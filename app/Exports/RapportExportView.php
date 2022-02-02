<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RapportExportView implements FromView, ShouldAutoSize, WithEvents
{

    
    public $visites;
    public $produits;
    
    public function __construct($visites = null, $produits)
    {

        $this->visites = $visites;
        $this->produits = $produits;
    }

    public function registerEvents(): array
    {
      return [
        AfterSheet::class => function(AfterSheet $event) {
         
          $event->sheet->getStyle('A1:FZ1')->applyFromArray([
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

          $event->sheet->getStyle('A2:FZ2')->applyFromArray([
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

       
        return view('rapports.tableVisite', ['visites'=>$this->visites,'produits'=>$this->produits])->with('message', 'Fichier Execl téléchargé avec succès ');
       
    
    }
}
