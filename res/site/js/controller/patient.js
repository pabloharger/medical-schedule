(function(){
  'use strinct';

  var appPatient = (function appPatientController(){
    var appDescription = 'Patient';
    var $selPatient = $('[data-js="patient-sel-patient"]');
    var $btnSave = $('[data-js="patient-btn-save"]');
    var $btnNew  = $('[data-js="patient-btn-new"]');
    var $btnDel = $('[data-js="patient-btn-del"]');
    var $btnCls = $('[data-js="patient-btn-clear"]');
    var $formMain = $('[data-js="patient-form-main"]');

    var $inpFirstName = $('[data-js="patient-inp-first-name"]');
    var $inpLastName = $('[data-js="patient-inp-last-name"]');
    var $inpDocNumber = $('[data-js="patient-inp-doc-number"]');
    var $inpPhoneNumber = $('[data-js="patient-inp-phone-number"]');
    var $npnMobilePhoneNumber = $('[data-js="patient-inp-mobile-number"]');
    var $npnEmail = $('[data-js="patient-inp-email"]');
    var $npnAddress = $('[data-js="patient-inp-address"]');
    var $npnCity = $('[data-js="patient-inp-city"]');
    var $npnState = $('[data-js="patient-inp-state"]');
    var $npnZipCode = $('[data-js="patient-inp-zip-code"]');

    function init(){
      initComponents();
      initEvents();
      clearControls();
      addShortCut();
      $selPatient.focus();
    }

    function initComponents(){
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
        width: '100%'
      });
    }

    function addShortCut(){
      utilForm.addCtrlShortCutArr($btnSave, 'S', false, savePatient);
      utilForm.addCtrlShortCutArr($btnNew, 'N', false, newPatient);
      utilForm.addCtrlShortCutArr($btnCls, 'L', false, clearControls);
      utilForm.addCtrlShortCutArr($btnDel, 'D', false, deletePatient);
    }

    function initEvents(){
      $btnNew.on('click', newPatient);
      $btnSave.on('click', savePatient);
      $btnDel.on('click', deletePatient);
      $btnCls.on('click', clearControls);
      $selPatient.on('select2:select', findPatient);
    }

    function clearControls(){
      $selPatient.val(null).trigger('change');
      $('.patient-input').val('');
      enableControls(false, false);
      $formMain.find('.is-invalid').removeClass('is-invalid');
    }

    function enableControls(enable, newRegister){
      $('.patient-input').prop('disabled', !enable);
      $selPatient.prop('disabled', enable);
      $btnSave.prop('disabled', !enable);
      $btnNew.prop('disabled', enable);
      $btnDel.prop('disabled', !enable);
      if (newRegister) $btnDel.prop('disabled', true);
      enable ? $inpFirstName.focus() : $selPatient.focus();
    }

    function newPatient(){
      clearControls();
      enableControls(true, true);
    }

    function validateFirstName(){
      if ($inpFirstName.val().trim() === '') {
        utilDOM.addClassIfNotExists($inpFirstName, 'is-invalid');
        return false;
      }
      $inpFirstName.removeClass('is-invalid');
      return true;
    }

    function validateLastName(){
      if ($inpLastName.val().trim() === '') {
        utilDOM.addClassIfNotExists($inpLastName, 'is-invalid');
        return false;
      }
      $inpLastName.removeClass('is-invalid');
      return true;
    }

    function validateForm(){
      let valid = validateFirstName()
      valid = validateLastName() && valid;
      return valid;
    }

    function savePatient(){
      const callBack = (data) => {
        var result = JSON.parse(data);
        if (result.code === 0) {
          //loading_off();
          util.message(appDescription, result.message);
          setSelectPatient(result.id, $inpFirstName.val());
          enableControls(true, false);
        } else {
          //loading_off();
          util.message(appDescription, result.message);
        }
      }

      //loading_on();
      if (validateForm()){
        $route = '/patient/';
        $method = 'POST';

        if ($selPatient.val() > 0) {
          $route += $selPatient.val();
          $method = 'PUT';
        }

        $.ajax({
          url: $route,
          type: $method,
          data: {
            id : Number($selPatient.val()),
            firstName : $inpFirstName.val(),
            lastName : $inpLastName.val(),
            docNumber : $inpDocNumber.val(),
            phoneNumber : $inpPhoneNumber.val(),
            mobileNumber : $npnMobilePhoneNumber.val(),
            email : $npnEmail.val(),
            address : $npnAddress.val(),
            city : $npnCity.val(),
            state : $npnState.val(),
            zipCode : $npnZipCode.val()
          },
          success: callBack,
          error: callBack
        });
      } else {
        utilForm.focusInvalidElement($formMain);
      }
    }

    function deletePatient(){
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

      if (confirm('Are you sure delete the patient?')){
        //loading_on();
        $.ajax({
          url: '/patient/' + Number($selPatient.val()),
          type: 'DELETE',
          success: callBack,
          error: callBack
        });
      }
    }

    function findPatient(){
      var idPatient = Number($selPatient.val());
      //loading_on();
      $.get(
        '/patient/' + idPatient,
        function(data) {
          var result = JSON.parse(data);
          if (result.code === 0) {
            $inpFirstName.val(result.firstName);
            $inpLastName.val(result.lastName);
            $inpDocNumber.val(result.docNumber);
            $inpPhoneNumber.val(result.phoneNumber);
            $npnMobilePhoneNumber .val(result.mobileNumber);
            $npnEmail .val(result.email);
            $npnAddress.val(result.address);
            $npnCity .val(result.city);
            $npnState .val(result.state);
            $npnZipCode .val(result.zipCode);
            
            enableControls(true, false);
          } else {
            //loading_off();
            util.message(appDescription, result.message);
          }
          //loading_off();
        }
      );
    }

    function setSelectPatient(id, name){
      utilForm.setSelect2($selPatient, id, name);
    }

    return {
      init: init
    }
  })();

  appPatient.init();

})();