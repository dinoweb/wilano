Ext.define('Parties.controller.Menu', {
    extend: 'Ext.app.Controller',
    
	views:
    [
        'Parties.view.Menu'
    ],
    
    stores:
    [
        'Parties.store.Menu'
    ],
    
    models:
    [
    	'Admin.model.Menu'
    ],
        
    init: function() {
        
        this.control({
                       'viewport > mainMenu > PartiesMenu':
                        {
                            itemdblclick: this.onMenuDbClick
                        }
                        
                    });
        
         this.application.addListener
         ({ 
            'viewPortCreated' : this.addMenu, 
        }); 
                
    },

    addMenu: function()
    {   
    
        var Panels = Ext.ComponentQuery.query('viewport > mainMenu');
                
        Panels[0].add ([{xtype: 'PartiesMenu'}]);
    },
    
    
    onMenuDbClick: function(Panel, Record)
    {        
        if (Record.isLeaf())
        {
        	console.info(Record.get('action'));
        	
        }
        
        
    }
});