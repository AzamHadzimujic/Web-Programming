$(document).ready(function () {
    var app = $.spapp({
        defaultView: "home", // which view loads first
        templateDir: "views/" // where view files are stored
    });

    // define routes for each view
    app.route({
        view: "home",
        load: "home.html"
    });

    app.route({
        view: "activities",
        load: "activities.html"
    });

    app.route({
        view: "blog",
        load: "blog.html"
    });

    app.route({
        view: "login",
        load: "login.html"
    });
    app.route({
        view: "register",
        load: "register.html"
    });
    app.route({
        view: "profile",
        load: "profile.html"
    });

    app.run();
});