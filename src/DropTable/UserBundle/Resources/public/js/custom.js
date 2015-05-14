// Facebook popup dialog.
window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
        appId      : '658242424287528',                        // App ID from the app dashboard
        channelUrl : '//yourdomain.com/channel.html',      // Channel file for x-domain comms
        status     : true,                                 // Check Facebook Login status
        xfbml      : true                                  // Look for social plugins on the page
    });
};

// Load the SDK asynchronously
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function fb_login() {
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            // connected
            alert('Already connected, redirect to login page to create token.');
            document.location = "connect/facebook";
        } else {
            // not_authorized
            FB.login(function(response) {
                if (response.authResponse) {
                    document.location = "connect/facebook";
                } else {
                    alert('Cancelled.');
                }
            }, {scope: 'email'});
        }
    });
}
