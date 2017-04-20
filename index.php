<?php
    include_once 'Controllers/ControlerFactory.php';
    include_once 'Controllers/ControlerDictionary.php';
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/Alert.php';

    $session = Session::getInstance();
    $session -> startSession();
?>

<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adaptacyjny system uczący</title>
    <link href="Content/css/bootstrap.css" rel="stylesheet">
    <link href="Content/css/footer.css" rel="stylesheet">
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php?con=1&page=1">Główna</a>
                    </li>
                    <li>
                        <a href="#">Kursy</a>
                    </li>
                    <li>
                        <a href="index.php?con=2&page=1">O nas</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php?con=3&page=2"><span class="glyphicon glyphicon-user"></span> Rejestracja</a></li>
                    <li><a href="index.php?con=3&page=1"><span class="glyphicon glyphicon-log-in"></span> Logowanie</a></li>
                </ul>
            </div>
        </div>
    </div>

    <br />
    <br />
    <br />

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if ($session -> __isset("alert"))
                    {
                        $alert = unserialize($session -> __get("alert"));
                        Alert::MakeAlert($alert);

                        $session -> __unset("alert");
                    }

                    if (isset($_GET["con"]))
                    {
                        $con_id = $_GET["con"];
                        $page_id;
                        
                        if (isset($_GET["page"]))
                        {
                            $page_id = $_GET["page"];
                            $controller = ControllerFactory::GetControllerById($con_id);
                            $controller -> GetViewById($page_id);
                        }
                    }
                    else
                    {
                        $mainController = ControllerFactory::GetControllerById(ControllerDictionary::MAIN_CONTROLLER_ID);
                        $mainController -> GetViewById(ControllerDictionary::MAIN_PAGE_ID);
                    }
                ?>
            </div>
        </div>
		
						<!-- editor -->
				<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
				<script>
					tinymce.init({ selector:'textarea',  
						plugins: "textcolor colorpicker link insertdatetime table image media  autoresize autolink wordcount",
						toolbar: "forecolor backcolor link insertdatetime table image media " });
				</script>
				  
				  <textarea id="getText"></textarea>
					<button onclick="viewText()">View</button>


				<script>
				function viewText()
				{
						alert(tinyMCE.get('getText').getContent());
				}
				</script>

			<hr/>
			<div>
				<ul class="contact-container">
					<li>
						<img src="Content/img/grafik.jpg">
						<div class="about-info">
							<strong>Piotr Aleksandrowicz</strong>
							<p><i>Grafik</i></p>
							<p>Potrafi zaprogramować, jednak jego największą pasją jest grafika i to właśnie tu się spełnia. Potrafi dopieścić każdą stronę zaprojektowaną przez jego kolegów.</p>
							<address>
								<strong>Adres e-mail:</strong> <a href="mailto:oldProgrammer@example.com">designer@example.com</a><br />
								<strong>Telefon kontaktowy: </strong>981 - 332 - 7399
							</address>
						</div>
					</li>
					<li>
						<img src="Content/img/mlodzyszProgramista.jpg">
						<div class="about-info">
							<strong>Łukasz Wesołowski</strong>
							<p><i>Młodszy programista</i></p>
							<p>Pała wielką pasją do programowania. Ma ogromną wiedzę, jednak nie zawsze potrafi ją w pełni wykorzystać, bowiem brak mu doświadczenia. Wraz z pomocą doświadocznych kolegów potrafi zdziałać cuda.</p>
							<address>
								<strong>Adres e-mail:</strong> <a href="mailto:oldProgrammer@example.com">youngProgrammer@example.com</a><br />
								<strong>Telefon kontaktowy: </strong>635 - 175 - 0199
							</address>
						</div>
					</li>
					<li>
						<img src="Content/img/starszyProgramista.jpg">
						<div class="about-info">
							<strong>Mateusz Kniżewski</strong>
							<p><i>Starszy programista</i></p>
							<p>Od dzieciństwa jego pasją są komputery. Jego ukochanym językiem jest C#, dlatego też każdy program pisany jest w tym dialekcie. Jest to wielki pasjonat programowania.</p>
							<address>
								<strong>Adres e-mail:</strong> <a href="mailto:oldProgrammer@example.com">oldProgrammer@example.com</a><br />
								<strong>Telefon kontaktowy: </strong>425 - 555 - 0100
							</address>
						</div>
					</li>
				</ul>
			</div>
				
            <footer class="footer navbar-fixed-bottom">
                <hr />
				<h6>&copy; Wszystkie prawa zastrzeżone - 2017</h6>
            </footer>
			
			
    </div>

    <script src="Content/js/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="Content/js/bootstrap.js"></script>
	
	<script>
		$( "ul.contact-container li img" ).click(function() 
		{
			$("ul.contact-container li img").css("opacity", 0.7);
			$(this).css("opacity", 1);
			
			$(this).parent().parent().find("li").find(".about-info").css("display", "none");		
			$(this).parent().find(".about-info").fadeIn( "slow" ).css("display", "block");		
			jumpToPageBottom();
		});
		
		
		function jumpToPageBottom() 
		{
			$('html, body').scrollTop( $(document).height() - $(window).height() );	
		}
	</script>
  </body>
</html>