<?php

namespace App\Controller\Admin;

use App\Entity\Leakage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LeakageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Leakage::class;
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
