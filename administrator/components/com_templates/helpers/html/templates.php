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
 */
class JHtmlTemplates
{
	/**
	 * Display the thumb for the template.
	 *
	 * @param   string	The name of the active view.
	 */
	public static function thumb($template, $clientId = 0)
	{
		$client		= JApplicationHelper::getClientInfo($clientId);
		$basePath	= $client->path.'/templates/'.$template;
		$baseUrl	= ($clientId == 0) ? JUri::root(true) : JUri::root(true).'/administrator';
		$thumb		= $basePath.'/template_thumbnail.png';
		$preview	= $basePath.'/template_preview.png';
		$html		= '';

		if (file_exists($thumb))
		{
			$clientPath = ($clientId == 0) ? '' : 'administrator/';
			$thumb	= $clientPath.'templates/'.$template.'/template_thumbnail.png';
			$html	= JHtml::_('image', $thumb, JText::_('COM_TEMPLATES_PREVIEW'));
			if (file_exists($preview))
			{
				$preview	= $baseUrl.'/templates/'.$template.'/template_preview.png';
				$html		= '<a href="'.$preview.'" class="thumbnail pull-left modal" title="'.JText::_('COM_TEMPLATES_CLICK_TO_ENLARGE').'">'.$html.'</a>';
			}
		}

		return $html;
	}

	/**
	 * Method to create an overrides list from the overrides array.
	 *
	 * @param   array   $overrides    Template overrides.
	 * @param   string  $url          Url to which file path is added.
	 * @param   string  $extensionId  Extension ID.
	 * @param   int     &$i           Collapse ID.
	 * @param   string  $parent       Parent key.
	 *
	 * @return  string  Overrides list.
	 */
	public static function createOverridesList($overrides, $url, $extensionId, &$i, $parent = null)
	{
		$html = isset($parent) ? JHtml::_('bootstrap.addSlide', 'templatestyleOverrides', JText::_($parent), 'folderCollapse' . ($i++)) : '';
		$html .= "<ul class=\"nav file-list\">\n";
		$add = "$extensionId:html";

		foreach ($overrides as $key => $value)
		{
			if (is_array($value))
			{
				$html .= "<li>\n" . self::createOverridesList($value, $url, $extensionId, $i, $key) . "</li>\n";
			}
			else
			{
				if (isset($parent))
				{
					$html .= "<li><a class=\"file\" href=\"" . JRoute::_($url . urlencode(base64_encode($add . $value))) . "\"><i class=\"icon-edit\"></i> Edit $key</a></li>\n";
				}
				else
				{
					$html .= "<li><a class=\"root-file\" href=\"" . JRoute::_($url . urlencode(base64_encode($add . $value))) . "\"><i class=\"icon-edit\"></i>Edit $key</a></li>\n";
				}
			}
		}
		$html .= "</ul>\n";
		$html .= isset($parent) ? JHtml::_('bootstrap.endSlide') : '';

		return $html;
	}
}
