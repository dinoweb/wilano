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
                              
        this.application.addListener
         ({ 
            'viewPortCreated' : this.addMenu, 
         }); 
         

                  
    },

    addMenu: function()
    {   
        var Panels = Ext.ComponentQuery.query('viewport > mainMenu'); 
                        
        Panels[0].add ([{xtype: 'MetadataMenu'}]);
              
        
    }
});