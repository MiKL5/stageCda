<?php

namespace App\Controller\Admin;

use App\Entity\FluidType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FluidTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FluidType::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
