Ext.application({

    requires:
    [
        //VIEW
        'Admin.view.Viewport',
        'Admin.view.BaseTreePanel',
        'Admin.view.BaseGridPanel',
        'Admin.view.BaseFormPanel',
        'Admin.view.BaseWindow',
        
        //MODEL
        'Admin.model.BaseModel',
        'Admin.model.Config',
        'Admin.model.Campi',
        'Admin.model.Associazioni',
        
        //STORE
        'Admin.store.BaseTreeStore',
        'Admin.store.BaseStore',
        'Admin.store.Config',
        
        //BUILDER
        'Admin.StoreBuilder',
        'Admin.PanelBuilder',
        'Admin.ConfigBuilder',
        'Admin.FormBuilder'
        
        
    ],

    controllers:
    [

    'Metadata.controller.Menu'
    

    ],
        
    stores:
    [
        'Admin.store.SiNo',
        'Admin.store.Languages'
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
     
     generateUniqid : function ()
     {
         var newDate = new Date;
         return newDate.getTime();
     }



});