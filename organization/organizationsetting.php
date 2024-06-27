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
    <title>Generator | Wnioski</title>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<?php require_once("../navbar.php"); ?>
<div class="wrapper fadeInDown">

    <?php
    $query = 'brak';
    if (isset($_GET['ID'])) {
        $ID = urldecode($_GET['ID']);
    } ?>
    <div class="table-responsive d-flex justify-content-center"></div>
    <table id="myTable" class="table table table-hover">
        <thead>
        <th scope="col">Imię, nazwisko</th>
        <th scope="col">Email</th>
        <th scope="col" data-orderable="false">Rola</th>
        <th scope="col">Opcje</th>
        </thead>
        <tbody>
        <?php
        require_once("../dbconnect.php");

        $sql = "SELECT oc.`OrganizationID`,oc.`organizationconnectID`,oc.`role`, oc.`accept`, u.name, u.surname, u.email, u.verify, u.userID FROM `organizationconnect` oc, `user` u where u.userID=oc.UserID and oc.OrganizationID=$ID";


        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>"
                . $row['name'] . ' ' . $row['surname'];
            "</td>";
            echo "<td>" . $row['email'] . " " . ($row['verify'] == 1 ? "(Zweryfikowany)" : "") . "</td>";
            echo "<td>";
            if($row['role']==3){
                echo "Właściciel Grupy";
            }else{


            echo "<form method='POST' action='update_role_organization.php' id='form-" . $row['organizationconnectID'] . "'>";
            echo "<input type='hidden' name='user_id' value='" . $row['organizationconnectID'] . "'>";
            echo "<select class='form-select form-select-lg mb-3' name='role' onchange='this.form.submit()' ";
            if ($row['verify'] == 0 or $row['userID']==returniserid()) {
                echo "disabled";
            }
            echo ">";
            echo "<option value='3'" . ($row['role'] == 2 ? " selected" : "") . ">Administrator Grupy</option>";
            echo "<option value='2'" . ($row['role'] == 1 ? " selected" : "") . ">Moderator Grupy</option>";
            echo "<option value='1'" . ($row['role'] == 0 ? " selected" : "") . ">Członek Grupy</option>";
            echo "</select>";
            echo "</form>";
            }
            echo "</td>";
            echo "<td>";
            if($row['role']==3 and $row['userID']==returniserid()){
                echo "<a href='delete_organization.php?ID=".$row["OrganizationID"]."'><input style='width: 40%' type='button' class='fadeIn fourth' value='Usuń całą organizacje'></a>";

            }else{
                echo "<a href='delete_role_organization.php?ID=".$row["organizationconnectID"]."'><input style='width: 40%' type='button' class='fadeIn fourth' value='Usuń użytkownika z grupy'></a>";
            }
            echo "</td>";

            echo "</tr>";
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
            searching: false
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