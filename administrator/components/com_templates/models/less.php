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
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 * @since       1.5
 */
class TemplatesModelLess extends JModelForm
{
	/**
	 * Method to get the record form.
	 *
	 * @param   array      $data        Data for the form.
	 * @param   boolean    $loadData    True if the form is to load its own data (default case), false if not.
	 * @return  JForm    A JForm object on success, false on failure
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();

		// Get the form.
		$form = $this->loadForm('com_templates.less', 'less', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to store the source file contents.
	 *
	 * @param   array  The souce data to save.
	 *
	 * @return  boolean  True on success, false otherwise and internal error set.
	 * @since   1.6
	 */
	public function save($data)
	{
		jimport('joomla.filesystem.file');

		$dispatcher = JEventDispatcher::getInstance();

		// Trigger the onExtensionBeforeSave event.
		$result = $dispatcher->trigger('onExtensionBeforeSave', array('com_templates.less', &$data, false));

		if (in_array(false, $result, true))
		{
			$this->setError($table->getError());

			return false;
		}
		$filePath = JPATH_ADMINISTRATOR . '/templates/isis/less/variables.less';
		$file = file($filePath);

		foreach ($file as &$line)
		{
			foreach ($data as $variable => $color)
			{
				if (preg_match('/@' . $variable . ':/', $line))
				{
					if (preg_match('/:\s*(.+)\s*;/i', $line, $placeholder))
					{
						$line = str_replace($placeholder[1], $color, $line);
					}
					else
					{
						$line = '@' . $variable . ': ' . $color . ';';
					}
					unset($data[$variable]);

					break;
				}
			}

			if (!count($data))
			{
				break;
			}
		}

		$textFile = implode('', $file);
		$return = JFile::write($filePath, $textFile);

		include JPATH_ROOT . '/build/libraries/less/lessc.php';
		include JPATH_ROOT . '/build/libraries/less/less.php';
		include JPATH_ROOT . '/build/libraries/less/formatter/joomla.php';

		$less = new JLess;
		$less->compileFile(JPATH_ADMINISTRATOR . '/templates/isis/less/template.less', JPATH_ADMINISTRATOR . '/templates/isis/css/template.css');

		if (!$return)
		{
			$this->setError(JText::sprintf('COM_TEMPLATES_ERROR_FAILED_TO_SAVE_FILENAME', $fileName));

			return false;
		}

		// Trigger the onExtensionAfterSave event.
		$dispatcher->trigger('onExtensionAfterSave', array('com_templates.less', &$table, false));

		return true;
	}
}
