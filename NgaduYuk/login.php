<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
  </head>
  <body>
    <?php
      require_once 'connect.php'; // koneksi ke database.

      /**
       * Cegah akses ke halaman login saat sedang login.
       */
      if(isset($_SESSION['is_login']) || isset($_COOKIE['_logged'])) {
        header('location:login.php');
      }

      if(isset($_POST['submit'])) {
        /**
         * Mendapatkan data dari formulir login.
         * Data: Email, Kata Sandi, dan Ingat Saya.
         */
        $email    = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $remember = (!empty($_POST['remember_me']) ? $_POST['remember_me'] : '');

        if(empty($email) || empty($password)) {
          /**
           * Cek apakah formulir telah terisi data.
           */
          echo '<b>Warning!</b> Silahkan isi semua data yang diperlukan.';
        } elseif(count((array) $connect->query('SELECT email FROM `admin` WHERE email = "'.$email.'"')->fetch_array()) == 0) {
          /**
           * Cek jika email tidak terdaftar.
           */
          echo '<b>Warning!</b> Email tidak terdaftar.';
        } else 
          /**
        * Mengecek data mahasiswa.
           */
          $admin = $connect->query('SELECT "password" , email FROM `admin`')->fetch_assoc();
          if(password_verify($password, $admin['password']));
            $_SESSION['is_login'] = $admin['email'];

            /**
             * Cek apakah tombol remember me diklik.
             */
            if($remember) {
              if(!isset($_COOKIE['is_logged'])) {
                /**
                 * Atur cookie selama 1 hari.
                 * Rumus: 60 * 60 * 24 = 1 hari.
                 */
                setcookie('_logged', substr(md5($email), 0, 10), time() + (60 * 60 * 24), '/');
              }
            }
            header("location:isi_laporan.php"); // Alihkan ke halaman index.
          } else {
            echo '<b>Warning!</b> Kata sandi salah.';
          }
      96
    ?>
    <form method="POST">
      <input type="email" name="email" value="" autocomplete="off" placeholder="Email" required>
      <br/>
      <input type="password" name="password" value="" autocomplete="off" placeholder="Kata sandi" required>
      <br/>
      <input type="checkbox" name="remember_me"> Ingat Saya
      <br/>
      <input type="submit" name="submit" value="Login">
    </form>
  </body>
</html>