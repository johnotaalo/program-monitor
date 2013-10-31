<?php
$config = array('login/authenticate' => array(array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[8]|max_length[15]'), array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[8]|max_length[50]')));
