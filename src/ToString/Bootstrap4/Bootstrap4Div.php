<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString\Bootstrap4;

use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\ToString\ToStringInterface;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;
use WScore\Validation\Interfaces\ResultInterface;

class Bootstrap4Div implements ToStringInterface
{
    /**
     * @var HtmlFormInterface
     */
    private $html;

    /**
     * @var ElementInterface
     */
    private $element;

    /**
     * @var Choices|Input|Tag
     */
    private $form;

    /**
     * @var null|ResultInterface
     */
    private $result;

    /**
     * Bootstrap4Div constructor.
     * @param HtmlFormInterface $html
     * @param ResultInterface $result
     */
    public function __construct($html, $result)
    {
        $this->html = $html;
        $this->element = $html->getElement();
        $this->form = $html->form();
        $this->result = $result;
    }

    /**
     * @param HtmlFormInterface $html
     * @param ResultInterface|null $result
     * @return Bootstrap4Div|ToStringInterface
     */
    public function create(HtmlFormInterface $html, ResultInterface $result = null): ToStringInterface
    {
        $self = clone($this);
        $self->html = $html;
        $self->element = $html->getElement();
        $self->form = $html->form();
        $self->result = $result;

        return $self;
    }

    public function row(): string
    {
        return '';
    }

    public function label(): string
    {
        return Tag::create('h2')
            ->setContents($this->html->label())
            ->toString();
    }

    public function widget(): string
    {
        return '';
    }

    private function getError(): string
    {
        if (!$this->result) return '';
        if ($this->result->isValid()) {
            return '';
        }
        return implode("\n", $this->result->getErrorMessage());
    }

    public function error(): string
    {
        $error = $this->getError();
        if (!$error) return '';
        $error = "<div class='invalid-feedback d-block'>{$error}</div>";
        return $error;
    }
}