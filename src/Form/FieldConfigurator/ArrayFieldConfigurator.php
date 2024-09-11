<?php

declare(strict_types=1);

namespace App\Form\FieldConfigurator;

use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\Configurator\ArrayConfigurator;


class ArrayFieldConfigurator implements FieldConfiguratorInterface
{
    public function __construct(
        private ArrayConfigurator $arrayConfigurator,
    ) {}

    public function supports(FieldDto $field, EntityDto $entityDto): bool
    {
        return $this->arrayConfigurator->supports($field, $entityDto);
    }

    public function configure(FieldDto $field, EntityDto $entityDto, AdminContext $context): void
    {
        $entryType = $field->getFormTypeOption('entry_type');

        $this->arrayConfigurator->configure($field, $entityDto, $context);

        if (is_string($entryType)) {
            $field->setFormTypeOptionIfNotSet('entry_type', $entryType);
        }
    }
}
