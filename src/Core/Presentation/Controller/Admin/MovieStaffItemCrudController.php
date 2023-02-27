<?php

namespace App\Core\Presentation\Controller\Admin;

use App\Core\Persistence\Entity\MovieStaff;
use App\Core\Presentation\Entity\Enum\EntityStaffTypeEnum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieStaffItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MovieStaff::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('type', 'Тип')
            ->setRequired(true)
            ->autocomplete()
            ->setChoices($this->getTypes())
            ->setColumns(12);
        yield TextField::new('title', 'Имя (через запятую)')
            ->setRequired(true)
            ->setColumns(12);
    }

    private function getTypes(): array
    {
        $types = EntityStaffTypeEnum::cases();

        $result = [];
        foreach ($types as $type) {
            $result[$type->getTitle()] = $type->value;
        }

        return $result;
    }
}
