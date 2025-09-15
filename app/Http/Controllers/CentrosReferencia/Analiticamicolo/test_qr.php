<?php

include_once dirname(__FILE__)."/phpqrcode/qrlib.php";

// --- url
$url = "https://es.wikipedia.org";
$codigo = $url;

$email="sandritascs@gmail.com";
$subject="Test qr";
$body = "Comprobacion del test qr";

QRcode::png($codigo,"temp/01.png",QR_ECLEVEL_L,3,1);

echo '<img src="temp/01.png"/>';

?>