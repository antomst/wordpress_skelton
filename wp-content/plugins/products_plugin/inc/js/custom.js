jQuery(function() {
    var tips = jQuery(".validateTips");
    var set;
    jQuery.fn.updateTips = function(t) {//update the notification
        if (t == '')
            tips.hide();
        else
            tips
                    .text(t)
                    .addClass("ui-state-error error").show();
    }

    jQuery.fn.checkLength = function(o, n, min, max) {//validation for text box
        if (max == '' && o.val().length < min) {
            o.addClass("ui-state-error");
            o.next().show().text(n + " is not entered.");
            return false;
        } else if (max != '' && (o.val().length > max || o.val().length < min)) {
            o.addClass("ui-state-error");
            o.next().show().text("Length of " + n + " must be between " +
                    min + " and " + max + ".");
            return false;
        } else {
            o.next().hide();
            return true;
        }
    }

    jQuery.fn.checkChecked = function(o, n) {//validation of radio button
        if (!o.is(":checked")) {
            o.addClass("ui-state-error");
            o.next().show().text(n + " is not selected.");
            return false;
        } else {
            o.next().hide();
            return true;
        }
    }

    jQuery.fn.checkRegexp = function(o, regexp, n) {//validation for regular expression
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            jQuery.fn.updateTips(n);
            return false;
        } else {
            return true;
        }
    }
    var msgs = jQuery(".msg");
    jQuery.fn.updatemsgs = function(s) {//update the notification
        //jQuery('.msg').remove(); 
        msgs.hide();
        clearTimeout(set);  
        jQuery(".msg").css( "color", "red" );
        if (s == 'save success')
        {    
            msgs.text("Record saved successfully").show();
            set = setTimeout(function() { msgs.hide();}, 3000);  
            jQuery(".msg").css( "color", "green" );                     
        }
        
        if (s == 'deletion success')
        {   
            msgs.text("Record successfully deleted").show();
            set = setTimeout(function() { msgs.hide();}, 3000);  
            jQuery(".msg").css( "color", "green" );
        }
        
        if (s == 'deletion duplicate')
        {   
            msgs.text("Deletion not possible"+"\n"+"Other related records present").show();      
            set = setTimeout(function() { msgs.hide();}, 3000); 
        }
        
        if (s == 'deletion fail')
        {
            msgs.text("Deletion failed").show();  
            set = setTimeout(function() { msgs.hide();}, 3000); 
        }
        
        if (s == 'duplicate comment')
        {
            msgs.text("Deletion not possible"+"\n"+"Comments present under this recipes").show();             
            set = setTimeout(function() { msgs.hide();}, 3000); 
        }
        
        if (s == 'edit fail')
        {
            msgs.text("Record not found").show();  
            set = setTimeout(function() { msgs.hide();}, 3000); 
        }      
    }
});
