<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

    public $unreviewedTickets = null;

    public $roles = array();

    public $userRoles = array();

    public function init(){
        parent::init();

        if( Yii::app()->user->checkAccess( 'ticket.to.admin' ) ){
            $count = Ticket::model()->getCounter();

            if( $count > 0 )
                $this->unreviewedTickets = ' <span class="badge badge-warning"> ' . $count . '</span>';
        }

        $this->roles = array_keys( Yii::app()->authManager->getRoles() );

        foreach( $this->roles as $role ){
            $this->userRoles[] = array( 'label' => ucfirst( $role), 'name' => $role );
        }
    }

}