<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 * @author		web-eau.net
 * @copyright   (C) 2010 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

if (!$list)
{
	return;
}

?>

<div class="category-module<?php echo $moduleclass_sfx; ?>">
	<?php foreach ($list as $group_name => $group) : ?>
	<div class="module-card-wrap">
		<?php foreach ($group as $item) : ?>
		<div class="module-card">
			<div class="module-card-title">
				<?php if ($params->get('link_titles') == 1) : ?>
					<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
						<?php echo $item->title; ?>
					</a>
					<?php else : ?>
					<?php echo $item->title; ?>
					<?php endif; ?>
			</div>
			<div class="module-card-meta">
				<?php if ($item->displayCategoryTitle) : ?>				
				<div class="module-card-category">
					<span class="fa fa-tag"></span>
					<span><?php echo $item->displayCategoryTitle; ?></span>
				</div>
				<?php endif; ?>
				<?php if ($params->get('show_author')) : ?>
				<div class="module-card-author">
					<span class="fa fa-user"></span>
					<span><?php echo $item->displayAuthorName; ?></span>
				</div>			
				<?php endif; ?>				
			</div>
			<div class="module-card-bottom">
                <?php
					$article_images  = json_decode($item->images);
					$article_image   = '';
					$article_image_alt   = '';
					if(isset($article_images->image_intro) && !empty($article_images->image_intro)) {
						$article_image  = $article_images->image_intro;
						$article_image_alt  = $article_images->image_intro_alt;
						}?>  					
					<a href="<?php echo $item->link; ?>">
						<img class="module-card-img card-img-top" src="<?php echo $article_image; ?>" alt="<?php echo $article_image_alt; ?>" >
					</a>
				<?php if ($params->get('show_introtext')) : ?>
				<div> 
					<p class="mod-articles-category-introtext"><?php echo $item->displayIntrotext; ?></p>
				</div>
				<?php endif; ?>	
				<?php if ($params->get('show_readmore')) : ?>
					<p class="mod-articles-category-readmore">
						<a class="module-card-button mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php if ($item->params->get('access-view') == false) : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
							<?php elseif ($readmore = $item->alternative_readmore) : ?>
								<?php echo $readmore; ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
									<?php if ($params->get('show_readmore_title', 0) != 0) : ?>
										<?php echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit')); ?>
									<?php endif; ?>
								<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
								<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
								<?php else : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php endif; ?>
						</a>
					</p>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
<?php endforeach; ?>
</div>