// Login Form

function ts_popup(url) {
  popusWindow = window.open(url,'popUpWindow','height=300,width=350,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}


$(function() {
    var button = $('#loginButton');
    var box = $('#loginBox');
    var form = $('#loginForm');
    button.removeAttr('href');
    button.mouseup(function(login) {
        box.toggle();
        button.toggleClass('active');
    });
    form.mouseup(function() {
        return false;
    });
    $(this).mouseup(function(login) {
        if(!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active');
            box.hide();
        }
    });
        
    var sceneryButton = $('#toggleAddArrScenery');
    sceneryButton.mouseup(function() {
        
        var sceneryBox = document.getElementById('addSceneryArrElemets');
        
        if (sceneryBox.style.display === 'none' || sceneryBox.style.display === '') {
            sceneryBox.style.display = 'block';
        } else {
            sceneryBox.style.display = 'none';
        }
        
    });
    
    var sceneryButton = $('#toggleAddScenery');
    sceneryButton.mouseup(function() {
        
        var sceneryBox = document.getElementById('addSceneryElemets');
        
        if (sceneryBox.style.display === 'none' || sceneryBox.style.display === '') {
            sceneryBox.style.display = 'block';
        } else {
            sceneryBox.style.display = 'none';
        }
        
    });
    
    
});
