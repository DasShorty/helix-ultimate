<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2025 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

use HelixUltimate\Framework\Platform\Helper;

defined ('JPATH_BASE') or die();

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 * @var   array    $inputType       Options available for this field.
 * @var   string   $accept          File types that are accepted.
 */

// Initialize some field attributes.
$attributes = array(
	$class ? 'class="form-control ' . $class . '"' : 'class="form-control"',
	$disabled ? 'disabled' : '',
	$readonly ? 'readonly' : '',
	!empty($onchange) ? 'onchange="' . $onchange . '"' : '',
	!empty($max) ? 'max="' . $max . '"' : '',
	!empty($step) ? 'step="' . $step . '"' : '',
	!empty($min) ? 'min="' . $min . '"' : '',
	$autofocus ? 'autofocus' : '',
);

$value = (float) $value;
$value = empty($value) ? $min : $value;

?>
<input
	type="range"
	name="<?php echo $name; ?>"
	id="<?php echo $id; ?>"
	value="<?php echo htmlspecialchars(Helper::CheckNull($value), ENT_COMPAT, 'UTF-8'); ?>"
	<?php echo implode(' ', $attributes); ?>>
