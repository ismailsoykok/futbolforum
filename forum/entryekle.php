<?php
        session_start();


$servername = "localhost";
$username = "root"; 
$password = "ismail42"; 
$dbname = "admindb"; 

try {
 
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){


    $kullanici_id = $_SESSION['user_id'];
    $baslik = $_POST['title'];
    $yazi = $_POST['content'];
    $tarih = date('Y-m-d H:i:s'); 

    $sql = "INSERT INTO gonderi (kullanıcı_id,baslik,icerik,olusturma_tarihi) VALUES (:kullanici_id, :baslik, :yazi, :tarih)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kullanici_id', $kullanici_id, PDO::PARAM_INT);
    $stmt->bindParam(':baslik', $baslik, PDO::PARAM_STR);
    $stmt->bindParam(':yazi', $yazi, PDO::PARAM_STR);
    $stmt->bindParam(':tarih', $tarih, PDO::PARAM_STR);
    $stmt->execute();

      if ($stmt->rowCount() > 0) {
        echo "Gönderi başarıyla eklendi!";
        header("Location: blog.php"); // Sayfayı yeniden yükle
        exit();
    } else {
        echo "Veri eklenmedi. Lütfen tekrar deneyin.";
    }

}

        ?>