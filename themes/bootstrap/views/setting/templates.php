<?php
//$this->pageTitle =
$this->breadcrumbs = array( 'Settings' );

?>

<h1><i class="icon-cogs"></i> Settings</h1>

<?php $this->widget( 'bootstrap.widgets.TbMenu',
    array(
                                                      'type'    => 'tabs', // '', 'tabs', 'pills' (or 'list')
                                                      'stacked' => false, // whether this is a stacked menu
                                                      'items'   => array(
                                                          array(
                                                              'label'  => 'General',
                                                              'icon'   => 'globe',
                                                              'url'    => array( '/settings/general' ),
                                                          ),
                                                          array(
                                                              'label' => 'SMS',
                                                              'icon'  => 'mobile-phone',
                                                              'url'   => array( '/settings/sms' )
                                                          ),
                                                          array(
                                                              'label' => 'E-mail Templates',
                                                              'icon'  => 'envelope',
                                                              'url'   => array( '/settings/templates' ),
                                                              'active' => true
                                                          ),
                                                      ),
                                                 )
)

?>

<div class="control-group "
    <div class="controls">
        <?php echo CHtml::dropDownList(
            'id',
            $_GET['id'],
            CHtml::listData( $templates , 'id', 'label' ),
            array(
                 'class'    => 'span3',
                 'empty'    => '-- Select a Template --',
                 'onchange' => 'window.location = "/settings/templates/" + this.value'
            )
        ); ?>
    </div>
</div>

<?php if( isset( $template ) ): ?>

    <?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
                                                                         'id'                   => 'template-form',
                                                                         'type'                 => 'horizontal',
                                                                         'enableAjaxValidation' => false,
                                                                    ) ); ?>

    <feildset>
        <legend>Edit Template With Key "<?php echo $template->key; ?>"</legend>

        <?php echo $form->textFieldRow( $template, 'label', array( 'class' => 'span3' ) ); ?>
        <?php echo $form->textAreaRow( $template, 'value', array( 'class' => 'span5', 'rows' => 5, 'hint' => $template->description ) ); ?>

        <h4>Placeholders</h4>
        <dl class="dl-horizontal">
            <dt><span class="label">%PACKAGE_ID%</span></dt><dd>Порядковый номер пака</dd>
            <dt><span class="label">%DROPNAME%</span></dt><dd>Полное имя дропа</dd>
            <dt><span class="label">%PACKAGE_NAME%</span></dt><dd>название пака</dd>
            <dt><span class="label">%HOLDER_NAME%</span></dt><dd>имя холдера (у дропа manager's name)</dd>
            <dt><span class="label">%DELIVERY_SYSTEM%</span></dt><dd>служба доставки</dd>
            <dt><span class="label">%TRACKING_NUMBER%</span></dt><dd>трэк</dd>
            <dt><span class="label">%PRICE%</span></dt><dd>цена пака</dd>
            <dt><span class="label">%DELIVERY_DATE%</span></dt><dd>дата доставки пака дропу</dd>
            <br>

            <dt><span class="label">%COMPANY%</span></dt><dd>Дроп-проект дропа (название)</dd>
            <dt><span class="label">%CURENT_DATE_TIME%</span></dt><dd>текущая дата и время</dd>
            <dt><span class="label">%PASSWORD%</span></dt><dd>пароль пользователя</dd>
            <dt><span class="label">%LOGIN%</span></dt><dd>логин дропа</dd>
            <br>

            <dd><b>----------- МУЛЬТИ-ПАК ----------</b></dd>
            <dd class="text-info">для мульти-пака можно использовать спец. тэг для цикла повторения трэков</dd>
            <dt><span class="label">%EACH_BEGIN%</span></dt><dd>начало информации для повтора</dd>
            <dt><span class="label">%EACH_END%</span></dt><dd>конец повторений</dd>
            <dt><span class="label">%TRACK%</b></span></dt><dd>трэк (используется именно такая константа для повторяющейся информации)</dd>
            <dt><span class="label">%SHIPPING%</b></span></dt><dd>шиппинг компания</dd>

            <hr />например:<br>
            %EACH_BEGIN%<br>
            Track: %SHIPPING% # %TRACK%<br>
            %EACH_END%
        </dl>
        <div class="text-info">все трэки будут написаны в таком стиле, по порядку</div>

        <div class="form-actions">
            <?php $this->widget( 'bootstrap.widgets.TbButton', array(
                                                                    'buttonType' => 'submit',
                                                                    'type'       => 'success',
                                                                    'icon'       => 'save',
                                                                    'label'      => 'Save',
                                                               )); ?>
            <?php $this->widget( 'bootstrap.widgets.TbButton', array(
                                                                    'type' => 'link',
                                                                    'url'        => array('/settings/templates'),
                                                                    'label'      => 'Cancel',
                                                               )); ?>
        </div>
    </feildset>

<?php
    $this->endWidget();
endif;
?>