<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    <div class="span3">
        <div id="sidebar">
        <?php $this->widget('bootstrap.widgets.TbMenu', array(
             'type'        => 'list',
             'encodeLabel' => false,
             'htmlOptions' => array( 'class' => 'well' ),
             'items'       => $this->menu,
        )); ?>
        </div><!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>