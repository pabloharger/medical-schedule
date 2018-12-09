<?php

namespace HOdonto\Model;

use \HOdonto\DB\Sql;
use \HOdonto\Model;

	class Schedule extends Model
	{
		public function get($idSchedule)
		{
			$sql = new Sql();

			if ((int)$idSchedule === 0) {
				$results = $sql->select('
					SELECT s.*, d.name name_dentist, p.name name_patient
					FROM tb_schedules s
					INNER JOIN tb_dentists d
					ON d.id_dentist = s.id_dentist
					INNER JOIN tb_patients p
					ON p.id_patient = s.id_patient
				');
			} else {
				$results = $sql->select('
					SELECT s.*, d.name name_dentist, p.name name_patient
					FROM tb_schedules s
					INNER JOIN tb_dentists d
					ON d.id_dentist = s.id_dentist
					INNER JOIN tb_patients p
					ON p.id_patient = s.id_patient
					WHERE s.id_schedule = :id_schedule
					', Array(
						':id_schedule'=>$idSchedule
					));
			}

			$result = Array();

			if (count($results) > 0) {
				foreach ($results as $row) {
					$data = Array();
					foreach ($row as $key => $col) {
						$data[$key] = $col;
					}

					array_push($result, $data);
				}
			}

			if ((int)$idSchedule > 0 && count($results) > 0) {
				$this->setValues($results[0]);
			}

			return $result;
		}

		public function save()
		{

			if ((int)$this->getid_schedule() === 0) {
				$query = '
					INSERT INTO tb_schedules (id_patient, id_dentist, date_time_begin, date_time_end, observation)
					VALUES (:id_patient, :id_dentist, :date_time_begin, :date_time_end, :observation)
				';
			} else {
				$query = '
					UPDATE tb_schedules
					SET id_patient = :id_patient,
						id_dentist = :id_dentist,
						date_time_begin = :date_time_begin,
						date_time_end = :date_time_end,
						observation = :observation
					WHERE id_schedule = :id_schedule
				';
				
				$data[':id_schedule'] = $this->getid_schedule();
			}

			$data[':id_patient'] = $this->getid_patient();
			$data[':id_dentist'] = $this->getid_dentist();
			$data[':date_time_begin'] = $this->getdate_time_begin();
			$data[':date_time_end'] = $this->getdate_time_end();
			$data[':observation'] = $this->getobservation();

			$sql = new Sql();

			$sql->query($query, $data);
			
			if ((int)$this->getid_schedule() === 0) {
				$result = $sql->select('
					SELECT *
					FROM tb_schedules
					WHERE id_schedule = LAST_INSERT_ID()
				');

				if (count($result) > 0)
					$this->setValues($result[0]);
			}

			$this->setcode(0);
			$this->setmessage('Shcedule saved!');
		}

		public function delete($idSchedule)
		{
			$sql = new Sql();
			$sql->query('
				DELETE FROM tb_schedules
				WHERE id_schedule = :id_schedule
			', Array(
				':id_schedule'=>$idSchedule
			));
		}
	}

?>