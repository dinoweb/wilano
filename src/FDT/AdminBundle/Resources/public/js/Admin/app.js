Ext.application({

    requires:
    [
    'Admin.view.Viewport'
    ],

    controllers:
    [

    'Metadata.controller.Menu'
    

    ],
    
    stores:
    [
        'Admin.store.SiNo',
        'Metadata.store.Languages'
    ],
    


    launch: function()
    {
        this.addEvents('viewPortCreated');
        this.enableBubble('viewPortCreated');

        Ext.create('Admin.view.Viewport');

        this.fireEvent('viewPortCreated');

    },
    
    resizeWindow: function (window)
    {
                             
        var bodyElement = Ext.getBody();
		
		var bodyHeight = bodyElement.getHeight ();
		var bodyWidth = bodyElement.getWidth ();
	
		window.setHeight(bodyHeight-20);
		window.setWidth(bodyWidth/1.5);
		window.center();
     
     
     },




});