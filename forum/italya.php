<?php
$servername = "localhost";
$username = "root"; 
$password = "ismail42"; 
$dbname = "admindb"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $adet = 5;
    $basla = 0;

    // Sayfa numarasını kontrol et ve 1 yap
    $sayfa = isset($_GET['sayfa_num']) ? (int)$_GET['sayfa_num'] : 1;
    $basla = ($sayfa - 1) * $adet;

    // Toplam satır sayısını al
    $countSql = "SELECT COUNT(*) AS toplam FROM italya";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute();
    $toplamSatir = $countStmt->fetch(PDO::FETCH_ASSOC)['toplam'];
    $sayfasay = ceil($toplamSatir / $adet);

    // Verileri al
    $sql = "SELECT * FROM italya ORDER BY tarih DESC LIMIT $basla, $adet";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $veriler = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="styles2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body style="background-image: url('img/seriea2.jpg');">
    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #171D8D; height: 60px; border-bottom: none;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php" style="color: white; font-size: 18px;">Ana Menü</a>
        </div>
        <div class="navbar-center">
            <img src="img/seriealogo.jpg" alt="Center Image" style="height: 50px;">
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: white; font-size: 18px;">Ligler <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="almanya.php">Bundesliga</a></li>
                        <li><a href="fransa.php">Ligue 1</a></li>
                        <li><a href="ingiltere.php">Premier League</a></li>
                        <li><a href="ispanya.php">La Liga</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container">
        <div class="content">
            <?php foreach ($veriler as $satır) { ?>
                <div class="photo-container">
                    <hr>
                    <p class="text"><?php echo $satır["yazı"]; ?></p>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($satır['foto']); ?>" alt="Fotoğraf" class="photo">
                    <div class="overlay"></div>
                    <hr>
                </div>
            <?php } ?>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
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
    </div>
</body>
</html>
