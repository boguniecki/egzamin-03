<?php


$serwer = 'localhost';
$user = 'root';
$password = '';
$database = 'egzamin';
$query1 = "SELECT `informacja`, `wart_min`, `wart_max` FROM `bmi`";

$connect = mysqli_connect($serwer, $user, $password, $database);

if(isset($_POST['waga']) && isset($_POST['wzrost'])){
    $waga = $_POST['waga'];
    $wzrost = $_POST['wzrost'];

    $bmi = ($waga/($wzrost*$wzrost))*10000;

    if($bmi <= 18) {$przedzial = 1;}
    if($bmi >= 19) {$przedzial = 2;}
    if($bmi >= 26) {$przedzial = 3;}
    if($bmi >= 31) {$przedzial = 4;}

    $date = date("Y-m-d");
    echo $date;
}


?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje BMI</title>
    <link rel="stylesheet" href="styl3.css">
</head>
<body>
    <section id="logo">
        <img src="wzor.png" alt="wzór BMI">
    </section>
    <section id="baner">
        <h1>Oblicz swoje BMI</h1>
    </section>
    <main id="glowny">
        <table>
            <tr>
                <th>Interpretacja BMI</th>
                <th>Wartość minimalna</th>
                <th>Wartość maksymalna</th>
            </tr>
            <?php
                $result1 = mysqli_query($connect, $query1);

                while($row = $result1 -> fetch_array()){
                    echo "<tr>";
                    echo "<td>$row[informacja]</td>";
                    echo "<td>$row[wart_min]</td>";
                    echo "<td>$row[wart_max]</td>";
                    echo "</tr>";
                }
            ?>

        </table>
    </main>
    <section id="lewy">
        <h2>Podaj wagę i wzrost</h2>
        <form action="bmi.php" method="POST">
            <label for="waga">Waga</label>
            <input type="number" name="waga" id="waga" min="1">
            <br>
            <label for="wzrost">Wzrost w cm</label>
            <input type="number" name="wzrost" id="wzrost" min="1">
            <br>
            <input type="submit" value="Oblicz i zapamiętaj wynik" id="oblicz">
        </form>
        <?php
            echo "Twoja  waga:  $waga; Twój wzrost: 
            $wzrost <br>BMI wynosi: $bmi";
            echo "<br>";
            echo $przedzial;
            echo "<br>";


            $query2 = "INSERT INTO `wynik`(`bmi_id`, `data_pomiaru`, `wynik`) VALUES ('$przedzial', '$date', '$bmi')";
            $result2 = mysqli_query($connect, $query2);


        ?>
        <!-- efekt działania skryptu 2 -->
    </section>
    <section id="prawy">
        <img src="rys1.png" alt="ćwiczenia">
    </section>
    <footer id="stopka">
        <p>Autor: 00000000000</p>
        <a href="kwerendy.txt">Zobacz kwerendy</a>
    </footer>
</body>
</html>

<?php
    mysqli_close($connect);
?>