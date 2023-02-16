<?php

namespace App\Controller\Admin;

use App\Entity\InterventionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class InterventionTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InterventionType::class;
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
