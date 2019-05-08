<?php
namespace WScore\FormModel\Validation;

use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ResultInterface;
use WScore\Validation\Interfaces\ValidationInterface;
use WScore\Validation\ValidatorBuilder;

class Validator
{
    private $builder;
    /**
     * @var ValidationInterface
     */
    private $validation;

    public function __construct(ValidatorBuilder $builder)
    {
        $this->builder = $builder;
    }

    public static function create(ValidatorBuilder $builder, ElementInterface $element): Validator
    {
        $self = new self($builder);
        $self->validation = $self->build($element);

        return $self;
    }

    private function build(ElementInterface $element): ValidationInterface
    {
        if ($element->isFormType() && $element instanceof FormElementInterface) {
            return $this->buildForm($element);
        }
        $filters = $element instanceof ElementInterface
            ? $element->getFilters()
            : [];
        $filters['type'] = $element->getType();
        $filters['multiple'] = $element->isMultiple();
        if ($element->isRequired()) {
            $filters[Required::class] = [];
        }
        $validation = $this->builder->chain($filters);
        return $validation;
    }

    private function buildForm(FormElementInterface $element): ValidationInterface
    {
        $validation = $this->builder->form();
        foreach ($element->getChildren() as $child) {
            if ($child->isRepeatedForm()) {
                $validation->addRepeatedForm($child->getName(), $this->build($child));
            } else {
                $validation->add($child->getName(), $this->build($child));
            }
        }
        return $validation;
    }

    public function verify($inputs): ResultInterface
    {
        return $this->validation->verify($inputs);
    }

    public function getValidation(): ValidationInterface
    {
        return $this->validation;
    }
}