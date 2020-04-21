(function(){
  'use strinct';

  var appDentist = (function appDentistController(){
    var appDescription = 'Dentist';
    var $selDentist = $('[data-js="dentist-sel-dentist"]');
    var $btnSave = $('[data-js="dentist-btn-save"]');
    var $btnNew  = $('[data-js="dentist-btn-new"]');
    var $btnDel = $('[data-js="dentist-btn-del"]');
    var $btnCls = $('[data-js="dentist-btn-clear"]');
    var $formMain = $('[data-js="dentist-form-main"]');

    var $inpFirstName = $('[data-js="dentist-inp-firstName"]');
    var $inpLastName = $('[data-js="dentist-inp-lastName"]');
    var $inpDocNumber = $('[data-js="dentist-inp-doc-number"]');

    function init(){
      initComponents();
      initEvents();
      clearControls();
      addShortCut();
    }

    function initComponents(){
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
      utilForm.addCtrlShortCutArr($btnSave, 'S', false, saveDentist);
      utilForm.addCtrlShortCutArr($btnNew, 'N', false, newDentist);
      utilForm.addCtrlShortCutArr($btnCls, 'L', false, clearControls);
      utilForm.addCtrlShortCutArr($btnDel, 'D', false, deleteDentist);
    }

    function initEvents(){
      $btnNew.on('click', newDentist);
      $btnSave.on('click', saveDentist);
      $btnDel.on('click', deleteDentist);
      $btnCls.on('click', clearControls);
      $selDentist.on('select2:select', findDentist);
    }

    function clearControls(){
      $selDentist.val(null).trigger('change');
      $('.dentist-input').val('');
      $formMain.find('.is-invalid').removeClass('is-invalid');
      enableControls(false, false);
    }

    function enableControls(enable, newRegister){
      $('.dentist-input').prop('disabled', !enable);
      $selDentist.prop('disabled', enable);
      $btnSave.prop('disabled', !enable);
      $btnNew.prop('disabled', enable);
      $btnDel.prop('disabled', !enable);
      if (newRegister) $btnDel.prop('disabled', true);
      enable ? $inpFirstName.focus() : $selDentist.focus();
    }

    function newDentist(){
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
      return validateFirstName() && validateLastName();
    }

    function saveDentist(){

      const callBack = (data) => {
        var result = JSON.parse(data);
        if (result.code === 0) {
          //loading_off();
          util.message(appDescription, result.message);
          setSelectDentist(result.id, $inpFirstName.val());
          enableControls(true, false);
        } else {
          //loading_off();
          util.message(appDescription, result.message);
        }
      }

    //loading_on();
      if (validateForm()){
        $route = '/dentist/';
        $method = 'POST';

        if ($selDentist.val() > 0) {
          $route += $selDentist.val();
          $method = 'PUT';
        }

        $.ajax({
          url: $route,
          type: $method,
          data: {
            id: $selDentist.val(),
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

    function deleteDentist(){
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

      if (confirm('Are you sure delete the dentist?')){
        //loading_on();
        $.ajax({
          url: '/dentist/' + Number($selDentist.val()),
          type: 'DELETE',
          success: callBack,
          error: callBack
        });
      }
    }

    function findDentist(){
      var idDentist = Number($selDentist.val());
      
      //loading_on();
      $.get(
        '/dentist/' + idDentist,
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

    function setSelectDentist(id, name){
      utilForm.setSelect2($selDentist, id, name);
    }

    return {
      init: init,
      formMain: $formMain
    }
  })();

  appDentist.init();
  window.appDentist = appDentist;
})();