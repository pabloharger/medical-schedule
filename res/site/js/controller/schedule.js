(function(){
  var appSchedule = (function scheduleController(){
    var appDescription = 'Schedule';
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
        titleFormat: 'DD/MM/YYYY',
        columnHeaderFormat: 'DD/MM',
        eventClick: scheduleClickHandler,
        eventResize: scheduleResizeHandler,
        eventDrop: scheduleEventDropHandler,
        dayClick: scheduleDayClickHandler,
        events: fillCalendar,
        locale: utilCookie.getCookie('langInitials')
      });

      $selDentist.select2({
        ajax: {
          type : "GET",
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
          type : "GET",
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
      }).on("select2:opening", 
        function(){
          $scheduleDialog.removeAttr("tabindex", "-1");
      }).on("select2:close", 
        function(){ 
          $scheduleDialog.attr("tabindex", "-1");
        }
      );

      // $selDentist.select2.defaults.set('language', utilCookie.getCookie('langInitials'));
      // $selPatient.select2.defaults.set('language', utilCookie.getCookie('langInitials'));

      $inpTimeInit.datetimepicker({format: 'DD/MM/YYYY HH:mm'});
      $inpTimeFinal.datetimepicker({format: 'DD/MM/YYYY HH:mm'});
    }

    function initEvents(){
      $('[data-js="schedule-dialog-add"]').on('click', addDialog);
      $btnDel.on('click', delDialog);
    }

    function addDialog(){
      if (validateData()){
        addSchedule();
        clearDialog();
      } else {
        utilForm.focusInvalidElement($formAdd);
      }
    }

    function delDialog(){
      const callBack = (data) => {
        var result = JSON.parse(data);
        $scheduleDialog.modal('hide');
        if (result.code === 0) {
          $schedule.fullCalendar('removeEvents', [ Number( $inpId.val() ) ] );
        }
        util.message(appDescription, result.message);
      }

      if (confirm('Are you sure?')) {
        $.ajax({
          url: '/schedule/' + Number($inpId.val()),
          type: 'DELETE',
          success: callBack,
          error: callBack
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
        utilDOM.addClassIfNotExists($inpTimeFinal, 'is-invalid');
        return false
      } 

      if (($inpTimeInit.val() !== '') && ($inpTimeInit.val() >= $inpTimeFinal.val())){  
        utilDOM.addInvalidFeedback($inpTimeFinal, "Final date can not be greater than the starting date", "is-invalid");
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
      const callBack = (data) => {
        var result = JSON.parse(data);
        if (result.code === 0) {
          //loading_off();
          $inpId.val(result.id);
          addCalendarSchedule({
            id: result.id,
            dentist: {
              firstName: result.dentist.firstName
            },
            patient: {
              firstName: result.patient.firstName
            },
            dateTimeBegin: result.dateTimeBegin,
            dateTimeEnd: result.dateTimeEnd,
            observation: result.observation
          });

          $scheduleDialog.modal('hide');
          //clearDialog();
        } else {
          //loading_off();
          util.message(appDescription, result.message);
        }
      }
      $route = '/schedule/';
      $method = 'POST';

      if (Number($inpId.val()) > 0) {
        $route += Number($inpId.val());
        $method = 'PUT';
      }

      $.ajax({
        url: $route,
        type: $method,
        data: {
          id : Number($inpId.val()),
          idDentist : $selDentist.val(),
          idPatient : $selPatient.val(),
          dateTimeBegin : utilMoment.getInternalFormatedDateTime($inpTimeInit.val()),
          dateTimeEnd : utilMoment.getInternalFormatedDateTime($inpTimeFinal.val()),
          observation : $inpObservation.val().trim()
        },
        success: callBack,
        error: callBack
      });
    }

    function fillCalendar(start, end, timezone, callback){
        $.get({
          url: '/schedule/',
          data: {
            dateTimeStart: utilMoment.getInternalFormatedDateTime(start),
            dateTimeEnd: utilMoment.getInternalFormatedDateTime(end)
          },
          dataType: 'json',
          success: (data) => {
            $events = Array.prototype.map.call(data, function(item){
              return formatEvent(item);
            })
            callback($events);
          }
        });
    }

    function formatEvent(event) {
      return {
          id : event.id,
          title : 
            'Dr. ' + event.dentist.firstName + '\n' +
            event.patient.firstName  + '\n' +
            (event.observation === null ? '': event.observation),
          start : event.dateTimeBegin,
          end : event.dateTimeEnd
        };
    }

    function addCalendarSchedule(event){
      $schedule.fullCalendar('removeEvents', [ Number( $inpId.val() ) ] );
      $schedule.fullCalendar(
        'addEventSource',
        [formatEvent(event)]
      );
    }

    function scheduleDayClickHandler(date, jsEvent, view) {
      clearDialog();

      $inpTimeInit.val(utilMoment.getInterfaceFormatedDateTime(date));
      $inpTimeFinal.val(utilMoment.getInterfaceFormatedDateTime(date));

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
      $.get( 
        '/schedule/' + id,
        function( data ) {
          var result = JSON.parse(data);
          if (result.code == 0) {
            //loading_off();
            $inpId.val(result.id);
            utilForm.setSelect2($selDentist, result.dentist.id, result.dentist.firstName);
            utilForm.setSelect2($selPatient, result.patient.id, result.patient.firstName);
            $inpTimeInit.val(utilMoment.getInterfaceFormatedDateTime(result.dateTimeBegin));
            $inpTimeFinal.val(utilMoment.getInterfaceFormatedDateTime(result.dateTimeEnd));
            $inpObservation.val((result.observation == null ? '' : result.observation));
            $scheduleDialog.modal();
            //clearDialog();
          } else {
            //loading_off();
            util.message(appDescription, result.message);
          }
        }
      );
    }

    function scheduleResizeHandler(event){
      refreshSchedule(event.id, event.start.format(), event.end.format());
    }

    function scheduleEventDropHandler(event){
      refreshSchedule(event.id, event.start.format(), event.end.format());
    }

    function refreshSchedule($id, $initDateTime, $finalDateTime){
      const callBack = (data) => {
        var result = JSON.parse(data);
        if (result.code > 0) util.message(appDescription, result.message);
      }

      $.ajax({
        url: '/schedule/' + Number($id),
        type: 'PUT',
        data: {
          id : Number($id),
          dateTimeBegin : utilMoment.getInternalFormatedDateTimeFromCallendar($initDateTime),
          dateTimeEnd : utilMoment.getInternalFormatedDateTimeFromCallendar($finalDateTime)
        },
        success: callBack,
        error: callBack
      });
    }

    return {
      init: init
    }
  })();

  appSchedule.init();
})();