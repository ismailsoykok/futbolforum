<?php 
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri alıyoruz
    if (isset($_SESSION['user_id'], $_POST['gonderi_id'], $_POST['yorumicerik'])) {
        $kullanici_id = $_SESSION['user_id']; // Oturumdaki kullanıcı ID'si
        $gonderi_id = $_POST['gonderi_id'];  // Yorum yapılacak gönderi ID'si
        $yorum = $_POST['yorumicerik']; // Yorumun içeriği
        $tarih = date('Y-m-d H:i:s'); // Yorumun oluşturulma tarihi

        // Yorum ekleme sorgusu
        $sql = "INSERT INTO yorumlar (gonderi_id, kullanici_id, yorum_metni, olusturma_tarihi2) 
                VALUES (:gonderi_id, :kullanici_id, :yazi, :tarih)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':gonderi_id', $gonderi_id, PDO::PARAM_INT);
        $stmt->bindParam(':kullanici_id', $kullanici_id, PDO::PARAM_INT);
        $stmt->bindParam(':yazi', $yorum, PDO::PARAM_STR);
        $stmt->bindParam(':tarih', $tarih, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Yorum başarıyla eklendi!";
            // Yorum ekleme işleminden sonra sayfayı yeniden yönlendirme
            header("Location: blog.php");
            exit();
        } else {
            echo "Veri eklenmedi. Lütfen tekrar deneyin.";
        }
    } else {
        echo "Gerekli veriler eksik.";
    }
}
?> 
