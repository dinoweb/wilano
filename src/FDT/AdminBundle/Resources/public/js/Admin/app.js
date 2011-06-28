Ext.define('Admin.app',
{
    extend: 'Ext.app.Application',
    
    
    requires:
    [
		'Admin.view.Viewport'
    ],
    
    stores:
    [
        'Admin.store.Paths'
    ],
    
    models:
    [
    	'Admin.model.Paths'
    ],
    
    createAppBundles : function ()
    {
        var pathStore = this.getStore ('Admin.store.Paths');
        
        pathStore.load({
                        scope   : this,
                        callback: function (records, operation, success)
                        {
                           if (success == true)
                           {
                                pathStore.each (this.aggiungiAppBundles);
                           } 
                            
                                                        
                        }
                  
                  });
    },
    
    aggiungiAppBundles : function (Record)
    {
        var appBundleName = Record.get('name')+'.app';

        Ext.create(appBundleName);
          
    
    },
    
    addController : function (controllerName)
    {
    
        var myController = Ext.create(controllerName,
                	       {
                                application: this
                           });
        myController.init(this);
        
        this.controllers.add (controllerName, myController);
    
    
    },
    
    launch : function ()
	 {
	    	    
	 	
	 	Ext.create('Admin.view.Viewport');
	 	
	 	this.createAppBundles ();
	 		 	
	 	

	 	
	 	
        //var store = this.getStore('Bundles');	 
	 
	 } 
    
    
    
    
});