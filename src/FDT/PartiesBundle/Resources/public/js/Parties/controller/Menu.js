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
            'viewport > mainMenu':
            {
                render: this.onPanelRendered,
            },
             'servizioMenu':
             {
                itemdblclick: this.onMenuDbClick
            }
        });
        
        this.onPanelRendered ();
    },

    onPanelRendered: function()
    {   
        var Panel = Ext.ComponentQuery.query('viewport > mainMenu');
                
        Panel[0].add ([{xtype: 'PartiesMenu'}]);
    },
    
    
    onMenuDbClick: function(Panel, Record)
    {
        console.log (Ext.Loader.getPath ('Parties'));
        
        if (Record.isLeaf())
        {
        	console.info(Record.get('palla'));
        	
        }
        
        
    }
});