<?php
namespace WScore\FormModel\Html;

use WScore\FormModel\Element\ChoiceType;
use WScore\Html\Form;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;

class HtmlChoices extends AbstractHtml
{
    /**
     * @var ChoiceType
     */
    private $element;

    public function __construct(ChoiceType $element)
    {
        $this->element = $element;
    }

    /**
     * @return Choices
     */
    public function form()
    {
        $name = $this->element->getFullName();
        $form = Form::choices($name, $this->element->getChoices())
            ->setAttributes($this->element->getAttributes());
        $form->required($this->element->isRequired());
        $form->expand($this->element->isExpand());
        $form->multiple($this->element->isMultiple());
        return $form;
    }

    /**
     * @return Input[]
     */
    public function choices()
    {
        $form = $this->form();
        return $form->getChoices();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}