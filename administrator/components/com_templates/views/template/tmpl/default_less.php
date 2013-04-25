<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>
<h1>LOL</h1>
<br />
<?php
$file = file('E:\Sites\home\localhost\www\joomla_development\joomla-cms\administrator\templates\isis\less\variables.less');
for ($i = 0; $i < count($file); $i++)
{
	if (preg_match('/^\/\/ ([A-Z0-9-\s]+)$/i', $file[$i], $match))
	{
		if (preg_match('/^\/\/\ [^A-Z0-9]+$/i', $file[$i + 1]))
		{
			echo '<br /><h2>' . $match[1] . '</h2>';
		}
	}
	elseif (substr($file[$i], 0, 1) == '@')
	{
		preg_match('/(@[A-Z]+):/i', $file[$i], $match);
		preg_match('/:\s*(.+)\s*;/i', $file[$i], $placeholder);

		if (isset($match[1]) && isset($placeholder[1]) && $placeholder[1] !== '')
		{
			echo "<div class=\"control-group\">";
			echo "<div class=\"control-label\">
	<label id=\"jform_title-lbl\" for=\"jform_title\" class=\"hasTip\" title=\"\" aria-invalid=\"false\">" . $match[1] . "</span></label>
</div>";
			echo "<div class=\"controls\">
	<input type=\"text\" name=\"jform[". $match[1] . "\" id=\"jform_title\" class=\"inputbox\" size=\"40\" required=\"required\" aria-required=\"true\" aria-invalid=\"false\" placeholder=\"". htmlspecialchars($placeholder[1]) . "\">
</div>";
			echo "</div>";
		}
	}
}
