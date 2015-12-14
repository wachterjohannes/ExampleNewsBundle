define(['text!./list.html'], function(list) {

    var defaults = {
        templates: {
            list: list
        }
    };

    return {

        defaults: defaults,

        header: {
            title: function() {
                return 'news.headline';
            }.bind(this),
            underline: false,

            toolbar: {
                buttons: {
                    add: {},
                    deleteSelected: {}
                }
            }
        },

        layout: {
            content: {
                width: 'max'
            }
        },

        initialize: function() {
            this.render();

            this.bindDomEvents();
            this.bindCustomEvents();
        },

        render: function() {
            this.$el.html(this.templates.list());

            this.sandbox.sulu.initListToolbarAndList.call(this,
                'news',
                '/admin/api/news/fields',
                {
                    el: this.$find('#list-toolbar-container'),
                    instanceName: 'news',
                    template: this.sandbox.sulu.buttons.get({
                        settings: {
                            options: {
                                dropdownItems: [
                                    {
                                        type: 'columnOptions'
                                    }
                                ]
                            }
                        }
                    })
                },
                {
                    el: this.sandbox.dom.find('#news-list'),
                    url: '/admin/api/news',
                    searchInstanceName: 'news',
                    searchFields: ['title', 'teaser'],
                    resultKey: 'news-items',
                    instanceName: 'news',
                    actionCallback: this.toEdit.bind(this),
                    viewOptions: {
                        table: {
                            actionIconColumn: 'title'
                        }
                    }
                }
            );
        },

        toEdit: function(id) {
            this.sandbox.emit('sulu.router.navigate', 'news/edit:' + id);
        },

        bindDomEvents: function() {
        },

        bindCustomEvents: function() {
        }
    };
});
