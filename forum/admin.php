<?php
$servername = "localhost"; 
$username = "root"; 
$password = "ismail42"; 
$dbname = "adminDB"; 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    $sql = "SELECT * FROM adminler WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $inputUsername, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($inputPassword == $user["password"]) {
            header("Location: post.php");
            exit();  
        } else {
            echo "<div class='alert alert-danger mt-3'>Şifre yanlış!</div>";
        }
    } else {
        echo "<div class='alert alert-danger mt-3'>Kullanıcı adı bulunamadı!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #fff;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2575fc;
        }
        .btn-primary {
            background-color: #2575fc;
            border: none;
        }
        .btn-primary:hover {
            background-color: #6a11cb;
        }
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            .container {
                margin: 20px auto;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Girişi</h2>
        <form method="POST" action="">
            <div class="form-group mb-3">
                <label for="username" class="form-label">Kullanıcı Adı:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Şifre:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
