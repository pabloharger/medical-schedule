(function(){
  var appSchedule = (function scheduleController(){
    var appDescription = 'Patient';
    var $schedule = $('[data-js="schedule-schedule"]');
    var $scheduleDialog = $('[data-js="schedule-dialog"]');
    var $inpId = $('[data-js="schedule-inp-id"]');
    var $selDentist = $('[data-js="schedule-sel-dentist"]');
    var $selPatient = $('[data-js="schedule-sel-patient"]');
    var $inpTimeInit = $('[data-js="schedule-inp-date-initial"]');
    var $inpTimeFinal = $('[data-js="schedule-inp-date-final"]');
    var $inpObservation = $('[data-js="schedule-inp-obs"]');
    var $formAdd = $('[data-js="schedule-form-add"]');
    var $btnDel = $('[data-js="schedule-dialog-del"]');

    function init(){
      initComponents();
      initEvents();
      clearDialog();
      fillCalendar();
    }

    function initComponents(){
      var date = new Date();

      $schedule.fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        allDaySlot: false,
        defaultView:'agendaWeek',
        editable: true,
        eventClick: scheduleClickHandler,
        eventResize: scheduleRedizeHandler,
        eventDrop: scheduleEventDropHandler,
        dayClick: scheduleDayClickHandler
      });

			$selDentist.select2({
				ajax: {
					type : "POST",
					url : "/lockup/dentist",
					dataType : 'json',
					delay : 250,
					data : 
						function (params) {
							return {
									q : params.term,
									page : params.page,
								};
							},
					processResults: function (data, params) {
						params.page = params.page || 1;

						return {
							results : data.items,
							pagination: {
								more: (params.page * 30) < data.total_count
							}
						};
					},
					cache: true
				},
				escapeMarkup: function (markup) { return markup; },
				minimumInputLength: 1,
        width: '100%',
        placeholder: 'Select a Dentist...'
      }).on("select2:opening", 
        function(){
          $scheduleDialog.removeAttr("tabindex", "-1");
      }).on("select2:close", 
        function(){ 
          $scheduleDialog.attr("tabindex", "-1");
        }
      );

			$selPatient.select2({
				ajax: {
					type : "POST",
          url : "/lockup/patient",
					dataType : 'json',
					delay : 250,
					data : 
						function (params) {
							return {
									q : params.term,
									page : params.page
								};
							},
					processResults: function (data, params) {
						params.page = params.page || 1;

						return {
							results : data.items,
							pagination: {
								more: (params.page * 30) < data.total_count
							}
						};
					},
					cache: true
				},
				escapeMarkup: function (markup) { return markup; },
				minimumInputLength: 1,
        width: '100%',
        placeholder: 'Select a patient...'
      }).on("select2:opening", 
        function(){
          $scheduleDialog.removeAttr("tabindex", "-1");
      }).on("select2:close", 
        function(){ 
          $scheduleDialog.attr("tabindex", "-1");
        }
      );

      $inpTimeInit.datetimepicker({
        format: 'dd/mm/yyyy hh:ii',
        autoclose: true,
        todayBtn: true,
        readOnly: true
      });

      $inpTimeFinal.datetimepicker({
        format: 'dd/mm/yyyy hh:ii',
        autoclose: true,
        todayBtn: true
      });
    }

    function initEvents(){
      $('[data-js="schedule-dialog-add"]').on('click', addDialog);
      $btnDel.on('click', delDialog);
    }

    function addDialog(){
      if (validateData()){
        addSchedule();
      } else {
        utilForm.focusInvalidElement($formAdd);
      }
    }

    function delDialog(){
      if (confirm('Are you sure?')) {
        $.post( 
          'schedule/delete',
          {
            id : Number($inpId.val())
          },
          function( data ) {
            var result = JSON.parse(data);

            $scheduleDialog.modal('hide');

            if (result.code === 0) {
              $schedule.fullCalendar('removeEvents', [ Number( $inpId.val() ) ] );
            }

            util.message(appDescription, result.message, 1);
          });

      }
    }

    function validateDentist(){
      if (Number($selDentist.val()) === 0){
        utilDOM.addClassIfNotExists($selDentist, 'is-invalid');
        return false;
      }
      
      $selDentist.removeClass('is-invalid');
      return true;
    }

    function validatePatient(){
      if (Number($selPatient.val()) === 0){
        utilDOM.addClassIfNotExists($selPatient, 'is-invalid');
        return false;
      }
      
      $selPatient.removeClass('is-invalid');
      return true;
    }
    
    function validateTimeInitial(){
      if ($inpTimeInit.val() === ''){
        utilDOM.addClassIfNotExists($inpTimeInit, 'is-invalid');
        return false;
      }

      $inpTimeInit.removeClass('is-invalid');
      return true;
    }
    
    function validateTimeFinal(){
      if ($inpTimeFinal.val() === ''){
        $inpTimeFinal.parent().find('.invalid-feedback').html("You need set the final time.");
        utilDOM.addClassIfNotExists($inpTimeFinal, 'is-invalid');
        return false
      } 
        
      if (($inpTimeInit.val() !== '') && ($inpTimeInit.val() >= $inpTimeFinal.val())){  
        utilDOM.addClassIfNotExists($inpTimeFinal, 'is-invalid');
        if ($inpTimeFinal.parent().find('.invalid-feedback') !== undefined)
          $inpTimeFinal.parent().find('.invalid-feedback').html("Final date can not be greater than the starting date");
        return false;
      }

      $inpTimeFinal.removeClass('is-invalid');
      return true;
    }

    function validateData(){
      var validate = validateDentist();
      validate = validatePatient() && validate;
      validate = validateTimeInitial () && validateTimeFinal() && validate;

      return validate;
    }

    function addSchedule(){
      $.post( 
        'schedule/save',
        {
          id : Number($inpId.val()),
          id_dentist : $selDentist.val(),
          id_patient : $selPatient.val(),
          date_time_begin : utilMoment.getInternalFormatedDateTime($inpTimeInit.val()),
          date_time_end : utilMoment.getInternalFormatedDateTime($inpTimeFinal.val()),
          observation : $inpObservation.val().trim()
        },
        function( data ) {
          var result = JSON.parse(data);
          if (result.code === 0) {
            //loading_off();
            $inpId.val(result.id);
            addCalendarSchedule(
              Number($inpId.val()),
              $selDentist.children()[0].innerText,
              $selPatient.children()[0].innerText,
              utilMoment.getInternalFormatedDateTime($inpTimeInit.val()),
              utilMoment.getInternalFormatedDateTime($inpTimeFinal.val()),
              $inpObservation.val().trim()
            );
            $scheduleDialog.modal('hide');
            //clearDialog();
          } else {
            //loading_off();
            util.message(appDescription, result.message, 1);
          }
        }
      );
    }

    function fillCalendar(){
      $.post( 
        'schedule/get',
        function( data ) {
          var result = JSON.parse(data);
          //loading_off();
          result.forEach(function(curVal){
            addCalendarSchedule(
              Number(curVal.id),
              curVal.name_dentist,
              curVal.name_patient,
              curVal.date_time_begin,
              curVal.date_time_end,
              curVal.observation
            );
          });
        }
      );
    }

    function addCalendarSchedule(id, nameDentist, namePatient, start, end, observation){
      $schedule.fullCalendar('removeEvents', [ Number( $inpId.val() ) ] );
      $schedule.fullCalendar(
        'addEventSource',
        [
          {
            id : id,
            title : 
              'Dr. ' + nameDentist + '\n' + 
              namePatient  + '\n' + 
              observation,
            start : start,
            end : end
          }
        ]
      );
    }

    function scheduleDayClickHandler(date, jsEvent, view) {
      clearDialog();
      $btnDel.hide();
      $scheduleDialog.modal();
    }

    function clearDialog(){
      $('.schedule-input').val('');
      $formAdd.find('.is-invalid').removeClass('is-invalid');
      $selPatient.val(null).trigger('change'); 
    }

    function scheduleClickHandler(calEvent){
      fillDialog(calEvent.id);
      $btnDel.show();
      $scheduleDialog.modal();
    }

    function fillDialog(id){
      $.post( 
        'schedule/get',
        {
          id : id,
        },
        function( data ) {
          var result = JSON.parse(data);
          if (result.length > 0) {
            result = result[0];
            //loading_off();
            $inpId.val(result.id);
            utilForm.setSelect2($selDentist, result.id_dentist, result.name_dentist);
            utilForm.setSelect2($selPatient, result.id_patient, result.name_patient);
            $inpTimeInit.val(utilMoment.getInterfaceFormatedDateTime(result.date_time_begin));
            $inpTimeFinal.val(utilMoment.getInterfaceFormatedDateTime(result.date_time_end));
            $inpObservation.val(result.observation);
            $scheduleDialog.modal();
            //clearDialog();
          } else {
            //loading_off();
            util.message(appDescription, result.message, 1);
          }
        }
      );
    }

    function scheduleRedizeHandler(event){
      refreshSchedule(event.id, event.start.format(), event.end.format());
    }

    function scheduleEventDropHandler(event){
      refreshSchedule(event.id, event.start.format(), event.end.format());
    }

    function refreshSchedule($id, $initDateTime, $finalDateTime){
      $.post( 
        'schedule/refresh',
        {
          id : Number($id),
          date_time_begin : $initDateTime,
          date_time_end : $finalDateTime
        },
        function( data ) {
          var result = JSON.parse(data);
          if (result.code > 0) {
            //loading_off();
            util.message(appDescription, result.message, 1);
          }
        }
      );
    }

    return {
      init: init
    }
  })();

  appSchedule.init();
})();