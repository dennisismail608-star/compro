<?php
// jika data setting sudah ada maka update data tersebut

$querySetting = mysqli_query($koneksi, "SELECT * FROM settings LIMIT 1");
$row = mysqli_fetch_assoc($querySetting);

if (isset($_POST['simpan'])) {
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $ig = $_POST['ig'];
  $fb = $_POST['fb'];
  $twitter = $_POST['twitter'];
  $linkedin = $_POST['linkedin'];

  // jika gambar terupload
  if (!empty($_FILES['logo']['name'])) {
    $logo = $_FILES['logo']['name'];
    $path = "uploads/";

    if (!is_dir($path)) mkdir($path);

    $logo_name = md5($logo);
    $target_files = $path . $logo_name;

    if (move_uploaded_file($_FILES['logo']['tmp_name'], $target_files)) {
      // jika gambarnya ada maka gambar sebelumnya akan diganti oleh gambar baru
      if (!empty($row['logo'])) {
        unlink($path . $row['logo']);
      }
    }
  }

  if ($row) {
    // update
    $id_setting = $row['id'];

    $update = mysqli_query($koneksi, "UPDATE settings SET email = '$email', phone = '$phone', address = '$address', ig = '$ig', fb = '$fb', twitter = '$twitter', linkedin = '$linkedin', logo = '$logo_name' WHERE id = '$id_setting'");
    if ($update) {
      header("location:?page=setting&ubah=berhasil");
    }
  } else {
    $insert = mysqli_query($koneksi, "INSERT INTO setting (email, phone, address, ig, fb, twitter, linkedin, logo) VALUES ('$email', '$phone', '$address', 'ig', 'fb', 'twitter', 'linkedin', 'logo')");
    if ($insert) {
      header("location:?page=setting&tambah=berhasil");
    }
  }
}

?>

<div class="pagetitle">
  <h1>Setting</h1>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Setting</h5>


          <form action="" method="post" enctype="multipart/form-data">
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">Email</label>
              </div>
              <div class="col-sm-10">
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email Anda" value="<?php echo isset($row['email']) ? $row['email'] : '' ?>" autofocus>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">Phone</label>
              </div>
              <div class="col-sm-10">
                <input type="number" name="phone" id="phone" class="form-control" placeholder="Masukkan telepon Anda" value="<?php echo isset($row['phone']) ? $row['phone'] : '' ?>">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">address</label>
              </div>
              <div class="col-sm-10">
                <textarea name="address" class="form-control" placeholder="Masukkan address Anda" id="floatingTextarea2" style="height: 100px"><?php echo isset($row['address']) ? $row['address'] : '' ?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">ig</label>
              </div>
              <div class="col-sm-10">
                <input type="url" name="ig" id="ig" class="form-control" placeholder="Masukkan ig Anda" value="<?php echo isset($row['ig']) ? $row['ig'] : '' ?>">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">fb</label>
              </div>
              <div class="col-sm-10">
                <input type="url" name="fb" id="fb" class="form-control" placeholder="Masukkan fb Anda" value="<?php echo isset($row['fb']) ? $row['fb'] : '' ?>">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">Twitter</label>
              </div>
              <div class="col-sm-10">
                <input type="url" name="twitter" id="twitter" class="form-control" placeholder="Masukkan Twitter Anda" value="<?php echo isset($row['twitter']) ? $row['twitter'] : '' ?>">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">Linkedin</label>
              </div>
              <div class="col-sm-10">
                <input type="url" name="linkedin" id="linkedin" class="form-control" placeholder="Masukkan Linkedin Anda" value="<?php echo isset($row['linkedin']) ? $row['linkedin'] : '' ?>">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-2">
                <label for="" class="form-label fw-bold">logo</label>
              </div>
              <div class="col-sm-10">
                <input type="file" class="form-control" name="logo" id="inputGroupFile02">
                <img class="mt-2" src="uploads/<?php echo isset($row['logo']) ? $row['logo'] : '' ?>" alt="" width="100">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-2"></div>
              <div class="col-sm-10">
                <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                <a href="?page=user" class="btn btn-secondary" onclick="history.back()">
                  ← Kembali
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>