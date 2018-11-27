<?php

namespace HOdonto\Model;

use \HOdonto\DB\Sql;
use \HOdonto\Model;

	class Patient extends Model
	{

		public static function lockUp($search)
		{
			$search = strtoupper($search);
			$data = array();

			$sql = new Sql();
			$results = $sql->select('
				SELECT p.id, p.name
				FROM tb_patients p
				WHERE UPPER(p.name) LIKE :name
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

		public function get($idPatient)
		{
			$sql = new Sql();

			$result = $sql->select("
				SELECT *
				FROM tb_patients
				WHERE id = :id
			", Array(
				'id'=>$idPatient
			));

			if (count($result) > 0) {
				$this->setData($result[0]);
				$this->setcode(0);
			} else {
				$this->setCode(1);
				$this->setmessage("Patient code $idPatient not found!");
			}
		}

		public function save()
		{

			if ((int)$this->getid() === 0) {
				$query = '
					INSERT INTO tb_patients (name, doc_number, telephone, cellphone, email, street, street_number, city, state, zipcode)
					VALUES (:name, :doc_number, :telephone, :cellphone, :email, :street, :street_number, :city, :state, :zipcode);
				';
			} else {
				$query = '
					UPDATE tb_patients 
					SET name = :name,
						doc_number = :doc_number,
						telephone = :telephone,
						cellphone = :cellphone,
						email = :email,
						street = :street,
						street_number = :street_number,
						city = :city,
						state = :state,
						zipcode = :zipcode
					WHERE id = :id
				';
				$data[':id'] = $this->getid();
			}

			$data[':name'] = $this->getname();
			$data[':doc_number'] = $this->getdoc_number();
			$data[':telephone'] = $this->gettelephone();
			$data[':cellphone'] = $this->getcellphone();
			$data[':email'] = $this->getemail();
			$data[':street'] = $this->getstreet();
			$data[':street_number'] = $this->getstreet_number();
			$data[':city'] = $this->getcity();
			$data[':state'] = $this->getstate();
			$data[':zipcode'] = $this->getzipcode();

			$sql = new Sql();

			$sql->query($query, $data);
			
			if ((int)$this->getid() === 0) {
				$result = $sql->select('SELECT LAST_INSERT_ID()');
				$this->setid((int)$result[0]['LAST_INSERT_ID()']);
			}

			$this->setcode(0);
			$this->setmessage('Patient saved!');
		}

		public function delete($idPatient)
		{
			$sql = new Sql();
			$sql->query('
				DELETE FROM tb_patients
				WHERE id = :id
			', Array(
				':id'=>$idPatient
			));
		}

	}

?>