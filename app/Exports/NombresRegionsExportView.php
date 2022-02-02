<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NombresRegionsExportView implements FromView, ShouldAutoSize, WithEvents
{
     
    public $visites;
    public $visitePharma;
    public $visiteMed;
   
    
    public function __construct($visites = null, $visiteMed = null, $visitePharma = null)
    {

        $this->visites = $visites;
        $this->visiteMed = $visiteMed;
        $this->visitePharma = $visitePharma;
       
    }

    public function registerEvents(): array
    {
      return [
        AfterSheet::class => function(AfterSheet $event) {
         
          $event->sheet->getStyle('A1:G1')->applyFromArray([
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

          $event->sheet->getStyle('A2:G2')->applyFromArray([
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

       
        return view('rapports.tableNombresRegions', ['visites'=>$this->visites,'visitePharma'=>$this->visitePharma,'visiteMed'=>$this->visiteMed])->with('message', 'Fichier Execl téléchargé avec succès ');
       
    
    }
}
