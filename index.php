<?php 
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "arkademy";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));
	
	//jika tombol simpan di klik
	if (isset($_POST['bsimpan'])) 
	{
		//pengujian data akan di edit atau disimpan baru
		if ($_GET['hal'] == "edit") 
		{
			//data akan di edit
			$edit = mysqli_query($koneksi, "UPDATE tb_produk set 
												nama_produk = '$_POST[tproduk]',
												keterangan = '$_POST[tketerangan]',
												harga = '$_POST[tharga]',
												jumlah = '$_POST[tjumlah]'
											WHERE id_barang = '$_GET[id]'
								");
			if ($edit)  //jika edit data sukses
			{
				echo "<script>
						alert('Edit data berhasil!');
						document.location='index.php';
					</script>";
			}
			else
			{
				echo "<script>
						alert('Edit data gagal!');
						document.location='index.php';
					</script>";
			}
		}
		else 
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tb_produk (nama_produk, keterangan, harga, jumlah) 
												VALUES  ('$_POST[tproduk]', 
														'$_POST[tketerangan]', 
														'$_POST[tharga]', 
														'$_POST[tjumlah]')
									");
			if ($simpan)  //jika simpan data sukses
			{
				echo "<script>
						alert('Simpan data berhasil!');
						document.location='index.php';
					</script>";
			}
			else
			{
				echo "<script>
						alert('Simpan data gagal!');
						document.location='index.php';
					</script>";
			}
		}	
	}

	// pengujian jika tombol edit/ hapus di klik
	if (isset($_GET['hal'])) 
	{
		//pengujian data yang akan di edit
		if ($_GET['hal'] == "edit") 
		{
			// tampilkan data yang akan di edit
			$tampil = mysqli_query($koneksi, "SELECT * from tb_produk WHERE id_barang = '$_GET[id]'");
			$data = mysqli_fetch_array($tampil);
			if ($data) 
			{
				//jika data ditemukan maka data ditampung ke dalam variabel
				$vproduk = $data['nama_produk'];
				$vketerangan = $data['keterangan'];
				$vharga = $data['harga'];
				$vjumlah = $data['jumlah'];
			}
		}
		else if($_GET['hal'] == "hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE from tb_produk WHERE id_barang = '$_GET[id]'");
			if ($hapus) {
				echo "<script>
						alert('Hapus data sukses!');
						document.location='index.php';
					</script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Tugas 10 CRUD - Fikry Aziz Septian</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

	<h1 class="text-center">TUGAS 10 CRUD</h1>
	<h2 class="text-center">@FikryAS</h2>

	<!-- Awal Card Form-->
	<div class="card mt-4">
	  <div class="card-header bg-primary text-white">
	    Form Input Data Barang
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Nama Produk</label>
	    		<input type="text" name="tproduk" value="<?=@$vproduk?>" class="form-control" placeholder="Input nama produk disini" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Keterangan</label>
	    		<textarea class="form-control" name="tketerangan" placeholder="Input keterangan produk disini"><?=@$vketerangan?></textarea>
	    	</div>
	    	<div class="form-row">
	    		<div class="col md-4">
		    		<label>Harga</label>
		    		<input type="text" name="tharga" value="<?=@$vharga?>" class="form-control" placeholder="Input harga produk disini" required>
	    		</div>
	    		<div class="col md-4">
		    		<label>Jumlah</label>
		    		<input type="text" name="tjumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Input jumlah produk disini" required>
	    		</div>
	    	</div>

	    	<button type="submit" class="btn btn-success mt-4" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger mt-4" name="breset">Reset Data</button>
	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form-->

	<!-- Awal Card Tabel-->
	<div class="card mt-4">
	  <div class="card-header bg-success text-white">
	    Daftar Barang
	  </div>
	  <div class="card-body">
	    
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>No.</th>
	  			<th>Nama Produk</th>
	  			<th>Keterangan</th>
	  			<th>Harga</th>
	  			<th>Jumlah</th>
	  			<th>Action</th>
	  		</tr>
	  		<?php 
	  			$no = 1;
	  			$tampil = mysqli_query($koneksi, "SELECT * from tb_produk order by id_barang desc");
	  			while($data = mysqli_fetch_array($tampil)):
	  		?>
	  		<tr>
	  			<td><?=$no++?></td>
	  			<td><?=$data['nama_produk']?></td>
	  			<td><?=$data['keterangan']?></td>
	  			<td><?=$data['harga']?></td>
	  			<td><?=$data['jumlah']?></td>
	  			<td>
	  				<a class="btn btn-warning" href="index.php?hal=edit&id=<?=$data['id_barang']?>">Edit</a>
	  				<a class="btn btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" href="index.php?hal=hapus&id=<?=$data['id_barang']?>">Hapus</a>
	  			</td>
	  		</tr>
	  	<?php endwhile; //penutup perulangan while ?>
	  	</table>

	  </div>
	</div>
	<!-- Akhir Card Tabel-->

</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>