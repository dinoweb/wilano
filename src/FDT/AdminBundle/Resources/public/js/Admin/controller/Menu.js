Ext.define('Admin.controller.Menu', {
    extend: 'Ext.app.Controller',
    
	views:
    [
        'servizio.Menu'
    ],
    
    stores:
    [
        'Menu'
    ],
    
    models:
    [
    	'Menu'
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
    },

    onPanelRendered: function(Panel)
    {   
        Panel.add ([{xtype: 'servizioMenu'}]);
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