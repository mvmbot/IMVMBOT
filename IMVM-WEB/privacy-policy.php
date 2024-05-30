<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>IESMVMBOT - OFFICIAL PROJECT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="keywords" content="IESMVMBOT, classroom discord bot, mvmbot, insmvmbot, mvm, discord bot" />
    <meta name="description" content="The best Discord bot for School alumns. " />

    <!-- Favicon -->
    <link rel="icon" href="IMVM-WEB/img/faviimvm.ico" type="image/x-icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@600;700&family=Ubuntu:wght@400;500&display=swap"
        rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet" />
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-PXHDMQQ0XY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-PXHDMQQ0XY');
    </script>


    <!-- Google Tag Manager Start -->
    <script>
        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PWQDVHW8');
    </script>
    <!-- Google Tag Manager End -->

    <!-- Google Translator Start -->
    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: "en",
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                showLogo: false,
            },
                "google_translate_element"
            );
        }
    </script>
    <!-- Google Translator End -->
</head>

<body>
    <!-- Google Tag Manager Start (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PWQDVHW8" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- Google Tag Manager End (noscript) -->

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->

    <div class="container-fluid bg-light p-0">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 d-flex justify-content-start align-items-center">
                <div class="text-center">
                    <div id="google_translate_element"></div>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <h5>Social Networks</h5>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn btn-sm-square bg-white text-primary me-1" href="https://discord.gg/bbncbv3gQm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-discord" viewBox="0 0 16 16">
                            <path
                                d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.19 12.19 0 0 0-3.658 0 8.258 8.258 0 0 0-.412-.833.051.051 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032c.001.014.01.028.021.037a13.276 13.276 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011 8.875 8.875 0 0 1-1.248-.595.05.05 0 0 1-.02-.066.051.051 0 0 1 .015-.019c.084-.063.168-.129.248-.195a.05.05 0 0 1 .051-.007c2.619 1.196 5.454 1.196 8.041 0a.052.052 0 0 1 .053.007c.08.066.164.132.248.195a.051.051 0 0 1-.004.085 8.254 8.254 0 0 1-1.249.594.05.05 0 0 0-.03.03.052.052 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019 13.235 13.235 0 0 0 4.001-2.02.049.049 0 0 0 .021-.037c.334-3.451-.559-6.449-2.366-9.106a.034.034 0 0 0-.02-.019Zm-8.198 7.307c-.789 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.45.73 1.438 1.613 0 .888-.637 1.612-1.438 1.612Zm5.316 0c-.788 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.451.73 1.438 1.613 0 .888-.631 1.612-1.438 1.612Z" />
                        </svg>
                    </a>
                    <a class="btn btn-sm-square bg-white text-primary me-1" href="https://twitter.com/IESMVMBOT">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-twitter-x" viewBox="0 0 16 16">
                            <path
                                d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                        </svg>
                    </a>
                    <a class="btn btn-sm-square bg-white text-primary me-1" href="https://www.instagram.com/iesmvmbot">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-instagram" viewBox="0 0 16 16">
                            <path
                                d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                        </svg>
                    </a>
                    <a class="btn btn-sm-square bg-white text-primary me-0" href="https://github.com/mvmbot">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-github" viewBox="0 0 16 16">
                            <path
                                d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src="img/logo.png" alt="IESMVMBOT" height="100">
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                <style>
                svg {
                    fill: #9900ff
                }
                </style>
                <path
                    d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
            </svg>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">HOME</a>
                <a href="./about-us.php" class="nav-item nav-link">ABOUT</a>
                <a href="./FAQ.php" class="nav-item nav-link">FAQ</a>
                <a href="./Changelog.php" class="nav-item nav-link">CHANGELOG</a>
                <div class="dropdown">
                    <button class="nav-item nav-link dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="background-color: #0a0a0a; color: white; border: none;">
                        USER
                    </button>
                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton1"
                        style="background-color: #000;">
                        <!-- Link to SIGN UP -->
                        <a href="./signup.php" class="nav-item nav-link" style="color: white;">SIGN UP</a>
                        <!-- Link to SIGN IN -->
                        <a href="./signin.php" class="nav-item nav-link" style="color: white;">SIGN IN</a>
                        <!-- Link to LOG OUT -->
                        <a href="./php/logout.php" class="nav-item nav-link" style="color: white;">LOG OUT</a>
                        <?php
                        if ($_SESSION["user"]) {
                            ?>
                        <!-- Link to VIEW PROFILE -->
                        <a href="./viewProfile.php" class="nav-item nav-link" style="color: white;"> View profile</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <?php
                if ($_SESSION["user"]) {
                    ?>
                <div class="dropdown">
                    <button class="nav-item nav-link dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="background-color: #0a0a0a; color: white; border: none;">
                        TICKETS
                    </button>
                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton2"
                        style="background-color: #000;">
                        <!-- Link to CREATE TICKET -->
                        <a href="./createTicket.php" class="nav-item nav-link" style="color: white;">CREATE TICKET</a>
                        <!-- Link to VIEW TICKETS -->
                        <a href="./viewTicket.php" class="nav-item nav-link" style="color: white;">VIEW TICKETS</a>
                    </div>
                </div>
                <?php
                } else if ($_SESSION["admin"]) {
                    ?>
                <div class="dropdown">
                    <button class="nav-item nav-link dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="background-color: #0a0a0a; color: white; border: none;">
                        TICKETS
                    </button>
                    <div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton2"
                        style="background-color: #000;">
                        <!-- Link to VIEW TICKETS -->
                        <a href="./viewTicketAdmin.php" class="nav-item nav-link" style="color: white;">VIEW TICKETS</a>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <?php
            if ($_SESSION["user"]) {
                $profileImage = $_SESSION['profileImage'] ?? 'img/defaultavatar.jpg'; // Image profile of user or default picture
                ?>
                <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                    <img src="<?php echo $profileImage; ?>" alt="User Avatar" height="30" class="rounded-circle">
                    <?php echo $_SESSION['user']; ?>
                </a>
                <?php
            } else if ($_SESSION["admin"]) {
                $profileImage = $_SESSION['profileImage'] ?? 'img/defaultadmin.jpg'; // Image profile of admin or default picture
                ?>
                <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                    <img src="<?php echo $profileImage; ?>" alt="Admin Avatar" height="30" class="rounded-circle">
                    <?php echo $_SESSION['admin']; ?>
                </a>
                <?php
            } else {
                ?>
                <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">ACCOUNT</a>
                <?php
            }
            ?>
        </div>
    </div>
</nav>
    <!-- Navbar End -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-7 text-start">

                    <h1 class="bs-primary text-center">PRIVACY POLICY IESMVMBOT</h1><br>

                    <div class="mb-4 text-white">Iesmvmbot, in order to protect individual rights, especially in
                        relation to automated processing and in order to be transparent with the User, has established a
                        policy that covers all such processing, the purposes pursued by the latter, the legitimacy of
                        such processing and also the tools available to the User to enable him/her to exercise his/her
                        rights.
                        <br><br>
                        Browsing this website implies full acceptance of the following provisions and conditions of use.
                        The use of cookies will be accepted. In case you do not agree, send an email to
                        iesmvmbot@gmail.com.
                        <br><br>
                        The updated version of this privacy policy is the only one applicable for the duration of the
                        use of the website until there is no other version to replace it.
                        <br><br>
                        For further information on the protection of personal data we invite you to consult the website
                        of the AEPD (Spanish Agency for Data Protection).<br>
                        https://www.agpd.es/portalwebAGPD/index-ides-idphp.php
                        <br><br>
                        <h3>Data collection</h3>
                        Your data is collected by the OWNER.<br>
                        A personal data refers to all information relating to an identified or identifiable natural
                        person (data subject). An identifiable person is a person who can be identified, directly or
                        indirectly, in particular by reference to a name, an identification number (DNI, NIF, NIE,
                        passport) or to one or more specific elements specific to his physical, physiological, genetic,
                        psychological, economic, cultural or social identity.
                        <br><br>
                        The data that in general will be collected are: Name and surname, address, e-mail address,
                        telephone number, date of birth, data related to means of payment. Other types of data may be
                        collected and the User will be informed.
                        <br><br>
                        <h3>For what purposes are your personal data processed?</h3>
                        The purpose of the processing of personal data that may be collected is to use them mainly by
                        the OWNER to manage its relationship with you, to offer you products and services according to
                        your interests, to improve your user experience and, where appropriate, to process your
                        requests, requests or orders. A commercial profile will be created based on the information you
                        provide. No automated decisions will be made based on this profile.
                        <br><br>
                        The data provided will be kept as long as the commercial relationship is maintained, provided
                        that the interested party does not request its deletion, or for the years necessary to comply
                        with legal obligations.
                        <br><br>
                        They will be recorded in the customer file and their processing will be recorded in the register
                        of processing to be kept by the OWNER (before May 25, 2018 it could also be included in the file
                        prepared with the personal data registered with the AEPD (Spanish Data Protection Agency) or
                        competent body of the respective Autonomous Community).
                        <br><br>
                        <h3>What is the legal basis for the processing of your data?</h3>
                        The legal basis for the processing of your personal data is:
                        <ul>
                            <li>The correct execution or fulfillment of the contract.</li><br>
                            <li>The legitimate interest of the OWNER</li>
                        </ul>
                        <br>
                        <h3>To which recipients will the data be communicated?</h3>
                        The User's personal data may eventually be communicated to third parties related to the OWNER by
                        contract for the performance of the tasks necessary for the management of your account as a
                        customer and without having to give your authorization.
                        <br><br>
                        Also when communications have to be made to the authorities in the event that the User has
                        carried out actions contrary to the law or breached the contents of the legal notice.
                        <br><br>
                        The User's data may be communicated to other group companies, if any, for internal
                        administrative purposes that may involve the processing of such data.
                        <br><br>
                        The User's personal data may be transferred to a third country or to an international
                        organization, but the User must be informed when such a transfer is to take place, and of the
                        conditions of the transfer and the recipient.
                        <br><br>
                        When some data is mandatory to access specific features of the website, the OWNER will indicate
                        such mandatory nature at the time of data collection from the User.
                        <br><br>
                        <h3>Cookies</h3>
                        During the first navigation, an explanatory banner on the use of cookies will appear, including
                        the possibility to accept all cookies or only technical cookies, essential for the operation of
                        the platform; excluding analytical and advertising cookies.
                        <br><br>
                        For more information, please consult our cookie policy.
                        <br><br>
                        <h3>User's rights</h3>
                        The user is informed of the possibility of exercising his rights of access, rectification,
                        cancellation and opposition. Each person also has the right to limit the processing of personal
                        data concerning him/her, the right to erase the transfer of personal data transmitted to the
                        data controller and the right to data portability.
                        <br><br>
                        The user has the possibility to file a complaint with the AEPD (Spanish Data Protection Agency)
                        or competent body of the respective Autonomous Community, when he/she has not obtained a
                        satisfactory solution in the exercise of his/her rights by writing to the same.
                        <br><br>
                        Unless the User objects, by sending an email to the email address iesmvmbot@gmail.com, your data
                        may be used, where appropriate, if applicable, for sending commercial information from
                        Iesmvmbot. The data provided will be retained for as long as the business relationship is
                        maintained or for the years necessary to comply with legal obligations.
                        <br><br>
                        The User is responsible for the information provided through this website is true, responding
                        for the accuracy of all data provided and keep it updated to reflect a real situation, being
                        responsible for false or inaccurate information provided and the damage, inconvenience and
                        problems that may cause Iesmvmbot or third parties.
                        <br><br>
                        This information will be kept and managed with due confidentiality, applying the necessary
                        computer security measures to prevent access or misuse of your data, its manipulation,
                        deterioration or loss.
                        <br><br>
                        However, the User must take into account that the security of computer systems is never
                        absolute. When personal data is provided over the Internet, such information could be collected
                        without your consent and processed by unauthorized third parties. Iesmvmbot disclaims any
                        responsibility for the consequences of such acts may have for the user, if he published the
                        information voluntarily.
                        <br><br>
                        You may access and exercise these rights by written and signed request that can be sent to the
                        address , enclosing Av. d'Eduard Maristany, 59, 08930 Sant Adrià de Besòs, Barcelona, Spain
                        photocopy of ID card or equivalent document.
                        <br><br>
                        The application may also be sent to the following e-mail address: iesmvmbot@gmail.com
                        <br><br>

                        These rights will be attended within 1 month, which may be extended to 2 months if the
                        complexity of the request or the number of requests received so requires. All this without
                        prejudice to the duty to retain certain data in the legal terms and until the possible
                        liabilities arising from a possible treatment, or, where appropriate, a contractual
                        relationship.
                        <br><br>
                        In addition to the above, and in relation to data protection regulations, users who so request,
                        have the possibility of organizing the destination of their data after their death.


                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Contact</h4>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+34 605 73 73 80</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>admin@iesmvmbot.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-sm-square bg-white text-primary me-1"
                                href="https://discord.gg/bbncbv3gQm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-discord" viewBox="0 0 16 16">
                                    <path
                                        d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.19 12.19 0 0 0-3.658 0 8.258 8.258 0 0 0-.412-.833.051.051 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032c.001.014.01.028.021.037a13.276 13.276 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011 8.875 8.875 0 0 1-1.248-.595.05.05 0 0 1-.02-.066.051.051 0 0 1 .015-.019c.084-.063.168-.129.248-.195a.05.05 0 0 1 .051-.007c2.619 1.196 5.454 1.196 8.041 0a.052.052 0 0 1 .053.007c.08.066.164.132.248.195a.051.051 0 0 1-.004.085 8.254 8.254 0 0 1-1.249.594.05.05 0 0 0-.03.03.052.052 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019 13.235 13.235 0 0 0 4.001-2.02.049.049 0 0 0 .021-.037c.334-3.451-.559-6.449-2.366-9.106a.034.034 0 0 0-.02-.019Zm-8.198 7.307c-.789 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.45.73 1.438 1.613 0 .888-.637 1.612-1.438 1.612Zm5.316 0c-.788 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.451.73 1.438 1.613 0 .888-.631 1.612-1.438 1.612Z" />
                                </svg>
                            </a>
                            <a class="btn btn-sm-square bg-white text-primary me-1"
                                href="https://twitter.com/IESMVMBOT">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-twitter-x" viewBox="0 0 16 16">
                                    <path
                                        d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                                </svg>
                            </a>
                            <a class="btn btn-sm-square bg-white text-primary me-1"
                                href="https://www.instagram.com/iesmvmbot">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-instagram" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                                </svg>
                            </a>
                            <a class="btn btn-sm-square bg-white text-primary me-0" href="https://github.com/mvmbot">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-github" viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Company</h4>
                        <a class="btn btn-link" href="./about-us.php">About Us</a>
                        <a class="btn btn-link" href="./FAQ.php">FAQ</a>
                        <a class="btn btn-link" href="./Changelog.php">Changelog</a>

                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Direct Link</h4>
                        <a class="btn btn-link" href="./privacy-policy.php">Privacy Policy</a>
                        <a class="btn btn-link" href="./cookies-policy.php">Cookies</a>

                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Newsletter</h4>
                        <p>Subscribe to our newsletter to stay updated about our bot.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text"
                                placeholder="Your email">
                            <button type="button"
                                class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">Register</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            <p>&copy; 2024 IESMVMBOT - All rights reserved - <a href="./privacy-policy.php">Privacy
                                    Policy</a></p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="./index.php">Home</a>
                                <a href="./cookies-policy.php">Cookies</a>
                                <a href="mailto:admin@iesmvmbot.com">Help</a>
                                <a href="./FAQ.php">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Chat button -->
        <!-- Chat button -->
    <div class="arena-chat" data-publisher="imvmbot" data-chatroom="95YVgkA" data-position="overlay"></div><script async src="https://go.eu.arena.im/public/js/arenachatlib.js?p=imvmbot&e=95YVgkA"></script>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
</body>

</html>