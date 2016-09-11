<?php
// $Id: $

/**
 * @file node-news_abteilung.tpl.php
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<div id="node-<?php echo $node->nid; ?>" class="node<?php if ($sticky) echo ' sticky'; ?><?php if (!$status) echo ' node-unpublished'; ?> clear-block">

<?php echo $picture; ?>

<?php if (!$page): ?>
  <h1><a href="<?php echo $node_url; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h1>
<?php endif; ?>

  <div class="meta">
    <?php if ($submitted): ?>
      <div class="submitted"><?php echo $submitted; ?></div>
    <?php endif; ?>

  </div>

  <div class="content">
    <?php echo $content; ?>
  </div>

  <div class="meta">
    <?php if ($links): ?>
      <div class="links">
        <?php echo $links; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
