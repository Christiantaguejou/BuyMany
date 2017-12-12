<?php

$pdo = new PDO('mysql:dbname=buymany; host=localhost', 'root', 'root');
//Pour afficher les exceptions
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//permet de recuperer les erreurs sous forme d'objets
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);