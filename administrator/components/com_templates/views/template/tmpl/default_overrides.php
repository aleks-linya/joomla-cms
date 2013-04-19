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

$style = "
      .file-list {
        margin-bottom: 0;
      }

      .file,
      .root-file {
        padding: 8px;
      }

      .root-file {
        margin-left: 8px;
      }
";
JFactory::getDocument()->addStyleDeclaration($style);
?>
<?php
	echo JHtml::_('bootstrap.startAccordion', 'templatestyleOptions', array('active' => 'folderCollapse0'));
	$i = 0;
	echo JHtml::_('templates.createOverridesList', $this->overrides, 'index.php?option=com_templates&task=source.edit&id=', $this->template->extension_id, $i);
	echo JHtml::_('bootstrap.endAccordion');
