<?php
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM portofolios WHERE id ='$id'");
    $rowEdit  = mysqli_fetch_assoc($query);
    $title = "Edit Portofolio";
} else {
    $title = "Tambah Portofolio";
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $queryGambar  = mysqli_query($koneksi, "SELECT id, image FROM portofolios WHERE id='$id'");
    $rowGambar = mysqli_fetch_assoc($queryGambar);
    $image = $rowGambar['image'];
    unlink("uploads/" . $image_name);
    $delete = mysqli_query($koneksi, "DELETE FROM portofolios WHERE id='$id'");

    if ($delete) {
        header("location:?page=portofolio&hapus=berhasil");
    }
}

// print_r($rowEdit['password']);
// die;

if (isset($_POST['simpan'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $client_name = $_POST['client_name'];
    $project_date = $_POST['project_date'];
    $project_url = $_POST['project_url'];
    $is_active = $_POST['is_Active'];
    $id_category = $_POST['id_category'];

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

            $image = time() . "-" . basename($image);
            $target_files = $path . $image;
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
        $update = "UPDATE portofolios SET title='$title', 
        content='$content', image='$image', is_active='$is_active', client_name='$client_name', project_date='$project_date', project_url='$project_url', id_category='$id_category' WHERE id='$id'";
    } else {

        $update = "UPDATE portofolios SET title='$title', 
        content='$content', image='$image', is_active='$is_active', client_name='$client_name', project_date='$project_date', project_url='$project_url', id_category='$id_category' WHERE id='$id'";
    }

    // print_r($password);
    // die;
    if ($id) {
        // ini query update
        $update = mysqli_query($koneksi, $update);
        if ($update) {
            header("location:?page=portofolio&ubah=berhasil");
        }
    } else {
        $insert = mysqli_query($koneksi, query: "INSERT INTO portofolios (title, content, image, is_active, id_category, client_name, project_date, project_url) 
        VALUES('$title','$content','$image','$is_active','$id_category','$client_name', '$project_date', '$project_url')");
        if ($insert) {
            header("location:?page=portofolio&tambah=berhasil");
        }
    }
}

$queryCategories = mysqli_query($koneksi, "SELECT * FROM categories WHERE type='portofolio' ORDER BY id DESC");
$rowCategories = mysqli_fetch_all($queryCategories, MYSQLI_ASSOC);

?>
<div class="pagetitle">
    <h1><?php echo $title ?></h1>
</div><!-- End Page Title -->

<section class="section">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title ?></h5>
                        <div class="mb-3">
                            <label for="" class="form-label">Gambar</label>
                            <input type="file"
                                name="image" required>
                            <small class="text-muted">)* Size : 1920 * 1088</small>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Kategori</label>
                            <select name="id_category" id="" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($rowCategories as $rowCategory): ?>
                                    <option value="<?php echo $rowCategory['id'] ?>"><?php echo $rowCategory['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Judul</label>
                            <input type=" text" class="form-control"
                                name="title" placeholder="Masukkan judul slider"
                                required value="<?php echo ($id) ? $rowEdit['title'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Isi</label>
                            <textarea name="content" id="summernote" class="form-control"><?php echo ($id) ? $rowEdit['content'] : '' ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">nama client</label>
                            <input type="text" name="client_name" class="form-control"
                                id="" value="<?php echo ($id) ? $rowEdit['client_name'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">tanggal project</label>
                            <input type="date" name="project_date" class="form-control"
                                id="" value="<?php echo ($id) ? $rowEdit['project_date'] : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">url project</label>
                            <input type="text" name="client_name" class="form-control"
                                id="" value="<?php echo ($id) ? $rowEdit['project_url'] : '' ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title ?></h5>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="">Status</label>
                                <select name="is_Active" id="" class="form-control">
                                    <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">Publish</option>
                                    <option <?php echo ($id) ? $rowEdit['is_active'] == 2 ? 'selected' : '' : '' ?> value="0">Draft</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                                <a href="?page=portofolio" class="text-muted">Kembali</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </form>
</section>