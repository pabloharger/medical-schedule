(function(w){
  'use strinct';

  var util =
    {
      message: (title, message, buttonOK = "ok") => {
        if (title) $('#message-title').html(title);
        if (message) $('#message-body').html(message);
        $('#message-ok').html(buttonOK);
        $('#my-modal').modal();
      }
    };

  var utilDOM = 
    {
      addClassIfNotExists: (elem, addClass) => {
        if (!elem.hasClass(addClass)) elem.addClass(addClass);
      },
      addInvalidFeedback: (elem, feedback, addClass) => {
        utilDOM.addClassIfNotExists(elem, addClass);
        if (elem.parent().find('.invalid-feedback') !== undefined) elem.parent().find('.invalid-feedback').html(feedback);
      }
    }
  ;

  var utilForm = (() => {
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
      // Mac OSx
      addShortCut(
        'Meta+' + key.toUpperCase(),
        propagate,
        callBack
      );
      // Windows
      addShortCut(
        'Ctrl+' + key,
        propagate,
        callBack
      );
    }

    return {
      addCtrlShortCutArr: (element, key, propagate, callBack) => {
        addCtrlShortCutGen(key, propagate, function(){
          if (!element.prop('disabled')) callBack();
        })
      },
      focusInvalidElement: (elem) => {
        var elementFocus = elem.find('.is-invalid');
        if (elementFocus.length > 0) $(elem.find('.is-invalid')[0]).focus();
      },
      setSelect2 : (select, id, placeholder) => {
        if (id === undefined) var id = 0;
        if (placeholder === undefined) var placeholder = '';
        select.children().remove();
        select.append('<option value="' + id + '">' + placeholder + '</option>');	
      }
    }
  })();

  var utilMoment = {
      getInternalFormatedDateTime: (date) => {
        return moment(date, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm:00.sss[Z]')
      },
      getInternalFormatedDateTimeFromCallendar: (date) => {
        return moment(date).format('YYYY-MM-DD HH:mm:00.sss[Z]')
      },
      getInterfaceFormatedDateTime: (date) => moment(date, 'YYYY-MM-DD HH:mm').format('DD/MM/YYYY HH:mm')
    };

  var utilCookie = {
    setCookie: (cname, cvalue, exdays) => {
      var d = new Date();
      d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
      var expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    getCookie: (cname) => {
      var name = cname + "=";
      var ca = document.cookie.split(';');
      for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
          c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
          return c.substring(name.length, c.length);
        }
      }
      return "";
    }
  }

  window.util = util;
  window.utilDOM = utilDOM ;
  window.utilMoment = utilMoment;
  window.utilForm = utilForm;
  window.utilMoment = utilMoment;
  window.utilCookie = utilCookie;
})(window);