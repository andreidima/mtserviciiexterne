<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Support\Facades\DB;


class SsmSalariatiExport
{
    public function export($query)
    {
        // Fetch data from DB
        if ($query->count() > 500) {
            return back()->with('error', 'Nu poți exporta în Excel un set mai mare de 500 salariați. Restrănge setul de date.');
        }
        $salariati=$query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $sheet->getStyle('A1:Z100')->getFont()->setName('Calibri')->setSize(11);

        // Set Headers
        $sheet->setCellValue('A1', 'Nume client');
        $sheet->setCellValue('B1', 'Salariat');
        $sheet->setCellValue('C1', 'Data SSM/ PSI');
        $sheet->setCellValue('D1', 'Semnat SSM');
        $sheet->setCellValue('E1', 'Semnat PSI');
        $sheet->setCellValue('F1', 'CNP');
        $sheet->setCellValue('G1', 'Funcția');
        $sheet->setCellValue('H1', 'A');
        $sheet->setCellValue('I1', 'Data ang.');
        $sheet->setCellValue('J1', 'Data inc.');
        $sheet->setCellValue('K1', 'Traseu');
        $sheet->setCellValue('L1', 'Observații');

        $row = 2;

        foreach ($salariati as $salariat) {
            $sheet->setCellValueExplicit('A' . $row, $salariat->nume_client, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B' . $row, $salariat->salariat, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $row, $salariat->data_ssm_psi, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D' . $row, $salariat->semnat_ssm, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('E' . $row, $salariat->semnat_psi, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F' . $row, $salariat->cnp, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G' . $row, $salariat->functia, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('H' . $row, $salariat->actionar, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('I' . $row, $salariat->data_angajare, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('J' . $row, $salariat->data_incetare, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('K' . $row, $salariat->traseu, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('L' . $row, $salariat->observatii_1, DataType::TYPE_STRING);
            $row++;
        }

        // Se parcug toate coloanele si se stabileste latimea AUTO
        foreach ($sheet->getColumnIterator() as $column) {
            // $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);

            $columnIndex = $column->getColumnIndex();

            // Disable Word Wrap
            $sheet->getStyle($columnIndex . '1:' . $columnIndex . '100')
                ->getAlignment()
                ->setWrapText(false);

            // Set AutoSize
            $sheet->getColumnDimension($columnIndex)->setAutoSize(true);
        }

        // Recalculate column widths
        $spreadsheet->getActiveSheet()->calculateColumnWidths();

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="SsmSalariati.xlsx"');
        $writer->save('php://output');
        exit();
    }
}
