<?php
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('username')
            ->setFormTypeOption('disabled', $pageName === Crud::PAGE_EDIT);
        yield TextField::new('name');
        yield EmailField::new('email');
        yield BooleanField::new('enabled');
        yield TextField::new('plainPassword')
            ->setLabel($pageName === Crud::PAGE_EDIT ? 'Edit password (optional)' : 'Password')
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->onlyOnForms();
        yield ChoiceField::new('roles')
            ->setChoices([
                'ROLE_COMMENTATOR' => User::ROLE_COMMENTATOR,
                'ROLE_WRITER' => User::ROLE_WRITER,
                'ROLE_EDITOR' => User::ROLE_EDITOR,
                'ROLE_ADMIN' => User::ROLE_ADMIN,
            ])
            ->allowMultipleChoices()
            ->onlyOnForms();
        yield ArrayField::new('roles')->onlyOnIndex();
        yield AssociationField::new('dossiers')->onlyOnDetail();
    }
}
