<?php

$this->breadcrumbs=array(
    'Tickets'=>array('manage'),
    "Detail View Ticket #" . $ticket->id,
);

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array(
        'label'   => 'Manage Tickets' . $this->unreviewedTickets,
        'icon'    => 'list',
        'url'     => array( 'manage' ),
        'visible' => Yii::app()->user->checkAccess( 'ticket.manage' )

    ),
    array(
        'label'   => 'Submit Ticket',
        'icon'    => 'plus',
        'url'     => array( 'create' ),
        'visible' => Yii::app()->user->checkAccess( 'ticket.create' )
    ),
    array( 'label' => 'CURRENT TICKET ACTIONS' ),
    array(
        'label'       => 'Reply',
        'icon'        => 'reply',
        'url'         => '#',
        'linkOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#replyModal',
        ),
        'visible' => Yii::app()->user->checkAccess( 'ticket.to.admin' ),
    ),
    array(
        'label'   => $ticket->isClosed ? 'Open' : 'Close',
        'icon'    => $ticket->isClosed ? 'ok' : 'remove-sign',
        'url'     => array( 'ticket/toggle', 'id' => $ticket->id ),
        'visible' => Yii::app()->user->checkAccess( 'ticket.toggle' )
    ),
    array(
        'label'   => 'Delete',
        'icon'    => 'remove',
        'url'     => array( 'ticket/delete', 'id' => $ticket->id ),
        'visible' => Yii::app()->user->checkAccess( 'ticket.delete' )
    ),
);

$i = 0;

?>

<h1<?php if( (bool) $ticket->isClosed ): ?> class="muted"<?php endif;?>>
    Detail View Ticket #<?php echo $ticket->id; ?>
    <?php if( (bool) $ticket->isClosed ): ?>
    <span class="label">Closed</span>
    <?php endif;?>
</h1>

<?php $this->widget( 'bootstrap.widgets.TbDetailView', array(
                                                            'data'       =>  $ticket,
                                                            'attributes' => array(
                                                                array(
                                                                    'name'  => 'senderId',
                                                                    'type'  => 'raw',
                                                                    'value' => CHtml::link( $ticket->sender->username, array("user", "id" => $ticket->sender->id ) )
                                                                ),
                                                                'created',
                                                                'subject',
                                                            ),
                                                       )
); ?>

<dl class="dl-horizontal">
<?php foreach( $ticket->messages as $msg ):?>
    <?php if( $i >= 1 ): ?>
        <dt><?php echo $msg->sender->username; ?></dt>
    <?php endif; ?>
    <dd>
        <div>
            <?php if( ! $msg->isReviewed ): ?>
            <span class="label label-warning">Unreviewed</span>
            <?php endif; ?>
             <?php if( $i >= 1 ): ?>
            <div class="pull-right">at <em><?php echo $msg->created; ?></em></div>
            <?php endif; ?>
        </div>
        <p><?php echo $msg->text; ?></p>
    </dd>
<?php $i++; endforeach; ?>
</dl>

<div class="form-actions">
    <?php
        if( Yii::app()->user->checkAccess('ticket.to.admin', $ticket->senderId )){
            $this->widget( 'bootstrap.widgets.TbButton', array(
                                                              'label'       => 'Replay',
                                                              'type'        => 'info',
                                                              'icon'        => 'reply',
                                                              'url'         => '#',
                                                              'htmlOptions' => array(
                                                                  'data-toggle' => 'modal',
                                                                  'data-target' => '#replyModal',
                                                              ),
                                                         )
            );
        }
    ?>
    <?php
        if( Yii::app()->user->checkAccess('ticket.toggle', $ticket->senderId )){
            $this->widget('bootstrap.widgets.TbButton', array(
                                                           'label'   => $ticket->isClosed ? 'Open' : 'Close',
                                                           'icon'    => $ticket->isClosed ? 'ok' : 'remove-sign',
                                                         'url'   => array( 'ticket/toggle' , 'id' => $ticket->id ),
                                                    ));
        }
    ?>
    <?php
        if( Yii::app()->user->checkAccess('ticket.delete', $ticket->senderId )){
            $this->widget('bootstrap.widgets.TbButton', array(
                                                           'label' => 'Delete Ticket',
                                                           'type'  => 'danger',
                                                           'icon'  => 'remove',
                                                           'url'   => array( 'ticket/delete' , 'id' => $ticket->id )
                                                      ));
        }
    ?>
</div>

<?php $this->beginWidget( 'bootstrap.widgets.TbModal', array( 'id' => 'replyModal' ) ); ?>

<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
                                                                         'id'                     => 'message-form',
                                                                         'enableClientValidation' => true,
                                                                         'clientOptions'          => array(
                                                                             'validateOnSubmit' => true,
                                                                         ),
                                                                         'htmlOptions'            => array( 'class' => 'form' ),
                                                                    )); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Your Reply</h4>
</div>

<div class="modal-body">
    <p><?php echo $form->textAreaRow( $message, 'text', array( 'class' => 'span5', 'rows' => '7' ) ); ?></p>
    <?php if( (bool) $ticket->isClosed ): ?>
    <p class="muted">Ticket will automatically open after sending a message</p>
    <?php endif; ?>
</div>

<div class="modal-footer">
    <?php $this->widget( 'bootstrap.widgets.TbButton', array(
                                                            'buttonType' => 'submit',
                                                            'label'      => 'Submit',
                                                            'type'       => 'primary',
                                                            'icon'       => 'ok'
                                                       )
); ?>
    <?php $this->widget( 'bootstrap.widgets.TbButton', array(
                                                            'label'       => 'Close Window',
                                                            'icon'        => 'remove',
                                                            'url'         => '#',
                                                            'htmlOptions' => array( 'data-dismiss' => 'modal' ),
                                                       )
); ?>
</div>

<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>