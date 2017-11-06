<?php

const CONFIG = array (
  'main' => 
  array (
    'title' => 'QuickPub',
    'defaultRole' => 'BU',
  ),
  'system' => 
  array (
    'echoErrorPath' => true,
    'returnErrors' => 'none',
    'displayErrors' => 'simple',
    'logErrors' => 'full',
  ),
  'roles' => 
  array (
    'TU' => 
    array (
      'name' => 'testUser',
      'title' => 'Test User',
      'code' => 'TU',
      'actions' => 
      array (
        'test' => 
        array (
          'name' => 'test',
          'title' => 'Test',
          'action' => 'test',
        ),
        'basic' => 
        array (
          'name' => 'basic',
          'title' => 'Basic',
          'action' => 'basic',
        ),
      ),
    ),
    'BU' => 
    array (
      'name' => 'basicUser',
      'title' => 'Basic User',
      'code' => 'BU',
      'actions' => 
      array (
        'basic' => 
        array (
          'name' => 'basic',
          'title' => 'Basic',
          'action' => 'basic',
        ),
      ),
    ),
  ),
  'actions' => 
  array (
    'test' => 
    array (
      'name' => 'test',
      'title' => 'Test',
      'pages' => 
      array (
        0 => 
        array (
          'name' => 'Page Name',
          'elements' => 
          array (
            0 => 
            array (
              'title' => 'Title',
              'name' => 'title',
              'type' => 'text',
              'id' => 'title',
            ),
            1 => 
            array (
              'title' => 'Text Input',
              'name' => 'textInput',
              'type' => 'text',
              'id' => 'textInput',
            ),
            2 => 
            array (
              'title' => 'File Input',
              'name' => 'file',
              'type' => 'file',
              'id' => 'file',
            ),
            3 => 
            array (
              'title' => 'Submit',
              'name' => 'submit',
              'type' => 'submit',
            ),
          ),
        ),
      ),
    ),
    'basic' => 
    array (
      'name' => 'basic',
      'title' => 'Basic',
      'pages' => 
      array (
        0 => 
        array (
          'name' => 'Demo Page',
          'elements' => 
          array (
            0 => 
            array (
              'title' => 'Title',
              'name' => 'title',
              'type' => 'text',
              'id' => 'title',
            ),
            1 => 
            array (
              'title' => 'Text Input',
              'name' => 'textInput',
              'type' => 'text',
              'id' => 'textInput',
            ),
            2 => 
            array (
              'title' => 'File Input',
              'name' => 'file',
              'type' => 'file',
              'id' => 'file',
            ),
            3 => 
            array (
              'title' => 'Submit',
              'name' => 'submit',
              'type' => 'submit',
            ),
          ),
        ),
      ),
    ),
  ),
);

?>
