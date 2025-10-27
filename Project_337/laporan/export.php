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
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue;
            }
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

// Query data transaksi
$sql = "SELECT t.*, b.nama_barang, u.username
        FROM tb_transaksi t
        JOIN tb_barang b ON t.id_barang = b.id
        LEFT JOIN tb_users u ON t.id_user = u.id
        ORDER BY t.tanggal DESC";
$result = $conn->query($sql);

// Inisialisasi PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(230, 230, 230);

// Lebar & alignment kolom tabel utama
$pdf->widths = [10, 35, 20, 20, 60, 25, 25];
$aligns = ['C', 'L', 'C', 'C', 'L', 'C', 'C'];

// === HEADER TABEL UTAMA ===
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Barang', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Jenis', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Jumlah', 1, 0, 'C', true);
$pdf->Cell(60, 10, 'Keterangan', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Tanggal', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Pengguna', 1, 1, 'C', true);

// === ISI TABEL ===
$pdf->SetFont('Arial', '', 10);
$no = 1;
$total_masuk = 0;
$total_keluar = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['jenis'] == 'masuk') {
        $total_masuk += $row['jumlah'];
    } elseif ($row['jenis'] == 'keluar') {
        $total_keluar += $row['jumlah'];
    }

    $pdf->Row([
        $no++,
        $row['nama_barang'],
        ucfirst($row['jenis']),
        $row['jumlah'],
        $row['keterangan'],
        date('d-m-Y', strtotime($row['tanggal'])),
        $row['username']
    ], $aligns);
}

// === TABEL TOTAL BARANG ===
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Rekapitulasi Total Barang', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetFillColor(230, 230, 230);

// Header kecil
$pdf->Cell(90, 10, 'Keterangan', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Jenis', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Jumlah', 1, 1, 'C', true);

// Isi total masuk
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(90, 10, 'Total Barang Masuk', 1, 0, 'L');
$pdf->Cell(50, 10, 'Masuk', 1, 0, 'C');
$pdf->Cell(50, 10, $total_masuk, 1, 1, 'C');

// Isi total keluar
$pdf->Cell(90, 10, 'Total Barang Keluar', 1, 0, 'L');
$pdf->Cell(50, 10, 'Keluar', 1, 0, 'C');
$pdf->Cell(50, 10, $total_keluar, 1, 1, 'C');

// === OUTPUT FILE PDF ===
$pdf->Output('D', 'riwayat_transaksi.pdf');
exit;
?>
