<?php

namespace HOdonto\Model;

use \HOdonto\DB\Sql;
use \HOdonto\Model;

	class Dentist extends Model
	{

		public static function lockUp($search)
		{
			$search = strtoupper($search);
			$data = array();

			$sql = new Sql();
			$results = $sql->select('
				SELECT d.id, d.name
				FROM tb_dentists d
				WHERE UPPER(d.name) LIKE :name
			', Array(
				':name'=> '%' . $search . '%'
			));

			$data = Array();
			$data['items'] = [];

			foreach ($results as $row) {				
				array_push(
					$data['items'],
					Array(
						'id'=>$row['id'],
						'text'=>$row['name']
					)
				);
			}
			return json_encode($data);
		}

		public function get($idDentist)
		{
			$sql = new Sql();

			$result = $sql->select("
				SELECT *
				FROM tb_dentists
				WHERE id = :id
			", Array(
				'id'=>$idDentist
			));

			if (count($result) > 0) {
				$this->setData($result[0]);
				$this->setcode(0);
			} else {
				$this->setCode(1);
				$this->setmessage("Dentist code $idDentist not found!");
			}
		}

		public function save()
		{

			if ((int)$this->getid() === 0) {
				$query = '
					INSERT INTO tb_dentists (name, doc_number)
					VALUES (:name, :doc_number)
				';
			} else {
				$query = '
					UPDATE tb_dentists 
					SET name = :name,
						doc_number = :doc_number
					WHERE id = :id
				';
				
				$data[':id'] = $this->getid();
			}

			$data[':name'] = $this->getname();
			$data[':doc_number'] = $this->getdoc_number();

			$sql = new Sql();

			$sql->query($query, $data);
			
			if ((int)$this->getid() === 0) {
				$result = $sql->select('SELECT LAST_INSERT_ID()');
				$this->setid((int)$result[0]['LAST_INSERT_ID()']);
			}

			$this->setcode(0);
			$this->setmessage('Dentist saved!');
		}

		public function delete($idDentist)
		{
			$sql = new Sql();
			$sql->query('
				DELETE FROM tb_dentists
				WHERE id = :id
			', Array(
				':id'=>$idDentist
			));
		}

	}

?>