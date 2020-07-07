<script type="text/javascript">

$(function () {
    $('#fullnameenColor').colorpicker();
    $('#fullnamearColor').colorpicker();
    $('#dateColor').colorpicker();
    $('#qrcodeColor').colorpicker();
    $('#serialnumberColor').colorpicker();
    $(".sidebar-toggle").trigger("click");
});

// helper function to get an element's exact position
function getHelperPosition(el) {
    var xPosition = 0;
    var yPosition = 0;

    while (el) {
        if (el.tagName == "BODY") {
            // deal with browser quirks with body/window/document and page scroll
            var xScrollPos = el.scrollLeft || document.documentElement.scrollLeft;
            var yScrollPos = el.scrollTop || document.documentElement.scrollTop;

            xPosition += (el.offsetLeft - xScrollPos + el.clientLeft);
            yPosition += (el.offsetTop - yScrollPos + el.clientTop);
        } else {
            xPosition += (el.offsetLeft - el.scrollLeft + el.clientLeft);
            yPosition += (el.offsetTop - el.scrollTop + el.clientTop);
        }

        el = el.offsetParent;
    }
    return {
        x: xPosition,
        y: yPosition
    };
}


function activeElementChange(activeElement)
{
    //alert(activeElement);
    document.getElementById('activeElement').value = activeElement;
}
function getPosition(event)
{
    var image_position = getHelperPosition(document.querySelector("#image-img"));
    var image_x = image_position.x+14;
    var image_y = image_position.y+14;

    var x = event.clientX + document.body.scrollLeft-image_x;
    var y = event.clientY + document.body.scrollTop-image_y;
    var coords = "X coords: " + x + ", Y coords: " + y;
    document.getElementById('position').innerHTML = coords;
}
function drawTextToCertificate(event)
{
    var image_position = getHelperPosition(document.querySelector("#image-img"));
    var image_x = image_position.x+14;
    var image_y = image_position.y+14;

    var activeElement = document.getElementById('activeElement').value;
    var elWidth = $('#'+activeElement+'Div').width();
    var elHeight = $('#'+activeElement+'Div').height();


    var x = event.clientX + document.body.scrollLeft-image_x-(elWidth/2);
    var y = event.clientY + document.body.scrollTop-image_y-(elHeight/2);
    var coords = "X coords: " + x + ", Y coords: " + y;



    document.getElementById('position').innerHTML = coords;

    var activeElementText = document.getElementById(activeElement).value;

    var activeElementFontSize = document.getElementById(activeElement+"Font").value;
    var activeElementFontColor = document.getElementById(activeElement+"Color").value;

    document.getElementById(activeElement+"X").value = parseInt(x);
    document.getElementById(activeElement+"Y").value = parseInt(y);

    //for draw element according to screen and image
    x=x+29;
    y=y+29

    var div = $('#'+activeElement+'Div').css({
        "padding": "0px",
        "background": "#fff",
        "position": "absolute",
        "color": activeElementFontColor,
        "font-size": activeElementFontSize+"px",
        "left": x,
        "top": y,
    });
    div.html( activeElementText );



    var activeElementTextWidth = div.width();
    var activeElementTextHeight = div.height();
    document.getElementById(activeElement+"Width").value = activeElementTextWidth;
    document.getElementById(activeElement+"Height").value = activeElementTextHeight;

    var activeElementChecked = document.getElementById(activeElement+"Checked").checked;


}

function drawTextTFromInput()
{
    var activeElement = document.getElementById('activeElement').value;
    var elWidth = $('#'+activeElement+'Div').width();
    var elHeight = $('#'+activeElement+'Div').height();

    var x = parseInt(document.getElementById(activeElement+"X").value) ;
    var y = parseInt(document.getElementById(activeElement+"Y").value) ;
    var coords = "X coords: " + x + ", Y coords: " + y;


    document.getElementById('position').innerHTML = coords;

    var activeElementText = document.getElementById(activeElement).value;

    var activeElementFontSize = document.getElementById(activeElement+"Font").value;
    var activeElementFontColor = document.getElementById(activeElement+"Color").value;

//for draw element according to screen and image
    x=x+29;
    y=y+29

    var div = $('#'+activeElement+'Div').css({
        "padding": "0px",
        "background": "#fff",
        "position": "absolute",
        "color": activeElementFontColor,
        "font-size": activeElementFontSize+"px",
        "left": x,
        "top": y,
    });
    div.html( activeElementText );



    var activeElementTextWidth = div.width();
    var activeElementTextHeight = div.height();
    document.getElementById(activeElement+"Width").value = activeElementTextWidth;
    document.getElementById(activeElement+"Height").value = activeElementTextHeight;



}

function openKCFinder(field,hiddenField) {
    window.KCFinder = {
        callBack: function(url) {
            field.attr("src",url);
            var filename = url.substr(url.lastIndexOf('image/')+6);
            hiddenField.val(filename);
            window.KCFinder = null;
        },
        title: 'File Browser',
    };
	window.open('{{asset("uploads/kcfinder/browse.php?type=image")}}', 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}


$("#form1").bootstrapValidator({
	excluded: [':disabled'],
    fields: {
        name_ar: {
            validators: {
                notEmpty: {
                    message: 'The name is required'
                }
            }
        },
        name_en: {
            validators: {
                notEmpty: {
                    message: 'The name is required'
                }
            }
        },
        image: {
            validators: {
                notEmpty: {
                    message: 'The image is required'
                }
            }
        }
    }
}).on('success.form.bv', function(e) {

});

</script>