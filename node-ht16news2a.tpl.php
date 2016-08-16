<?php
// $Id: $

/**
 * @file node-ht16news2a.tpl.php
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
      <div class="floatleft">
      <?php print $node->field_ht16image[0]['view'] ?></div>
      <?php print $content; ?></div>
        <div style="clear:both"></div>
      <?php unset($node->field_ht16image[0]); ?>
      <div class="floatleft">
      <?php if($page !=0 or !$teaser): ?>
        <?php foreach ($node->field_ht16image as $otherimage=>$image) {
          print"<div class='floatleft'>".$image['view']."</div>"; } ?>
      <?php endif; ?></div>
  <div style="clear:both"></div>
  </div>

  <div class="meta">
    <?php if ($links): ?>
      <div class="links">
        <?php echo $links; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
