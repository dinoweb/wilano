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
        	var controller = this.getController(Record.get('controller'));
        	/*var controller = Ext.ClassManager.instantiate(Record.get('controller'), {
                                                                                    record: Record                                                                                 
                                                                                  });*/
            controller.init(Record);
        }
        
        
    },

    addMenu: function()
    {   
        var Panels = Ext.ComponentQuery.query('viewport > mainMenu'); 
                        
        Panels[0].add ([{xtype: 'MetadataMenu'}]);
              
        
    }
});