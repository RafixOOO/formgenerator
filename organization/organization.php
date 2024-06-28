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
    <title>Generator | Organizacja</title>
</head>
<body>
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
<?php require_once("../navbar.php"); ?>
    <div class="wrapper fadeInDown">
     <?php
    $query = 'brak';
    if (isset($_GET['query'])) {
    $query = urldecode($_GET['query']);
} ?>

<input type="text" id="search" class="code-input" placeholder="Wyszukiwanie organizacji" style="width: 20%;" value="<?php if($query!='brak')echo $query; ?>"/>
        <div class="table-responsive d-flex justify-content-center"></div>
        <form method="POST" action="save_organization.php">
        <table id="myTable" class="table table table-hover">
            <thead>
                        <th scope="col">Grupa</th>
                        <th scope="col">Rola</th>
                        <th scope="col">Czy Grupa zaakceptowana?</th>
                        <th scope="col" data-orderable="false">Zarządzaj</th>
                </thead>
                <tbody>
                <?php
                require_once("../dbconnect.php");
                $id=returniserid();
                if($query=='brak'){
                    $sql="SELECT od.OrganizationID,od.Name, oc.role, oc.accept as uz, od.accept as gr from organizationdata od, organizationconnect oc WHERE od.OrganizationID=oc.OrganizationID and oc.UserID=$id and od.accept!=2 and oc.accept!=2";
                }else{
                    $sql="SELECT od.OrganizationID,od.Name, oc.role, oc.accept as uz, od.accept as gr from organizationdata od, organizationconnect oc WHERE od.OrganizationID=oc.OrganizationID and CONCAT(od.Name, ' #', od.OrganizationID) Like '%$query%' and od.accept=1 and od.accept!=2 and oc.UserID!=$id";
                }

                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row['Name'].' #'.$row['OrganizationID'];
                    echo  "</td>";
                    echo "<td>";
                    if($row['uz']==1 and $query=='brak'){
                        if($row['role']==3){
                            echo "Właściciel Grupy";
                        }else if($row['role']==2){
                            echo "Administrator Grupy";
                        }else if($row['role']==1){
                            echo "Moderator Grupy";
                        }else {
                            echo "Członek Grupy";
                        }

                    }else if($row['role']==0 and $row['uz']==0){
                        echo "Oczekiwanie";
                    }else{
                        echo "Brak";
                    }
                    echo "</td>";
                    echo "<td>";
                        if($row['gr']==1){
                            echo "Tak";
                        }else{
                            echo "Nie";
                        }
                        echo "</td>";

                        if($query=="brak"){
                            echo "<td><a href='organizationsetting.php?ID=".$row['OrganizationID']."&ROLE=".$row['role']."'><input style='width: 40%' type='button' class='fadeIn fourth' value='" . ($row['gr'] == 0 ? "Oczekiwanie na akceptacje" : "Zarządzaj") . "' ></a></td>";
                        }else{
                            echo "<td><a href='send_organization.php?ID=".$row['OrganizationID']."'><input style='width: 40%' type='button' class='fadeIn fourth' value='Wyślij prośbę'></a></td>";
                        }


                        echo "</tr>";
                    }

?>
                </tbody>
                <tfoot>
            <tr>

                    <td colspan="3">
                        <input type="text" id="create" name="create" class="code-input" placeholder="Nazwa organizacji" style="width: 50%; float:right; margin-bottom: 2.5%;" />
                    </td>
                    <td>
                        <input type="submit" class="fadeIn fourth" value="Utwórz organizację" style="width: 50%;" />
                    </td>

            </tr>
        </tfoot>

        </table>
        </form>
    </div>
</body>
    <script>
        $(document).ready(function(){
          const baseUrl = "http://10.100.101.14/programs/formgenerator/organization/organization.php"; // Stały URL
          let timer;
          $("#search").on("input", function(){
            clearTimeout(timer);
            let query = $(this).val();
            timer = setTimeout(function() {
              const url = new URL(baseUrl); // Użycie stałego URL-a
              if (query.length > 0) {
                url.searchParams.set('query', query);
                window.history.pushState({}, '', url);

                $.ajax({
                  url: url.href,
                  success: function(data) {
                    const results = $(data).find("#result").html();
                    $("#result").html(results);
                  }
                });
              } else {
                $("#result").html('');
                window.history.pushState({}, '', baseUrl); // Przywrócenie URL-a bez parametrów
              }
                location.reload();
            }, 1000); // 1-sekundowe opóźnienie
          });
        });
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