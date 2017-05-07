<?php
    class ExceptionDictionary
    {
        const REGISTER_DB_FAILED = "Wystąpił błąd bazy danych podczas rejestracji.";
        const LOGIN_DB_NOT_FOUND = "Nie ma konta o podanym email!";
        const LOGIN_DB_FAILED = "Nieprawidłowa nazwa użytkownika lub hasło!";
        const ADD_COURSE_FAILED = "Tytuł lub opis kursu pozostał pusty!";
        const DB_FAILED = "Wystąpił błąd bazy danych";

        const PAGE_404 = "Views/Errors/404.php";
        const PAGE_403 = "Views/Errors/403.php";
    }
?>