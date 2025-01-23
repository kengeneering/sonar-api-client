<?php

namespace Kengineering\Sonar\Graphql;

class Query
{
    private string $fieldName = '';

    protected ?string $alias = null;

    /** @var (string|Query)[] */
    private $fields = [];

    /** @var self[] */
    private $subqueries = [];

    /** @var array<array<mixed|string>> */
    public $variables = [];

    /**
     * @param  array<string|Query>  $fields
     */
    public function __construct(string $fieldName, array $fields, ?string $alias = null)
    {
        $this->fieldName = $fieldName;
        $this->alias = $alias;
        foreach ($fields as $field) {
            if (is_object($field) && get_class($field) === get_class($this)) {
                $this->subqueries[] = $field;
            } else {
                $this->fields[] = $field;
            }
        }
    }

    public function build(): Query
    {
        return $this;
    }

    public function __toString()
    {
        $variables = '';
        $fields = implode(' ', array: $this->fields);
        foreach ($this->subqueries as $subquery) {
            $fields .= ' '.(string) $subquery;
        }
        foreach ($this->variables as $name => $variable) {
            $variables .= $name.': '.'$'.$variable['name'].' ';
        }
        if ($variables) {
            $variables = '('.$variables.')';
        }

        return (isset($this->alias) ? $this->alias.': ' : '').$this->fieldName.$variables.' {'.$fields.'}';
    }

    /**
     * @return array<array<mixed|string>>
     * */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @param  array<array<mixed|string>|mixed>  $data  // If it can contain any type
     */
    public function addVariable(array $data, string $type, bool $required = false): self
    {
        foreach ($data as $name => $value) {
            $this->variables[$name] = [
                'data' => $value,
                'name' => str_shuffle('abcdefghijklmnopqrstuvwxyz'),
                'type' => $type,
                'required' => $required,
            ];
        }

        return $this;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    //######
    //
    //
    // maybe a function to add subqueries after creation?
    // not sure when this would be used unless used raw for other api clients.
    //
    //
}
