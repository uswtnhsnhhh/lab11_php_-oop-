<?php
// modules/user/Form.php - class library untuk form sederhana

class Form
{
    private $fields = [];
    private $action;
    private $submit = 'Submit Form';
    private $jumField = 0;

    public function __construct($action, $submit)
    {
        $this->action = $action;
        $this->submit = $submit;
    }

    public function addField($name, $label)
    {
        $this->fields[$this->jumField]['name']  = $name;
        $this->fields[$this->jumField]['label'] = $label;
        $this->jumField++;
    }

    public function displayForm()
    {
        echo "<form action='{$this->action}' method='POST' class='form-box'>";
        echo "<table class='form-table'>";
        for ($j = 0; $j < count($this->fields); $j++) {
            echo "<tr><td class='form-label'>".$this->fields[$j]['label'] ."</td>";
            echo "<td><input class='form-input' type='text' name='".$this->fields[$j]['name']."'></td></tr>";
        }
        echo "<tr><td colspan='2'>";
        echo "<button type='submit' class='btn btn-primary'>".$this->submit."</button></td></tr>";
        echo "</table>";
        echo "</form>";
    }
}
