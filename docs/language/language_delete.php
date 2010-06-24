<?php
/************************************************************************/
/* AContent                                                             */
/************************************************************************/
/* Copyright (c) 2009                                                   */
/* Adaptive Technology Resource Centre / University of Toronto          */
/*                                                                      */
/* This program is free software. You can redistribute it and/or        */
/* modify it under the terms of the GNU General Public License          */
/* as published by the Free Software Foundation.                        */
/************************************************************************/

define('TR_INCLUDE_PATH', '../include/');

include(TR_INCLUDE_PATH.'vitals.inc.php');
include_once(TR_INCLUDE_PATH.'classes/DAO/LanguagesDAO.class.php');

if (isset($_REQUEST['id']))
{
	$pieces = explode('_', $_REQUEST['id'], 2);
	$lang_code = $pieces[0];
	$charset = $pieces[1];
}

$languagesDAO = new LanguagesDAO();

if (isset($_POST['submit_no'])) 
{
	$msg->addFeedback('CANCELLED');
	header('Location: index.php');
	exit;
} 
else if (isset($_POST['submit_yes']))
{
	if ($languagesDAO->Delete($lang_code))
	{
		$msg->addFeedback('ACTION_COMPLETED_SUCCESSFULLY');
		header('Location: index.php');
		exit;
	}
}

$row = $languagesDAO->getByLangCodeAndCharset($lang_code, $charset);

unset($hidden_vars);
$hidden_vars['id'] = $_REQUEST['id'];

require(TR_INCLUDE_PATH.'header.inc.php');

$msg->addConfirm(array('DELETE_LANG', $row['native_name']), $hidden_vars);
$msg->printConfirm();

require(TR_INCLUDE_PATH.'footer.inc.php');
?>
