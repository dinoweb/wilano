Ext.application({

    requires:
    [
    'Admin.view.Viewport'
    ],

    controllers:
    [

    'Metadata.controller.Menu',
    'Metadata.controller.Tipologie'
    

    ],


    launch: function()
    {
        this.addEvents('viewPortCreated');
        this.enableBubble('viewPortCreated');

        Ext.create('Admin.view.Viewport');

        this.fireEvent('viewPortCreated');

    }




});