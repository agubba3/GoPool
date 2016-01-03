<?php
$base = true;
//session_start();
$db = new PDO('mysql:host=gopool.cklcxx7fvgfc.us-west-2.rds.amazonaws.com;dbname=gopooldb', 'gopool_master', 'saltyswoleman18');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);