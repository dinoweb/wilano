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
    
    
    createAppBundles : function (store)
    {
        store.each (this.aggiungiAppBundles);
        
        /*
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
*/
    },
    
    aggiungiAppBundles : function (Record)
    {
        
        var appBundleName = Record.get('name')+'.app';
        
         console.log (appBundleName);
                
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
    
    
    init : function (store)
	 {
	    console.log ('init iniziato');	    
	 	
	 	this.createAppBundles (store);
	 		 	
	 	
	 	
	 	console.log ('init chiamato');

	 	
	 	
        //var store = this.getStore('Bundles');	 
	 
	 },
	 
	 launch : function ()
	 {
	 
	   Ext.create('Admin.view.Viewport');
	 
	   console.log ('launch chiamato');
	   
	 }
    
    
    
    
});