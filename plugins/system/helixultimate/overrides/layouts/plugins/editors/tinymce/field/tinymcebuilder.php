<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2025 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string  $autocomplete   Autocomplete attribute for the field.
 * @var   boolean $autofocus      Is autofocus enabled?
 * @var   string  $class          Classes for the input.
 * @var   string  $description    Description of the field.
 * @var   boolean $disabled       Is this field disabled?
 * @var   string  $group          Group the field belongs to. <fields> section in form XML.
 * @var   boolean $hidden         Is this field hidden in the form?
 * @var   string  $hint           Placeholder for the field.
 * @var   string  $id             DOM id of the field.
 * @var   string  $label          Label of the field.
 * @var   string  $labelclass     Classes to apply to the label.
 * @var   boolean $multiple       Does this field support multiple values?
 * @var   string  $name           Name of the input field.
 * @var   string  $onchange       Onchange attribute for the field.
 * @var   string  $onclick        Onclick attribute for the field.
 * @var   string  $pattern        Pattern (Reg Ex) of value of the form field.
 * @var   boolean $readonly       Is this field read only?
 * @var   boolean $repeat         Allows extensions to duplicate elements.
 * @var   boolean $required       Is this field required?
 * @var   integer $size           Size attribute of the input.
 * @var   boolean $spellcheck     Spellcheck state for the form field.
 * @var   string  $validate       Validation rules to apply.
 * @var   array   $value          Value of the field.
  *
 * @var   array   $menus           List of the menu items
 * @var   array   $menubarSource   Menu items for builder
 * @var   array   $buttons         List of the buttons
 * @var   array   $buttonsSource   Buttons by group, for the builder
 * @var   array   $toolbarPreset   Toolbar presset (default values)
 * @var   int     $setsAmount      Amount of sets
 * @var   array   $setsNames       List of Sets names
 * @var   JForm[] $setsForms       Form with extra options for an each set
 * @var   string   $languageFile   TinyMCE language file to translate the buttons
 *
 * @var   FileLayout  $this       Context
 */

HTMLHelper::_('behavior.core');

$helix_plg_url = Uri::root(true) . '/plugins/system/helixultimate';
Factory::getDocument()->addScript($helix_plg_url . '/assets/js/admin/jquery-ui.min.js');

HTMLHelper::_('stylesheet', 'media/vendor/tinymce/skins/lightgray/skin.min.css', array('version' => 'auto', 'relative' => false));
HTMLHelper::_('stylesheet', 'editors/tinymce/tinymce-builder.css', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'editors/tinymce/tinymce-builder.js', array('version' => 'auto', 'relative' => true));

if ($languageFile)
{
	HTMLHelper::_('script', $languageFile, array('version' => 'auto', 'relative' => false));
}

Factory::getDocument()->addScriptOptions('plg_editors_tinymce_builder',
	array(
		'menus'         => $menus,
		'buttons'       => $buttons,
		'toolbarPreset' => $toolbarPreset,
		'formControl'   => $name . '[toolbars]',
	)
);

?>
<div id="joomla-tinymce-builder">

	<p><?php echo Text::_('PLG_TINY_SET_SOURCE_PANEL_DESCRIPTION'); ?></p>

	<div class="mce-tinymce mce-container mce-panel">
		<div class="mce-container-body mce-stack-layout">

			<div class="mce-container mce-menubar mce-toolbar mce-stack-layout-item">
				<div class="mce-container-body mce-flow-layout timymce-builder-menu source" data-group="menu"
					data-value="<?php echo $this->escape(json_encode($menubarSource)); ?>">
				</div>
			</div>

			<div class="mce-toolbar-grp mce-container mce-panel mce-stack-layout-item">
				<div class="mce-container-body mce-flow-layout timymce-builder-toolbar source" data-group="toolbar"
					data-value="<?php echo $this->escape(json_encode($buttonsSource)); ?>">
				</div>
			</div>

		</div>
	</div>

	<hr>
	<p><?php echo Text::_('PLG_TINY_SET_TARGET_PANEL_DESCRIPTION'); ?></p>

	<?php // Render tabs for each set ?>
	<ul class="nav nav-tabs" id="set-tabs">
		<?php foreach ($setsNames as $num => $title) :
			$isActive = $num === $setsAmount - 1;
		?>
		<li class="nav-item">
			<a href="#set-<?php echo $num; ?>" class="nav-link <?php echo $isActive ? 'active' : ''; ?>">
				<?php echo $title; ?></a>
		</li>
		<?php endforeach; ?>
	</ul>

	<?php // Render tab content for each set ?>
	<div class="tab-content">
		<?php
		$presetButtonClases = array(
			'simple'   => 'btn-success',
			'medium'   => 'btn-info',
			'advanced' => 'btn-warning',
		);
		foreach ($setsNames as $num => $title) :

			// Check whether the values exists, and if empty then use from preset
			if (empty($value['toolbars'][$num]['menu'])
				&& empty($value['toolbars'][$num]['toolbar1'])
				&& empty($value['toolbars'][$num]['toolbar2']))
			{
				// Take the preset for default value
				switch ($num) {
					case 0:
						$preset = $toolbarPreset['advanced'];
						break;
					case 1:
						$preset = $toolbarPreset['medium'];
						break;
					default:
						$preset = $toolbarPreset['simple'];
				}

				$value['toolbars'][$num] = $preset;
			}

			// Take existing values
			$valMenu = empty($value['toolbars'][$num]['menu'])     ? array() : $value['toolbars'][$num]['menu'];
			$valBar1 = empty($value['toolbars'][$num]['toolbar1']) ? array() : $value['toolbars'][$num]['toolbar1'];
			$valBar2 = empty($value['toolbars'][$num]['toolbar2']) ? array() : $value['toolbars'][$num]['toolbar2'];
		?>
			<div class="tab-pane <?php echo $num === $setsAmount - 1 ? 'active' : ''; ?>" id="set-<?php echo $num; ?>">
				<div class="btn-toolbar float-end">
					<div class="btn-group btn-group-sm">

					<?php foreach(array_keys($toolbarPreset) as $presetName) :
						$btnClass = empty($presetButtonClases[$presetName]) ? 'btn-primary' : $presetButtonClases[$presetName];
						?>
						<button type="button" class="btn <?php echo $btnClass; ?> button-action"
							data-action="setPreset" data-preset="<?php echo $presetName; ?>" data-set="<?php echo $num; ?>">
							<?php echo Text::_('PLG_TINY_SET_PRESET_BUTTON_' . $presetName); ?>
						</button>
					<?php endforeach; ?>

						<button type="button" class="btn btn-danger button-action"
							 data-action="clearPane" data-set="<?php echo $num; ?>">
							<?php echo Text::_('JCLEAR'); ?></button>
					</div>
				</div>

				<div class="mce-tinymce mce-container mce-panel">
					<div class="mce-container-body mce-stack-layout">
						<div class="mce-container mce-menubar mce-toolbar timymce-builder-menu target"
							data-group="menu" data-set="<?php echo $num; ?>"
							data-value="<?php echo $this->escape(json_encode($valMenu)); ?>">
						</div>
						<div class="mce-toolbar-grp mce-container mce-panel timymce-builder-toolbar target"
						    data-group="toolbar1" data-set="<?php echo $num; ?>"
						    data-value="<?php echo $this->escape(json_encode($valBar1)); ?>">
						</div>
						<div class="mce-toolbar-grp mce-container mce-panel timymce-builder-toolbar target"
						    data-group="toolbar2" data-set="<?php echo $num; ?>"
						    data-value="<?php echo $this->escape(json_encode($valBar2)); ?>">
						</div>
					</div>
				</div>

				<?php // Render the form for extra options ?>
				<?php echo $this->sublayout('setoptions', array('form' => $setsForms[$num])); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
