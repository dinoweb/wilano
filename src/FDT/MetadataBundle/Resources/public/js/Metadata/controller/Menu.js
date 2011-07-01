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
    	'Metadata.model.Menu'
    ],
    
    init: function() {
                              
          this.control({
                        
                        'viewport > mainMenu > MetadataMenu':
                        {
                            itemdblclick: this.onMenuDbClick
                        }
                        
                      });
          
          this.addMenu ();

                  
    },
    
    onPanelRendered: function() {
        console.log('The panel was added');
    },

    addMenu: function()
    {   
        var Panel = Ext.ComponentQuery.query('viewport > mainMenu');
        
                
        Panel[0].add ([{xtype: 'MetadataMenu'}]);
              
        
    },
    
    
    onMenuDbClick: function(Panel, Record)
    {        
        
        if (Record.isLeaf())
        {
        	console.info(Record.get('action'));
        	
        }
        
        
    }
});