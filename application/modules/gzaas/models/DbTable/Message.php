<?php

class Gzaas_Model_DbTable_Message extends Zend_Db_Table_Abstract
{
	protected $_name = 'messages';


	public function addMessage($message)
	{
		$newMessage = array (
			'message' => stripSlashes($message['message']),
			'visibility' => $message['visibility'],
			'inblacklist' => $message['inblacklist'],
			'urlKey' => $message['urlKey'],
			'date' => $message['date'],
			'ip' => $message['ip'],
			'languageUser' => $message['languageUser'],
			'api' => $message['api']
		);
		$this->insert($newMessage);
		$idMessage = $this->_db->lastInsertId();
		return $idMessage;
	}

	public function getMessage($urlKey)
	{
		$columns = "id, message, urlKey, visibility, languageUser";
		$table = $this->_name;
		$condition = "urlKey = '".$urlKey."'";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$message = $this->_db->fetchRow($query);

		return $message;
	}

	public function getNumTotalMessages()
	{
		$columns = "COUNT(id) AS numTotalMessages";
		$table = $this->_name;
		$condition = "visibility = 1 AND inblacklist = 0";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition;
		$numTotalMessages = $this->_db->fetchOne($query);

		return $numTotalMessages;
	}

	public function getRandomUrlKey($randomPosition)
	{
		$columns = "urlKey";
		$table = $this->_name;
		$condition = "visibility = 1 AND inblacklist = 0";
		$limit = $randomPosition.",1";

		$query = "SELECT ".$columns." FROM ".$table." WHERE ".$condition." LIMIT ".$limit;
		$urlKey = $this->_db->fetchOne($query);

		return $urlKey;
	}

}