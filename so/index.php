<!DOCTYPE html>
<html lang="en">
<?php
include "../core.php";
$fnc = new database();
$modal_script = "";

$sql = "SELECT * FROM so_member WHERE Year(so_idpa_expire) >= " . (date("Y") - 1) . " AND so_idpa_id is not null AND so_idpa_id <> '' AND so_status = 'enable' AND so_level = 'IPOC' ORDER BY so_firstname_en;";
$member_ipoc = $fnc->get_db_array($sql)[0];
$sql = "SELECT * FROM so_member WHERE Year(so_idpa_expire) >= " . (date("Y") - 1) . " AND so_idpa_id is not null AND so_idpa_id <> '' AND  so_status = 'enable' AND so_level = 'CSO' ORDER BY so_firstname_en;";
$member_cso = $fnc->get_db_array($sql);
$sql = "SELECT * FROM so_member WHERE Year(so_idpa_expire) >= " . (date("Y") - 1) . " AND so_idpa_id is not null AND so_idpa_id <> '' AND  so_status = 'enable' AND so_level = 'SO' ORDER BY so_firstname_en;";
// die ($sql . "<br><br>");
$member_so = $fnc->get_db_array($sql);
$sql = "SELECT * FROM so_member WHERE Year(so_idpa_expire) >= " . (date("Y") - 1) . " AND so_idpa_id is not null AND so_idpa_id <> '' AND  so_status = 'enable' AND so_level <> 'IPOC' AND so_level <> 'CSO' AND so_level <> 'SO' ORDER BY so_firstname_en;";
$member_trainee = $fnc->get_db_array($sql);
$sql = "SELECT * FROM v_on_duty where Year(match_begin) >= " . (date("Y") - 1) . ";";
// $sql = "SELECT * FROM v_on_duty;";
$member_on_duty = $fnc->get_db_array($sql);

// echo "<pre>";
// print_r($member_ipoc);
// echo "</pre><hr>";
// echo "<pre>";
// print_r($member_cso);
// echo "</pre><hr>";
// echo "<pre>";
// print_r($member_so);
// echo "</pre><hr>";
// echo "<pre>";
// print_r($member_trainee);
// echo "</pre><hr>";

?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SO-IDPASOTH.COM</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../images/favicon-96x96.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="styles.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">SAFETY OFFICER</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#cso">CSO</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#so">SO</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#trainee">Trainee</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="container d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <img class="masthead-avatar mb-5 shadow border-3 border-dark" src="https://idpasoth.com/<?= $member_ipoc["so_avatar"] ?>" alt="<?= $member_ipoc["so_firstname_en"]  . " &nbsp; " . $member_ipoc["so_lastname_en"] ?>" />
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-2">IPOC</h1>
            <h3 class="masthead-heading text-uppercase mb-0 fs-4" style="letter-spacing: 0.2em;"><?= $member_ipoc["so_firstname_en"]  . " &nbsp; " . $member_ipoc["so_lastname_en"] ?></h3>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0" style="letter-spacing: 0.25em;">IDPA SO THAILAND</p>
        </div>
    </header>
    <?php
    function find_idpa_id($obj)
    {
        global $member;
        return $obj["so_idpa_id"] === $member["so_idpa_id"];
    }

    function gen_array_filter($array, $key, $value)
    {
        $result = array();
        foreach ($array as $k => $val) {
            if ($val[$key] == $value) {
                array_push($result, $array[$k]);
            }
        }
        return $result;
    }

    function gen_member_card($member)
    {
        global $modal_script, $member_on_duty, $fnc;
        // echo "<pre>";
        // print_r($member);
        // echo "</pre><hr>";
    ?>
        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#portfolioModal_<?= $member["so_idpa_id"] ?>">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                <div class="portfolio-item-caption-content text-center text-white fs-6"><?= $member["so_firstname_en"] . " &nbsp; " . $member["so_lastname_en"] ?><br><?= $member["so_idpa_id"] ?></div>
            </div>
            <img class="img-fluid shadow" src="https://idpasoth.com/<?= $member["so_avatar"] ?>" alt="<?= $member["so_firstname_en"] . " &nbsp; " . $member["so_lastname_en"] ?>" />
            <div class="mt-4" style="font-size: 0.85em;"><?= $member["so_firstname_en"] . " &nbsp; " . $member["so_lastname_en"] ?></div>
        </div>
    <?php
        $data = gen_array_filter($member_on_duty, "so_idpa_id", $member["so_idpa_id"]);
        $sql = "SELECT * FROM v_on_duty WHERE so_idpa_id = '" . $member["so_idpa_id"] . "' AND Year(match_begin) >= " . (date("Y") - 1) . " ORDER BY match_begin Desc;";
        $data = $fnc->get_db_array($sql);
        // echo "member_on_duty " . $member["so_idpa_id"] . "<pre>";
        // print_r($data);
        // echo "</pre>";
        if ($data) {
            $modal_script .= gen_modal_member_info($data);
        }
    }

    function gen_modal_member_info($duty)
    {
        // echo "duty<pre>";
        // print_r($duty);
        // echo "</pre>";
        $modal = '<div class="portfolio-modal modal fade" id="portfolioModal_' . $duty[0]["so_idpa_id"] . '" tabindex="-1" aria-labelledby="portfolioModal_' . $duty[0]["so_idpa_id"] . '" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-0"><button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <div class="modal-body text-center pb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Portfolio Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0 fs-4"><span class="text-danger">SO Portfolio</span><br>' . $duty[0]["so_idpa_id"] . '<br>' . $duty[0]["so_firstname_en"] . ' &nbsp; ' . $duty[0]["so_lastname_en"] . '</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <!-- Portfolio Modal - Image-->

                                    <div class="table-responsive">
                                        <table class="table table-primary table-striped" style="font-size: 0.8em;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th scope="col">DATE</th>
                                                    <th scope="col">MATCH</th>
                                                    <th scope="col">POSITION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            ';
        foreach ($duty as $row) {
            $modal .= '
<tr class="">
<td scope="row">' . $row["match_begin"] . '</td>
<td class="text-start">' . $row["match_name"] . '</td>
<td>' . $row["on_duty_position"] . '</td>
</tr>';
        }
        $modal .= '
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Portfolio Modal - Text-->
                                    <p class="mb-4 d-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia neque assumenda ipsam nihil, molestias magnam, recusandae quos quis inventore quisquam velit asperiores, vitae? Reprehenderit soluta, eos quod consequuntur itaque. Nam.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $modal;
    } ?>

    <!-- CSO Section-->
    <section class="page-section portfolio" id="cso">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">CSO</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                <!-- Portfolio Item 1-->
                <?php foreach ($member_cso as $mem) { ?>
                    <div class="col-md-6 col-lg-3 mb-0 p-5">
                        <?php gen_member_card($mem) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- SO Section-->
    <section class="page-section portfolio" id="so">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">SO</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                <!-- Portfolio Item 1-->
                <?php foreach ($member_so as $mem) { ?>
                    <div class="col-md-6 col-lg-3 mb-0 p-5">
                        <?php gen_member_card($mem) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- TRAINEE Section-->
    <section class="page-section portfolio" id="trainee">
        <div class="container">
            <!-- Portfolio Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">TRAINEE</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
            </div>
            <!-- Portfolio Grid Items-->
            <div class="row justify-content-center">
                <!-- Portfolio Item 1-->
                <div class="row justify-content-center">
                    <!-- Portfolio Item 1-->
                    <?php foreach ($member_trainee as $mem) { ?>
                        <div class="col-md-6 col-lg-3 mb-0 p-5">
                            <?php gen_member_card($mem) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section-->
    <section class="page-section bg-primary text-white mb-0 d-none" id="about">
        <div class="container">
            <!-- About Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- About Section Content-->
            <div class="row">
                <div class="col-lg-4 ms-auto">
                    <p class="lead">Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional SASS stylesheets for easy customization.</p>
                </div>
                <div class="col-lg-4 me-auto">
                    <p class="lead">You can create your own custom avatar for the masthead, change the icon in the dividers, and add your email address to the contact form to make it fully functional!</p>
                </div>
            </div>
            <!-- About Section Button-->
            <div class="text-center mt-4">
                <a class="btn btn-xl btn-outline-light" href="https://startbootstrap.com/theme/freelancer/">
                    <i class="fas fa-download me-2"></i>
                    Free Download!
                </a>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="footer text-center d-none">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Location</h4>
                    <p class="lead mb-0">
                        2215 John Daniel Drive
                        <br />
                        Clark, MO 65243
                    </p>
                </div>
                <!-- Footer Social Icons-->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Around the Web</h4>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-dribbble"></i></a>
                </div>
                <!-- Footer About Text-->
                <div class="col-lg-4">
                    <h4 class="text-uppercase mb-4">About Freelancer</h4>
                    <p class="lead mb-0">
                        Freelance is a free to use, MIT licensed Bootstrap theme created by
                        <a href="http://startbootstrap.com">Start Bootstrap</a>
                        .
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; <a href="https://idapsoth.com">IDAPSOTH.COM</a> 2023</small></div>
    </div>

    <?php if ($modal_script) {
        echo $modal_script;
    } ?>

    <!-- Bootstrap core JS-->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <!-- <script src="js/scripts.js"></script> -->
    <!-- <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> -->
</body>

</html>