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
         
         this.application.addListener
         ({ 
            'viewPortCreated' : this.addMenu, 
         }); 
         

                  
    },
    
    onPanelRendered: function() {
        console.log('The panel was added');
    },

    addMenu: function()
    {   
        var Panels = Ext.ComponentQuery.query('viewport > mainMenu'); 
                        
        Panels[0].add ([{xtype: 'MetadataMenu'}]);
              
        
    },
    
    launch : function ()
	 {
	   
	    this.addMenu ();
	 
	   //console.log ('launch chiamato');
	   
	 },
    
    
    onMenuDbClick: function(Panel, Record)
    {        
        
        if (Record.isLeaf())
        {
        	console.info(Record.get('action'));
        	
        }
        
        
    }
});