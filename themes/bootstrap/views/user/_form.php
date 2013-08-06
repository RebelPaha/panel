<?php $form = $this->beginWidget( 'bootstrap.widgets.TbActiveForm', array(
     'id'                     => 'user-form',
     'type'                   => 'horizontal',
     'enableClientValidation' => true,
     'clientOptions'          => array(
         'validateOnSubmit' => true,
     ),
     'htmlOptions'            => array( 'class' => 'form' ),
)); ?>

<fieldset>
    <?php

    $userForm  = $form->textFieldRow( $user, 'username', array( 'class' => 'span3', 'readonly' => ! $user->isNewRecord ) );
    $userForm .= $form->passwordFieldRow( $user, 'password', array( 'class' => 'span3', 'value' => '' ));
    $userForm .= $form->textFieldRow( $user, 'email',  array( 'class' => 'span3' ));
    $userForm .= $form->textFieldRow( $user, 'jabber',  array( 'class' => 'span3' ));
    $userForm .= $form->dropDownListRow( $user, 'state', $user->getStates(), array( 'class' => 'span3' ));
//    $userForm .= $form->dropDownListRow( $user, 'managers', CHtml::listData(User::model()->getUsersFromRole(), 'id', 'username'), array( 'class' => 'span3' ));
//    $userForm .= $form->checkBoxListRow( $user, 'managers', CHtml::listData(User::model()->getUsersFromRole(), 'id', 'username'));

    if( isset( $profile ) ){
        $profileForm =  $form->dropDownListRow(
            $profile,
            'projectId',
            CHtml::listData( Project::model()->findAll(), 'id', 'name' ),
            array( 'class' => 'span3', 'empty' => '--None--' )
        );
        $profileForm .= $form->textFieldRow( $profile, 'firstName', array( 'class' => 'span3' ) );
        $profileForm .= $form->textFieldRow( $profile, 'middleName', array( 'class' => 'span3' ) );
        $profileForm .= $form->textFieldRow( $profile, 'lastName', array( 'class' => 'span3' ) );
        $profileForm .= $form->dropdownListRow( $profile, 'countryId', CHtml::listData( Country::model()->findAll(), 'id', 'name' ), array( 'class' => 'span3' ) );
        $profileForm .= $form->textFieldRow( $profile, 'city', array( 'class' => 'span3' ) );
        $profileForm .= $form->textareaRow( $profile, 'address', array( 'class' => 'span3', 'rows' => 2 ) );
        $profileForm .= $form->textFieldRow( $profile, 'zip', array( 'class' => 'span3' ) );
        $profileForm .= $form->textFieldRow( $profile, 'homephone', array( 'class' => 'span3' ) );
        $profileForm .= $form->textFieldRow( $profile, 'cellphone', array( 'class' => 'span3' ) );
        $profileForm .= $this->widget('application.components.WasDatepicker.WasDatepicker', array(
                                                                       'model' => $profile,
                                                                       'attribute' => 'dob',
                                                                       'form' => $form,
                                                                       //model + attribute or 'name'=>'nameInput',
                                                                       'options' => array(
                                                                           'language' => 'en',
                                                                           'format' => 'yyyy-mm-dd',
                                                                           'autoclose' => 'true',
                                                                           'startDate' => '1900,1,1',
                                                                           'endDate' => date('Y,m,d'),
                                                                           'weekStart' => 1,
                                                                           'startView' => 2,
                                                                           'keyboardNavigation' => true
                                                                       ),
                                                                  ), true
        );

        $profileForm .= $form->textFieldRow( $profile, 'ssn', array( 'class' => 'span3' ) );
        $profileForm .= $form->checkboxRow( $profile, 'docsAlert' );
        $profileForm .= $form->checkboxRow( $profile, 'isPaid' );
        $profileForm .= $form->textFieldRow( $profile, 'paidAmount', array( 'class' => 'span3' ) );
        $profileForm .= $form->textareaRow( $profile, 'lastEmployer', array( 'class' => 'span3', 'rows' => 2 ) );
        $profileForm .= $form->textareaRow( $profile, 'comment', array( 'class' => 'span3', 'rows' => 5 ) );

        $info = $this->widget('bootstrap.widgets.TbDetailView', array(
                                                                     'type'       => array( 'striped', 'condensed' ),
                                                                     'data'       => $profile,
                                                                     'attributes' => array(
                                                                         array( 'name' => 'regIp' ),
                                                                         array( 'name' => 'lastVisit' ),
                                                                         array( 'name' => 'userAgent' ),
                                                                     ),
                                                                ), true
        );


        $this->widget( 'bootstrap.widgets.TbTabs', array(
                                             'type'      => 'tabs',
                                             'placement' => 'top',
                                             'tabs'      => array(
                                                 array( 'label' => 'Main', 'content' => $userForm, 'active' => true ),
                                                 array( 'label' => 'Profile', 'content' => $profileForm ),
                                                 array(
                                                     'label'   => 'Info',
                                                     'content' => $info,
                                                     'visible' => ! $user->isNewRecord
                                                 ),
                                             ),
                                        )
        );
    }
    else {
        echo $userForm;
    }

     ?>

    <div class="form-actions">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                 'buttonType' => 'submit',
                 'label' => $user->isNewRecord ? 'Add' : 'Save',
                 'type' => 'success',
                 'icon' => $user->isNewRecord ? 'plus' : 'save'
            )
        );

        echo '&nbsp;';

        if( ! $user->isNewRecord ){
            $this->widget(
                'bootstrap.widgets.TbButton', array(
                                                   'label'       => 'Delete',
                                                   'type'        => 'danger',
                                                   'icon'        => 'trash',
                                                   'url'         => array( 'delete', 'id' => $user->id ),
                                                   'htmlOptions' => array(
                                                       'confirm' => 'Are you sure you want to delete this item?'
                                                   )
                                              )
            );
        }

        echo '&nbsp;';

        $this->widget( 'bootstrap.widgets.TbButton', array( 'label' => 'Cancel', 'type' => 'link', 'url' => array( 'manage' ) ) );
        ?>
    </div>

</fieldset>

<?php $this->endWidget(); ?>
