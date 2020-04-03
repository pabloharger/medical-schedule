<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="py-2">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"> Scheduler
            <br>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <!--shcedule-->
                <div data-js="schedule-schedule"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" data-js="schedule-dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add chedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div data-js="schedule-form-add" action="#">
              <input type="hidden" class="schedule-input" data-js="schedule-inp-id">
              <div class="form-group">
                <label>Dentist</label>
                <select class="schedule-select form-control" data-js="schedule-sel-dentist"></select>
                <div class="invalid-feedback">
                    You need select the dentist.
                </div>
              </div>
              <div class="form-group">
                  <label>Patient</label>
                  <select class="schedule-select form-control" data-js="schedule-sel-patient"></select>
                  <div class="invalid-feedback">
                      You need select the patient.
                  </div>
              </div>
              <div class="form-group">
                  <label>Initial Time</label>
                  
                  <input type="text" placeholder="Initial date time" class="form-control datetimepicker-input" data-js="schedule-inp-date-initial" id="scheduleInpDateInicial" data-toggle="datetimepicker" data-target="#scheduleInpDateInicial"/>
                  <div class="invalid-feedback">
                    You need set the initial time.
                  </div>
              </div>
              </div>
              <div class="form-group">
                  <label>End Time</label>
                  <input type="text" placeholder="Final date time" class="form-control datetimepicker-input" data-js="schedule-inp-date-final" id="scheduleInpDateFinal" data-toggle="datetimepicker" data-target="#scheduleInpDateFinal"/>
                  <div class="invalid-feedback">
                      You need set the final time.
                  </div>
              </div>
              <div class="form-group">
                  <label>Observation</label>
                  <input type="text" class="form-control schedule-input" placeholder="Observation" data-js="schedule-inp-obs">
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-js="schedule-dialog-del">Delete Schedule</button>
        <button type="button" class="btn btn-primary" data-js="schedule-dialog-add">Add Schedule</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Moment -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<!-- Full Calendar -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.1/dist/fullcalendar.min.css" integrity="sha256-tXJP+v7nTXzBaEuLtVup1zxWFRV2jyVemY+Ir6/CTQU=" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.1/dist/fullcalendar.min.js" integrity="sha256-O04jvi1wzlLxXK6xi8spqNTjX8XuHsEOfaBRbbfUbJI=" crossorigin="anonymous"></script>

<!-- DateTimePicker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/locales/en-gb.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />

<!-- Ruels Form -->
<script src='res/site/js/controller/schedule.js'></script>