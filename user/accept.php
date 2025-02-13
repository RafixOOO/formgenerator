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
    <title>Generator | Zarządzaj</title>
    <link rel="icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEAAAAALAAAAAABAAEAAAIA" type="image/gif">
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<?php require_once("../navbar.php"); ?>
    <div class="wrapper fadeInDown">
        <table id="myTable" class="table table table-hover">
            <thead>
                        <th scope="col">Grupa</th>
                        <th scope="col">Imię, nazwisko, email</th>
                        <th scope="col">Czy konto zweryfikowane?</th>
                        <th scope="col" data-orderable="false">Rola</th>
                </thead>
                <tbody>
                <?php
                require_once("../dbconnect.php");
                $id=returniserid();
                $sql="SELECT od.OrganizationID,od.Name, oc.role, od.accept, u.name, u.surname, u.email, u.verify from `organizationdata` od, `organizationconnect` oc, `user` u WHERE od.OrganizationID=oc.OrganizationID and oc.UserID=u.userID and oc.role=3 and od.accept=0;;";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row['Name'].' #'.$row['OrganizationID'];
                     echo   "</td>";
                    echo "<td>".$row['name']." ".$row['surname'] .", ". $row['email']  . "</td>";
                    echo "<td>";
                            if($row['verify']==1){
                                echo "Tak";
                            }else{
                                echo "Nie";
                            }
                        echo "</td>";


                            echo "<td><a href='save_accept.php?ID=".$row['OrganizationID']."'><input style='width: 25%' type='button' class='fadeIn fourth' value='Akceptuj'></a>";
                            echo "<a href='usun_accept.php?ID=".$row['OrganizationID']."'><input style='width: 25%' type='button' class='fadeIn fourth' value='Usuń'></a>";

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