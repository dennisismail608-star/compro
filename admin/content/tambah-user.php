<?php
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if(isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id ='$id'");
    $rowEdit = mysqli_fetch_assoc($query);

    $title = "edit user";
} else {
    $title = "tambah user";
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete = mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'");

    header("location:?page=user&hapus=berhasil");
}


if(isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = ($_POST['password']) ? $_POST['password'] : $rowEdit['password'];


    if($id) {
        $update = mysqli_query($koneksi, "UPDATE users SET name='$name',
        email='$email' password='$password' WHERE id='$id'");

    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO  users (name, email, password) 
        VALUES('$name', '$email', '$password')");
        if ($insert) {
            header("location:?page=user&tambah=berhasil");
        }
    }
}

?>

<div class="pagetitle">
      <h1>tambah user</h1>
      
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
           <div class="col-lg-12">
   
             <div class="card">
               <div class="card-body">
                 <h5 class="card-title"><?php echo $title ?></h5>
                 <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" 
                        name="name" placeholder="masukan nama anda" 
                        required value="<?php echo ($id) ? $rowEdit['name'] : ''?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="email" class="form-control" 
                        name="email" placeholder="masukan email anda" 
                        required value="<?php echo ($id) ? $rowEdit['email'] : ''?>">
                    </div>
                    <div class="mb-3">
                        <label for="">password</label>
                        <input type="password" class="form-control" 
                        name="password" placeholder="masukan password anda" 
                        <?php echo (!$id) ? 'required' : '' ?>>
                        <small>)* isi password jika ingin mengubah password</small>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="simpan">simpan</button>
                        <a href="?page=user" class="text-muted">kembali</a>
                    </div>
                 </form>

                
                 
               </div>
             </div>
           </div>
   
           
         </div>
        
        </section>