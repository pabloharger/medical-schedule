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
                    <input class="form-control" data-js="schedule-inp-date-initial">
                    <div class="invalid-feedback">
                        You need set the initial time.
                    </div>
                </div>
                <div class="form-group">
                    <label>End Time</label>
                    <input class="form-control" data-js="schedule-inp-date-final">
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
<script src="res/site/components/moment/moment.min.js"></script>

<!-- Full Calendar -->
<link href="res/site/components/fullcalendar/fullcalendar.min.css" rel="stylesheet"></link>
<script src="res/site/components/fullcalendar/fullcalendar.min.js"></script>

<!-- DateTimePicker -->
<script src="res/site/components/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<link href="res/site/components/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet"></link>

<!-- Ruels Form -->
<script src='res/site/js/controller/schedule.js'></script>