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
        'Admin.FormBuilder',
        
        //CONTROLLER
        'Admin.controller.BaseCrudController',
        'Admin.controller.BaseRelatedController'
        
        
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
    
    resizeWindow: function (window, height, width)
    {
        height = typeof(height) != 'undefined' ? height : 20;
        width = typeof(width) != 'undefined' ? width : 1.5;
                             
        var bodyElement = Ext.getBody();
		
		var bodyHeight = Ext.Element.getViewportHeight ();
		var bodyWidth = Ext.Element.getViewportWidth ();
	
		window.setHeight(bodyHeight-height);
		window.setWidth(bodyWidth/width);
		window.center();     
     
     },
     
     generateUniqid : function ()
     {
         var newDate = new Date;
         return newDate.getTime();
     }



});