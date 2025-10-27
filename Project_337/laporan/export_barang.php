<?php
include '../config/db.php';
require('../fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Logo dan Judul
        $this->Image('../assets/logo.png', 10, 8, 20);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'LAPORAN DATA BARANG GUDANG', 0, 1, 'C');
        
        // Zona waktu WIB
        date_default_timezone_set('Asia/Jakarta');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 8, 'Dicetak: ' . date('d-m-Y H:i') . ' WIB', 0, 1, 'C');
        $this->Ln(5);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }

    // ==== FUNGSI UNTUK TABEL DENGAN TINGGI OTOMATIS ====
    function Row($data, $aligns) {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 6 * $nb;

        $this->CheckPageBreak($h);
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($aligns[$i]) ? $aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 6, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") $nb--;
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") { $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue; }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else $i = $sep + 1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else $i++;
        }
        return $nl;
    }
}

// === QUERY DATA BARANG ===
$sql = "SELECT * FROM tb_barang ORDER BY tanggal_input DESC";
$result = $conn->query($sql);

// === INISIALISASI PDF ===
$pdf = new PDF();
$pdf->AddPage('L'); // Landscape
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(230, 230, 230);

// === SETTING KOLOM ===
$pdf->widths = [10, 35, 55, 40, 30, 20, 35];
$aligns = ['C', 'C', 'L', 'C', 'C', 'C', 'C'];

// === HEADER TABEL ===
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Kode Barang', 1, 0, 'C', true);
$pdf->Cell(55, 10, 'Nama Barang', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Kategori', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Satuan', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Stok', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Tanggal Input', 1, 1, 'C', true);

// === ISI TABEL ===
$pdf->SetFont('Arial', '', 10);
$no = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Row([
        $no++,
        $row['kode_barang'],
        $row['nama_barang'],
        $row['kategori'],
        $row['satuan'],
        $row['stok'],
        date('d-m-Y', strtotime($row['tanggal_input']))
    ], $aligns);
}

// === OUTPUT PDF ===
$pdf->Output('D', 'laporan_barang.pdf');
exit;
?>
