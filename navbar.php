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

function redirectToNewPage2() {
    // Ustawienie adresu URL nowej strony
    var newPageURL1 = "http://10.100.101.14/programs/formgenerator/formready/tocheck.php";
    // Przekierowanie użytkownika
    window.location.href = newPageURL1;
    }

function redirectToNewPage3() {
    // Ustawienie adresu URL nowej strony
    var newPageURL1 = "http://10.100.101.14/programs/formgenerator/formready/szkic.php";
    // Przekierowanie użytkownika
    window.location.href = newPageURL1;
    }
function redirectToNewPage4() {
    // Ustawienie adresu URL nowej strony
    var newPageURL1 = "http://10.100.101.14/programs/formgenerator/user/role_user.php";
    // Przekierowanie użytkownika
    window.location.href = newPageURL1;
    }
function redirectToNewPage5() {
    // Ustawienie adresu URL nowej strony
    var newPageURL1 = "http://10.100.101.14/programs/formgenerator/user/accept.php";
    // Przekierowanie użytkownika
    window.location.href = newPageURL1;
    }
    </script>
<nav class="navbar navbar-expand-lg py-3">
<!-- 2024 Created by: Rafał Pezda-->
<!-- link: https://github.com/RafixOOO -->
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
                            <?php if(returnRole()==1 or returnRole()==2 or returnRole()==3) { ?>
                        <div class="dropdown">
                            <button class="dropdown-toggle nav-link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Wnioski
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" onclick="redirectToNewPage1()">Wnioski</a></li>
                                 <?php if(returnRole()==2 or returnRole()==3) { ?>
                                <li><a class="dropdown-item" onclick="redirectToNewPage2()">Do sprawdzenia</a></li>
                                <?php } ?>
                                <li><a class="dropdown-item" onclick="redirectToNewPage3()">Szkice</a></li>
                            </ul>
                        </div>
                        <?php } else{ ?>
                        <button <?php $url = $_SERVER['REQUEST_URI']; if(strpos($url, '/formready/formready.php') !== false){ echo 'class="nav-link active"'; } else{echo 'class="nav-link"'; } ?> id="about-tab" data-bs-toggle="tab" data-bs-target="#about"
                            type="button" role="tab" aria-controls="about" aria-selected="false" onclick="redirectToNewPage1()">Wnioski</button><?php } ?>
                        <button class="nav-link" id="timing-tab" data-bs-toggle="tab" data-bs-target="#timing"
                            type="button" role="tab" aria-controls="timing" aria-selected="false">Organizacja</button>
                        <div class="dropdown">
                            <button class="dropdown-toggle nav-link" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo returnImieNazwisko(); ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php if(returnRole()==3) { ?>
                                <li><a class="dropdown-item" onclick="redirectToNewPage4()">Role</a></li>
                                <?php } ?>

                                <?php if(returnRole()==2 or returnRole()==3) { ?>
                                <li><a class="dropdown-item" onclick="redirectToNewPage5()">Akceptacje</a></li>
                                <?php } ?>
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
