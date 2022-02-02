<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class NombresExportView implements FromView, ShouldAutoSize, WithEvents
{
     
    public $visites;
    public $nbMed;
    public $nbPharma;
    public $commande;
   
    
    public function __construct($visites = null, $nbMed = null, $nbPharma = null, $commande = null)
    {

        $this->visites = $visites;
        $this->nbMed = $nbMed;
        $this->nbPharma = $nbPharma;
        $this->commande = $commande;
       
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

       
        return view('rapports.tableNombres', ['visites'=>$this->visites, 'nbMed'=>$this->nbMed, 'nbPharma'=>$this->nbPharma, 'commande'=>$this->commande])->with('message', 'Fichier Execl téléchargé avec succès ');
       
    
    }
}
