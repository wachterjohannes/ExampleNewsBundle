define(['text!./form.html'], function(form) {

    var defaults = {
        templates: {
            form: form,
            url: '/admin/api/news'
        },
        translations: {
            title: 'public.title',
            teaser: 'news.teaser'
        }
    };

    return {

        defaults: defaults,

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
            this.render();

            this.bindDomEvents();
            this.bindCustomEvents();
        },

        render: function() {
            this.$el.html(this.templates.form({translations: this.translations}));

            this.sandbox.form.create('#news-form');
        },

        bindDomEvents: function() {
            this.$el.find('input, textarea').on('keypress', function() {
                this.sandbox.emit('sulu.header.toolbar.item.enable', 'save');
            }.bind(this));
        },

        bindCustomEvents: function() {
            this.sandbox.on('sulu.toolbar.save', this.save.bind(this));
        },

        save: function(action) {
            if (!this.sandbox.form.validate('#news-form')) {
                return;
            }

            var data = this.sandbox.form.getData('#news-form');

            this.sandbox.util.save(this.templates.url(), 'POST', data).then(function(response) {
                this.afterSave(response, action);
            }.bind(this));
        },

        afterSave: function(response, action) {
            this.sandbox.emit('sulu.header.toolbar.item.disable', 'save');

            if (action === 'back') {
                this.sandbox.emit('sulu.router.navigate', 'news');
            } else if (action === 'new') {
                this.sandbox.emit('sulu.router.navigate', 'news/add');
            } else if (!this.options.id) {
                this.sandbox.emit('sulu.router.navigate', 'news/edit:' + response.id);
            }
        }
    };
});
