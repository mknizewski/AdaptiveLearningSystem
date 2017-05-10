<?php 
    include_once 'Enviroment/Session.php';
    include_once 'Enviroment/User.php';
    include_once 'Dictionaries/UserRolesDictionary.php';

    $session = Session::getInstance();
    $user = unserialize($session -> __get("user"));

    echo "<h2> Ankieta adaptacyjna - " . $user -> Name . " " . $user -> Surname . "</h2>";
?>
<hr />
<div class="alert alert-info">
    Przed zaczęciem kursu prosimy o wypełnienie krótkiej ankiety. Pozwoli to sytemowi spersonalizować kurs specjalnie pod Ciebie.
</div>
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
  

  <div class="col-sm-6">
    <div class="panel panel-info">
        <div class="panel-heading">Ankieta adaptacyjna</div>
        <div class="panel-body">
             <form method="POST" action="index.php?con=4&page=4">
                <div>
                    <div class="form-group">
                        <b>Gdy spotykasz nieznaną ci osobę, na co zwracasz uwagę w pierwszej kolejności?</b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p0v"> Jak wygląda i jak jest ubrana. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p0a"> W jaki sposób i co mówi, jaki ma głos. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p0r"> Co w stosunku do niej czujesz. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p0k"> W jaki sposób się zachowuje i co robi.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Co najczęściej zostaje ci w pamięci po kilku dniach od spotkania nieznanej ci wcześniej osoby? </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p1v"> Jej twarz. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p1a"> Jej imię/nazwisko. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p1r"> To, co czułeś, będąc w jej towarzystwie, nawet jeśli zapomniałeś jej imię/nazwisko lub twarz. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p1k"> To, co robiliście razem, nawet jeśli zapomniałeś jej imienia/nazwiska lub twarzy.</label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Gdy wchodzisz do nieznanego ci pomieszczenia, na co zwracasz przede wszystkim uwagę? </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p2v"> Na jego wygląd. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p2a"> Na dźwięki i rozmowy, jakie się w nim toczą. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p2r"> Na to, jak dobrze emocjonalnie i fizycznie się w nim czujesz. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p2k"> Na to, co się w nim dzieje i co ty mógłbyś w nim robić. </label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Gdy uczysz się czegoś nowego, w jaki sposób robisz to najchętniej? </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p3v"> Gdy nauczyciel daje ci coś do czytania na papierze lub tablicy, pokazuje ci książki, ilustracje, wykresy, mapy, szkice lub przedmioty, nie każąc ci przy tym niczego mówić, pisać, ani o niczym dyskutować. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p3a"> Gdy nauczyciel wyjaśnia wszystko, mówiąc lub wygłaszając wykład, pozwala ci przedyskutować temat i zadawać pytania, nie każąc ci przy tym na nic patrzeć, niczego czytać, pisać ani robić. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p3r"> Gdy nauczyciel pozwala ci zapisywać informacje lub sporządzać rysunki, dotykać przedmiotów, pisać na klawiaturze lub robić coś rękami. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p3k"> Gdy nauczyciel pozwala ci robić projekty, symulacje, eksperymenty, grać w gry, odgrywać role, odtwarzać rzeczywiste sytuacje z życia, dokonywać odkryć lub też angażować się winne działania związane z ruchem. </label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Gdy uczysz czegoś innych, co zwykle robisz? </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p4v"> Dajesz im coś do oglądania, na przykład jakiś przedmiot, ilustrację lub wykres, udzielając przy tym jedynie krótkiego werbalnego wyjaśnienia lub nie udzielając go wcale, dopuszczając lub nie do krótkiej dyskusji. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p4a"> Objaśniasz wszystko werbalnie, nie pokazując Żadnych materiałów graficznych. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p4r"> Rysujesz coś, piszesz lub winny sposób używasz rąkdo wyjaśniania. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p4k"> Demonstrujesz coś, robiąc to lub każesz uczniom robić to wspólnie z tobą. </label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Jaki rodzaj książek czytasz najchętniej? </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p5v"> Książki, które zawierają opisy pomagające ci zobaczyć to, co się dzieje. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p5a"> Książki zawierające informacje faktograficzne, historyczne lub dużo dialogów. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p5r"> Książki o uczuciach i emocjach bohaterów, poradniki, książki o emocjach i związkach międzyludzkich lub książki na temat tego, jak poprawić stan twojego ciała i umysłu. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p5k"> Krótkie książki z wartką akcją lub książki, które pomagają ci doskonalić umiejętności w sporcie, hobby czy też rozwijać jakiś talent. </label>
                    </div>
                </div>
                <br />
                <div>
                    <div class="form-group">
                        <b>Którą z poniższych czynności wykonujesz najchętniej w czasie wolnym? </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p6v"> Czytasz książkę lub przeglądasz czasopismo.</label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p6a"> Słuchasz książki nagranej na kasetę, rozmowy w radiu, słuchasz muzyki lub sam muzykujesz. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p6r"> Piszesz, rysujesz, piszesz na maszynie/komputerze lub robisz coś rękami. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p6k"> Uprawiasz sport, budujesz coś lub grasz w grę wymagającą ruchu. </label>
                    </div>
                </div>
				<br />
				<div>
                    <div class="form-group">
                        <b>Co wywołuje u ciebie największy niepokój? </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p7v"> Miejsce, w którym panuje bałagan i nieład. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p7a"> Miejsce, w którym jest za cicho. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p7r"> Miejsce, w którym nie czujesz się dobrze fizycznie lub emocjonalnie.  </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p7k"> Miejsce, w którym nie wolno niczego robić lub jest za mało przestrzeni na ruch.</label>
                    </div>
                </div>
				<br />
				<div>
                    <div class="form-group">
                        <b>Gdybyś miał zapamiętać nowe słowo, zrobiłbyś to najlepiej: </b>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p8v"> Widząc je. </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p8a"> Słysząc je. </label>
                    </div>
					 <div class="checkbox">
                        <label><input type="checkbox" name="p8r"> Zapisując je.  </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="p8k"> Odtwarzając to słowo w umyśle lub fizycznie.</label>
                    </div>
                </div>
				
                <button type="submit" class="btn btn-default" style="float: right;">Zatwierdź</button>
            </form>
        </div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="panel panel-primary">
        <div class="panel-heading">Wyszukiwarka</div>
        <div class="panel-body">
            <form class="form-inline" method="POST" action="">
                <div class="form-group">
                    <input type="text" placeholder="Wpisz szukaną frazę" name"search" class="form-control" />
                </div>
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </div>
    </div>
  </div>
</div>