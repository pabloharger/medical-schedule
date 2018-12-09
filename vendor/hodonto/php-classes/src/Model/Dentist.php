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
				SELECT d.id_dentist, d.name
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
						'id'=>$row['id_dentist'],
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
				WHERE id_dentist = :id_dentist
			", Array(
				'id_dentist'=>$idDentist
			));

			if (count($result) > 0) {
				$this->setValues($result[0]);
				$this->setcode(0);
			} else {
				$this->setCode(1);
				$this->setmessage("Dentist code $idDentist not found!");
			}
		}

		public function save()
		{

			if ((int)$this->getid_dentist() === 0) {
				$query = '
					INSERT INTO tb_dentists (name, doc_number)
					VALUES (:name, :doc_number)
				';
			} else {
				$query = '
					UPDATE tb_dentists
					SET name = :name,
						doc_number = :doc_number
					WHERE id_dentist = :id_dentist
				';
				
				$data[':id_dentist'] = $this->getid_dentist();
			}

			$data[':name'] = $this->getname();
			$data[':doc_number'] = $this->getdoc_number();

			$sql = new Sql();

			$sql->query($query, $data);
			
			if ((int)$this->getid_dentist() === 0) {
				$result = $sql->select('
					SELECT *
					FROM tb_dentists
					WHERE id_dentist = LAST_INSERT_ID()
				');

				if (count($result) > 0)
					$this->setValues($result[0]);
			}

			$this->setcode(0);
			$this->setmessage('Dentist saved!');
		}

		public function delete($idDentist)
		{
			$sql = new Sql();
			$sql->query('
				DELETE FROM tb_dentists
				WHERE id_dentist = :id_dentist
			', Array(
				':id_dentist'=>$idDentist
			));
		}

	}

?>