<?php require_once("../auth.php"); ?>

<?php if(!isLoggedIn()):
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
    endif;

?>
<!DOCTYPE html>
<html lang="PL">
<head>
    <meta charset ="utf-8" />
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
    <title>Generator | Wnioski</title>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<?php require_once("../navbar.php"); ?>
    <div class="wrapper fadeInDown">
    <div class="table-responsive d-flex justify-content-center"></div>
        <table id="myTable" class="table table table-hover">
            <thead>
                        <th scope="col">Imię, nazwisko</th>
                        <th scope="col" style="width:10em;">Wniosek</th>
                        <th scope="col">Data utworzenia</th>
                        <th scope="col" data-orderable="false">Opcje</th>
                </thead>
                <tbody>
                <?php
                require_once("../dbconnect.php");
                $id=returniserid();
                $sql="SELECT a.name, u.name as nazwa,u.surname, u.phone, u.email, a.datetime, a.`applicationID` FROM application a, user u WHERE u.userID=a.userID and a.deleted=2;  ";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>"
                        . $row["nazwa"]." ".$row["surname"].
                        "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>";
                    echo $row["datetime"];
                        echo "</td>";
                        
                       
                            echo "<td><a href='szkicedit.php?ID=".$row["applicationID"]."'><input style='width: 25%' type='button' class='fadeIn fourth' value='Edytuj'></a>";
                            echo "<a href='szkicread.php?ID=".$row["applicationID"]."'><input style='width: 25%' type='button' class='fadeIn fourth' value='Podgląd'></a>";
                        
                        echo "</tr>";
                    }

?>

        </table>
    </div>
</body>
    <script>
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                paging: false,
                info: false,
                searching: false
            });

            $('#myTable').on('order.dt', function () {
                var order = table.order()[0];

                // Usuń wszystkie klasy sortowania
                $('th i').removeClass('fa-sort-asc fa-sort-desc');

                // Dodaj odpowiednią klasę sortowania na podstawie aktualnego kierunku sortowania
                $('th:eq(' + order[0] + ') i').addClass(order[1] === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc');
            });

            $('#searching').key(function(){
                table.search($(this).val()).draw() ;
            })
        });
    </script>

</html>