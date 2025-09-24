<?php 
session_start();

if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['user_name'] = $_COOKIE['user_name'];
}

$servername = "localhost";
$username = "root"; 
$password = "ismail42"; 
$dbname = "admindb"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}

$adet = 5;
$basla = 0;

// Sayfa numarasını kontrol et ve 1 yap
$sayfa = isset($_GET['sayfa_num']) ? (int)$_GET['sayfa_num'] : 1;
$basla = ($sayfa - 1) * $adet;

// Arama işlemi
$arama = isset($_GET['arama']) ? $_GET['arama'] : ''; 
$aramaKosulu = !empty($arama) ? "WHERE gonderi.baslik LIKE :arama" : '';

// Toplam satır sayısını al
$countSql = "SELECT COUNT(*) AS toplam FROM gonderi $aramaKosulu";
$countStmt = $pdo->prepare($countSql);

if (!empty($arama)) {
    $countStmt->bindValue(':arama', '%' . $arama . '%', PDO::PARAM_STR);
}

$countStmt->execute();
$toplamSatir = $countStmt->fetch(PDO::FETCH_ASSOC)['toplam'];
$sayfasay = ceil($toplamSatir / $adet);


$sql = "SELECT gonderi.*, kullanıcılar.kullanıcı_adı 
        FROM gonderi 
        JOIN kullanıcılar ON gonderi.kullanıcı_id = kullanıcılar.id 
        $aramaKosulu
        ORDER BY gonderi.olusturma_tarihi DESC
        LIMIT $basla, $adet";
$stmt = $pdo->prepare($sql);

if (!empty($arama)) {
    $stmt->bindValue(':arama', '%' . $arama . '%', PDO::PARAM_STR);
}

$stmt->execute();
$veriler = $stmt->fetchAll(PDO::FETCH_ASSOC); 

$sql2 = "SELECT * FROM yorumlar 
         INNER JOIN gonderi ON gonderi.id = yorumlar.gonderi_id 
         INNER JOIN kullanıcılar ON kullanıcılar.id = yorumlar.kullanici_id 
         WHERE gonderi.id = :gonderi_id
         ORDER BY yorumlar.olusturma_tarihi2 DESC;"  
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="script.js" language="javascript"></script> 
</head>
<body>

    <!-- Navbar -->
<div class="navbar" style="background-color: #6594C0;">
    <div class="logo"><a href="index.php"><img class="foto" src="img/leurop.png"></a></div>
    <div class="search-bar">
        <form action="" method="GET">
    <div class="input-container">
        <input type="text" name="arama" placeholder="Başlık ara..." value="<?php echo htmlspecialchars($arama); ?>">
        <button type="submit" class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
</svg></button>
    </div>
</form>

    </div>


   
    <div class="user-buttons">
     <?php if (!isset($_SESSION['user_id'])) { ?>
        <a id="login-btn" onclick="login_button()">Giriş Yap</a>
        <a id="register-btn" onclick="register_button()">Kayıt Ol</a>
    
    <?php } else { ?>
   
        <a href="logout.php" class="logout-btn" style="margin-right:20px;">Çıkış Yap</a>
  
    <?php }
     
    ?>
</div>
</div>



    <!-- Navbar -->
    <?php if (!isset($_SESSION['user_id'])) { ?>
  <div>  
    <!-- Login Formu -->
    <div class="login" id="login-form">
        <form action="" method="POST">
            <div>
                Gmail:
                <input type="text" id="mail" name="mail" class="form-control" placeholder="Gmail adresinizi girin">
            </div>
            <div>
                Şifre:
                <input type="password" id="password" name="password" class="form-control" placeholder="Şifrenizi girin">
            </div>
            <div>
                <button type="submit"class="btn btn-primary">Giriş Yap</button>
            </div>
        </form>

        <?php

session_start();


$servername = "localhost";
$username = "root"; 
$password = "ismail42"; 
$dbname = "admindb"; 

try {
 
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = $_POST['mail'];
    $user_password = $_POST['password'];

    $sql = "SELECT * FROM kullanıcılar WHERE mail = :mail";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($user_password, $user['sifre'])) {
            // Oturum bilgilerini sakla
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['kullanıcı_adı'];

            // Çerez oluştur
            setcookie("user_id", $user['id'], time() + (86400 * 30), "/"); // 30 gün geçerli
            setcookie("user_name", $user['kullanıcı_adı'], time() + (86400 * 30), "/");

            header("Location: blog.php");
            exit();
        } else {
            echo "Hatalı şifre!";
             header("Location: blog.php");
        }
    } else {
        echo "Kullanıcı bulunamadı!";
        header("Location: blog.php");
    }
}


// Bağlantıyı kapat
$conn = null;
?>

    </div>
    <!-- Login Formu -->

    <!-- Register Formu -->
    <div class="register" id="register-form">
    <form action="" method="POST">
        <div>
            Ad:
            <input type="text" id="ad" name="ad" class="form-control" placeholder="Adınızı Giriniz" oninput="buttoncontrol()" >
        </div>
        <div>
            Soyad:
            <input type="text" id="soyad" name="soyad" class="form-control" placeholder="Soyadınızı Giriniz" oninput="buttoncontrol()">
        </div>
        <div>
            Mail:
            <input type="text" id="mail-register" name="mail-register" class="form-control" placeholder="Mail Giriniz" oninput="buttoncontrol()">
        </div>
        <div>
            Şifre:
            <input type="password" id="password-register" name="password-register" class="form-control" placeholder="Şifre Giriniz(En az 6 karakter)" oninput="buttoncontrol()">
        </div>
        <div>
            Kullanıcı Adı:
            <input type="text" id="kullanıcı_ad" name="kullanıcı_ad" class="form-control" placeholder="Kullanıcı Adı Giriniz(En az 4 karakter)" oninput="buttoncontrol()">
        </div>
        <div>
            <button type="submit" id="kayıtbuton" name="kayıtbuton" disabled onmouseover="buttoncontrol()" class="btn btn-primary">Kayıt</button>
        </div>
    </form>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "ismail42";
        $dbname = "admindb"; // Replace with your actual database name

        try {
            // Create a new PDO instance
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Sanitize and retrieve form data
            $ad = $_POST['ad'];
            $soyad = $_POST['soyad'];
            $mail = $_POST['mail-register'];
            $kullanıcı_ad = $_POST['kullanıcı_ad'];
            $sifre = password_hash($_POST['password-register'], PASSWORD_BCRYPT);

            // Check if the email already exists
            $stmt = $conn->prepare("SELECT COUNT(*) FROM kullanıcılar WHERE mail = :mail OR kullanıcı_adı = :userad");
            $stmt->bindParam(':mail', $mail);
            $stmt->bindParam(':userad', $kullanıcı_ad);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                echo "Error: Email and nickname already exists.";
            } else {
                // Prepare SQL query to insert user data into the database
                $sql = "INSERT INTO kullanıcılar (ad, soyad, mail, kullanıcı_adı, sifre) 
                        VALUES (:ad, :soyad, :mail, :kullanici_ad, :sifre)";
                
                // Prepare the statement
                $stmt = $conn->prepare($sql);
                
                // Bind parameters to the query
                $stmt->bindParam(':ad', $ad);
                $stmt->bindParam(':soyad', $soyad);
                $stmt->bindParam(':mail', $mail);
                $stmt->bindParam(':kullanici_ad', $kullanıcı_ad);
                $stmt->bindParam(':sifre', $sifre);
                
                // Execute SQL query
                if ($stmt->execute()) {
                    echo "New record created successfully!";

                    // Start session
                    session_start();

                    // Set session variables
                    $_SESSION['user_id'] = $conn->lastInsertId(); // Save the last inserted ID
                    $_SESSION['user_name'] = $kullanıcı_ad; // Save the username
                    
                    // Set cookies for 30 days
                    setcookie("user_id", $_SESSION['user_id'], time() + (86400 * 30), "/");
                    setcookie("user_name", $kullanıcı_ad, time() + (86400 * 30), "/");

                    // Redirect to a page (optional)
                    // header("Location: welcome.php");
                    // exit();
                } else {
                    echo "Error: Unable to insert data.";
                }
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close connection
        $conn = null;
    }
    ?> 



</div>


</div>
<?php  } ?>
    <!-- Register Formu -->


  <?php if(isset($_SESSION['user_id'])){ ?> 
    <!-- Baslık ve Yazı Ekleme -->
    <div class="entry-text" id="entry-text" style="display: none;">
        <form action="entryekle.php" method="post">
            <label for="title">Başlık:</label>
            <input type="text" id="title" name="title" required placeholder="Başlık girin">
            <label for="content">Yazı:</label>
            <textarea id="content" name="content" rows="4" required placeholder="Yazınızı buraya girin"></textarea>
            <button type="submit">Gönder</button>
        </form>
        
    </div> <?php } ?>
    <!-- Baslık ve Yazı Ekleme  -->

    <!-- Baslık ve Yazıların Gösterimi -->
<div class="content">
  <?php foreach($veriler as $satır) {
    // Gönderinin ID'sini alıyoruz
    $gonderi_id = $satır["id"];

    // Yorumları almak için sorguyu hazırlıyoruz
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(':gonderi_id', $gonderi_id, PDO::PARAM_INT);
    $stmt2->execute();
    $veriler2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="entry">
        <h1><?php echo $satır["baslik"]; ?></h1>
        <hr>
        <div class="meta"><?php echo $satır["icerik"]; ?></div>
        <div class="meta2"><?php echo $satır["olusturma_tarihi"] . ' - ' . $satır["kullanıcı_adı"]; ?></div>

        <!-- Yorumlar için Aç/Kapa Butonu -->
        <svg onclick="toggleForm(<?php echo $satır['id']; ?>)" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#6594C0" class="bi bi-chat-left-dots-fill" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm5 4a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
        </svg>

        <!-- Yorum Formu -->
        <div id="comment-form-<?php echo $satır['id']; ?>" class="comment-form" style="display: none;">
             <?php if (isset($_SESSION['user_id'])) { ?>
        <!-- Yorum Ekleme Formu -->
        <form method="POST" action="yorumekle.php">
            <input type="hidden" id="gonderi_id" name="gonderi_id" value="<?php echo $satır['id']; ?>">
            <textarea name="yorumicerik" id="yorumicerik" placeholder="Yorumunuzu buraya yazın..." required></textarea>
            <button type="submit">Gönder</button>
        </form>
    <?php } else echo "Yorum eklemek için oturum açın.."; ?>
            <br>

            <?php foreach($veriler2 as $satır2) { ?>
                <div class="comment">
                    <div class="comment-meta">
             

                        <span class="comment-author"><?php echo $satır2["kullanıcı_adı"]; ?></span> - 
                        <span class="comment-date"><?php echo $satır2["olusturma_tarihi2"]; ?></span>

                    </div>
                    <div class="comment-content">
                        <p><?php echo $satır2["yorum_metni"]; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div> 
<?php } ?>

</div>



    <!-- Baslık ve Yazıların Gösterimi -->

    <!-- Pagination Numaralama Bölümü-->
    <nav aria-label="Page navigation example" class="pagination-container">
        <ul class="pagination">
            <!-- Previous -->
            <?php if ($sayfa > 1) { ?>
                <li class="page-item"><a class="page-link" href="?sayfa_num=<?php echo $sayfa - 1; ?>">Previous</a></li>
            <?php } else { ?>
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
            <?php } ?>

            <!-- Page Numbers -->
            <?php for ($sayac = 1; $sayac <= $sayfasay; $sayac++) { ?>
                <li class="page-item <?php echo $sayac == $sayfa ? 'active' : ''; ?>">
                    <a class="page-link" href="?sayfa_num=<?php echo $sayac; ?>"><?php echo $sayac; ?></a>
                </li>
            <?php } ?>

            <!-- Next -->
            <?php if ($sayfa < $sayfasay) { ?>
                <li class="page-item"><a class="page-link" href="?sayfa_num=<?php echo $sayfa + 1; ?>">Next</a></li>
            <?php } else { ?>
                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
            <?php } ?>
        </ul>
    </nav>
    <!-- Pagination Numaralama Bölümü-->

    <?php if(isset($_SESSION['user_id'])){ ?>
    <div class="floating-logo">
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#6594C0" class="bi bi-chat-right-text" viewBox="0 0 16 16" onclick="toggleEntryText()">
            <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
        </svg> 
    </div> <?php } ?>
    <!--Entry butonu -->

</body>
</html>