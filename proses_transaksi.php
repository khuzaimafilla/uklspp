<?php 
session_start();
if(isset($_SESSION['login']) ) {
	include 'koneksi.php';
	if($_GET['act']=='bayar') {
		$idspp = $_GET['id'];
		$nis   = $_GET['nis'];
		
		// bulan
		$today =date("ymd");//menentukan hari sekarang contoh (220125)
		$query =mysqli_query($konek , "SELECT max(nobayar) AS last FROM spp WHERE nobayar LIKE '$today%'");
		//mngambil nilai terbesar pada kolom nobayar berdasarkan nilai dari variabel $today
		$data = mysqli_fetch_assoc($query);//mengembalikan nilai berupa assosiative array berdasarkan nama pada kolom spp
		$lastNobayar = $data['last'];//mengambil nilai kolom last dan disimpan pada variable $nobayar
		$lastNoUrut  = substr($lastNobayar, 6 ,4);//mengambil  string karakter yang adaa pada variable $lastnobayar mulai dari index ke 6(karakter ke 7 dan diambil sebanyak 4)
		$nextNoUrut  = $lastNoUrut;//mengambil nilai dari variable $lastnourut dan disimpan ke dalam variable $nextnourut
		$nextNobayar = $today.sprintf('%04s' , $nextNoUrut);//menyimpan nilai variable

		// tanggal bayar
		$tglbayar = date('Y-m-d');

		// id admin
		$admin = $_SESSION['id'];
		
		$byr = mysqli_query($konek ,"UPDATE spp SET 
			nobayar = '$nextNobayar',
			tglbayar = '$tglbayar',
			ket = 'LUNAS',
			idadmin = '$admin' 
			WHERE idspp = '$idspp'");

		if ($byr) {
			header('location: transaksi.php?nis='.$nis);
		}else {
			echo "
			<script>
			alert('gagal')
			</script>
			";

		}
		
	}
	else if($_GET['act']=='batal'){
	    $idspp = $_GET['id'];
		$nis   = $_GET['nis'];

		$batal = mysqli_query($konek ,"UPDATE spp SET 
			nobayar = null,
			tglbayar = null,
			ket = null,
			idadmin = null 
			WHERE idspp = '$idspp'");

			if ($batal) {
				header('location: transaksi.php?nis='.$nis);
		}
	}
}
 ?>