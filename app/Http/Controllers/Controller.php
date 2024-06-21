<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DateTime;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function import(Request $request)
    // {
    //     $file = $request->file('file');
    //     $fileContents = file($file->getPathname());

    //     foreach ($fileContents as $line) {
    //         $data = str_getcsv($line, ','); // Use semicolon as the delimiter

    //         $id = intval($data[0]);
    //         $film = $data[1];
    //         $categorie = $data[2];
    //         $salle = $data[3];
    //         $date = $data[4];
    //         $heure = $data[5];

    //         Seance::updateOrCreate(
    //             ['id' => $id],
    //             [
    //                 'film' => $film,
    //                 'categorie' => $categorie,
    //                 'salle' => $salle,
    //                 'date' => $date,
    //                 'heure' => $heure,
    //                 'updated_at' => now(),
    //                 'created_at' => now(),
    //             ]
    //         );
    //     }

    //     return redirect()->back()->with('success', 'CSV file imported successfully.');
    // }

    // public function getData(){
    //     $liste = Seance::all();
    //     return view('import',compact("liste"));
    // }

    // public function export()
    // {
    //     // Supposons que $liste est récupérée depuis votre base de données
    //     $liste = Seance::all();

    //     // Ouvrez un handle de fichier en mode 'écriture' pour un fichier appelé export.csv
    //     $handle = fopen('php://output', 'w');

    //     // Écrivez les en-têtes
    //     fputcsv($handle, ['id', 'film', 'categorie', 'salle', 'date', 'heure']);

    //     // Écrivez les données
    //     foreach ($liste as $row) {
    //         fputcsv($handle, [$row->id, $row->film, $row->categorie, $row->salle, $row->date, $row->heure]);
    //     }

    //     fclose($handle);

    //     // Renvoyez le fichier CSV au navigateur pour le téléchargement
    //     return response()->streamDownload(function () use ($handle) {
    //         fpassthru($handle);
    //     }, 'export.csv');
    // }

    // public function exportExcel()
    // {
    //     // Créer une nouvelle instance de Spreadsheet
    //     $spreadsheet = new Spreadsheet();

    //     // Ajouter les données à la feuille de calcul
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $liste = Seance::all();
    //     // Ajouter l'en-tête
    //     $sheet->fromArray(['id', 'film', 'categorie', 'salle', 'date', 'heure'], NULL, 'A1');

    //     // Ajouter les données
    //     $row = 2;
    //     foreach ($liste as $row_data) {
    //         $sheet->setCellValue('A' . $row, $row_data->id);
    //         $sheet->setCellValue('B' . $row, $row_data->film);
    //         $sheet->setCellValue('C' . $row, $row_data->categorie);
    //         $sheet->setCellValue('D' . $row, $row_data->salle);
    //         $sheet->setCellValue('E' . $row, $row_data->date);
    //         $sheet->setCellValue('F' . $row, $row_data->heure);
    //         $row++;
    //     }

    //     // Créer un écrivain pour Excel (xlsx)
    //     $writer = new Xlsx($spreadsheet);

    //     // Spécifier le nom du fichier à télécharger
    //     $fileName = 'export.xlsx';

    //     // Enregistrer le fichier Excel dans le répertoire de stockage
    //     $writer->save(storage_path('app/public/' . $fileName));

    //     // Retourner le chemin du fichier pour le téléchargement
    //     return redirect()->back()->with('success', 'CSV file imported successfully.');
    // }

    // public function import_exel(Request $request)
    // {
    //     // Validez le fichier Excel
    //     $request->validate([
    //         'exel' => 'required|mimes:xlsx,xls'
    //     ]);

    //     // Récupérez le fichier téléchargé
    //     $file = $request->file('exel');

    //     // Charger le fichier Excel
    //     $spreadsheet = IOFactory::load($file);

    //     // Sélectionner la première feuille de calcul
    //     $worksheet = $spreadsheet->getActiveSheet();

    //     // Parcourir les lignes de la feuille de calcul (à partir de la deuxième ligne car la première ligne est souvent l'en-tête)
    //     foreach ($worksheet->getRowIterator(2) as $row) {
    //         $cellIterator = $row->getCellIterator();
    //         $cellIterator->setIterateOnlyExistingCells(false);

    //         $data = [];
    //         foreach ($cellIterator as $cell) {
    //             $data[] = $cell->getValue();
    //         }

    //         // Assurez-vous que vous avez suffisamment de données pour traiter
    //         if (count($data) >= 6) {
    //             $id = intval($data[0]);
    //             $film = $data[1];
    //             $categorie = $data[2];
    //             $salle = $data[3];
    //             $dateString = trim($data[4]); // Supprimer les espaces blancs autour de la chaîne de date
    //             $date = DateTime::createFromFormat('d/m/Y', $dateString);
    //             $heure = DateTime::createFromFormat('H:i', $data[5]); // Convertir l'heure au format H:i
    //             var_dump($date);
    //             // echo $heure;
    //             // Assurez-vous que les objets de date et d'heure sont valides
    //             // if ($date && $heure) {
    //             //     // Utilisez setCellValue pour définir la valeur de la cellule avec la date formatée
    //             //     $worksheet->setCellValue('E' . $row->getRowIndex(), Date::PHPToExcel($date));
    //             //     $worksheet->setCellValue('F' . $row->getRowIndex(), Date::PHPToExcel($heure));

    //             //     Seance::updateOrCreate(
    //             //         ['id' => $id],
    //             //         [
    //             //             'film' => $film,
    //             //             'categorie' => $categorie,
    //             //             'salle' => $salle,
    //             //             'date' => $date->format('Y-m-d'),
    //             //             'heure' => $heure->format('H:i:s'),
    //             //             'updated_at' => now(),
    //             //             'created_at' => now(),
    //             //         ]
    //             //     );
    //             //     // echo $date;
    //             // }
    //         }
    //     }

        // return redirect()->back()->with('success', 'Excel file imported successfully.');
    // }
}
