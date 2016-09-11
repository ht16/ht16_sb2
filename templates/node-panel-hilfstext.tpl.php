<?php
// $Id: node-panel-hilfstext.tpl.php,v 1.0.0.0 2011/06/30 08:03:14 krueschi Exp $

/**
 * @file node-panel-hilfstext.tpl.php
 *
 */
?>
<div id="node-<?php echo $node->nid; ?>" class="node<?php if ($sticky) echo ' sticky'; ?><?php if (!$status) echo ' node-unpublished'; ?> clear-block">

<?php if (!$page): ?>
  <h1><a href="<?php echo $node_url; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h1>
<?php endif; ?>

  <div class="meta">
    <?php if ($submitted): ?>
      <div class="submitted"><?php echo $submitted; ?></div>
    <?php endif; ?>

  </div>

  <div class="content">
	<div class="hilfstext-content">
		<?php echo $content; ?>
  </div></div>

  <div class="meta">
    <?php if ($links): ?>
      <div class="links">
        <?php echo $links; ?>
      </div>
    <?php endif; ?>
  </div>
</div>