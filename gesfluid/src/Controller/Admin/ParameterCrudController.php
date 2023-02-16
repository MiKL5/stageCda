<?php

namespace App\Controller\Admin;

use App\Entity\Parameter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ParameterCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Parameter::class;
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      'parameter',
      TextareaField::new('value')->renderAsHtml(),
    ];
  }
}

?>
