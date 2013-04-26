<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View to edit a template style.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 * @since       1.6
 */
class TemplatesViewLess extends JViewLegacy
{
	protected $form;

	protected $ftp;

	protected $source;

	protected $state;

	protected $template;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$canDo		= TemplatesHelper::getActions();

		JToolbarHelper::title(JText::_('COM_TEMPLATES_MANAGER_EDIT_LESS'), 'thememanager');

		// Can save the item.
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::apply('less.apply');
			JToolbarHelper::save('less.save');
		}

		JToolbarHelper::cancel('less.cancel');
		JToolbarHelper::divider();
	}
}
