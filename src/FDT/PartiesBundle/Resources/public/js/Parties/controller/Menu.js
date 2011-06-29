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
                                       'PartiesMenu':
                                        {
                                            itemdblclick: this.onMenuDbClick
                                        }
                                    });
        
        
        this.addMenu ();
    },

    addMenu: function()
    {   
        var Panel = Ext.ComponentQuery.query('viewport > mainMenu');
                
        Panel[0].add ([{xtype: 'PartiesMenu'}]);
    },
    
    
    onMenuDbClick: function(Panel, Record)
    {        
        if (Record.isLeaf())
        {
        	console.info(Record.get('action'));
        	
        }
        
        
    }
});