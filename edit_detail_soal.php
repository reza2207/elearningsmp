<title>Edit Detail soal</title>
<?php include ("config/koneksi.php");
include ("header.php");?>
	<?php
			$id = $_GET["id"];
			$idsoal = $_GET['idsoal'];
			$sql = mysqli_query($connect, "SELECT * FROM soal WHERE id_test='$id' AND id_soal='$idsoal'");
			if(mysqli_num_rows($sql) == 0){
				echo '<script>javascript:history.go(-1);</script>';
			}else{
				$data = mysqli_fetch_assoc($sql);
				if(isset($_POST['tambah'])){
					$id = $_POST['idsoal'];
					$soal = ucfirst(addslashes($_POST['soal']));
					$pila = ucfirst(addslashes($_POST['pil_a']));
					$pilb = ucfirst(addslashes($_POST['pil_b']));
					$pilc = ucfirst(addslashes($_POST['pil_c']));
					$pild = ucfirst(addslashes($_POST['pil_d']));

					$kunci = $_POST['kunci'];

					$ubah = mysqli_query($connect, "UPDATE soal SET soal='$soal', pil_a= '$pila', pil_b= '$pilb', pil_c= '$pilc', pil_d= '$pild', kunci_jawaban = '$kunci' WHERE id_test='$id'"); //update ke database
					if($ubah){
					print "<script>alert('Berhasil');
					javascript:window.location = 'edit_soal.php?ubahsuccess&idsoal=$idsoal&id=$id';</script>";
						}else{ echo '<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  						<strong>Soal gagal diubah.</strong>
	  						</div>';
	  				}
	  			}?>
<div class="container" style="background-color:#F8F8FF;	box-shadow: 10px 10px 5px #888888;	border-radius: 10px">
<br>
			<form role="form" method="post">
	      		<div class="container-fluid">
  					<div class="form-group"> 
  						<input type="hidden" name="idsoal" value="<?php echo $id;?>">
	    				<label for="soal">Soal:</label>
	    				<textarea type="text" name="soal" class="form-control" required><?php echo $data['soal'];?></textarea>
	 				</div>
 					<div class="form-group">
  						<label for="pil_a">Pilihan A:</label>
  						<input type="text" name="pil_a" class="form-control" value="<?php echo $data['pil_a'];?>" required> 
  					</div>
	  				<div class="form-group">
  						<label for="pil_b">Pilihan B:</label>
  						<input type="text" name="pil_b" class="form-control" value="<?php echo $data['pil_b'];?>" required> 
  					</div>
  					<div class="form-group">
  						<label for="pil_c">Pilihan C:</label>
  						<input type="text" name="pil_c" class="form-control" value="<?php echo $data['pil_c'];?>" required>
  					</div>
  					<div class="form-group">
  						<label for="pil_d">Pilihan D:</label>
  						<input type="text" name="pil_d" class="form-control" value="<?php echo $data['pil_d'];?>" required>
  					</div>
  					<div class="form-group">
  						<label for="kunci">Kunci Jawaban:</label>
  						<select class="form-control" name="kunci" required>
  						<?php if($data['kunci_jawaban']=='A'){
  							echo'
									<option value="a" selected>A</option>
								    <option value="b">B</option>
								    <option value="c">C</option>
								    <option value="d">D</option>'
							;}elseif($data['kunci_jawaban']=='B'){
								    echo'<option value="a">A</option>
								    <option value="b" selected>B</option>
								    <option value="c">C</option>
								    <option value="d">D</option>'
							;}elseif($data['kunci_jawaban']=='C'){
									echo '<option value="a">A</option>
								    <option value="b">B</option>
								    <option value="c" selected>C</option>
								    <option value="d">D</option>'
							;}else{echo '<option value="a">A</option>
								    <option value="b">B</option>
								    <option value="c">C</option>
								    <option value="d" selected>D</option>'
								;}?>
						</select>
				</div>
		      	<div class="modal-footer">
			    	<button type="reset" class="btn btn-default" name="reset">Reset</button>
			    	<button type="submit" class="btn btn-primary" name="tambah">Ubah</button>
			    </div>
		   	</form>
</div>
<?php }?>
</div>
<br>
<?php include ('footer.php');?>