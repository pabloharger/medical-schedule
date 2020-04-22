(function(){
  'use strinct';

  var appDoctor = (function appDoctorController(){
    var appDescription = 'Doctor';
    var $selDoctor = $('[data-js="doctor-sel-doctor"]');
    var $btnSave = $('[data-js="doctor-btn-save"]');
    var $btnNew  = $('[data-js="doctor-btn-new"]');
    var $btnDel = $('[data-js="doctor-btn-del"]');
    var $btnCls = $('[data-js="doctor-btn-clear"]');
    var $formMain = $('[data-js="doctor-form-main"]');

    var $inpFirstName = $('[data-js="doctor-inp-firstName"]');
    var $inpLastName = $('[data-js="doctor-inp-lastName"]');
    var $inpDocNumber = $('[data-js="doctor-inp-doc-number"]');

    function init(){
      initComponents();
      initEvents();
      clearControls();
      addShortCut();
    }

    function initComponents(){
      $selDoctor.select2({
        ajax: {
          type : "GET",
          url : "/lockup/doctor",
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
              pagination: { more: (params.page * 30) < data.total_count }
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; },
        minimumInputLength: 1,
        width: '100%'
      });
    }

    function addShortCut(){
      utilForm.addCtrlShortCutArr($btnSave, 'S', false, saveDoctor);
      utilForm.addCtrlShortCutArr($btnNew, 'N', false, newDoctor);
      utilForm.addCtrlShortCutArr($btnCls, 'L', false, clearControls);
      utilForm.addCtrlShortCutArr($btnDel, 'D', false, deleteDoctor);
    }

    function initEvents(){
      $btnNew.on('click', newDoctor);
      $btnSave.on('click', saveDoctor);
      $btnDel.on('click', deleteDoctor);
      $btnCls.on('click', clearControls);
      $selDoctor.on('select2:select', findDoctor);
    }

    function clearControls(){
      $selDoctor.val(null).trigger('change');
      $('.doctor-input').val('');
      $formMain.find('.is-invalid').removeClass('is-invalid');
      enableControls(false, false);
    }

    function enableControls(enable, newRegister){
      $('.doctor-input').prop('disabled', !enable);
      $selDoctor.prop('disabled', enable);
      $btnSave.prop('disabled', !enable);
      $btnNew.prop('disabled', enable);
      $btnDel.prop('disabled', !enable);
      if (newRegister) $btnDel.prop('disabled', true);
      enable ? $inpFirstName.focus() : $selDoctor.focus();
    }

    function newDoctor(){
      clearControls();
      enableControls(true, true);
    }

    function validateFirstName(){
      if ($inpFirstName.val().trim() === '') {
        utilDOM.addClassIfNotExists($inpFirstName, 'is-invalid');
        return false;
      } else {
        $inpFirstName.removeClass('is-invalid');
        return true;
      }
    }

    function validateLastName(){
      if ($inpLastName.val().trim() === '') {
        utilDOM.addClassIfNotExists($inpLastName, 'is-invalid');
        return false;
      } else {
        $inpLastName.removeClass('is-invalid');
        return true;
      }
    }

    function validateForm(){
      let valid = validateFirstName()
      valid = validateLastName() && valid;
      return valid;
    }

    function saveDoctor(){

      const callBack = (data) => {
        var result = JSON.parse(data);
        if (result.code === 0) {
          //loading_off();
          util.message(appDescription, result.message);
          setSelectDoctor(result.id, $inpFirstName.val());
          enableControls(true, false);
        } else {
          //loading_off();
          util.message(appDescription, result.message);
        }
      }

    //loading_on();
      if (validateForm()){
        $route = '/doctor/';
        $method = 'POST';

        if ($selDoctor.val() > 0) {
          $route += $selDoctor.val();
          $method = 'PUT';
        }

        $.ajax({
          url: $route,
          type: $method,
          data: {
            id: $selDoctor.val(),
            firstName : $inpFirstName.val(),
            lastName: $inpLastName.val(),
            docNumber : $inpDocNumber.val()},
          success: callBack,
          error: callBack
        });
      } else {
        utilForm.focusInvalidElement($formMain);
      }
    }

    function deleteDoctor(){
      const callBack = (data) => {
        var result = JSON.parse(data);
        if (result.code === 0) {
          //loading_off();
          clearControls();
          util.message(appDescription, result.message);
        } else {
          //loading_off();
          util.message(appDescription, result.message);
        }
      }

      if (confirm('Are you sure delete the doctor?')){
        //loading_on();
        $.ajax({
          url: '/doctor/' + Number($selDoctor.val()),
          type: 'DELETE',
          success: callBack,
          error: callBack
        });
      }
    }

    function findDoctor(){
      var idDoctor = Number($selDoctor.val());
      
      //loading_on();
      $.get(
        '/doctor/' + idDoctor,
        function(data) {
          var result = JSON.parse(data);
          if (result.code === 0) {
            $inpFirstName.val(result.firstName);
            $inpLastName.val(result.lastName);
            $inpDocNumber.val(result.docNumber);
            enableControls(true, false);
          } else {
            //loading_off();
            util.message(appDescription, result.message);
          }
          //loading_off();
        }
      );
    }

    function setSelectDoctor(id, name){
      utilForm.setSelect2($selDoctor, id, name);
    }

    return {
      init: init,
      formMain: $formMain
    }
  })();

  appDoctor.init();
  window.appDoctor = appDoctor;
})();