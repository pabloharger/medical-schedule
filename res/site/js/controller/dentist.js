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

        var $inpName = $('[data-js="dentist-inp-name"]');
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
					type : "POST",
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
				placeholder: 'Select a dentist...'
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
            if (newRegister)
				$btnDel.prop('disabled', true);
			enable ? $inpName.focus() : $selDentist.focus();
        }

        function newDentist(){
            clearControls();
            enableControls(true, true);
		}

		function validateName(){
			if ($inpName.val().trim() === '') {
				utilDOM.addClassIfNotExists($inpName, 'is-invalid');
				return false;
			} else {
				$inpName.removeClass('is-invalid');
				return true;
			}
		}

		function validateForm(){
			return validateName();
		}

        function saveDentist(){
			//loading_on();

			if (validateForm()){
				$.post( 
					'/dentist/save',
					{
						id_dentist : Number($selDentist.val()),
						name : $inpName.val(),
						doc_number : $inpDocNumber.val()
					},
					function( data ) {
						var result = JSON.parse(data);
						if (result.code === 0) {
                            //loading_off();
							util.message(appDescription, result.message, 0);
							setSelectDentist(result.id_dentist, $inpName.val());
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

        function deleteDentist(){
			if (confirm('Are you sure delete the dentist?')){
				//loading_on();
				$.post(
					'/dentist/delete',
					{
						id_dentist : Number($selDentist.val())
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

        function findDentist(){
            var idDentist = Number($selDentist.val());
            
            if (idDentist === 0){
                util.message(appDescription, "You didn't select a dentist!");
			} else {
				//loading_on();
				$.post(
					//'controller/dentist.php',
					'/dentist/find',
					{
						id_dentist : idDentist
					},
					function( data ) {
                        var result = JSON.parse(data);
						if (result.code === 0) {
							$inpName.val(result.name)
							$inpDocNumber.val(result.doc_number);
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