<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Veri İşleme Formu</title>
    <script src="script.js" language="javascript"> </script> 
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f3f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #5e2a8c;
            padding: 30px 0;
            font-size: 2.5rem;
            animation: fadeIn 1s ease-out;
        }

        form {
            background-color: #fff;
            width: 60%;
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            animation: slideIn 1s ease-out;
        }

        div {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            font-size: 1.1rem;
            color: #5e2a8c;
            display: block;
            margin-bottom: 8px;
            transition: color 0.3s ease;
        }

        label:hover {
            color: #7e34a1;
        }

        select, textarea, input[type="file"], button {
            width: 100%;
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        select:focus, textarea:focus, input[type="file"]:focus, button:focus {
            border-color: #5e2a8c;
            outline: none;
        }

        select, input[type="file"], button {
            background-color: #f8f0ff;
        }

        textarea {
            resize: vertical;
        }

        button {
            background-color: #5e2a8c;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #7e34a1;
            transform: translateY(-2px);
        }

        button:active {
            background-color: #5e2a8c;
            transform: translateY(2px);
        }

        @media (max-width: 768px) {
            form {
                width: 80%;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-50px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
   <div style="position: fixed; top: 0; width: 100%; text-align: center; z-index: 1000;">
    <a href="leurope.php"><button type="submit" name="onay">Çıkış Yap</button></a>
</div>
    
    <form action="post2.php" method="POST" enctype="multipart/form-data">
        <!-- Lig Seçimi -->
        <div>
            <label for="options">Hangi Ligin Haberi Seçin:</label>
            <select id="options" name="options">
                <option value="hikaye">Hikaye</option>
                <option value="ispanya">La Liga</option>
                <option value="italya">Serie A</option>
                <option value="ingiltere">Premier League</option>
                <option value="almanya">Bundesliga</option>
                <option value="fransa">Ligue 1</option>
            </select>
        </div>

        <!-- Fotoğraf Yükleme -->
        <div>
            <label for="photo-upload">Fotoğraf Seç:</label>
            <input type="file" id="photo-upload" name="photo" accept="image/jpeg, image/png">
        </div>


        
        <div>

            <label for="userTitle">Başlık:</label>
            <textarea id="userTitle" name="userTitle" rows="5"  placeholder="Metninizi buraya yazın..." ></textarea>
        </div>

        <!-- Metin Girişi -->

        <div>
            <label for="userText">Metin:</label>
            <textarea id="userText" name="userText" rows="5" placeholder="Metninizi buraya yazın..."></textarea>
        </div>

        <!-- Gönder Butonu -->
        <button type="submit" name="onay">Gönder</button>
        <hr>
         
    </form>
    <script>
    // Başlığı otomatik göster/gizle fonksiyonu
    function storyTitle() {
        const titleDiv = document.getElementById('userTitle'); // Div'i seçiyoruz.
        const options = document.getElementById('options'); // Select elemanını seçiyoruz.

        if (options.value === 'hikaye') { // Seçili değer "hikaye" mi kontrol ediyoruz.
            titleDiv.style.display = 'block'; // Div'i görünür yapıyoruz.
        } else {
            titleDiv.style.display = 'none'; // Diğer durumlarda gizliyoruz.
        }
    }

    // Sayfa yüklendiğinde ve seçim değiştiğinde fonksiyonu çalıştır:
    window.onload = storyTitle; // İlk yükleme sırasında kontrol.
    document.getElementById('options').addEventListener('change', storyTitle); // Seçim değiştiğinde kontrol.
</script>

</body>
</html>
