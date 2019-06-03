<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Input;

class Html extends AbstractHtml
{
    /**
     * @param ElementInterface $element
     * @param HtmlFormInterface|null $parent
     * @return HtmlFormInterface
     */
    public static function create(ElementInterface $element, HtmlFormInterface $parent=null): HtmlFormInterface
    {
        if ($element->getType() === ElementType::CHOICE_TYPE && $element instanceof ChoiceType) {
            return new HtmlChoices($element, $parent);
        }
        if ($element->isFormType() && $element instanceof FormType) {
            if ($element->isRepeatedForm()) {
                return new HtmlRepeatedForm($element, $parent);
            }
            return new HtmlForm($element, $parent);
        }
        if ($element->getType() === ElementType::TEXTAREA) {
            return new HtmlTextArea($element, $parent);
        }
        $self = new self($element, $parent);

        return $self;
    }

    /**
     * @return Input
     */
    public function form()
    {
        $type = $this->element->getType();
        $name = $this->fullName();
        $attributes = $this->element->getAttributes();
        if (is_string($this->value())) {
            $attributes['value'] = $this->value();
        }
        $form = Form::input($type, $name)->setAttributes($attributes);
        $form->required($this->element->isRequired());

        return $form;
    }
}