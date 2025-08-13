<?php
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM about WHERE id ='$id'");
    $rowEdit  = mysqli_fetch_assoc($query);
    $title = "Edit tentang kami";
} else {
    $title = "Tambah tentang kami";
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $queryGambar  = mysqli_query($koneksi, "SELECT id, image FROM about WHERE id='$id'");
    $rowGambar = mysqli_fetch_assoc($queryGambar);
    $image_name = $rowGambar['image'];
    unlink("uploads/" . $image_name);
    $delete = mysqli_query($koneksi, "DELETE FROM about WHERE id='$id'");

    if ($delete) {
        header("location:?page=about&hapus=berhasil");
    }
}

// print_r($rowEdit['password']);
// die;

if (isset($_POST['simpan'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $is_active = $_POST['is_active'];

    if (!empty($_FILES['image']['name'])) {
        $image     = $_FILES['image']['name'];
        $tmp_name  = $_FILES['image']['tmp_name'];
        $type      = mime_content_type($tmp_name);
        // print_r($type);
        // die;

        $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];

        if (in_array($type, $ext_allowed)) {
            $path = "uploads/";
            if (!is_dir($path)) mkdir($path);

            $image_name = time() . "-" . basename($image);
            $target_files = $path . $image_name;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_files)) {
                // jika gambarnya ada maka gambar sebelumnya akan di ganti oleh 
                // gambar baru
                if (!empty($row['image'])) {
                    unlink($path . $row['image']);
                }
            }
        } else {
            echo "extensi file tidak ditemukan";
            die;
        }
    }

    // print_r($password);
    // die;
    if ($id) {
        // ini query update
        $update = mysqli_query($koneksi, "UPDATE about SET title='$title', 
        content='$content', is_active='$is_active', image='$image_name' WHERE id='$id'");
        if ($update) {
            header("location:?page=about&ubah=berhasil");
        }
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO about (title, content, image, is_active) 
        VALUES('$title','$content','$image_name', $is_active)");
        if ($insert) {
            header("location:?page=about&tambah=berhasil");
        }
    }
}




?>
<div class="pagetitle">
    <h1><?php echo $title ?></h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $title ?></h5>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="">Gambar</label>
                            <input type="file"
                                name="image" required>
                            <small class="text-muted">)* Size : 1920 * 1088</small>
                        </div>
                        <div class="mb-3">
                            <label for="">Judul</label>
                            <input type="text" class="form-control"
                                name="title" placeholder="Masukkan judul slider"
                                required value="<?php echo ($id) ? $rowEdit['title'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="">Isi</label>
                            <textarea name="content" id="summernote" class="form-control"><?php echo ($id) ? $rowEdit['content'] : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="">is_Active</label>
                            <select name="is_active" id="" class="form-control">
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">publish</option>
                                <option <?php echo ($id) ? $rowEdit['is_active'] == 0 ? 'selected' : '' : '' ?> value="0">draft</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=user" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>


    </div>

</section>