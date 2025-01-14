<?php require_once("../auth.php"); ?>

<?php if (!isLoggedIn()):
    header("Location: ../index.php"); // Przekierowanie na stronę po zalogowaniu
    exit;
endif;

?>
<!DOCTYPE html>
<html lang="PL">
<head>
    <meta charset="utf-8"/>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
    <title>Generator | Strona główna</title>
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEAAAAALAAAAAABAAEAAAIA" type="image/gif">

</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<?php require_once("../navbar.php"); ?>
<div class="wrapper fadeInDown">
    <?php if (returnRole() == 1 or returnRole() == 2 or returnRole() == 3) { ?>
        <a href="../formcreate/formbuilder.php" style="width: 15%"><input type="button" class="fadeIn fourth"
                                                                          value="Utwórz" style="width: 100%"></a>
    <?php } ?>
    <div class="table-responsive d-flex justify-content-center"></div>
    <table id="myTable" class="table table table-hover">
        <thead>
        <th scope="col" style="width:25%;">Wniosek</th>
        <th scope="col" style="width:10%;">Data utworzenia</th>
        <th scope="col" style="width:10%;">Data zakończenia</th>
        <th scope="col" data-orderable="false">Opcje</th>
        </thead>
        <tbody>
        <?php
        require_once("../dbconnect.php");
        $id=returniserid();
        $sql = "SELECT a.*
FROM `application` a
WHERE a.`deleted` = 0
  AND NOT EXISTS (
    SELECT 1
    FROM `readyapplication` r
    WHERE r.applicationID = a.applicationID
      AND r.userID = $id
      AND r.status != 1
  )
  order by a.datetimedo asc;";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            if(new DateTime($row["datetimedo"]) < new DateTime() && returnRole()==3){
                if(returnRole()==3){
                    echo "<tr style='background-color:lightgray;'>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["datetime"] . "</td>";
                    echo "<td>" . $row["datetimedo"] . "</td>";
                    echo "<td><a href='formsread.php?ID=" . $row["applicationID"] . "&finish=1'><input style='width: 25%' type='button' class='fadeIn fourth' value='Podgląd'></a>";
                    if (returnRole() == 2 or returnRole() == 3) {
                        echo "<a href='formscopy.php?ID=" . $row["applicationID"] . "'><input style='width: 25%;' type='button' class='fadeIn fourth' value='Kopiuj do szkiców'></a></td>";
                    }
                    echo "</tr>";
                }
            } else if(new DateTime($row["datetimedo"]) > new DateTime()){
                echo "<tr>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["datetime"] . "</td>";
                echo "<td>" . $row["datetimedo"] . "</td>";
                echo "<td><a href='formsread.php?ID=" . $row["applicationID"] . "&finish=0'><input style='width: 25%' type='button' class='fadeIn fourth' value='Wypełnij'></a>";
                if (returnRole() == 2 or returnRole() == 3) {
                    echo "<a href='formsdelete.php?ID=" . $row["applicationID"] . "'><input style='width: 25%; background-color: red;' type='button' class='fadeIn fourth' value='Usuń'></a>";
                    echo "<a href='formscopy.php?ID=" . $row["applicationID"] . "'><input style='width: 25%;' type='button' class='fadeIn fourth' value='Kopiuj do szkiców'></a></td>";
                }
                echo "</tr>";
            }
           
        }

        ?>

    </table>
</div>
</body>
<script>
    $(document).ready(function () {
        var table = $('#myTable').DataTable({
            paging: false,
            info: false,
            searching: false,
            order: [[2, 'desc']]
        });

        $('#myTable').on('order.dt', function () {
            var order = table.order()[0];

            // Usuń wszystkie klasy sortowania
            $('th i').removeClass('fa-sort-asc fa-sort-desc');

            // Dodaj odpowiednią klasę sortowania na podstawie aktualnego kierunku sortowania
            $('th:eq(' + order[0] + ') i').addClass(order[1] === 'asc' ? 'fa-sort-asc' : 'fa-sort-desc');
        });

        $('#searching').key(function () {
            table.search($(this).val()).draw();
        })
    });
</script>

</html>