<?php
namespace Reportico\Widgets;

/*

 * Core
 *
 e Widget representing the Reportico instance
 * Serves up core Reportico css and js files
 *
 * @link http://www.reportico.co.uk/
 * @copyright 2010-2014 Peter Deed
 * @author Peter Deed <info@reportico.org>
 * @package Reportico
 * @version $Id: reportico.php,v 1.68 2014/05/17 15:12:31 peter Exp $
 */
use \Reportico\Engine\ReporticoLocale;
use \Reportico\Engine\ReporticoApp;
use \Reportico\Engine\ReporticoLang;

class CriteriaListSelect2Multi extends CriteriaList
{
    public $value = false;
    public $expanded = false;
    public $lastgroup = false;
    public $group = false;

    public function __construct($engine, $criteria = false, $expanded = false)
    {
        $this->criteria = $criteria;
        $this->expanded = $expanded;

        parent::__construct($engine, $criteria, $expanded);
    }

    public function getConfig() {

        $init = [ ];
        $runtime = [ ];

        return
            [
                'name' => 'criteria-list-select2-multi',
                'order' => 200,
                'files' => [
                    'css' => [],
                    'js' => [],
                    'events' => [
                        'init' => $init,
                        'runtime' => $runtime
                    ]
                ]
            ];
    }

    public function renderWidgetStart()
    {
        $res = &$this->criteria->list_values;
        $k = key($res);
        $multisize = 4;
        if ($res && count($res[$k]) > 4) {
            $multisize = count($res[$k]);
        }

        if (isset($res[$k])) {
            if (count($res[$k]) >= 10) {
                $multisize = 10;
            }
        }

        $criteriaName = preg_replace("/ /", " ", $this->criteria->query_name);
        $tag = "select2_dropdown_static_" . $criteriaName;
        if ( $this->expanded) {
            $tag .= "_expanded";
        }

        $tag_pref = $this->expanded ? "EXPANDED_" : "MANUAL_";
        $text = '<SELECT id="'.$tag.'" class="' . $this->criteria->parent_reportico->getBootstrapStyle('design_dropdown') . 'reportico-prepare-drop-select2 reportico-prepare-select2-static" name="' . $tag_pref . $this->criteria->query_name . '[]" size="' . $multisize . '" >';
        $text .= '<OPTION></OPTION>';
        return $text;
    }

    public function renderWidgetItem($label, $value, $selected )
    {

        $text = "";
        $this->lastgroup = false;
        $this->group = false;
        $criteriaName = preg_replace("/ /", " ", $this->criteria->query_name);

        $selectedFlag = $selected ? "selected" : "";
        $name = $this->expanded ? "EXPANDED_" . $criteriaName : $criteriaName;

        if ( $lab == "GROUP" )
            $group = $ret;
        if ( $group != $this->lastgroup )
        {
            if ( $this->lastgroup )
                $text .= "</OPTGROUP>";
            $text .= '<OPTGROUP LABEL="'.$ret.'">';
            $this->lastgroup = $group;
        }
        else
        {
            $text .= '<OPTION label="'.$lab.'" value="'.$ret.'" '.$checked.'>'.$lab.'</OPTION>';
        }



        return '<OPTION label="' . $label . '" value="' . $value . '" ' . $selectedFlag . '>' . $label . '</OPTION>';
    }


    public function renderWidgetEnd()
    {
        $text = "";
        if ( $this->lastgroup )
                $text .= "</OPTGROUP>";
        $text .=  "</SELECT>";
        return $text;
    }

}
// -----------------------------------------------------------------------------
