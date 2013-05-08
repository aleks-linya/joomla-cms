<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_feed
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php
if (is_string($feed))
{
	echo $feed;
}
else
{
	$lang      = JFactory::getLanguage();
	$myrtl     = $params->get('rssrtl');
	$direction = '';

	if ($lang->isRTL() && $myrtl == 0)
	{
		$direction = " redirect-rtl";
	}
	elseif ($lang->isRTL() && $myrtl == 1)
	{
		$direction = " redirect-ltr";
	}
	elseif ($lang->isRTL() && $myrtl == 2)
	{
		$direction = " redirect-rtl";
	}
	elseif ($myrtl == 0)
	{
		$direction = " redirect-ltr";
	}
	elseif ($myrtl == 1)
	{
		$direction = " redirect-ltr";
	}
	elseif ($myrtl == 2)
	{
		$direction = " redirect-rtl";
	}
	?>

	<?php if ($feed != false) : ?>
	<?php
	// Image handling
	$iUrl   = isset($feed->image) ? $feed->image : null;
	$iTitle = isset($feed->imagetitle) ? $feed->imagetitle : null;
	?>
	<div class="row-striped">
	<div style="direction: <?php echo $rssrtl ? 'rtl' : 'ltr'; ?>; text-align: <?php echo $rssrtl ? 'right' : 'left'; ?> ! important"  class="feed<?php echo $moduleclass_sfx; ?>">
	<?php if (!is_null($feed->title) && $params->get('rsstitle', 1)) : ?>
		<h2 class="redirect-ltr">
			<a href="<?php echo str_replace('&', '&amp', $feed->link); ?>" target="_blank">
				<?php echo $feed->title; ?></a>
		</h2>
	<?php endif; ?>

	<?php if ($params->get('rssdesc', 1)) : ?>
		<?php echo $feed->description; ?>
	<?php endif; ?>

	<?php if ($params->get('rssimage', 1) && $iUrl) : ?>
		<img src="<?php echo $iUrl; ?>" alt="<?php echo @$iTitle; ?>"/>
	<?php endif; ?>

	<ul class="newsfeed<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php if (!empty($feed)) : ?>
		<?php for ($i = 0; $i < $params->get('rssitems', 5); $i++) : ?>
			<?php
			$uri  = (!empty($feed[$i]->guid) || !is_null($feed[$i]->guid)) ? $feed[$i]->guid : $feed[$i]->uri;
			$uri  = substr($uri, 0, 4) != 'http' ? $params->get('rsslink') : $uri;
			$text = !empty($feed[$i]->content) || !is_null($feed[$i]->content) ? $feed[$i]->content : $feed[$i]->description;
			?>
			<li>
				<?php if (!empty($uri)) : ?>
					<h5 class="feed-link">
						<a href="<?php echo $uri; ?>" target="_blank">
							<?php  echo $feed[$i]->title; ?></a></h5>
				<?php else : ?>
					<h5 class="feed-link"><?php  echo $feed[$i]->title; ?></h5>
				<?php  endif; ?>

				<?php if ($params->get('rssitemdesc') && !empty($text)) : ?>
					<div class="feed-item-description">
						<?php
						// Strip the images and iframes.
						$text = JFilterOutput::stripImages($text);
						$text = JFilterOutput::stripIframes($text);

						// For backward compatibility.
						$characterCount = $params->get('character_count') !== null ? $params->get('character_count') : $params->get('word_count');

						$text = JHtml::_('string.truncateComplex', $text, $characterCount);
						echo str_replace('&apos;', "'", $text);
						?>
					</div>
				<?php endif; ?>
			</li>
		<?php endfor; ?>
	</ul>
	<?php endif; ?>
	<?php endif; ?>
	</div>
	</div>
<?php
}
