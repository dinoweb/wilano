Ext.define('Metadata.controller.Menu', {
    extend: 'Ext.app.Controller',
    
	views:
    [
        'Metadata.view.Menu'
    ],
    
    stores:
    [
        'Metadata.store.Menu'
    ],
    
    models:
    [
    	'Admin.model.Menu'
    ],
    
    init: function() {
                              
        this.control({
                        
                        'viewport > mainMenu > MetadataMenu':
                        {
                            itemdblclick: this.onMenuDbClick
                        }
                        
                      });
        
        
        this.application.addListener
         ({ 
            'viewPortCreated' : this.addMenu, 
         }); 
         

                  
    },
    
    onMenuDbClick: function(Panel, Record)
    {        
        
        if (Record.isLeaf())
        {
        	var controllerPath = Record.get('controller');
        	var controller = Ext.create(controllerPath, {
                                                            tipologia: Record,
                                                            application: this.application                                                                                 
                                                          });
            controller.init();
        }
        
        
    },

    addMenu: function()
    {   
        var Panels = Ext.ComponentQuery.query('viewport > mainMenu'); 
                        
        Panels[0].add ([{xtype: 'MetadataMenu'}]);
              
        
    }
});