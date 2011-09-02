Ext.define('Metadata.view.Tipologie.Edit', {
    extend: 'Ext.window.Window',
    alias : 'widget.tipologieEdit',
    
    config: {
        record: null
    },

    autoShow: true,
    titleCollapse: true,
    autoScroll:true,
    constrain: true,
    shadow: false,
    autoDestroy: true,
    collapsible: true,
    modal: true,
    defaults: {autoHeight:false, bodyStyle:'padding:5px'},
    initComponent: function() {
        this.items = [
            {
                xtype: 'form',
                items: [
                    {
                        xtype: 'textfield',
                        name : 'name',
                        fieldLabel: 'Name'
                    },
                    {
                        xtype: 'textfield',
                        name : 'email',
                        fieldLabel: 'Email',
                        value: this.getRecord().get('tipologiaType')
                    },
                    {
                        xtype: 'textfield',
                        name : 'test',
                        fieldLabel: 'Test'
                    }
                    
                ]
            }
        ];

        this.buttons = [
            {
                text: 'Save',
                action: 'save'
            },
            {
                text: 'Cancel',
                scope: this,
                handler: this.destroy
            }
        ];

        this.callParent(arguments);
    }
});