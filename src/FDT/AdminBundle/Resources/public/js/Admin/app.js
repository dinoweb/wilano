Ext.application
({
    name: 'Admin',

    appFolder: '/bundles/fdtadmin/js/Admin',
    
    controllers: 
   	[
        'Admin.controller.Menu'
    ],
    
    
    requires:
    [
		'Admin.view.Viewport'
    ],
    
    

    
    launch : function ()
	 {
	    console.log (Ext.Loader.getPath ('Test'));
	    
	    var myController = Ext.create('Test.controller.Palla',
	        {
                application: this
            });
        myController.init(this);
        
        this.controllers.add ('Test.controller.Palla', myController);
	 	
	 	Ext.create('Admin.view.Viewport');
	 	
	 	

	 	
	 	
        //var store = this.getStore('Bundles');	 
	 
	 } 
    
    
    
    
});