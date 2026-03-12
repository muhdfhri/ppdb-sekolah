<?php

namespace App\Exports;

use Illuminate\Support\Collection;

/**
 * LaporanExport
 * Menghasilkan file Excel (.xlsx) atau PDF menggunakan library PHP murni
 * tanpa dependensi maatwebsite/excel — cukup dengan PhpSpreadsheet + DomPDF.
 *
 * Instalasi (jalankan sekali):
 *   composer require phpoffice/phpspreadsheet
 *   composer require barryvdh/laravel-dompdf
 */
class LaporanExport
{
    /** Kolom yang ditampilkan & urutan */
    protected array $columns = [
        'no' => 'No',
        'nama_siswa' => 'Siswa',
        'nomor_pendaftaran' => 'No. Pendaftaran',
        'nisn' => 'NISN',
        'asal_sekolah' => 'Asal Sekolah',
        'jurusan_pilihan1' => 'Jurusan',
        'tanggal_daftar' => 'Tanggal Daftar',
    ];

    protected string $schoolName = 'SMK NU II Medan';
    protected string $color = '01893E';  // hijau primer
    protected string $colorLight = 'E8F5EE';

    // ── Excel ─────────────────────────────────────────────────

    public function toExcel(Collection $data): string
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Pendaftar');

        $colCount = count($this->columns);
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);

        // ── Judul ──
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', 'LAPORAN DATA PENDAFTAR PPDB');
        $this->styleCell($sheet, 'A1', [
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => $this->color]],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->mergeCells("A2:{$lastCol}2");
        $sheet->setCellValue('A2', $this->schoolName . ' — Dicetak: ' . now()->translatedFormat('d F Y'));
        $this->styleCell($sheet, 'A2', [
            'font' => ['size' => 9, 'color' => ['rgb' => '555555']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'E8F5EE']],
            'alignment' => ['horizontal' => 'center'],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(16);

        // ── Header kolom (baris 3) ──
        $headerRow = 3;
        $col = 1;
        foreach ($this->columns as $label) {
            $cellAddr = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $headerRow;
            $sheet->setCellValue($cellAddr, $label);
            $this->styleCell($sheet, $cellAddr, [
                'font' => ['bold' => true, 'size' => 9, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => $this->color]],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'FFFFFF']]],
            ]);
            $col++;
        }
        $sheet->getRowDimension($headerRow)->setRowHeight(20);

        // ── Data rows ──
        $dataStart = $headerRow + 1;
        foreach ($data as $i => $row) {
            $r = $dataStart + $i;
            $fill = $i % 2 === 0 ? 'F0FAF4' : 'FFFFFF';
            $col = 1;
            foreach (array_keys($this->columns) as $key) {
                $cellAddr = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col) . $r;
                $sheet->setCellValue($cellAddr, $row[$key] ?? '—');
                $this->styleCell($sheet, $cellAddr, [
                    'font' => ['size' => 9],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => $fill]],
                    'alignment' => [
                        'horizontal' => in_array($key, ['no', 'tanggal_daftar', 'jurusan_pilihan1']) ? 'center' : 'left',
                        'vertical' => 'center',
                    ],
                    'borders' => ['allBorders' => ['borderStyle' => 'thin', 'color' => ['rgb' => 'DDDDDD']]],
                ]);
                $col++;
            }
            $sheet->getRowDimension($r)->setRowHeight(18);
        }

        // ── Total row ──
        $totalRow = $dataStart + count($data);
        $sheet->mergeCells("A{$totalRow}:" . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount - 1) . $totalRow);
        $sheet->setCellValue("A{$totalRow}", 'TOTAL PENDAFTAR');
        $sheet->setCellValue("{$lastCol}{$totalRow}", count($data));
        foreach (range(1, $colCount) as $c) {
            $addr = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($c) . $totalRow;
            $this->styleCell($sheet, $addr, [
                'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => $this->color]],
                'alignment' => ['horizontal' => $c === 1 ? 'right' : 'center', 'vertical' => 'center'],
            ]);
        }
        $sheet->getRowDimension($totalRow)->setRowHeight(20);

        // ── Column widths ──
        $widths = [5, 28, 20, 16, 28, 10, 16];
        foreach ($widths as $c => $w) {
            $sheet->getColumnDimensionByColumn($c + 1)->setWidth($w);
        }

        // ── Freeze header ──
        $sheet->freezePane("A{$dataStart}");

        // ── Save ke temp file ──
        $tmpPath = storage_path('app/exports/laporan_ppdb_' . now()->format('Ymd_His') . '.xlsx');
        @mkdir(dirname($tmpPath), 0755, true);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tmpPath);

        return $tmpPath;
    }

    // ── PDF ───────────────────────────────────────────────────

    public function toPdf(Collection $data): string
    {
        $rows = $data->map(fn($r) => array_values(array_intersect_key(
            $r,
            array_flip(array_keys($this->columns))
        )))->toArray();

        $html = $this->buildHtml($rows);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape')
            ->setOption(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true]);

        $tmpPath = storage_path('app/exports/laporan_ppdb_' . now()->format('Ymd_His') . '.pdf');
        @mkdir(dirname($tmpPath), 0755, true);
        $pdf->save($tmpPath);

        return $tmpPath;
    }

    // ── HTML template untuk PDF ───────────────────────────────

    private function buildHtml(array $rows): string
    {
        $headerCells = implode('', array_map(
            fn($l) => "<th>{$l}</th>",
            array_values($this->columns)
        ));

        $bodyRows = '';
        foreach ($rows as $i => $row) {
            $bg = $i % 2 === 0 ? '#f0faf4' : '#ffffff';
            $cells = implode('', array_map(fn($v) => "<td>{$v}</td>", $row));
            $bodyRows .= "<tr style='background:{$bg}'>{$cells}</tr>";
        }

        $total = count($rows);
        $date = now()->translatedFormat('d F Y');
        $color = '#01893e';

        return <<<HTML
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<style>
  body   { font-family: sans-serif; font-size: 9pt; color: #222; margin:0; padding:0; }
  .title { text-align:center; font-size:14pt; font-weight:bold; color:{$color}; margin-bottom:2px; }
  .sub   { text-align:center; font-size:8.5pt; color:#666; margin-bottom:12px; }
  table  { width:100%; border-collapse:collapse; }
  thead tr { background:{$color}; color:#fff; }
  th     { padding:6px 8px; font-size:8.5pt; text-align:center; }
  td     { padding:5px 8px; font-size:8pt; border-bottom:1px solid #ddd; }
  td:first-child, td:nth-child(6), td:nth-child(7) { text-align:center; }
  .footer { margin-top:10px; font-size:7.5pt; color:#888; }
</style>
</head>
<body>
<div class="title">LAPORAN DATA PENDAFTAR PPDB</div>
<div class="sub">SMK NU II Medan &mdash; Dicetak: {$date}</div>
<table>
  <thead><tr>{$headerCells}</tr></thead>
  <tbody>{$bodyRows}</tbody>
</table>
<div class="footer">Total Pendaftar: {$total} orang &nbsp;|&nbsp; Dokumen ini digenerate otomatis oleh sistem PPDB SMK NU II Medan</div>
</body>
</html>
HTML;
    }

    // ── Helper: apply style array ke sel ─────────────────────

    private function styleCell(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, string $cell, array $style): void
    {
        $s = $sheet->getStyle($cell);

        if (!empty($style['font'])) {
            $f = $s->getFont();
            if (isset($style['font']['bold']))
                $f->setBold($style['font']['bold']);
            if (isset($style['font']['size']))
                $f->setSize($style['font']['size']);
            if (isset($style['font']['color']))
                $f->getColor()->setRGB($style['font']['color']['rgb']);
        }

        if (!empty($style['fill'])) {
            $fill = $s->getFill();
            $fill->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $fill->getStartColor()->setRGB($style['fill']['startColor']['rgb']);
        }

        if (!empty($style['alignment'])) {
            $a = $s->getAlignment();
            if (isset($style['alignment']['horizontal'])) {
                $map = [
                    'center' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'left' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'right' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                ];
                $a->setHorizontal($map[$style['alignment']['horizontal']] ?? $style['alignment']['horizontal']);
            }
            if (isset($style['alignment']['vertical'])) {
                $a->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            }
        }

        if (!empty($style['borders'])) {
            foreach ($style['borders'] as $borderType => $borderDef) {
                $bStyle = \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN;
                $color = new \PhpOffice\PhpSpreadsheet\Style\Color();
                $color->setRGB($borderDef['color']['rgb'] ?? 'CCCCCC');
                $border = $s->getBorders();
                $border->getLeft()->setBorderStyle($bStyle)->setColor($color);
                $border->getRight()->setBorderStyle($bStyle)->setColor($color);
                $border->getTop()->setBorderStyle($bStyle)->setColor($color);
                $border->getBottom()->setBorderStyle($bStyle)->setColor($color);
            }
        }
    }
}