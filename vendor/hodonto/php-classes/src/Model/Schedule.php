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
					ON d.id = s.id_dentist
					INNER JOIN tb_patients p
					ON p.id = s.id_patient
				');
			} else {
				$results = $sql->select('
					SELECT s.*, d.name name_dentist, p.name name_patient
					FROM tb_schedules s
					INNER JOIN tb_dentists d
					ON d.id = s.id_dentist
					INNER JOIN tb_patients p
					ON p.id = s.id_patient
					WHERE s.id = :id
					', Array(
						':id'=>$idSchedule
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

			return $result;
		}

		public function save()
		{

			if ((int)$this->getid() === 0) {
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
					WHERE id = :id
				';
				
				$data[':id'] = $this->getid();
			}

			$data[':id_patient'] = $this->getid_patient();
			$data[':id_dentist'] = $this->getid_dentist();
			$data[':date_time_begin'] = $this->getdate_time_begin();
			$data[':date_time_end'] = $this->getdate_time_end();
			$data[':observation'] = $this->getobservation();

			$sql = new Sql();

			$sql->query($query, $data);
			
			if ((int)$this->getid() === 0) {
				$result = $sql->select('SELECT LAST_INSERT_ID()');
				$this->setid((int)$result[0]['LAST_INSERT_ID()']);
			}

			$this->setcode(0);
			$this->setmessage('Shcedule saved!');
		}

		public function delete($idSchedule)
		{
			$sql = new Sql();
			$sql->query('
				DELETE FROM tb_schedules
				WHERE id = :id
			', Array(
				':id'=>$idSchedule
			));
		}
/*
id
id_dentist
id_patient
date_time_begin
date_time_end
observation

    
	function save(){


				$data = array();
				$data['code'] = 0;
                $data['message'] = '';
                $data['data'] = [];

                $schedule = Pojoschedule::getInstance();
                $schedule->beginTransaction();

				$schedule->findId($id, false);
				$schedule->setid($id);
                $schedule->setid_dentist($id_dentist);
                $schedule->setid_patient($id_patient);
				$schedule->setdate_time_begin($date_time_begin);
                $schedule->setdate_time_end($date_time_end);
                $schedule->setobservation($observation);
				if ($schedule->getFind()){
					$schedule->update();
				} else {
					$schedule->insert();
                }
                
                $schedule->endTransaction();
	
				$data['message'] = 'Schedule saved!';
				$data['data'][0]['id'] = $schedule->getid();
    }
*/


	}

?>