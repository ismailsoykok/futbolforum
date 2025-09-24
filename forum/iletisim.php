<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #333;
        color: white;
        padding: 10px 0;
        text-align: center;
    }

    header a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        margin: 10px;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .contact-info div {
        width: 30%;
    }

    .contact-info h3 {
        color: #333;
        border-bottom: 2px solid #f4f4f4;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    .contact-info p {
        font-size: 16px;
        color: #666;
    }

    .form-container {
        margin-top: 20px;
    }

    .form-container h3 {
        color: #333;
        margin-bottom: 20px;
    }

    input[type="text"], input[type="email"], textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    button {
        padding: 10px 20px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #555;
    }

    footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px;
        margin-top: 50px;
    }

    /* Mobile Responsive */
    @media screen and (max-width: 768px) {
        .container {
            width: 90%;
            padding: 15px;
        }

        .contact-info {
            flex-direction: column;
            align-items: center;
        }

        .contact-info div {
            width: 100%;
            margin-bottom: 20px;
        }

        .contact-info h3 {
            text-align: center;
        }

        .form-container h3 {
            text-align: center;
        }

        button {
            width: 100%;
            font-size: 18px;
        }
    }

    @media screen and (max-width: 480px) {
        header a {
            font-size: 16px;
        }

        .contact-info p {
            font-size: 14px;
        }

        input[type="text"], input[type="email"], textarea {
            font-size: 14px;
        }

        button {
            font-size: 14px;
        }
    }
</style>

</head>
<body>

<header>
    <a href="index.php">Ana Sayfaya Dön</a>
</header>

<div class="container">
    <h1>İletişim</h1>

    <div class="contact-info">
        <div>
            <h3>Adres</h3>
            <p></p>
        </div>
        <div>
            <h3>Telefon</h3>
            <p>+90 555 886 3950</p>
        </div>
        <div>
            <h3>E-posta</h3>
            <p>leurope@gmail.com</p>
        </div>
    </div>

    <div class="form-container">
        <h3>Bizimle İletişime Geçin</h3>
        <form action="" method="post">
            <input type="text" id="ad_soyad" name="ad_soyad" placeholder="Adınız ve Soyadınız" required>
            <input type="email" name="email" id="email" placeholder="E-posta Adresiniz" required>
            <textarea name="mesaj" id="mesaj" rows="5" placeholder="Mesajınızı buraya yazın..." required></textarea>
            <button type="submit">Gönder</button>
        </form>
        <?php
$servername = "localhost";
$username = "root"; 
$password = "ismail42"; 
$dbname = "admindb"; 

try {
  
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Hata modunu ayarlama
    
   
    

   
   
} catch (PDOException $e) {
    // Hata mesajını ekrana yazdır
    echo "Hata: " . $e->getMessage();
}
       
   $adsoyad = $_POST['ad_soyad'];
        $mail = $_POST["email"];
        $mesaj = $_POST["mesaj"];

 
    $sql = "INSERT INTO sikayet (adsoyad, mail, mesaj) VALUES (:adsoyad, :mail, :mesaj)";
    $stmt = $pdo->prepare($sql);
    
    
    $stmt->bindParam(':adsoyad', $adsoyad, PDO::PARAM_STR);
    $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindParam(':mesaj', $mesaj, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Şikayet Başarıyla Gönderildi!";
        header("Location: leurope.php");
    } else {
        echo "Lütfen tekrar deneyin.";
    }







        ?>
    </div>
</div>

<footer>
    <p>&copy; 2024 LEUROPE HABERCİLİK. Tüm hakları saklıdır.</p>
</footer>

</body>
</html>
