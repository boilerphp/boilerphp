
var stepLength = () => {
    return $('[step-id]').length;
}

function badgeClick() {
    $('[step-badge]').click(function(){
        index = $(this).attr("step-badge");
        index = Number(index);

        let current = currentIndex($('.step-next')); current = Number(current);
        let change = true;

        if(index > current) {
            for (let i = 1; i < index; i++) {
               if(!validateCurrentStep(i)) { stepError(i); change = false; } 
               else { stepCompleted(i); next(i) } 
            }
            
            if(change) { next((index - 1)); }
        } 
        else if(index < current) {
            
            for (let i = 1; i < current; i++) {
                previous((current - i));
                if((current - i) == index) { break; }
            }

        }




    })
}

function validateCurrentStep(current) {

    var valid = true,
        fields = $('[step-id="' + current + '"]').children().find('[step-field-required="true"]');
    fields.each(function () {
        $(this).css("border-color","#dcdcdc").siblings('[step-validation-result="true"]').remove();
        
        if ($(this).val() === "") { 
            var message = $(this).attr("step-validation-message");
            if(message != "") {
                $(this).css("border-color","red").after('<span class="text-danger step-validation-message" step-validation-result="true">'+ message +'</span>');
            }
            valid = false; 
        }

        if($(this).attr("type") == "checkbox" || $(this).attr("type") == "radio") {
            if($(this).prop("checked") != true) {
                var message = $(this).attr("step-validation-message");
                if(message != "") {
                    var this_id = $(this).attr("id");
                    $('[for="step-'+this_id+'-result"]').html('<small class="text-danger" validation-result="true"><br>'+ message +'</small>');
                }
                valid = false; 
            }
        }
    });

    return valid;
}

var currentIndex = (nextObject) => {
    return nextObject.attr("step-current");
}

function nextAction() {
    $(".step-next").click(function () {
        let current = currentIndex($(this));

        if (validateCurrentStep(current)) {
            stepCompleted(current); next(current);
        }
        else {
            stepError(current);
        }
    });
}

function nextStep(current, index) {
    $('[step-id="' + current + '"]').fadeOut().removeClass("active").removeClass("show").addClass("hide");
    $('[step-id="' + index + '"]').removeClass("hide").fadeIn().attr("class", "show active");

    setNextIndex(index);
    activeBadge(index);
}

function setNextIndex(index) {
    if (index < stepLength()) {
        submitButton(false);
    }
    $(".step-next").attr("step-current", index);
}


function next(current) {
    let index = Number(current) + 1;
    if (index == stepLength()) {
        submitButton(true);
    }

    if (index <= stepLength()) {
        if (index > 1) { setPreviousButton(current); }
        nextStep(current, index);
    }
}



function previousAction() {
    $(".step-previous").click(function () {
        let index = $(this).attr("step-page");
        previous(index);
    });
}

function previous(index) {

    index = Number(index);
    let current = index + 1;
    $('[step-id="' + current + '"]').fadeOut().removeClass("active").removeClass("show").addClass("hide");
    $('[step-id="' + index + '"]').removeClass("hide").fadeIn().attr("class", "show active");

    setPreviousButton((index - 1));
    setNextIndex(index);
    resetBadge((index + 1));
    activeBadge((index))
}

function resetBadge(index) {
    $('[step-badge="' + index + '"]').removeClass(["active", "completed", "error"]);
}

function activeBadge(index) {
    $('[step-badge="' + index + '"]').removeClass(["error", "completed"]).addClass("active");
}

function stepCompleted(current) {
    $('[step-badge="' + current + '"]').removeClass("active").removeClass("error").addClass("completed");
}

function stepError(current) {
    $('[step-badge="' + current + '"]').addClass("error");

    stepModal("error", "Some required fields are not filled correctly.")
}

function stepModal(mode, message, iconClass = null) {

    // let iconError = (iconClass !== null) ? iconClass : "fa fa-alert-circle-outline";
    // let iconSuccess = (iconClass !== null) ? iconClass : "fa fa-check-circle-outline";
    
    let icon = "";
    if(mode == "success") {
        icon = '<span class="svg-icon step-icon svg-icon-success svg-icon-8x">\
            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                    <polygon points="0 0 24 0 24 24 0 24"/>\
                    <path d="M9.26193932,16.6476484 C8.90425297,17.0684559 8.27315905,17.1196257 7.85235158,16.7619393 C7.43154411,16.404253 7.38037434,15.773159 7.73806068,15.3523516 L16.2380607,5.35235158 C16.6013618,4.92493855 17.2451015,4.87991302 17.6643638,5.25259068 L22.1643638,9.25259068 C22.5771466,9.6195087 22.6143273,10.2515811 22.2474093,10.6643638 C21.8804913,11.0771466 21.2484189,11.1143273 20.8356362,10.7474093 L17.0997854,7.42665306 L9.26193932,16.6476484 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(14.999995, 11.000002) rotate(-180.000000) translate(-14.999995, -11.000002) "/>\
                    <path d="M4.26193932,17.6476484 C3.90425297,18.0684559 3.27315905,18.1196257 2.85235158,17.7619393 C2.43154411,17.404253 2.38037434,16.773159 2.73806068,16.3523516 L11.2380607,6.35235158 C11.6013618,5.92493855 12.2451015,5.87991302 12.6643638,6.25259068 L17.1643638,10.2525907 C17.5771466,10.6195087 17.6143273,11.2515811 17.2474093,11.6643638 C16.8804913,12.0771466 16.2484189,12.1143273 15.8356362,11.7474093 L12.0997854,8.42665306 L4.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.999995, 12.000002) rotate(-180.000000) translate(-9.999995, -12.000002) "/>\
                </g>\
            </svg>\
        </span>';
    } 
    else if(mode == "error")
    {
        icon = '<span class="svg-icon step-icon svg-icon-danger svg-icon-8x">\
            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                    <rect x="0" y="0" width="24" height="24"/>\
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>\
                    <path d="M12.0355339,10.6213203 L14.863961,7.79289322 C15.2544853,7.40236893 15.8876503,7.40236893 16.2781746,7.79289322 C16.6686989,8.18341751 16.6686989,8.81658249 16.2781746,9.20710678 L13.4497475,12.0355339 L16.2781746,14.863961 C16.6686989,15.2544853 16.6686989,15.8876503 16.2781746,16.2781746 C15.8876503,16.6686989 15.2544853,16.6686989 14.863961,16.2781746 L12.0355339,13.4497475 L9.20710678,16.2781746 C8.81658249,16.6686989 8.18341751,16.6686989 7.79289322,16.2781746 C7.40236893,15.8876503 7.40236893,15.2544853 7.79289322,14.863961 L10.6213203,12.0355339 L7.79289322,9.20710678 C7.40236893,8.81658249 7.40236893,8.18341751 7.79289322,7.79289322 C8.18341751,7.40236893 8.81658249,7.40236893 9.20710678,7.79289322 L12.0355339,10.6213203 Z" fill="#000000"/>\
                </g>\
            </svg>\
        </span>';
    }
    else if(mode == "warning")
    {
        icon = '<span class="svg-icon step-icon svg-icon-warning svg-icon-8x">\
            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                    <rect x="0" y="0" width="24" height="24"/>\
                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>\
                    <rect fill="#000000" x="11" y="10" width="2" height="7" rx="1"/>\
                    <rect fill="#000000" x="11" y="7" width="2" height="2" rx="1"/>\
                </g>\
            </svg>\
        </span>';
    }

    $("body").append('<div class="step-overlay step-modal-hide"><div class="step-modal-box"><div class="text-center">' + icon + '<p class="step-message">' + message + '</p><button class="step-close btn btn-primary">Close</button></div></div></div>');
    $(".step-modal-hide").fadeIn();
    closePopUpAction();
}

function stepLoading(state, message = null){
    if(state) {
        $("body").append('<div class="step-overlay text-center" step-loading="true"><div class="step-loading"><div class="d-flex justify-content-center"><div class="spinner-grow text-primary" role="status"><span class="sr-only text-white"></span></div></div><p class="text-center text-white">'+message+'</p></div></div>');
    } 
    else {
        $('[step-loading="true"]').remove();
    }
}

function closePopUpAction() {
    $(".step-close").click(function () {
        $(".step-overlay").fadeOut().remove();
    });
}

function submitButton(state) {
    if (state) {
        $(".step-next").hide(); $(".step-submit").removeAttr("disabled").show();
    }
    else {
        $(".step-next").show(); $(".step-submit").attr("disabled","disabled").hide();
    }
}

function stepSubmit() {
    $(".step-submit").click(function(event){
        current = $('[step-id]').length;
        
        if(validateCurrentStep(current)) 
        {
            if($('[step-disable-submit="true"]').length == 0) {
                submitForm();
            }
        } 
        else 
        {
            event.preventDefault();
            stepError(current);
        }
    });
}

function submitForm() {
    $(".formloader").fadeIn();
    $(".step-form")[0].submit();
}

function setPreviousButton(index) {
    if (index == 0) {
        $(".step-previous").removeAttr("step-page").hide();
    }
    else {
        $(".step-previous").attr("step-page", index).show();
    }

}

function initActions() {
    $(".step-submit").hide();
    $(".step-previous").hide();
    $(".step-next").attr("step-current", "1");

}

function init() {
    initActions();
    badgeClick();
    nextAction();
    previousAction();
    stepSubmit();
}

function Step() {}

Step.prototype.init = function () {
    return init();
}

Step.prototype.modal = function (mode, message) {
    return stepModal(mode, message);
}

Step.prototype.loader = function(state, message = null) {
    return stepLoading(state, message);
}