<?php
namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('title');
        yield ImageField::new('image')
            ->setBasePath('/images/category')
            ->onlyOnIndex();
        yield TextField::new('file')
            ->setFormType(VichImageType::class)
            ->setLabel('Image')
            ->onlyOnForms();
        yield DateTimeField::new('updatedAt')->onlyOnIndex();
        yield AssociationField::new('dossier')->onlyOnForms();
    }
}
