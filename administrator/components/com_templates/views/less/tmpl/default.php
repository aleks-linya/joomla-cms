<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');
JHtml::_('formbehavior.chosen', 'select');

$canDo = TemplatesHelper::getActions();
$input = JFactory::getApplication()->input;

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root(true) . '/media/jui/css/jquery.minicolors.css');
$document->addScript(JURI::root(true) . '/media/jui/js/jquery.minicolors.min.js');


$script = array();
$script[] = "	jQuery(document).ready(function (){";
$script[] = "		jQuery('.minicolors').each(function() {";
$script[] = "			jQuery(this).minicolors({";
$script[] = "				control: jQuery(this).attr('data-control') || 'hue',";
$script[] = "				position: jQuery(this).attr('data-position') || 'right',";
$script[] = "				theme: 'bootstrap'";
$script[] = "			});";
$script[] = "		});";
$script[] = "	});";

// Add the script to the document head.
$document->addScriptDeclaration(implode("\n", $script));
?>

<form action="<?php echo JRoute::_('index.php?option=com_templates&view=less'); ?>" method="post" name="adminForm" id="adminForm">
		<fieldset id="template-manager">
			<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'less')); ?>

				<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'less', JText::_('COM_TEMPLATES_LESS', true)); ?>
				<?php echo JHtml::_('bootstrap.startAccordion', 'templatestyleLess', array('active' => 'valCollapse0'));
						$i = 0; ?>
					<?php
					$file = file(JPATH_ADMINISTRATOR . '/templates/isis/less/variables.less');

					for ($i = 0; $i < count($file); $i++)
					{
						if (preg_match('/^\/\/ ([A-Z0-9-\s]+)$/i', $file[$i], $match))
						{
							if (preg_match('/^\/\/\ [^A-Z0-9]+$/i', $file[$i + 1]))
							{
								$header = '';
								$printHeader = true;

								if ($i > 0)
								{
									$header .= JHtml::_('bootstrap.endSlide');
								}
								$header .= JHtml::_('bootstrap.addSlide', 'templatestyleLess', JText::_($match[1]), 'valCollapse' . ($i++));
							}
						}
						elseif (substr($file[$i], 0, 1) == '@')
						{
							preg_match('/@([A-Z]+):/i', $file[$i], $match);
							preg_match('/:\s*(.+)\s*;/i', $file[$i], $placeholder);

							if (isset($match[1]) && isset($placeholder[1]) && $placeholder[1] !== '')
							{
								if ($printHeader)
								{
									echo $header;
									$printHeader = false;
								}

								if (substr($placeholder[1], 0, 1) == '#')
								{
									echo "<div class=\"control-group\">
											<div class=\"control-label\">
												<label id=\"jform_title-lbl\" for=\"jform_title\" class=\"hasTip\" title=\"\" aria-invalid=\"false\">@" . $match[1] . "</label>
											</div>
											<input type=\"text\" name=\"jform[" . $match[1] . "]\" id=\"jform_color2\" value=\"" . $placeholder[1] . "\" class=\"minicolors minicolors-input\" data-position=\"right\" size=\"7\">
											</div>";
								}
								else
								{
									echo "<div class=\"control-group\">";
									echo "<div class=\"control-label\">
							<label id=\"jform_title-lbl\" for=\"jform_title\" class=\"hasTip\" title=\"\" aria-invalid=\"false\">@" . $match[1] . "</span></label>
						</div>";
									echo "<div class=\"controls\">
							<input type=\"text\" name=\"jform[" . $match[1] . "\" id=\"jform_title\" class=\"inputbox\" size=\"40\" aria-required=\"true\" aria-invalid=\"false\" placeholder=\"" . htmlspecialchars($placeholder[1]) . "\">
						</div>";
									echo "</div>";
								}
							}
						}
					}
					echo JHtml::_('bootstrap.endSlide');
					?>
				<?php echo JHtml::_('bootstrap.endAccordion'); ?>
				<?php echo JHtml::_('bootstrap.endTab'); ?>

			<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		</fieldset>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
</form>
