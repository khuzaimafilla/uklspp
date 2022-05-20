<?php 
include 'koneksi.php';
$sqlsiswa = mysqli_query($konek , "SELECT * FROM siswa WHERE idsiswa = '$_GET[id]' ") ;
$sw = mysqli_fetch_assoc($sqlsiswa);

$sqlspp=mysqli_query($konek , "SELECT max(jatuhtempo) AS last FROM spp WHERE idsiswa = '$_GET[id]' ") ;
$spp = mysqli_fetch_assoc($sqlspp);
 

include 'header.php';
 ?>
<div class="container">
	<div class="page-header">
<h2 >EDIT DATA SISWA</h2>
 
</div>
 	<?php if (isset($error)) : ?>
 		<p style="font-family: arial; color: red; size: 14px;">Silahkan Lengkapi Form Terlebih Dahulu</p>
 	<?php endif; ?>
 	<form action="" method="post">
 	<table class="table">
 		<tr>
 			<td>NIS</td>
 			<td>
 				<input class="form-control" type="hidden" name="id" value="<?= $sw['idsiswa'] ?>">
 				<input class="form-control" type="text" readonly name="nis" value="<?= $sw['nis'] ?>" size="30">
 			</td>
 		</tr>
 		<tr>
 			<td>Nama Siswa</td>
 			<td>
 				<input class="form-control" type="text" name="namasiswa" value="<?= $sw['namasiswa'] ?>" maxlength="40" size="30">
 			</td>
 		</tr>
 		<tr>
 			<td>Kelas</td>
 			<td>
 				<select class="form-control" name="kelas">
 					<?php 
 					$data = mysqli_query($konek ,"SELECT * FROM walikelas ORDER BY kelas ASC");
 					while($kls = mysqli_fetch_assoc($data)){
 					 ?>
 					 <?php if($sw['kelas'] == $kls['kelas']) {
 					 	$selected = 'selected';
 					 }else {
 					 	$selected="";
 					 }
 					 ?>
 					 <option value="<?= $kls['kelas']; ?>"><?= $kls['kelas']; ?></option>
 					 <?php
 					}
 					 ?>
 							
 				</select>
 			</td>
 		</tr>
 		<tr>
 			<td>Tahun Ajaran</td>
 			<td>
 				<input class="form-control" type="text" name="tahunajaran" readonly value="<?= $sw['tahunajaran'] ?>" >
 			</td>
 		</tr>
 	
 		<tr>
 			<td>Biaya</td>
 			<td>
 				<input class="form-control" type="text" name="biaya" value="<?= $sw['biaya'] ?>" >
 			</td>
 		</tr>
 		<tr>
 			<td>Jatuh Tempo</td>
 			<td>
 				<input class="form-control" type="text" name="jatuhtempo" value="2021-01-10" readonly>
 			</td>
 		</tr>
		 <tr>
 			<td><strong>Tambah Tagihan SPP <br/> (Hitungan Dalam Tahun)</strong> </td>
 			<td>
			  <input class="form-control" type="hidden" name="jatuhtempoakhir" value="<?= $spp['last'] ?>" >
			  <input class="form-control" type="number" name="tambahtagihan" value="0" >

 			<!--	
			  <select class="form-control" name="tambahtagihan" required>
 					<option value="0" selected >0 Tahun</option>
 					<option value="1" >1 Tahun</option>
 					<option value="2">2 Tahun</option>
 				</select>
				-->
				 <div class="alert alert-danger">
				<span><b>Biarkan 0 Jika tidak ada tambahan tagihan</b></span>
			</div>
 			</td>
 		</tr>
 		<tr>
 			<td></td>
 			<td>
 				<button class="btn btn-info" type="submit" name="ubah">UPDATE DATA</button>
 			</td>
 		</tr>
 	</table>
 </form>
 
 </body>
 </html>
<?php 
 if (isset($_POST['ubah']) ) {
 	$id = $_POST['id'];
 	$nis   		 = $_POST['nis'];
 	$namasiswa 	 = $_POST['namasiswa'];
 	$kelas 		 = $_POST['kelas'];
 	$tahunajaran = $_POST['tahunajaran'];
 	$biaya  	 = $_POST['biaya'];
	$tbh_tagihan =$_POST['tambahtagihan'];
 	// $awaltempo	 = $_POST['jatuhtempo'];
	 $tambahjatuhtempo=$_POST['jatuhtempoakhir'];
	 $bulanIndo =[
		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember',
	];
	
 	$ubah = mysqli_query($konek , "UPDATE siswa SET nis = '$nis',
 		namasiswa = '$namasiswa',
 		kelas = '$kelas',
 		tahunajaran = '$tahunajaran',
 		biaya  = '$biaya' WHERE idsiswa = '$id'");

	$ubahspp=mysqli_query($konek,"UPDATE spp SET jumlah='$biaya' WHERE idsiswa='$sw[idsiswa]'");

 	if ($ubah){
		 if($tbh_tagihan!=0){
			$c=($tbh_tagihan * 12)+1; //agar tidak terjadi perulangan yang sama pada bulan terakhir 
			 
			for ($i=1 ; $i<$c;$i++){
				// tanggal jatuh tempo setiap tanggal 10
				$jatuhtempo = date("Y-m-d" , strtotime("+$i month" , strtotime($tambahjatuhtempo)));
		
				$bulan     = $bulanIndo[date('m' ,strtotime($jatuhtempo))]."  ".date('Y', strtotime($jatuhtempo));
				// simpan data
				$add = mysqli_query($konek,"INSERT INTO spp(idsiswa , jatuhtempo, bulan, jumlah) VALUES ('$sw[idsiswa]','$jatuhtempo','$bulan','$biaya')");
				
			}
		 }
		 
		/**
		if($tbh_tagihan==1){
			for ($i=0 ; $i<12;$i++){
				// tanggal jatuh tempo setiap tanggal 10
				$jatuhtempo = date("Y-m-d" , strtotime("+$i month" , strtotime($tambahjatuhtempo)));
		
				$bulan     = $bulanIndo[date('m' ,strtotime($jatuhtempo))]."  ".date('Y', strtotime($jatuhtempo));
				// simpan data
				$add = mysqli_query($konek,"INSERT INTO spp(idsiswa , jatuhtempo, bulan, jumlah) VALUES ('$idsiswa','$jatuhtempo','$bulan','$biaya')");
				
			}
		}elseif($tbh_tagihan==2){
			for ($i=0 ; $i<24;$i++){
				// tanggal jatuh tempo setiap tanggal 10
				$jatuhtempo = date("Y-m-d" , strtotime("+$i month" , strtotime($tambahjatuhtempo)));
		
				$bulan     = $bulanIndo[date('m' ,strtotime($jatuhtempo))]."  ".date('Y', strtotime($jatuhtempo));
				// simpan data
				$add = mysqli_query($konek,"INSERT INTO spp(idsiswa , jatuhtempo, bulan, jumlah) VALUES ('$idsiswa','$jatuhtempo','$bulan','$biaya')");
				
			}
		}else{}
		 */


 		echo "
 		<script>
 		alert('data berhasil diedit');
 		document.location.href = 'datasiswa.php';
 		</script>
 		";
 	}else{
 		echo "
 		<script>
 		alert('data gagal diedit');
 		</script>
 		";
 	}
 }


  ?>
</div>
 <?php include 'footer.php'; ?>