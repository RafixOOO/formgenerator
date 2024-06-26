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
    <input type="text" placeholder="Wyszukiwanie użytkownika" style="width: 15%"/>
    <div class="table-responsive d-flex justify-content-center"></div>
        <table id="myTable" class="table table table-hover">
            <thead>
                        <th scope="col">Imię, nazwisko</th>
                        <th scope="col">Email</th>
                        <th scope="col">Czy konto zweryfikowane?</th>
                        <th scope="col" data-orderable="false">Rola</th>
                </thead>
                <tbody>
                <?php
                require_once("../dbconnect.php");
                $id=returniserid();
                $sql="SELECT * FROM `user` where role IN (1,2,3) order by role desc;";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>"
                        .$row['name'].' '. $row['surname'];
                        "</td>";
                    echo "<td>" .$row['email'].  "</td>";
                    echo "<td>";
                            if($row['verify']==1){
                                echo "Tak";
                            }else{
                                echo "Nie";
                            }
                        echo "</td>";
                            echo "<td>";
                            echo "<form method='POST' action='update_role.php' id='form-" . $row['userID'] . "'>";
                            echo "<input type='hidden' name='user_id' value='" . $row['userID'] . "'>";
                            echo "<select class='form-select form-select-lg mb-3' name='role' onchange='this.form.submit()' ";
                            if($row['verify']==0 or $row['userID']==returniserid()){echo "disabled";}
                            echo ">";
    echo "<option value='3'" . ($row['role'] == 3 ? " selected" : "") . ">Administrator</option>";
    echo "<option value='2'" . ($row['role'] == 2 ? " selected" : "") . ">Moderator</option>";
    echo "<option value='1'" . ($row['role'] == 1 ? " selected" : "") . ">Recenzent</option>";
    echo "</select>";
    echo "</form>";
    echo "</td>";
                        
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