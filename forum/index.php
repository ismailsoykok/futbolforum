<?php
$uri = 'http://api.football-data.org/v4/competitions/PL/standings';

// API anahtarınızı buraya ekleyin
$api_token = '283261d76d28457b85396496100201e0';

$reqPrefs = array(
    'http' => array(
        'method'  => 'GET',
        'header'  => 'X-Auth-Token: ' . $api_token
    )
);

$stream_context = stream_context_create($reqPrefs);

// API'den yanıt alıyoruz
$response = file_get_contents($uri, false, $stream_context);

// Yanıtı çözümle
$standings = json_decode($response, true);

// Verilerin doğru şekilde alındığını kontrol ediyoruz
if (json_last_error() === JSON_ERROR_NONE && isset($standings['standings'][0]['table'])) {
    $teams = $standings['standings'][0]['table'];
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script.js" language="javascript"> </script> 
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="tablolar.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
     <!-- Navbar -->
    <div class="navbar">
      <div class="social-icons">
        <a href="https://instagram.com/leuropefootball"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/> 
            </svg>
        </a>
        <a href="https://x.com/leuropefootball">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
            </svg>
        </a>
    </div>
    <div>
        <a href="blog.php" class="blog">Forum</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-chat" viewBox="0 0 20 20">
  <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
</svg> 
        

       <a href="hikaye.php" class="blog">Hikayeler</a>
    </div>

    <!-- Sağ Taraftaki Menü Bağlantıları -->
    <div class="menu-items">
<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="white" class="bi bi-database" viewBox="0 0 16 16">
  <path d="M4.318 2.687C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4c0-.374.356-.875 1.318-1.313M13 5.698V7c0 .374-.356.875-1.318 1.313C10.766 8.729 9.464 9 8 9s-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777A5 5 0 0 0 13 5.698M14 4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16s3.022-.289 4.096-.777C13.125 14.755 14 14.007 14 13zm-1 4.698V10c0 .374-.356.875-1.318 1.313C10.766 11.729 9.464 12 8 12s-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10s3.022-.289 4.096-.777A5 5 0 0 0 13 8.698m0 3V13c0 .374-.356.875-1.318 1.313C10.766 14.729 9.464 15 8 15s-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13s3.022-.289 4.096-.777c.324-.147.633-.323.904-.525"/>
</svg>
       <a href="admin.php" class="nav-item" onclick="openLoginForm()">Admin</a>

        
        <a href="iletisim.php" class="nav-item">İletişim</a>
    </div>
    </div> 



    <!-- Kaydırılabilir div container -->
   <div class="scoreboard-container">

        <!-- Premier Lig Puan Durumu -->
        <div class="scoreboard">
            <a href="ingiltere.php"><div class="scoreboard-header" style="height: 50px; background-image: url('img/pl.png'); background-size: contain; background-position: center; background-repeat: no-repeat;"></div></a>

            <div class="scoreboard-body">
                <div class="team">
                        <span class="team-wins" style="font-weight: bold;">></span>
                        <span class="team-name" style="font-weight: bold;">TAKIM</span>
                        <span class="team-wins" style="font-weight: bold;"> G</span>
                        <span class="team-losses" style="font-weight: bold;"> B</span>
                        <span class="team-losses" style="font-weight: bold;"> M</span>
                        <span class="team-points" style="font-weight: bold;">P</span>
                      </div>


                <?php
                $uri = 'http://api.football-data.org/v4/competitions/PL/standings';
                $response = file_get_contents($uri, false, $stream_context);
                $data = json_decode($response, true);

                if ($data && isset($data['standings'][0]['table'])) {
            foreach ($data['standings'][0]['table'] as $team) {
                // Verileri alıyoruz
                $teamName = $team['team']['name'];
                $points = $team['points'];
                $wins = $team['won'];
                $losses = $team['lost'];
                $draws = $team['draw'];
                $sira = $team['position'];

                // Her bir takım için HTML çıktısını oluşturuyoruz
                echo '<div class="team">
                        <span class="team-wins">' . $sira . '</span>
                        <span class="team-name">' . $teamName . '</span>
                        <span class="team-wins">' . $wins . '</span>
                        <span class="team-wins">' . $draws . '</span>
                        <span class="team-losses">' . $losses . '</span>
                        <span class="team-points">' . $points . '</span>
                      </div>';
            }
        }
                ?>
            </div>
        </div>


        <!-- La Liga Puan Durumu -->
        <div class="scoreboard">
            <a href="ispanya.php"><div class="scoreboard-header" style="height: 50px; background-image: url('img/ispanya.png'); background-size: contain; background-position: center; background-repeat: no-repeat;"></div></a>

            <div class="scoreboard-body">
                <div class="team">
                        <span class="team-wins" style="font-weight: bold;">></span>
                        <span class="team-name" style="font-weight: bold;">TAKIM</span>
                        <span class="team-wins" style="font-weight: bold;"> G</span>
                         <span class="team-wins" style="font-weight: bold;"> B</span>
                        <span class="team-losses" style="font-weight: bold;"> M</span>
                        <span class="team-points" style="font-weight: bold;">P</span>
                      </div>


                <?php
                $uri = 'http://api.football-data.org/v4/competitions/PD/standings';
                $response = file_get_contents($uri, false, $stream_context);
                $data = json_decode($response, true);

                if ($data && isset($data['standings'][0]['table'])) {
            foreach ($data['standings'][0]['table'] as $team) {
                // Verileri alıyoruz
                $teamName = $team['team']['name'];
                $points = $team['points'];
                $wins = $team['won'];
                $losses = $team['lost'];
                $draws = $team['draw'];
                $sira = $team['position'];

                // Her bir takım için HTML çıktısını oluşturuyoruz
                echo '<div class="team">
                        <span class="team-wins">' . $sira . '</span>
                        <span class="team-name">' . $teamName . '</span>
                        <span class="team-wins">' . $wins . '</span>
                         <span class="team-losses">' . $draws . '</span>
                        <span class="team-losses">' . $losses . '</span>
                        <span class="team-points">' . $points . '</span>
                      </div>';
            }
        }
                ?>
            </div>
        </div>

        <!-- Bundesliga Puan Durumu -->
                <div class="scoreboard">
            <a href="almanya.php"><div class="scoreboard-header" style="height: 50px; background-image: url('img/almanya.png'); background-size: contain; background-position: center; background-repeat: no-repeat;"></div></a>

            <div class="scoreboard-body">
                <div class="team">
                        <span class="team-wins" style="font-weight: bold;">></span>
                        <span class="team-name" style="font-weight: bold;">TAKIM</span>
                        <span class="team-wins" style="font-weight: bold;"> G</span>
                        <span class="team-wins" style="font-weight: bold;"> B</span>
                        <span class="team-losses" style="font-weight: bold;"> M</span>
                        <span class="team-points" style="font-weight: bold;">P</span>
                      </div>


                <?php
                $uri = 'http://api.football-data.org/v4/competitions/BL1/standings';
                $response = file_get_contents($uri, false, $stream_context);
                $data = json_decode($response, true);

                if ($data && isset($data['standings'][0]['table'])) {
            foreach ($data['standings'][0]['table'] as $team) {
                // Verileri alıyoruz
                $teamName = $team['team']['name'];
                $points = $team['points'];
                $wins = $team['won'];
                $losses = $team['lost'];
              $draws = $team['draw'];
                $sira = $team['position'];

                // Her bir takım için HTML çıktısını oluşturuyoruz
                echo '<div class="team">
                        <span class="team-wins">' . $sira . '</span>
                        <span class="team-name">' . $teamName . '</span>
                        <span class="team-wins">' . $wins . '</span>
                        <span class="team-losses">' . $draws . '</span>
                        <span class="team-losses">' . $losses . '</span>
                        <span class="team-points">' . $points . '</span>
                      </div>';
            }
        }
                ?>
            </div>
        </div>

        <!-- Serie A Puan Durumu -->
                <div class="scoreboard">
            <a href="italya.php"><div class="scoreboard-header" style="height: 50px; background-image: url('img/italya.png'); background-size: contain; background-position: center; background-repeat: no-repeat;"></div></a>

            <div class="scoreboard-body">
                <div class="team">
                        <span class="team-wins" style="font-weight: bold;">></span>
                        <span class="team-name" style="font-weight: bold;">TAKIM</span>
                        <span class="team-wins" style="font-weight: bold;"> G</span>
                        <span class="team-wins" style="font-weight: bold;"> B</span>
                        <span class="team-losses" style="font-weight: bold;"> M</span>
                        <span class="team-points" style="font-weight: bold;">P</span>
                      </div>


                <?php
                $uri = 'http://api.football-data.org/v4/competitions/SA/standings';
                $response = file_get_contents($uri, false, $stream_context);
                $data = json_decode($response, true);

                if ($data && isset($data['standings'][0]['table'])) {
            foreach ($data['standings'][0]['table'] as $team) {
                // Verileri alıyoruz
                $teamName = $team['team']['name'];
                $points = $team['points'];
                $wins = $team['won'];
                $losses = $team['lost'];
               $draws = $team['draw'];
                $sira = $team['position'];

                // Her bir takım için HTML çıktısını oluşturuyoruz
                echo '<div class="team">
                        <span class="team-wins">' . $sira . '</span>
                        <span class="team-name">' . $teamName . '</span>
                        <span class="team-wins">' . $wins . '</span>
                        <span class="team-wins">' . $draws . '</span>
                        <span class="team-losses">' . $losses . '</span>
                        <span class="team-points">' . $points . '</span>
                      </div>';
            }
        }
                ?>
            </div>
        </div>


        <!-- Ligue 1 Puan Durumu -->
                <div class="scoreboard">
            <a href="fransa.php"><div class="scoreboard-header" style="height: 50px; background-image: url('img/fransa.png'); background-size: contain; background-position: center; background-repeat: no-repeat;"></div></a>

            <div class="scoreboard-body">
                <div class="team">
                        <span class="team-wins" style="font-weight: bold;">></span>
                        <span class="team-name" style="font-weight: bold;">TAKIM</span>
                        <span class="team-wins" style="font-weight: bold;"> G</span>
                        <span class="team-losses" style="font-weight: bold;"> B</span>
                        <span class="team-losses" style="font-weight: bold;"> M</span>
                        <span class="team-points" style="font-weight: bold;">P</span>
                      </div>


                <?php
                $uri = 'http://api.football-data.org/v4/competitions/FL1/standings';
                $response = file_get_contents($uri, false, $stream_context);
                $data = json_decode($response, true);

                if ($data && isset($data['standings'][0]['table'])) {
            foreach ($data['standings'][0]['table'] as $team) {
                // Verileri alıyoruz
                $teamName = $team['team']['name'];
                $points = $team['points'];
                $wins = $team['won'];
                $losses = $team['lost'];
                $draws = $team['draw'];
               
                $sira = $team['position'];

                // Her bir takım için HTML çıktısını oluşturuyoruz
                echo '<div class="team">
                        <span class="team-wins">' . $sira . '</span>
                        <span class="team-name">' . $teamName . '</span>
                        <span class="team-wins">' . $wins . '</span>
                        <span class="team-wins">' . $draws . '</span>
                        <span class="team-losses">' . $losses . '</span>
                        <span class="team-points">' . $points . '</span>
                      </div>';
            }
        }
                ?>
            </div>
        </div>





    <div class="image-container">
        <a href="italya.php"><img src="img\italya.png" alt="Resim 1" class="image"></a>
        <a href="ispanya.php"><img src="img\ispanya.png" alt="Resim 2" class="image"></a>
        <a href="fransa.php"><img src="img\fransa.png" alt="Resim 4" class="image"></a>
        <a href="almanya.php"><img src="img\almanya.png" alt="Resim 3" class="image"></a>
        <a href="ingiltere.php"><img src="img\pl.png" alt="Resim 5" class="image"></a>
    </div>
</body>
</html>
