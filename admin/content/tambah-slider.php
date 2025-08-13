<?php

$id = isset($_GET['id']) ? $_GET['edit'] : '';

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM sliders WHERE id = '$id'");
    $rowEdit = mysqli_fetch_assoc($query);

    $title = "Edit Slider";
} else {
    $title = "Tambah Slider";
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = mysqli_query($koneksi, "DELETE FROM sliders WHERE id = '$id'");

    header("location:?page=slider&hapus=berhasil");
}

if (isset($_POST['simpan'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // jika gambar terupload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $type = mime_content_type($tmp_name);

        $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];

        if (!in_array($type, $ext_allowed)) {
            echo "Extensi file tidak diizinkan";
            exit;
        }

        $path = "uploads/";
        if (!is_dir($path)) mkdir($path);

        $image_name = md5($image) . "." . pathinfo($image, PATHINFO_EXTENSION);
        $target_files = $path . $image_name;


        if (move_uploaded_file($tmp_name, $target_files)) {
            echo "Upload berhasil";
        } else {
            echo "Upload gagal";
        }
    }

    if ($id) {
        // ini query update
        $update = mysqli_query($koneksi, "UPDATE sliders SET title = '$title', description = '$description', image = '$image_name' WHERE id = '$id'");
        if ($update) {
            header("location:?page=slider&ubah=berhasil");
        }
    } else {
        // print_r($title); 
        // die;
        $insert = mysqli_query($koneksi, "INSERT INTO sliders (title, description, image) VALUES ('$title', '$description', '$image')");
        if ($insert) {
            header("location:?page=slider&tambah=berhasil");
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
                            <input type="file" class="form-control"
                                name="image" required>
                            <small class="">)* Size : 1920 * 1088</small>
                        </div>
                        <div class="mb-3">
                            <label for="">Judul</label>
                            <input type="text" class="form-control"
                                name="title"
                                required value="<?php echo ($id) ? $rowEdit['title'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="">Deskripsi</label>
                            <textarea class="form-control" name="description" required><?php echo ($id) ? $rowEdit['description'] : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                            <a href="?page=slider" class="text-muted">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>


    </div>

</section>