<?php
$this->breadcrumbs=array(
    'Tickets',
);

$this->menu = array(
    array( 'label' => 'OPERATIONS' ),
    array( 'label' => 'Create Ticket', 'icon' => 'plus', 'url' => array( 'create' ), 'active' => true ),
    array(
        'label' => 'Manage Tickets' . $this->unreviewedTickets,
        'icon' => 'list',
        'url' => array( 'manage' )
    ),
);
?>

<h1>Tickets</h1>

<?php echo $this->renderPartial( '_addForm', array( 'ticket' => $ticket, 'message' => $message ) ); ?>