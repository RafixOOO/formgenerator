<script>
        function redirectToNewPage() {
        // Ustawienie adresu URL nowej strony
        var newPageURL = "http://10.100.101.14/programs/formgenerator/forms/forms.php";
        // Przekierowanie użytkownika
        window.location.href = newPageURL;
        }
function redirectToNewPage1() {
    // Ustawienie adresu URL nowej strony
    var newPageURL1 = "http://10.100.101.14/programs/formgenerator/formready/formready.php";
    // Przekierowanie użytkownika
    window.location.href = newPageURL1;
    }
    </script>
<nav class="navbar navbar-expand-lg py-3">
    <div class="pe-lg-0 ps-lg-5 container-fluid justify-content-between">
        <a class="navbar-brand" href="#">
            <img src="../img/Fundacja-SMK-CMYK-logotyp.jpg" height="80" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <div class="nav_left d-lg-flex align-items-center">
                <nav>
                    <div class="nav d-block d-lg-flex nav-tabs" id="nav-tab" role="tablist">
                            <button <?php $url = $_SERVER['REQUEST_URI']; if(strpos($url, '/forms/forms.php') !== false){ echo 'class="nav-link active"'; } else{echo 'class="nav-link"'; } ?> id="home-tab" type="button" onclick="redirectToNewPage()">Strona główna</button>
                        <button <?php $url = $_SERVER['REQUEST_URI']; if(strpos($url, '/formready/formready.php') !== false){ echo 'class="nav-link active"'; } else{echo 'class="nav-link"'; } ?> id="about-tab" data-bs-toggle="tab" data-bs-target="#about"
                            type="button" role="tab" aria-controls="about" aria-selected="false" onclick="redirectToNewPage1()">Wnioski</button>
                        <button class="nav-link" id="timing-tab" data-bs-toggle="tab" data-bs-target="#timing"
                            type="button" role="tab" aria-controls="timing" aria-selected="false">Organizacja</button>
                        <div class="dropdown">
                            <button class="dropdown-toggle nav-link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo returnImieNazwisko(); ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!--<li><a class="dropdown-item" href="#">Akcja 1</a></li>-->
                                <!-- <li><a class="dropdown-item" href="#">Akcja 2</a></li>-->
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../logout.php">Wyloguj się</a></li>
                            </ul>
                        </div>

                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </nav>
