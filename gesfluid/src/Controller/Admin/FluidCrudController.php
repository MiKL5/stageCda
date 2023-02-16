<?php

namespace App\Controller\Admin;

use App\Entity\Fluid;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class FluidCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fluid::class;
    }

    public function configureFields(string $pageName): iterable
    {
      return [
        'name',
        AssociationField::new('fluidType')->renderAsNativeWidget(),
      ];
    }
}
