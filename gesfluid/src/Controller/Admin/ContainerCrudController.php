<?php

namespace App\Controller\Admin;

use App\Entity\Container;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ContainerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Container::class;
    }

    public function configureFields(string $pageName): iterable
    {
      return [
        'serialNumber',
        'capacity',
        AssociationField::new('fluid')->renderAsNativeWidget(),
        'fluidQuantity',
      ];
    }
}
