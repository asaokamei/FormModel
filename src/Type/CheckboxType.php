<?php
declare(strict_types=1);

namespace WScore\FormModel\Type;

use WScore\FormModel\Element\Button;
use WScore\FormModel\FormBuilder;
use WScore\Validator\ValidatorBuilder;

class CheckboxType extends Button implements TypeInterface
{
    public function __construct(ValidatorBuilder $builder, string $name, string $label = '')
    {
        parent::__construct($builder, 'checkbox', $name, $label);
    }

    /**
     * @param FormBuilder $builder
     * @param string $name
     * @param array $options
     * @return TypeInterface|CheckboxType
     */
    public static function forge(FormBuilder $builder, string $name, array $options): TypeInterface
    {
        $type = new self($builder->getValidationBuilder(), $name);
        $builder->apply($type, $options);
        $type->setToString($builder->getToString());

        return $type;
    }
}