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
        
        var $inpName = $('[data-js="patient-inp-name"]');;
        var $inpDocNumber = $('[data-js="patient-inp-doc-number"]');;
        var $inpPhoneNumber = $('[data-js="patient-inp-phone-number"]');
        var $npnCellPhoneNumber = $('[data-js="patient-inp-cell-phone-number"]');
        var $npnEmail = $('[data-js="patient-inp-email"]');
        var $npnStreet = $('[data-js="patient-inp-street"]');
        var $npnStreetNumber = $('[data-js="patient-inp-number"]');
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
            if (newRegister)
				$btnDel.prop('disabled', true);
			enable ? $inpName.focus() : $selPatient.focus();
        }

        function newPatient(){
            clearControls();
            enableControls(true, true);
		}
		
		function validateName(){
			if ($inpName.val().trim() === '') {
				utilDOM.addClassIfNotExists($inpName, 'is-invalid');
				return false;
			}
			$inpName.removeClass('is-invalid');
			return true;
		}

		function validateForm(){
			return validateName();
		}

        function savePatient(){
			//loading_on();
			if (validateForm()){
				$.post( 
					'/patient/save',
					{
						id_patient : Number($selPatient.val()),
						name : $inpName.val(),
                        doc_number : $inpDocNumber.val(),
                        telephone : $inpPhoneNumber.val(),
                        cellphone : $npnCellPhoneNumber.val(),
                        email : $npnEmail.val(),
                        street : $npnStreet.val(),
                        street_number : $npnStreetNumber.val(),
                        city : $npnCity.val(),
                        state : $npnState.val(),
                        zipcode : $npnZipCode.val()
                    },
					function( data ) {
						var result = JSON.parse(data);
						if (result.code === 0) {
                            //loading_off();
							util.message(appDescription, result.message, 0);
							setSelectPatient(result.id_patient, $inpName.val());
							enableControls(true, false);
						} else {
							//loading_off();
							util.message(appDescription, result.message, 1);
						}
					}
				);
			} else {
				utilForm.focusInvalidElement($formMain);
			}
        }

        function deletePatient(){
			if (confirm('Are you sure delete the patient?')){
				//loading_on();
				$.post(
					'/patient/delete',
					{
						id_patient : Number($selPatient.val())
					},
					function( data ) {
						var result = JSON.parse(data);
						if (result.code === 0) {
							//loading_off();
							clearControls();
							util.message(appDescription, result.message, 0);
						} else {
							//loading_off();
							util.message(appDescription, result.message, 1);
						}
					}
				);
			}
        }

        function findPatient(){
            var idPatient = Number($selPatient.val());
            
            if (idPatient === 0){
                util.message(appDescription, "You didn't select a patient!");
			} else {
				//loading_on();
				$.post(
					'/patient/find',
					{
						id_patient : idPatient
					},
					function( data ) {
                        var result = JSON.parse(data);
						if (result.code === 0) {
							$inpName.val(result.name);
                            $inpDocNumber.val(result.doc_number);
                            $inpPhoneNumber.val(result.phone_number);
                            $npnCellPhoneNumber .val(result.cell_phone_number);
                            $npnEmail .val(result.email);
                            $npnStreet.val(result.street);
                            $npnStreetNumber.val(result.street_number);
                            $npnCity .val(result.city);
                            $npnState .val(result.state);
                            $npnZipCode .val(result.zipcode);
							enableControls(true, false);
						} else {
							//loading_off();
							util.message(appDescription, result.message, 1);
						}
						//loading_off();
					}
				);
			}
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