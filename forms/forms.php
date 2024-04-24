<html>
<head>
    <link rel="stylesheet" href="style.css" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.5/datatables.min.js"></script>
    <title>Generator | Strona główna</title>
</head>
<body>
<?php require_once("../navbar.php"); ?>
    <div class="wrapper fadeInDown">
    <div class="table-responsive"></div>
        <table id="myTable" class="table table table-hover">
            <thead>
                        <th scope="col">Wniosek</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Data zakończenia</th>
                        <th scope="col" data-orderable="false"></th>
                </thead>
                <tbody>
                    <tr>
                        <th>Wniosek 1</th>
                        <td>Mark</td>
                        <td>24.05.2025</td>
                        <td>Otto</td>
                    </tr>
                    <tr>
                        <th>Wniosek 2</th>
                        <td>Jacob</td>
                        <td>24.05.2025</td>
                        <td>Thornton</td>
                    </tr>
                    <tr>
                        <th>Wniosek 3</th>
                        <td>Larry the Bird</td>
                        <td>24.05.2025</td>
                        <td>Thornton</td>
                    </tr>
                </tbody>

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