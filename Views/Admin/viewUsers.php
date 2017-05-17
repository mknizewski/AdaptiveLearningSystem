<?php
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';


    //include_once 'Controllers/AdminController.php';


    $session = Session::getInstance();
	$dbContext = new DbContext();
    $user = unserialize($session -> __get("user"));
	
	$selectStatement = "SELECT * FROM users";
    $usersList = $dbContext -> Select($selectStatement);
?>
<h2>Lista użytkowników</h2>
<hr />
<div class="row">
    <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Nawigacja</div>
        <div class="panel-body"> 
              <ul>
                <li><a href="index.php?con=4&page=1">Główna</a></li>
                <li><a href="#">Dostępne kursy</a></li>
                <li><a href="#">Kontakt</a></li>
                <?php
                    if ($user -> RoleId == UserRolesDictionary::ADMIN)
                    {
                        echo '<li><a href="index.php?con=5&page=1">Panel administracyjny</a></li>';
                    }
                    else
                    {
                        echo '<li><a href="index.php?con=4&page=3">Ankieta adaptacyjna</a></li>';
                    }
                ?>
            </ul> 
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Ustawienia konta</div>
        <div class="panel-body">
            <ul>
                <li><a href="index.php?con=4&page=5">Zmiana hasła</a></li>
                <li><a href="index.php?con=4&page=2">Sprawdź uprawnienia</a></li>
            </ul> 
        </div>
    </div>
  </div>
    <div class="col-md-9">
		<div class="panel panel-info">
            <div class="panel-heading">Użytkownicy w serwisie</div>
            <div class="panel-body ">
                <table class="table table-hover">
                    <thead>
                        <tr>
							<th>Imię</th>
                            <th>Nazwisko</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Styl uczenia</th>
                            <th>Kursy</th>
							<th>Zmień rolę</th>
							<th>VARK</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							error_reporting(E_ALL & ~E_NOTICE);
                            if ($usersList -> num_rows > 0)
                            {
                                while ($row = $usersList -> fetch_assoc())
                                {
									$id = "'" . $row["id"] . "'";

                                    $role_id = "'" . $row["role_id"] . "'";
                                    $learning_style_id = "'" . $row["learning_style_id"] . "'";			
									$selectStatement = "SELECT * FROM roles WHERE id = ".$role_id;
									$rolesList = $dbContext -> Select($selectStatement);
									if ($rolesList -> num_rows > 0)
										while ($rowRoles = $rolesList -> fetch_assoc())
											$role = $rowRoles["name"];
									
									$selectStatement = "SELECT * FROM learningstyles WHERE id = ".$learning_style_id;
									$learningStylesList = $dbContext -> Select($selectStatement);
									if ($learningStylesList -> num_rows > 0)
										while ($rowLearningStyle = $learningStylesList -> fetch_assoc())
											$learning_style = $rowLearningStyle["name"];	
									else
										$learning_style = "Jeszcze nie określono";
										
                                    echo "<tr>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["surname"] . "</td>";
                                    echo "<td> <a href = 'mailto:". $row["email"] ."'>". $row["email"] ."</a> </td>";
                                    echo "<td>" . $role  ."</td>"; 
                                    echo "<td>". $learning_style . "</td>";
									echo "<td>";
										$selectStatement = "SELECT * FROM courses_users WHERE id_user = ".$id;
										$signToCourseList = $dbContext -> Select($selectStatement);
										if ($signToCourseList -> num_rows > 0)
										{
											echo '<div class="dropdown disabled">
																			<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Zapisany do ...
																			<span class="caret disabled"></span></button>
																			<ul id="dropDownMenu_Courses" class="dropdown-menu" >';
											while ($rowIdCourses = $signToCourseList -> fetch_assoc())
											{
												$id_course = $rowIdCourses["id_course"];
												$id_courses_users = $rowIdCourses["id"];
												
												
												$selectStatement = "SELECT * FROM courses WHERE id = ".$id_course;
												$coursesList = $dbContext -> Select($selectStatement);
												if ($coursesList -> num_rows > 0)
												{
													while ($rowCourses = $coursesList -> fetch_assoc())
													{														
														$courseName = $rowCourses["title"];														
														echo '<li><a style="" href="#">'. $courseName .'</a><a href="#" id="goout" onclick="DeleteUser(' . $id . ', ' . $id_course . ')" style="">Wypisz</a></li>';
													}	
												}
											}
												echo'	</ul>
												  </div>';
										}
										else
											echo 'Jeszcze nie zapisany...';
									echo "</td>";
									/*echo '<td>
										<input type= "text"  size = "1" name ='. $id .'/> 
										<input type= 'submit' name= 'change_role' size= '2' value= 'Zmień' onclick=".   .' />
										</td>';*/
									echo '<td>
											<div class="dropdown disabled">
												<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'. $role .'
												<span class="caret disabled"></span></button>
												<ul id="dropDownMenu_Courses" class="dropdown-menu" >
													<li><a onclick="UpdateRole(' . $row["id"] . ', ' . 1 . ')" href="#">'. admin .'</a></li>
													<li><a onclick="UpdateRole(' . $row["id"] . ', ' . 2 . ')" href="#">'. student .'</a></li>
													<li><a onclick="UpdateRole(' . $row["id"] . ', ' . 3 . ')" href="#">'. guest .'</a></li>
												</ul>
											</div>
										  </td>';
									echo '<td><button type="submit" class="btn btn-primary" onclick = "ResetVARK('. $row["id"] .')">Resetuj</button></td>';
                                    echo "</tr>";
                                }
                            }
                        ?>							
					</tbody>
				</table>

                <a href="index.php?con=5&page=1" style="float: right; margin-top: 5px" class="btn btn-default">Cofnij</a>

			</div>
		</div>
    </div>
</div>

<!-- LEKCJA 1 - O programowaniu w .NET -->
<!-- MODUL1 - Wstęp --> <!-- DLA WSZYSTKICH --> KOLEJNOSC -> 1
<div class="row">
	<div class="col-md-12">
		<h4>O czym?</h4>
		<ul class="list-group">
			<a class="list-group-item">W tej sekcji dowiesz się na temat samego .NETa.</a>
			<a class="list-group-item">Trochę podstaw teoretycznych to podstawa dobrej nauki!</a>
		<br>		
		<h4>W jaki sposób?</h4>
		<ul class="list-group">
			<a class="list-group-item">Sporo wiedzy teoretycznej (lecz nie przejmuj się tym!)</a>
		<br>		
		<h4>Weryfikacja!</h4>
		<ul class="list-group">
			<a class="list-group-item">Testy wiedzy sprawdzą to czy wszystko dobrze zapamiętałeś! ;)</a>
	</div>
</div>


<!-- MODUL2 - Sedno --> <!-- AURAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Audiobook - <i>O programowaniu w .NET</i></h4>
			<span>W audiobooku znajdziesz informacje nt. definicji samego .NETa. Dowiesz się o tym czym jest Visual Studio. Poznasz definicję
			samego C#, co pomoże Ci lepiej zrozumieć ten język programowania.</span>
		</div>
		<audio style="width: 100%;" controls>
			<source src="http://pioter-test.cba.pl/als/01_01.mp3" type="audio/mpeg">
		</audio> 
	</div>
</div>

<!-- MODUL3 - Sedno --> <!-- DLA WSZYSTKICH --> KOLEJNOSC -> 3
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>MS .NET</h4>
			<span>NET Framework, w skrócie .NET (wym. dot net) – platforma programistyczna opracowana przez Microsoft, obejmująca środowisko uruchomieniowe (Common Language Runtime – CLR) 
			oraz biblioteki klas dostarczające standardowej funkcjonalności dla aplikacji.
.NET nie jest związany z jakimś konkretnym językiem oprogramowania. Możesz pisać programy w jednym z wielu języków, np. C#, F#, J#, C++/CLI, Visual Basic .NET. Zadaniem tejże platformy jest zarządzanie elementami systemu, takimi jak: kod aplikacji, pamięć czy zabezpieczenia.
 W tym środowisku możesz tworzyć oprogramowanie, które będzie działać po stronie serwera (IIS), bądź też takie, które będzie pracowało na systemach, 
 które posiadają działającą implementację tej platformy</span>
		</div>
		<div class="col-md-12 well well-md" style="">
			<h4>Visual Studio</h4>
			<span>Środowiskiem programistycznym, którego będziemy używać w naszym kursie jest Microsoft Visual Studio. Jest to flagowy produkt, który umożliwia pisanie w kilku językach programowania. Istnieje także wiele innych narzędzi jak choćby 
			komercyjny Borland, czy też środowisko zastępcze dla MS VS - SharpDevelop.</span>
		</div>
		<div class="col-md-12 well well-md" style="">
			<h4>C#</h4>
			<span>C# jest językiem programowania opracowanym przez firmę Microsoft. Jego głównym twórcą jest Anders Hejlsberg – inżynier oprogramowania znany z pracy nad Turbo Pascalem.
C# łączy w sobie to, co najlepsze z języków Java, C oraz C++. Składnia języka podobna jest do tej z C++, zaś samo działanie programów przypomina mechanizm Javy (jest to wirtualizacja). </span>
		</div>
	</div>
</div>




<!-- ****************************************** -->
<!-- LEKCJA 2 - ZMIENNE  -->
<!--Wstęp  --> <!-- DLA WSZYSTKICH --> KOLEJNOSC -> 1
<div class="row">
	<div class="col-md-12">
		<h4>O czym?</h4>
		<ul class="list-group">
			<a class="list-group-item">O typach zmiennych (w tym liczby całkowite, zmiennoprzecinkowe, referencyjne oraz pozostałe typy)</a>
			<a class="list-group-item">O rzutowaniu i konwersji</a>
			<a class="list-group-item">O rodzajach konwersji</a>
			<a class="list-group-item">O stałych oraz wykorzystaniu słowa kluczowego const</a>
			<a class="list-group-item">O wyświetlaniu wartości na różne sposoby</a>
		<br>		
		<h4>W jaki sposób?</h4>
		<ul class="list-group">
			<a class="list-group-item">Filmiki tutorialowe Akademii C#</a>
			<a class="list-group-item">Dokładnie opisany kod umieszczony w materiałach wideo</a>
			<a class="list-group-item">Lekcje teoretyczne</a>
			<a class="list-group-item">Wiedza teoretyczna</a>
		<br>		
		<h4>Weryfikacja!</h4>
		<ul class="list-group">
			<a class="list-group-item">Testy sprawdzające wiedzę</a>
			<a class="list-group-item">Praktyczne zadania programistyczne</a>
	</div>
</div>

<!-- MODUL1- Typy zmiennych -->

<!-- MODUL1- Typy zmiennych --> <!-- VISUAL --> KOLEJNOSC -> 2
GRAFIKA - Typy zmiennych
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 1 </strong><i>Typy zmiennych</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_11.png"></br></br>
		</div>
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 2 </strong><i>Proste operatory arytmetyczne</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_12.png"></br></br>
		</div>
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 3 </strong><i>Typy danych</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_12b.jpg"></br></br>
		</div>
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 4 </strong><i>Animacja pokazująca działanie programu</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_13.gif"></br></br>
		</div>
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 5 </strong><i>Tabela o prostych typach danych</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_13b.jpg"></br></br>
		</div>
	</div>
</div>

<!-- MODUL1 - Typy zmiennych --> <!-- AURAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Audiobook - <i>Typy zmiennych</i></h4>
			<span>W audiobooku znajdziesz informacje nt. tego czym jest zmienna, w jaki sposób deklaruje się zmienną. Zawarte są również informacje odnośnie podziału zmiennych w języku C#  i zasadzie przechowywanie wartości przez dany typ zmiennych.</span>
		</div>
		<audio style="width: 100%;" controls>
			<source src="http://pioter-test.cba.pl/als/02_01.mp3" type="audio/mpeg">
		</audio> 
	</div>
</div>

<!-- MODUL1 - Typy zmiennych --> <!--  Reading --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Typy zmiennych - <i>omówienie</i></h4>
			<span>C sharp ma do zaoferowania wiele typów zmiennych, które mogą być wykorzystane przez nas w programie. </p>
						   <b>Zmienna</b>, jak sama nazwa wskazuje będzie się zmieniać w trakcie przetwarzania programu. Zmienna jest podstawowym sposobem przechowywania informacji w komputerze; w kodzie źródłowym traktowana, jako odnośnik do określonego miejsca w pamięci komputera. </p>

							Definicja zmiennej opiera się na następującym schemacie:
							<li><b>Sposób pierwszy:</b> typ nazwa_zmiennej1 = wartość (z przypisaniem wartości początkowej)</li>
							<li><b>Sposób drugi:</b> typ nazwa_zmiennej2; (bez przypisania wartości początkowej)</li></p>
							
							Należy pamiętać, że podczas odwołania się do zmiennej o nieokreślonej wartości może spowodować błędne działanie programu. </p>
							
							Typy dzielimy na dwa rodzaje. Pierwszym z typów są <b>typy skalarne</b>, które przechowuje wartości na stosie. Podstawowymi typami skalarnymi są między innymi: </p>

							Liczby całkowite: 
							<li><b>byte</b> - liczba bez znaku (8 bitowa);</li>
							<li><b>sbyte</b> - liczba ze znakiem (8 bitowa);</li>
							<li><b>short</b> - liczba ze znakiem (16 bitowa);</li>
							<li><b>int</b>  - liczba ze znakiem (32 bitowa);</li>
							<li><b>long</b>  - liczba ze znakiem (64 bitowa).</li>
							</p>
							
							Liczby zmiennoprzecinkowe:
							<li><b>float</b> - liczba pojedynczej precyzji;</li>
							<li><b>double</b> - liczba podwójnej precyzji;</li>
							<li><b>decimal</b> - liczba stałej precyzji.</li>
							</p>
							
							Pozostałe typy:
							<li><b>string</b> - ciąg znaków Unicode;</li>
							<li><b>char</b> - znak Unicode;</li>
							<li><b>bool</b> - wartość logiczna. </li>
							</p>
							
							Istnieją również <b>typy referencyjne</b>, które przechowują na stosie adres do wartości na stercie. Podczas gdy na daną wartość wskazuje kilka zmiennych typu referencyjnego to zmiana wartości wpływa na każdą ze zmiennych.</span>
		</div> 
	</div>
</div>

<!-- MODUL1 - Typy zmiennych --> <!--  Kinestetic --> KOLEJNOSC -> 2
<div class="row">
			<div class="col-md-12">
				<iframe style="width: 100%;" height="400px"
					src="https://www.youtube.com/embed/L0_q4ZZIUbw" frameborder="0" allowfullscreen>
				</iframe>
				<div class="well well-md" style="width: 100%;">
					<h4>Akademia C# - <i>Typy zmiennych w C#</i></h4>
					<span>
						Materiał video przedstawia sposób zastosowania różnych typów w zmiennych w języku C sharp.
					</span>
				</div>	
			</div>	
		</div>

		
		
<!-- MODUL2- Rzutowanie i konwersja -->
		
		<!-- MODUL2- Rzutowanie i konwersja --> <!-- VISUAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 1 </strong><i>Rzutowanie</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_21.jpg"></br>
		</div>		
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 2 </strong><i>Konwersja</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_22.jpg"></br>
		</div>
	</div>
</div>

<!-- MODUL2 - Rzutowanie i konwersja --> <!-- AURAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Audiobook - <i>Rzutowanie i konwersja</i></h4>
			<span>W audiobooku znajdziesz informacje nt. tego czym jest rzutowanie zmiennych, w jaki sposób przebiega konwersja zmiennych. Zawarte są również informacje odnośnie podziale konwersji w języku C# .</span>
		</div>
		<audio style="width: 100%;" controls>
			<source src="http://pioter-test.cba.pl/als/02_02.mp3" type="audio/mpeg">
		</audio> 
	</div>
</div>

<!-- MODUL2 - Rzutowanie i konwersja --> <!--  Reading --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Rzutowanie i konwersja - <i>omówienie</i></h4>
			<span><b>Rzutowanie</b> jest określane mianem tzw. jawnej konwersji typów (<b>implicit</b>). Rzutowanie jawne informuje kompilator, że celowo zamierzamy dokonać konwersji oraz że jesteśmy świadomi, że może dojść do utracenia danych.</p>

	W przypadku gdy rzutujemy zmienną typu int do typu double (<b>konwersja poszerzająca</b>) nie ryzykujemy utraceniem danych, ponieważ double jest bardziej pojemny. Jeżeli zaś będziemy rzutować zmienną typu double do int (<b>konwersja przybliżająca</b>), sprawimy, że zmienna będzie miała wartość tylko całkowitą (część ułamkowa zostanie utracona).</p>

	Utrata precyzji nie musi powodować błędu, ale wymaga, aby proces takiej konwersji był kontrolowany przez programistę, dlatego konieczne jest jawne wykonywanie operacji rzutowania typów.</p>

	Istnieją też inne konwersje dostępne w C#:
		<li>konwersje niejawne (explicit);</li>
		<li>zdefiniowane przez użytkownika;</li>
		<li>konwersje przy pomocy metod do konwersji dostępnych w bibliotekach.</li>
		</p>
		
		Klasa <b>Convert</b> w C# umożliwia konwertowanie podstawowych typów danych na inny podstawowy typ danych. Podstawowe konwersje używane w języku C#:

			<li><b>ToBoolean</b> - zwraca wartość logiczną danego typu wejściowego;</li>
			<li><b>ToChar</b> - konwertuje przykładowo liczbę całkowitą ze znakiem na jego odpowiednik znaku Unicode;</li>
			<li><b>ToDecimal</b> - kowertuje wartość przykładowo byte na odpowiadającą mu liczbę dziesiętną;</li>
			<li><b>ToDouble</b> - konwertuje wartość określonej liczby całkowitej/zmiennoprzecinkowej na liczbę zmiennoprzecinkową podwójnej precyzji;</li>
			<li><b>ToInt</b> - konwertuje liczbę na odpowiadającą mu liczbę całkowitą. W przypadku znaków Unicode konwersja polega na przedstawieniu znaku przykładowo char na odpowiadającą mu liczbę z przestrzeni znaków Unicode;</li>
			<li><b>ToString</b> - konwertuje dany typ na ciąg znaków.</li>
			</p>
			
			Do konwersji typów można również wykorzystać metodę <b>Int32.Parse().</b> Należy lecz pamiętać, że parametrem metody może być jedynie ciąg znaków (string). Klasa <b>Convert</b> w odróżnieniu przyjmuje parametry określonych metod, jako obiekty. Podczas gdy obiektem traktowanym jako argument jest ciąg znaków, powołuje się wówczas do metody <b>Int32.TryParse().</b>

</span>
		</div> 
	</div>
</div>

<!-- MODUL2 - Rzutowanie i konwersja --> <!--  Kinestetic --> KOLEJNOSC -> 2
<div class="row">
			<div class="col-md-12">
				<iframe style="width: 100%;" height="400px"
					src="https://www.youtube.com/embed/1k65N59vju4" frameborder="0" allowfullscreen>
				</iframe>
				<div class="well well-md" style="width: 100%;">
					<h4>Akademia C# - <i>Rzutowanie i konwersja</i></h4>
					<span>
						Materiał video przedstawia sposób zastosowania rzutowania i konwersji w C#. Dzięki temu zrozumiesz zasadę działania rzutowania i nie będzie stanowić to Tobie żadnych problemów.
					</span>
				</div>	
			</div>	
		</div>
		


<!-- MODUL3- Stałe-->
		
		<!-- MODUL3- Stałe--> <!-- VISUAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 1 </strong><i>Stałe</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/02_31.jpg"></br>
		</div>
	</div>
</div>

<!-- MODUL3 - Stałe --> <!-- AURAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Audiobook - <i>Stałe</i></h4>
			<span>W audiobooku znajdziesz informacje nt. tego czym jest stała, w jaki sposób deklarujemy stała w C #.  Jest również omówione w jaki sposób dzielimy stałe w programowaniu.</span>
		</div>
		<audio style="width: 100%;" controls>
			<source src="http://pioter-test.cba.pl/als/02_03.mp3" type="audio/mpeg">
		</audio> 
	</div>
</div>

<!-- MODUL3- Stałe --> <!--  Reading --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Stałe - <i>omówienie</i></h4>
			<span><b>Stałe</b> są to zmienne, które nie podlegają modyfikacji. Aby zadeklarować stałą używamy słowa <b>const.</b>
			</p>

			Sposób deklaracji stałej:
				<li><b>const</b> typ nazwa = wartość.</li></p>
			Raz już zadeklarowanej wartości nie możemy potem zmieniać w programie. Będzie to skutkować błędem programu.</p> 

			Aby zapobiec błędom w programie, podczas wyświetlania zmiennej możemy dokonać operację na tej zmiennej podczas wyświetlania, lecz zmienna w pamięci wciąż będzie miała stałą, niezmienną, zadeklarowaną wcześniej wartość.</p>

			W jeżyku C# wyróżniamy 3 rodzaje stały:
				<li><b>literały</b> - reprezentacja konkretnej wartości określonego typu wyliczeniowego;</li>
				<li><b>stałe symboliczne</b> - definiuje się poza funkcjami, traktowana jako zmienna globalna dostępna dla wszystkich funkcji;</li>
				<li><b>wyliczenia (enum)</b> - tworzy się za pomocą dyrektywy preprocesora przy pomocy klauzuly #define w części nagłówkowej, tuż po załączeniu bibliotek do programu przy pomocy #include.</li>

</span>
		</div> 
	</div>
</div>

<!-- MODUL3 - Stałe --> <!--  Kinestetic --> KOLEJNOSC -> 2
<div class="row">
			<div class="col-md-12">
				<iframe style="width: 100%;" height="400px"
					src="https://www.youtube.com/embed/U7-wyqQllDY" frameborder="0" allowfullscreen>
				</iframe>
				<div class="well well-md" style="width: 100%;">
					<h4>Akademia C# - <i>Stałe</i></h4>
					<span>
						Materiał video przedstawia sposób użycia stałych w C#. Dzięki temu zrozumiesz zasadę stałych w programowaniu.
					</span>
				</div>	
			</div>	
		</div>
		
		
		<!-- MODUL4- Wyświetlanie wartości -->
		
		<!-- MODUL4- Wyświetlanie wartości--> <!-- VISUAL (w Reading to samo) --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Wyświetlanie wartości - <i>omówienie</i></h4>
			<span>C# ma do zaoferowania wiele sposobów wyświetlania wartości:

				<li><b>{O:C}</b> - służy do formatowania waluty</li>
				<li><b>{0:E}</b> - służy do wyświetlania liczby w notacji wykładniczej</li>
				<li><b>{0:Dn}</b> - służy do wyświetlania liczby dziesiętnej, gdzie n to minimalna ilość cyfr w wyświetlanej liczbie;</li>
				<li><b>{0:Fn}</b> - służy do wyświetlania liczby z n ilością miejsc po przecinku;</li>
				<li><b>{0:X}</b> - służy do wyświetlania liczby w systemie szesnastkowym;</li>
				<li><b>{0:d}</b> - służy do wyświetlania dnia;</li>
				<li><b>{0:t}</b> - służy do wyświetlania godziny;</li>
				<li><b>{0:P}</b> - służy do wyświetlania procentów;</li>
				<li><b>{0:Nm}</b> - służy do wyświetlania numeru, gdzie m to ilość miejsc po przecinku.</li>

</span>
		</div> 
	</div>
</div>

<!-- MODUL4 - Wyświetlanie wartości --> <!-- AURAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Audiobook - <i>Wyświetlanie wartości</i></h4>
			<span>W audiobooku znajdziesz informacje nt. tego w jaki sposób wyświetlać wartości zmiennych przy odpowienim formacie.</span>
		</div>
		<audio style="width: 100%;" controls>
			<source src="http://pioter-test.cba.pl/als/02_04.mp3" type="audio/mpeg">
		</audio> 
	</div>
</div>

<!-- MODUL4- Wyświetlanie wartości --> <!--  Reading --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Wyświetlanie wartości - <i>omówienie</i></h4>
			<span>C# ma do zaoferowania wiele sposobów wyświetlania wartości:

				<li><b>{O:C}</b> - służy do formatowania waluty</li>
				<li><b>{0:E}</b> - służy do wyświetlania liczby w notacji wykładniczej</li>
				<li><b>{0:Dn}</b> - służy do wyświetlania liczby dziesiętnej, gdzie n to minimalna ilość cyfr w wyświetlanej liczbie;</li>
				<li><b>{0:Fn}</b> - służy do wyświetlania liczby z n ilością miejsc po przecinku;</li>
				<li><b>{0:X}</b> - służy do wyświetlania liczby w systemie szesnastkowym;</li>
				<li><b>{0:d}</b> - służy do wyświetlania dnia;</li>
				<li><b>{0:t}</b> - służy do wyświetlania godziny;</li>
				<li><b>{0:P}</b> - służy do wyświetlania procentów;</li>
				<li><b>{0:Nm}</b> - służy do wyświetlania numeru, gdzie m to ilość miejsc po przecinku.</li>

</span>
		</div> 
	</div>
</div>

<!-- MODUL4 - Wyświetlanie wartości --> <!--  Kinestetic --> KOLEJNOSC -> 2
<div class="row">
			<div class="col-md-12">
				<iframe style="width: 100%;" height="400px"
					src="https://www.youtube.com/embed/m_-uAYpI8sg" frameborder="0" allowfullscreen>
				</iframe>
				<div class="well well-md" style="width: 100%;">
					<h4>Akademia C# - <i>Wyświetlanie wartości</i></h4>
					<span>
						Materiał video przedstawia sposób użycia stałych w C#. Dzięki temu zrozumiesz zasadę stałych w programowaniu.
					</span>
				</div>	
			</div>	
		</div>

<!-- ****************************************** -->
<!-- LEKCJA 3 - OPERATORY  -->
<!--Wstęp  --> <!-- DLA WSZYSTKICH --> KOLEJNOSC -> 1
<div class="row">
	<div class="col-md-12">
		<h4>O czym?</h4>
		<ul class="list-group">
			<a class="list-group-item">O operatorach arytmetycznych (mnożenie, dzielenie, dodawanie, odejmowanie, itp.)</a>
			<a class="list-group-item">O operatorach logicznych (AND, OR i NOT)</a>
			<a class="list-group-item">O operatorach porównania</a>
			<a class="list-group-item">O operatorze warunkowym</a>
			<a class="list-group-item">O sposobie użycia operatorów w programowaniu w języku C#</a>
		<br>		
		<h4>W jaki sposób?</h4>
		<ul class="list-group">
			<a class="list-group-item">poprzez utworzone filmy Akademii C#</a>
			<a class="list-group-item">dostęp do kodu źródłowego</a>
			<a class="list-group-item">ogrom teorii</a>
			<a class="list-group-item">wiedza teoretyczna</a>
		<br>		
		<h4>Weryfikacja!</h4>
		<ul class="list-group">
			<a class="list-group-item">Sprawdzian praktyczny z użycia operatorów danego typu </a>
			<a class="list-group-item">Weryfikacja wiedzy</a>
	</div>
		
	<!-- MODUL2- Operatory arytmetyczne -->

	<!--MODUL2 - Operatory arytmetyczne --> <!-- VISUAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 1 </strong><i>Rodzaje operatorów</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/03_11.png"></br>
		</div>		
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 2 </strong><i>Operatory arytmetyczne (tabela)</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/03_12.jpeg"></br>
		</div>		
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 3 </strong><i>Operatory</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/03_02.PNG"></br>
		</div>		
	</div>
</div>

<!-- MODUL2 - Operatory arytmetyczne --> <!-- AURAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Audiobook - <i>Operatory arytmetyczne</i></h4>
			<span>W audiobooku znajdziesz informacje nt. tego czym jest operator i do czego używa się operatorów. Omówione zostaje również zasada działania oraz znaczenie operatorów arytmetycznych w programowaniu.</span>
		</div>
		<audio style="width: 100%;" controls>
			<source src="http://pioter-test.cba.pl/als/03_01.mp3" type="audio/mpeg">
		</audio> 
	</div>
</div>

<!-- MODUL2 - Operatory arytmetyczne --> <!--  Reading --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Operatory arytmetyczne - <i>omówienie</i></h4>
			<span><b>Operatorem</b> określamy jeden lub kilka znaków, które są wykorzystywane w języku programowania na każdym kroku. Pozwalają one wykonywać różne operacje na zmiennych, kolekcjach itp. Dzielimy je na:
				<li>arytmetyczne;</li>
				<li>logiczne;</li>
				<li>warunkowe;</li>
				<li>przypisania;</li>
				<li>bitowe;</li>
				<li>porównania.</li>
				</p>

				Operatorem <b>arytmetycznym</b> nazywamy operator służący do wykonywania prostych działań matematycznych:
					<li>Operator dodawania (+);</li>
					<li>Operator odejmowania (-);</li>
					<li>Operator mnożenia (*);</li>
					<li>Operator dzielenia (/);</li>
					<li>Operator reszty z dzielenia (%);</li>
					<li>Operator inkrementacji (++) - umieszczany przez lub po nazwie zmiennej dokonuje zwiększenia wartości zmiennej o 1;</li>
					<li>Operator dekrementacji (--) - umieszczany przed lub po nazwie zmiennej dokonuje zmniejszenia wartości zmiennej o 1.</li>
					</p>
					
					<b>Uwaga: W przypadku, gdy zmienna z takim operatorem (inkrementacji lub dekrementacji) występuje, jako samodzielna instrukcja wówczas położenia operatora nie ma znaczenia. Zatem:</b>
					<li><b>liczba++</b> jest równoważna z <b>++liczba;</b></li>
					</p>
					Jeżeli jednak inkrementowana lub dekrementowana liczba bierze udział w jakimś wyrażeniu, wówczas położenie operatora ma znaczenia.</span>
		</div> 
	</div>
</div>

<!-- MODUL2 - Operatory arytmetyczne --> <!--  Kinestetic --> KOLEJNOSC -> 2
<div class="row">
			<div class="col-md-12">
				<iframe style="width: 100%;" height="400px"
					src="https://www.youtube.com/embed/8iLVat7AeJI" frameborder="0" allowfullscreen>
				</iframe>
				<div class="well well-md" style="width: 100%;">
					<h4>Akademia C# - <i>Operatory arytmetyczne</i></h4>
					<span>
						Materiał video przedstawia sposób zastosowania operatorów arytmetycznych w C#.
					</span>
				</div>	
			</div>	
		</div>

	<!-- MODUL3- Operatory logiczne -->
	
	<!--MODUL3 - Operatory logiczne--> <!-- VISUAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 1 </strong><i>Rodzaje operatorów</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/03_11.png"></br>
		</div>			
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 2 </strong><i>Operatory logiczne</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/03_01.jpg"></br>
		</div>			
		<div class="col-md-12 well well-md" style="">
			<strong>Rys. 3 </strong><i>Rodzaje operatorów</i>
			<img style="width: 100%" src="http://pioter-test.cba.pl/als/03_02.PNG"></br>
		</div>	
	</div>
</div>
	
	<!-- MODUL3 - Operatory logiczne --> <!-- AURAL --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Audiobook - <i>Operatory logiczne</i></h4>
			<span>W audiobooku znajdziesz informacje nt. tego czym jest operator i do czego używa się operatorów. Omówione zostaje również zasada działania oraz znaczenie operatorów logicznych w programowaniu.</span>
		</div>
		<audio style="width: 100%;" controls>
			<source src="http://pioter-test.cba.pl/als/03_02.mp3" type="audio/mpeg">
		</audio> 
	</div>
</div>

<!-- MODUL3 - Operatory logiczne --> <!--  Reading --> KOLEJNOSC -> 2
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 well well-md" style="">
			<h4>Operatory logiczne - <i>omówienie</i></h4>
			<span>Operatory <b>logiczne</b> służą do łączenia wyrażeń będących w relacji:
				<li><b>Suma warunków</b> (|| - lub [OR]) - zwraca true jeśli chociaż jeden warunek jest prawdziwy. Operator || jest sumą logiczną dwóch wyrażeń;</li>
				<li><b>Iloczyn warunków</b> (&& - i [AND]) - zwraca true jeśli oba warunki są prawdziwe. Operator && jest iloczynem logicznym dwóch wyrażeń; </li>
				<li><b>Negacja warunku</b> (! - nie [NOT]) - zmienia true na false i na odwrót;</li>
				<li><b>Alternatywa wykluczająca warunku</b> (^ - EXCLUSIVE-OR) - zwróci true jeśli tylko jeden warunek jest prawdziwy.</li>
				</p>
				Argumenty wyrażenia logicznego muszą być typu <b>bool</b> lub wyrażenia relacyjne oraz wywołane metody, które zwracają właśnie wartość logiczną <b>bool.</b></span>
		</div> 
	</div>
</div>

<!-- MODUL3 - Operatory logiczne --> <!--  Kinestetic --> KOLEJNOSC -> 2
<div class="row">
			<div class="col-md-12">
				<iframe style="width: 100%;" height="400px"
					src="https://www.youtube.com/embed/oiaiK7Z9la4" frameborder="0" allowfullscreen>
				</iframe>
				<div class="well well-md" style="width: 100%;">
					<h4>Akademia C# - <i>Operatory logiczne</i></h4>
					<span>
						Materiał video przedstawia sposób zastosowania operatorów logicznych w C#.
					</span>
				</div>	
			</div>	
		</div>
	
<br /><br /><br />		

	</div>
</div>



<script>
    function DeleteUser(uId, cId)
    {
	    if (confirm('Czy na pewno chcesz usunąć danego użytkownika z kursu?'))
	    {
		    $.ajax({
		        url: "index.php?con=5&page=10",
		        data: { userId: uId, courseId: cId },
		        type: "POST",
		        success: function() {
			        location.reload(true);
		        }
	        });
	    }
    }
</script>
<script>
	function UpdateRole(uId, rId)
	{
		if (confirm('Czy na pewno chcesz zmienić role użytkownika?'))
	    {
		    $.ajax({
		        url: "index.php?con=5&page=16",
		        data: { userId: uId, role_id: rId },
		        type: "POST",
		        success: function() {
			        location.reload(true);
		        }
	        });
	    }
	}
</script>
<script>
	function ResetVARK(uId)
	{
		if (confirm('Czy na pewno chcesz zresetować VARK?'))
	    {
		    $.ajax({
		        url: "index.php?con=5&page=17",
		        data: { userId: uId },
		        type: "POST",
		        success: function() {
			        location.reload(true);
		        }
	        });
	    }
	}
</script>