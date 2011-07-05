Ext.application({
    
    requires:
    [
		'Admin.view.Viewport'
    ],
    
    controllers:
    [
        
        'Metadata.controller.Menu',
        'Parties.controller.Menu'
        
    
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
    
    
	 launch : function ()
	 {
	   this.addEvents('viewPortCreated');
       this.enableBubble('viewPortCreated');
	   
	   Ext.create('Admin.view.Viewport');
	   
	   this.fireEvent('viewPortCreated');
	   
	   
	 
	   //console.log ('launch chiamato');
	   
	 }
    
    
    
    
});