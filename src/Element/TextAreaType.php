<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Html\HtmlTextArea;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ValidationInterface;

final class TextAreaType extends AbstractElement
{
    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = new HtmlTextArea($this);
        $html->setInputs($inputs);
        return $html;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        $filters = $this->prepareFilters('text');
        if ($this->isRequired()) {
            $filters[Required::class] = [];
        }
        $validation = $this->validationBuilder->chain($filters);
        return $validation;
    }
}