define(function() {
    return {

        header: {
            title: function() {
                return 'news.headline';
            }.bind(this),
            toolbar: {
                buttons: {
                    save: {
                        parent: 'saveWithOptions'
                    }
                }
            }
        },

        layout: {
            content: {
                width: 'fixed',
                leftSpace: true,
                rightSpace: true
            }
        },

        initialize: function() {
            this.$el.html('<h1>Hello awesome sulu world</h1>');
        }
    };
});
