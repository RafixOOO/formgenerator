<?php require_once("../auth.php"); ?>

<?php if(!isLoggedIn()):
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
    endif;

?>
<html>
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
                        <th scope="col">Imię, nazwisko, telefon</th>
                        <th scope="col">Wniosek</th>
                        <th scope="col">Punkty</th>
                        <th scope="col" data-orderable="false">Opcje</th>
                </thead>
                <tbody>
                <?php
                require_once("../dbconnect.php");
                $id=returniserid();
                $sql="SELECT r.status, r.type, a.name, r.readyID, u.name as nazwa,u.surname, u.phone, u.email FROM readyapplication r, application a, user u WHERE u.userID=r.userID and r.applicationID=a.applicationID and r.userID!=$id; ";
                $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>"
                        . $row["nazwa"]." ".$row["surname"]." ".$row["phone"].
                         "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>";
                        if($row["type"] == 0 and $row["status"] == 0) {
                            echo "Sprawdzanie";
                        } else{
                            echo $row["type"]."/100";
                        }
                        echo "</td>";
                        
                        if($row["type"] != 0){
                            echo "<td><a href='formscheck.php?ID=".$row["readyID"]."'><input style='width: 25%' type='button' class='fadeIn fourth' value='Sprawdzone' disabled></a>";
                        } else {
                            echo "<td><a href='formscheck.php?ID=".$row["readyID"]."'><input style='width: 25%' type='button' class='fadeIn fourth' value='Sprawdź'></a>";

                        }
                        
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