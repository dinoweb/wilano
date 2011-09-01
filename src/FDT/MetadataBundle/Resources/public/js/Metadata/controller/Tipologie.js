Ext.define('Metadata.controller.Tipologie', {
    extend: 'Ext.app.Controller',
    
    views:
    [
        'Metadata.view.Tipologie.Manage'
    ],
    
    init: function() {
                              
          this.control({
                        
                        'viewport > mainMenu > MetadataMenu':
                        {
                            itemdblclick: this.onMenuDbClick
                        },
                        
                        '#tipologiemanageaggiungi':
                        {
                            click: this.aggiungi
                        }
                        
                      });
                  

                  
    },
        
    onMenuDbClick: function(Panel, Record)
    {        
        
        if (Record.isLeaf())
        {
        	var view = Ext.widget('tipologiemanage');
        	view.setTitle('Configurazione '+Record.get('tipologiaType'));
        	var toolbar = this.createToolbar(Record);
        	view.addDocked(toolbar);
        	
        	var Panels = Ext.ComponentQuery.query('#mainPanel'); 
            Panels[0].add (view);
        	
        	view.show();
        }
        
        
    },
    
    createToolbar : function (Record)
    {
      var toolbar = Ext.create('Ext.toolbar.Toolbar', {
                    dock: 'top',
                    items: [
                                {
                                    text: 'Button'
                                },
                                {
                                    xtype: 'splitbutton',
                                    text : 'Split Button'
                                },
                                '->',
                                {
                                    xtype    : 'textfield',
                                    name     : 'field1',
                                    emptyText: 'enter search term'
                                }
                            ]
                    });

      return toolbar;
        
    },
    
    aggiungi: function ()
    {
        
        console.log('aggiungi');
        
        
    }
    
    
    
    
    
    
    
    
    
});