// Init App
var myApp = new Framework7({
    // Enable Material theme for Android device only
    material: true,
    pushState: true
});
var welcomescreen = myApp.welcomescreen(welcomescreen_slides, options);

// Init View
var mainView = myApp.addView('.view-main', {
});
var commingUp = myApp.addView('.view-commingUp', {
});
var menus = myApp.addView('.view-menus', {
});

myApp.onPageInit('about', function (page) {
    // Do something here for "about" page
    myApp.hideIndicator()

});
$$(window).on('load', function (e) {
    myApp.showIndicator();
    setTimeout(function(){
        myApp.hideIndicator();
        welcomescreen.close();
    },5000);
});