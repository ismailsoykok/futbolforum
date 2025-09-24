<?php

$servername = "localhost";
$username = "root"; 
$password = "ismail42"; 
$dbname = "admindb"; 

try {
  
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Hata modunu ayarlama
    
    // Formdan gelen veriler
    $lig = $_POST['options']; 
    $yazi = $_POST['userText']; 
    $baslik = $_POST['userTitle'];

    $tarih = date('Y-m-d H:i:s'); 

   
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $foto = file_get_contents($_FILES['photo']['tmp_name']);
    } else {
        die("Fotoğraf yüklenemedi.");
    }
    if(empty($baslik)){

        $sql = "INSERT INTO $lig (foto, yazı, tarih) VALUES (:foto, :yazi, :tarih)";
         $stmt = $pdo->prepare($sql);
    
    
    $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
    $stmt->bindParam(':yazi', $yazi, PDO::PARAM_STR);
    $stmt->bindParam(':tarih', $tarih, PDO::PARAM_STR);
    $stmt->execute();
}
else{
      $sql = "INSERT INTO $lig (foto, baslik, yazı, tarih) VALUES (:foto, :baslik, :yazi, :tarih)";
         $stmt = $pdo->prepare($sql);
    
    
    $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
    $stmt->bindParam(':baslik', $baslik, PDO::PARAM_STR);
    $stmt->bindParam(':yazi', $yazi, PDO::PARAM_STR);
    $stmt->bindParam(':tarih', $tarih, PDO::PARAM_STR);
    $stmt->execute();



}
    
   

   
    if ($stmt->rowCount() > 0) {
        echo "Gönderi başarıyla eklendi!";
        header("Location: post.php");
    } else {
        echo "Veri eklenmedi. Lütfen tekrar deneyin.";
    }
} catch (PDOException $e) {
    // Hata mesajını ekrana yazdır
    echo "Hata: " . $e->getMessage();
}

// Bağlantıyı kapat
$pdo = null;
?>
