<?php
require_once '../vendor/autoload.php';

use mikehaertl\pdftk\Pdf;

$pdf = new Pdf();
$pdf->addFile('cerfa_15497-03_Saisie_numérique.pdf');
$pdf->fillForm([
  'Operateur' => 'Nicole Croisille'
])
  ->saveAs('test.pdf');
?>
