<?php 
// jika data setting ada maka update data tersebut
// selain itu kalo belum ada maka insert data
if(isset($_POST['simpan'])){
  $email = $_POST ['email'];
  $phone = $_POST ['phone'];
  $address = $_POST ['address'];
  $ig = $_POST ['ig'];
  $fb = $_POST ['fb'];
  $twitter = $_POST ['twitter'];
  $linkedin = $_POST ['linkedin'];
  $querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
  if(mysqli_num_rows($querySetting) > 0) {
    // update
    $row = mysqli_fetch_assoc($querySetting);
    $id_setting = $row['id'];

    $update = mysqli_query($koneksi, "UPDATE settings SET email='$email', phone='$phone', addres='$address', ig='$ig', fb='$fb', twitter='$twitter', linkedin='$linkedin' WHERE id='$id_setting'");
  } else {
    // insert
    $insert = mysqli_query($koneksi, "INSERT INTO settings (email, phone, address, ig. fb. twitter, linkedin) VALUES ('$email', '$phone', '$address', '$ig', '$fb', '$twitter', $linkedin)");
    if ($insert) {
    header("location:?page=setting&tambah=berhasil");
    }
  }
}
 $querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
 $row = mysqli_fetch_assoc($querySetting);
?>
<div class="pagetitle">
      <h1>pengaturan</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
           <div class="col-lg-12">
   
             <div class="card">
               <div class="card-body">
                <div class="card-tittle fw-bold">pengaturan</div>
                 <form action="" method="post" enctype="multipart/form-data">
                  <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">email</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="email" name="email" id="" class="form-control">
                    </div>
                  </div>
                   <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">no telp</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="number" name="phone" id="" class="form-control value="<?php echo isset($row['email']) ? $row['email'] : ''?>>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">Alamat</label>
                    </div>
                    <div class="col-sm-6">
                      <textarea name="addres" id="" class="form-control value="<?php echo isset($row['address']) ? $row['address'] : ''?>" ></textarea>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">twitter</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="url" name="twitter" id="" class="form-control" value="<?php echo isset($row['twitter']) ? $row['twitter'] : ''?>>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">fb</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="url" name="fb" id="" class="form-control" value="<?php echo isset($row['fb']) ? $row['fb'] : ''?>>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">ig</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="url" name="ig" id="" class="form-control" value="<?php echo isset($row['ig']) ? $row['ig'] : ''?>>
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">linkedin</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="url" name="linkedin" id="" class="form-control" value="<?php echo isset($row['linkedin']) ? $row['linkedin'] : ''?>>
                    </div>
                  </div>
                    <div class="mb-3 row">
                    <div class="col-sm-2">
                      <label for="" class="fw-bold">logo</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="file" name="logo" id="" class="form-control">
                    </div>
                    
                  </div>
                  <div class="mb-3 row">
                    <div class="col-sm-12">
                      <button class="btn btn-primary" name="simpan">simpan</button>
                    </div>
                  </div>
                 </form>
               </div>
             </div>
   
           </div>
         </div>
        
        </section>