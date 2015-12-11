require.config({
    paths: {
        examplenews: '../../examplenews/js',
        examplenewscss: '../../examplenews/css'
    }
});

define(function() {
    return {

        name: "Example New Bundle",

        initialize: function(app) {

            'use strict';

            app.components.addSource('examplenews', '/bundles/examplenews/js/components');

            app.sandbox.mvc.routes.push({
                route: 'news',
                callback: function() {
                    return '<p>Hello awesome sulu world!</p>'
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'news/add',
                callback: function() {
                    return '<div data-aura-component="news/form@examplenews"/>';
                }
            });
        }
    };
});
