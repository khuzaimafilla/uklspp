<?php 
include 'koneksi.php';

include 'header.php';
 ?>
<div class="container">
<div class="container">
	<div class="page-header">
	<div class="panel panel-info col-md-15">
	<div class="panel-heading">
	<h2 class="text-primary"> DATA SISWA SMK TELKOM MALANG</h2>
</div>
 <table class="table table-bordered table-striped">
 	<tr>
 		<th>NO</th>
 		<th>KELAS</th>
 		<th>NIS</th>
 		<th>NAMA SISWA</th>
 		<th>TAHUN AJARAN</th>
		<th>BIAYA</th>
		<th>AKSI</th>
 	</tr>
 	<?php 
 	$data = $konek ->query("SELECT * FROM siswa ORDER BY idsiswa ASC");
 	$i=1;
 	while ($dta = mysqli_fetch_assoc($data) ) : 
 	 ?>
 	 <tr>
 	 	<td><?= $i; ?></td>
 	 	<td><?= $dta['kelas'] ?></td>
 	 	<td><?= $dta['nis'] ?></td>
 	 	<td><?= $dta['namasiswa'] ?></td>
 	 	<td><?= $dta['tahunajaran'] ?></td>
 	 	<td><?= $dta['biaya'] ?></td>
 	 	<td>
 	 		<a class="btn btn-info btn-sm" href="ubahSW.php?id=<?= $dta['idsiswa'] ?>">EDIT</a> 
 	 		<a class="btn btn-danger btn-sm" href="hapusSW.php?id=<?= $dta['idsiswa'] ?>" onclick ="return confirm('apakah anda yakin ingin menghapus data? data SPP Siswa yang bersangkutan akan ikut terhapus')">HAPUS</a>
 	 	</td>
 	 </tr>
 	 <?php $i++;  ?>
 	<?php endwhile; ?>
 </table>
 
 </div>
 <a class="btn btn-primary " href="tambahSW.php">TAMBAH DATA</a>
 <p align="center" style="font-family: arial; color: red; size: 10px;">Menghapus Data Siswa Maka Akan menghapus Data Pembayaran dan data tagihan Siswa pada tabel SPP</p>
 <?php include 'footer.php'; ?>