<?php
namespace App\Services\EventSubscriber;

use App\Entity\Intervention;
use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Leakage;
use App\Repository\InterventionRepository;
use App\Repository\ParameterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use mikehaertl\pdftk\Pdf;

class FormSubmitSubscriberService implements EventSubscriberInterface
{

  private $fields = [
    1 => 'Case_Assemblage',
    2 => 'Case_MiseService',
    3 => 'Case_Modif',
    4 => 'Case_Maintenance',
    5 => 'Case_CtrlPerio',
    6 => 'Case_CtrlNonPerio',
    7 => 'Case_Demantel',
    8 => 'Case_Autre',
  ];

  private $interventionRepository;

  public function __construct(InterventionRepository $interventionRepository, ParameterRepository $parameterRepository)
  {
    $this->interventionRepository = $interventionRepository;
    $this->parameterRepository = $parameterRepository;
  }

  public static function getSubscribedEvents()
  {
    return [
      KernelEvents::VIEW => ['onPost', EventPriorities::POST_WRITE],
    ];
  }

  public function onPost(ViewEvent $event): void
  {
    $entity = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();

    if ($entity instanceof Leakage && Request::METHOD_POST === $method) {
      $this->onLeakPost($event);
      return;
    }

    if (!$entity instanceof Intervention || Request::METHOD_POST !== $method) {
      return;
    }

    $intervention = $entity;

    // Intervention date
    $pdfDate = $intervention->getDate()->format('Ymd');
    $date = $intervention->getDate()->format('d/m/Y');

    // Owner
    $ownerName = $this->parameterRepository->getValue('detenteur');
    $certificateNumber = $this->parameterRepository->getValue('attestation');

    // User
    $user = $intervention->getUser();
    $userId = $user->getUserId();
    $userName = $user->getFirstName() . ' ' . $user->getLastName();

    // PDF filename
    $filename = $pdfDate . '_' . $userId . '-' . $intervention->getId() . '.pdf';

    // Equipment
    $equipment = $intervention->getEquipment();

    // Intervention type
    $type = $intervention->getInterventionType();

    // Manual leak detector and leak detection system
    $detector = $intervention->getAccessory();
    if ($detector) {
      $detectorName = $detector->getName();
      $detectorCtrlD = $detector->getControlDate()->format('d');
      $detectorCtrlM = $detector->getControlDate()->format('m');
      $detectorCtrlY = $detector->getControlDate()->format('Y');
    } else {
      $detectorName = '';
      $detectorCtrlD = '';
      $detectorCtrlM = '';
      $detectorCtrlY = '';
    }

    // Control frequency
    $leakDetectionSystem = '';
    $controlFrequency = '';
    $fluidQuantity = '';
    $leakFound = '';

    $control = ($type->getId() === 5 || $type->getId() === 6);
    $mandatoryControl = !$control;

    if ($control || $mandatoryControl) {
      $leakDetectionSystem = ($equipment->getLeakDetectionSystem()) ? 1 : 2;
      $equipmentFluidQuantity = $equipment->getWeight();
      if ($equipmentFluidQuantity <= 2 || $equipmentFluidQuantity < 30) {
        $fluidQuantity = 'Case_HCFC_2';
      } elseif ($equipmentFluidQuantity <= 30 || $equipmentFluidQuantity < 300) {
        $fluidQuantity = 'Case_HCFC_30';
      } else {
        $fluidQuantity = 'Case_HCFC_300';
      }
      $leakFound = 'Case_Fuite_Non';
      $frequency = $equipment->getControlFrequency();
      if ($leakDetectionSystem === 1) {
        switch ($frequency) {
          case 24:
            $controlFrequency = 'Case_Avec_24m';
            break;
          case 12:
            $controlFrequency = 'Case_Avec_12m';
            break;
          case 6:
            $controlFrequency = 'Case_Avec_6m';
            break;
        }
      } else {
        switch ($frequency) {
          case 12:
            $controlFrequency = 'Case_Sans_12m';
            break;
          case 6:
            $controlFrequency = 'Case_Sans_6m';
            break;
          case 3:
            $controlFrequency = 'Case_Sans_3m';
            break;
        }
      }
    }

    // Fluid quantities
    $A = $intervention->getVirginFluidQuantity();
    $B = $intervention->getRecycledFluidQuantity();
    $C = $intervention->getRegeneratedFluidQuantity();

    $ABC = $A + $B + $C;

    $D = $intervention->getForProcessingFluidQuantity();
    $E = $intervention->getReusableFluidQuantity();

    $BSFF = $intervention->getBsffNumber();

    $DE = $D + $E;

    // Container
    $container = $intervention->getContainer();
    $containerSerialNumber = ($container) ? ($container->getSerialNumber()) : '';

    // Type de déchets
    $fluid = $equipment->getFluid();
    $waste = ($D) ? ($fluid->getFluidType()->getId()) : '';

    switch ($waste) {
      case 1:
        $adrRid = 'Case_12_UN1078';
        break;
      case 2:
        $adrRid = 'Case_12_Autre140601';
        break;
      case 3:
        $adrRid = 'Case_12_UN3161';
        break;
      case 4:
        $adrRid = 'Case_12_Autre160504';
        break;
      default:
        $adrRid = '';
        break;
    }

    $pdf = new Pdf('template.pdf', [
      'command' => 'bin/pdftk',
      'useExec' => true,
    ]);

    $result = $pdf->fillForm([
      'Operateur' => $userName,
      'Detenteur' => $ownerName,
      'Attestation_no' => $certificateNumber,

      // Equipement
      'Equipement_ID' => $equipment->getName(),
      'Equipement_Fluide' => $equipment->getFluid()->getName(),
      'Equipement_Charge' => $equipment->getWeight(),
      'Equipement_teqCO2' => $equipment->getCo2EqTonnage(),

      // Nature de l'intervention
      $this->fields[$type->getId()] => 'Yes',
      $this->fields[6] => $mandatoryControl ? 'Yes' : 'No',
      'Autre' => $intervention->getOtherInterventionType(),

      // Détecteur et système permanent de détection de fuites
      'Detecteur_ID'   => $detectorName,
      'Controle_Jour'  => $detectorCtrlD,
      'Controle_Mois'  => $detectorCtrlM,
      'Controle_Annee' => $detectorCtrlY,

      'Bouton_Oui' => $leakDetectionSystem,

      // Fréquence minimale du contrôle périodique
      $fluidQuantity => 'Yes',
      $controlFrequency => 'Yes',

      // Quantités de fluide
      '11_Quantite' => ($ABC > 0) ? ($ABC) : '',
      '11_QA' => ($ABC > 0) ? ($A) : '',
      '11_QB' => ($ABC > 0) ? ($B) : '',
      '11_QC' => ($ABC > 0) ? ($C) : '',

      '11_QDE' => ($DE > 0) ? ($DE) : '',
      '11_QD' => ($DE > 0) ? ($D) : '',
      '11_BSFF' => $BSFF,
      '11_QE' => ($DE > 0) ? ($E) : '',

      // Fuites
      $leakFound => 'Yes',

      // Contenant
      '11_Contenant_ID' => $containerSerialNumber,

      // Déchets
      $adrRid => 'Yes',

      // Installation prévue de destination du fluide récupéré
      '13_Instal' => $intervention->getCollectedFluidDestination(),

      // Observations
      '14_Observations' => $intervention->getRemarks(),

      // Date et signatures
      'Sign_Operateur_Nom' => $userName,
      'Sign_Operateur_Qualite' => 'Stagiaire',
      'Sign_Operateur_Date' => $date,
      'Sign_Detenteur_Date' => $date,

    ]);

    if ($intervention->getLeaks()) {
      $result = $pdf->saveAs('interventions/' . $filename);
    } else {
      $result = $pdf->flatten()->saveAs('interventions/' . $filename);
    }
    
    if ($result === false) {
      $error = $pdf->getError();
      dd($error);
    }

    // Save PDF path
    $intervention->setPdfPath('interventions/' . $filename);
    $this->interventionRepository->save($intervention, true);
  }

  public function onLeakPost(ViewEvent $event)
  {
    $leak = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();

    if (!$leak instanceof Leakage || Request::METHOD_POST !== $method) {
      return;
    }

    $intervention = $leak->getIntervention();
    $pdfPath = $intervention->getPdfPath();
    $leakNum = $leak->getNum();
    $leakCount = $leak->getCount();

    $leakLocationField = 'Fuite_Loca_' . $leakNum;
    $leakLocation = $leak->getLocation();
    $leakFixedField = 'Case_Rep_Fuite' . $leakNum . '_realisee';
    $leakFixed = $leak->getFixed();
    $leakToDoField = 'Case_Rep_Fuite' . $leakNum . '_AFaire';
    $leakToDo = !$leak->getFixed();

    $pdf = new Pdf($pdfPath, [
      'command' => 'bin/pdftk',
      'useExec' => true,
    ]);

    $result = $pdf->fillForm([
      'Case_Fuite_Oui' => 'Yes',
      'Case_Fuite_Non' => 'No',
      $leakLocationField => $leakLocation,
      $leakFixedField => ($leakFixed) ? 'Yes' : 'No',
      $leakToDoField => ($leakToDo) ? 'Yes' : 'No',
    ]);

    if ($leakNum === $leakCount)
      $result = $pdf->flatten()->saveAs($pdfPath);
    else
      $result = $pdf->saveAs($pdfPath);

    if ($result === false) {
      $error = $pdf->getError();
      dd($error);
    }
  }
}

?>