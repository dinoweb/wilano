Ext.define('Admin.view.BaseWindow', {
    extend: 'Ext.window.Window',    
        
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

        this.buttons = [
            {
                text: 'Save',
                id: 'buttonSave',
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