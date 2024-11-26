<?php
require '../../koneksi/koneksi.php';
$title_web = 'Daftar Booking';
include '../header.php';

if (empty($_SESSION['USER'])) {
    session_start();
}

if (!empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $sql = "SELECT b.*, p.jenis_ps FROM booking b 
            LEFT JOIN playstation p ON b.id_ps = p.id_ps 
            WHERE b.id_login = '$id' 
            ORDER BY b.id_booking DESC";
} else {
    $sql = "SELECT b.*, p.jenis_ps FROM booking b 
            LEFT JOIN playstation p ON b.id_ps = p.id_ps 
            ORDER BY b.id_booking DESC";
}

try {
    // Menjalankan query dan menangkap hasilnya
    $hasil = $koneksi->query($sql)->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<br>
<div class="container">
    <div class="card">
        <div class="card-header text-white bg-primary">
            <h5 class="card-title">
                Daftar Booking
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Kode Booking</th>
                            <th>Type PS</th>
                            <th>Nama</th>
                            <th>Tanggal Sewa</th>
                            <th>Lama Sewa</th>
                            <th>Total Harga</th>
                            <th>Konfirmasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        foreach ($hasil as $isi) {
                            // Debugging: Tampilkan isi dari $isi untuk memastikan data ada
                            // var_dump($isi); // Uncomment untuk melihat data $isi jika diperlukan
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?= $isi['kode_booking']; ?></td>
                            <td><?= isset($isi['jenis_ps']) ? $isi['jenis_ps'] : 'Tidak ada'; ?></td> <!-- Cek null atau kosong -->
                            <td><?= $isi['nama']; ?></td>
                            <td><?= $isi['tanggal']; ?></td>
                            <td><?= $isi['lama_sewa']; ?> hari</td>
                            <td>Rp. <?= number_format($isi['total_harga']); ?></td>
                            <td><?= $isi['konfirmasi_pembayaran']; ?></td>
                            <td>
                                <a class="btn btn-primary" href="bayar.php?id=<?= $isi['kode_booking']; ?>" 
                                role="button">Detail</a>   
                            </td>
                        </tr>
                        <?php 
                        $no++;
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>
