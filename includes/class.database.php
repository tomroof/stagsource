<?php
/*********************************************************************************************
Author 	: V V VIJESH
Date	: 04-Feb-2011
Purpose	: MySQLi database access layer
*********************************************************************************************/
class database extends MySQLi
{
	public function __construct($host = '', $username = '', $password = '', $databse = '')	
	{
		if($host != '' && $username != '' && $password != '' && $databse != '')
		{
			parent::__construct($host, $username, $password, $databse);
		}
		else
		{
			parent::__construct(HOST, USERNAME, PASSWORD, DATABASE, ini_get("mysqli.default_port"), ini_get("mysqli.default_socket") );
		}
	}
}
?>