<?php
session_start();
require "conf.php";
global $yhendus;

if(isset($_REQUEST["nimi"]) && !empty($_REQUEST["nimi"]) && isset($_REQUEST["perenimi"]) && !empty($_REQUEST["perenimi"])
&& isset($_REQUEST["result"]) && !empty($_REQUEST["result"])){
    global $yhendus;
    $kask=$yhendus->prepare("Update jooksjad set  eesnimi=?,perenimi=?,result=? where id=? ");
    $kask->bind_param("ssii", $_REQUEST["nimi"], $_REQUEST["perenimi"],$_REQUEST["result"],$_REQUEST["id"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}

function isAdmin(){
    return isset($_SESSION['status']) && $_SESSION['status'];
}
if (isset($_SESSION["login"]) && isset($_SESSION["!login"]) && isset($_SESSION['status'])) {

    include('registration.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Leht</title>
    <link rel="stylesheet" type="text/css" href="jookja.css">
</head>
<script>
function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.querySelector("table");
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[columnIndex];
                    y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                    if (isNaN(x.innerHTML)) {
                        shouldSwitch = x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase();
                    } else {
                        shouldSwitch = parseFloat(x.innerHTML) > parseFloat(y.innerHTML);
                    }

                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        break;
                    }
                }
            }
        }

            function openModal() {
            document.getElementById('languageModal').style.display = 'block';
        }

            function closeModal() {
            document.getElementById('languageModal').style.display = 'none';
        }


    function openModal(id, nimi, perenimi, result) {
        document.getElementById('id').value = id;
        document.getElementById('nimi').value = nimi;
        document.getElementById('perenimi').value = perenimi;
        document.getElementById('result').value = result;
        document.getElementById('muuda').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('muuda').style.display = 'none';
    }
</script>

<body>
<header>
    <img src="logo.png" id="logo" alt="logo" width="100" height="100">
    <?php
    if(isset($_SESSION['login'])){
        ?>
        <h1 id="loginname"><?="$_SESSION[login]"?></h1>
        <a href="logout.php"   class="logi">Logi välja</a>
        <?php
    } else {
        ?>
        <a id="lingid" href="login.php">Logi sisse</a>

        <?php
    }
    ?>
    <?php
    if(isset($_SESSION['login'])){
        ?>
        <a id="lingid" href="logout.php"></a>
        <?php
    } else {
        ?>
        <a id="lingid" href="registration.php">Registreerimine</a>

        <?php
    }
    ?>
    <?php
    if(isset($_SESSION['login'])){
        ?>
        <?php
    }

    ?>
    <?php
    if (isset($_SESSION["login"]))
    {
    ?>
    <nav id="navmenu">
        <a href="jooksmain.php" id="lingid2">Lisamine</a>
        <a href="start.php" id="lingid2">Start</a>
        <a href="lopp.php" id="lingid2">Lõpp</a>
        <a href="autasustamise.php" id="lingid2">Autasustamise</a>
    </nav>
</header>
<div id="regdiv">
    <h1>Halduspaneel</h1>
</div>

<div id="muuda" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="Muuda_joksja">Muuda joksja</h2>
        <form action="?">
            <input type="hidden" name="id" id="id">
            <label for="nimi">Nimi:</label>
            <input type="text" name="nimi" id="nimi">
            <label for="perenimi">Perenimi:</label>
            <input type="text" name="perenimi" id="perenimi">
            <label for="result">Result</label>
            <input type="number" name="result" id="result">
            <input type="submit" name="jkskls" id="jkskls" value="Muuda">
        </form>

    </div>
</div>

<table>
    <tr>
        <th id="cursor" onclick="sortTable(0)">Nimi</th>
        <th id="cursor" onclick="sortTable(1)">Perenimi</th>
        <th>Alustamisaeg</th>
        <th>Lõpetamisaeg</th>
        <th id="cursor" onclick="sortTable(2)">Tulemus</th>
        <th>Muuda</th>
    </tr>
    <?php
    global $yhendus;
    $kask=$yhendus->prepare("SELECT id, eesnimi, perenimi,alustamisaeg,lopetamisaeg,result from jooksjad;");
    $kask->bind_result($id,$nimi,$perenimi,$alustamiaeg,$lopitamisaeg,$result);
    $kask->execute();
    while ($kask->fetch()) {
        echo "<tr>";
        echo "<td>" . $nimi . "</td>";
        echo "<td>" . $perenimi . "</td>";
        echo "<td>" . $alustamiaeg . "</td>";
        echo "<td>" . $lopitamisaeg . "</td>";
        echo "<td>" . $result . "</td>";
        echo "<td><input type='button' id='muudabtn' name='muudabtn' value='Muuda' onclick='openModal($id, \"$nimi\", \"$perenimi\", $result)'></td>";
        echo "</tr>";
    }

    ?>
</table>
<br>
<?php
}
?>
</body>
</html>
