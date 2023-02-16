<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class EquipmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Equipment::class;
    }

    public function configureFields(string $pageName): iterable
    {
      return [
        'name',
        'weight',
        'co2EqTonnage',
        'leakDetectionSystem',
        'controlFrequency',
        AssociationField::new('fluid')->renderAsNativeWidget(),
      ];
    }
}
