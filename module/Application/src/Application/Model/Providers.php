<?php
// module/Application/src/Application/Model/Provider.php:
namespace Provider\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class Providers extends AbstractTableGateway
{
	protected $table ='providers';

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Providers());
		$this->initialize();
	}

	public function fetchAll()
	{
		$resultSet = $this->select();
		return $resultSet;
	}

	public function getProvider($id)
	{
		$id  = (int) $id;
		$rowset = $this->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveProvider($provider)
	{
		$data = array(
				'artist' => $provider->artist,
				'title'  => $provider->title,
		);
		$id = (int)$provider->id;
		if ($id == 0) {
			$this->insert($data);
		} else {
			if ($this->getProvider($id)) {
				$this->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
	}

	public function deleteProvider($id)
	{
		$this->delete(array('id' => $id));
	}
}