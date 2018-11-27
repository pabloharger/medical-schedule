(function(w){
    'use strinct';



    var util = (function utilController(){
        return {
            message: function message(title, message, type){
                $.prompt(message,{ 
                    buttons:{'Close':true},
                    title: title,
                    buttonClose: false,
                    close: function(e,v,m,f){}
                });
            }
        }
    })();

    var utilDOM = (function utilDOMController(){
        return {
            addClassIfNotExists: function addClassIfNotExists(elem, addClass){
                if (!elem.hasClass(addClass))
                    elem.addClass(addClass);
            }
        }
    })();

    var utilForm = (function utilFormController(){

        function addShortCut(shortcut, propagate, callBack){
            w.shortcut.add(
                shortcut,
                callBack,
                { 
                    'type':'keydown',
                    'propagate':propagate,
                    'target':document
                }
            );
        }

        function addCtrlShortCutGen(key, propagate, callBack){
            addShortCut(
                'Meta+' + key.toUpperCase(),
                propagate,
                callBack
            );
            addShortCut(
                'Ctrl+' + key,
                propagate,
                callBack
            );
        }

        return {
            addCtrlShortCutArr: function addCtrlShortCut2(element, key, propagate, callBack){    
                addCtrlShortCutGen(key, propagate, function(){
                    if (!element.prop('disabled')){
                        callBack();
                    }
                })
            },
            focusInvalidElement: function focusInvalidElement(elem){
                var elementFocus = elem.find('.is-invalid');
                if (elementFocus.length > 0)
                    $(elem.find('.is-invalid')[0]).focus();
            },
            setSelect2 : function setSelect2(select, id, placeholder){
                if (id === undefined)
                    var id = 0;
                if (placeholder === undefined)
                    var placeholder = '';
                select.children().remove();
                select.append('<option value="' + id + '">' + placeholder + '</option>');	
            }
        }
    })();

    var utilMoment = (function utilMomentController(){
        return {
            getInternalFormatedDateTime: function getInternalFormatedDateTime(date){
                return moment(date, 'DD/MM/YYYY HH:mm:SS').format('YYYY-MM-DD HH:mm:ss');
            },
            getInterfaceFormatedDateTime: function getInternalFormatedDateTime(date){
                return moment(date, 'YYYY-MM-DD HH:mm:ss').format('DD/MM/YYYY HH:mm:SS');
            }
        }
    })();
    
    window.util = util;
    window.utilDOM = utilDOM ;
    window.utilMoment = utilMoment;
    window.utilForm = utilForm;
    window.utilMoment = utilMoment;
})(window);