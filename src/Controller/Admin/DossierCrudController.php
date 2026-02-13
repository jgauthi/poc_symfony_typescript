<?php
namespace App\Controller\Admin;

use App\Entity\Dossier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DossierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dossier::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield AssociationField::new('author');
        yield TextareaField::new('content');
        yield BooleanField::new('active');
        yield AssociationField::new('categories');
        yield AssociationField::new('client');
    }
}
