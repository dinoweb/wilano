Ext.define('Metadata.controller.Tipologie', {
    extend: 'Ext.app.Controller',
    
    config: {
        record: null
    },
    
    views:
    [
        'Tipologie.Manage',
        'Tipologie.Edit'
    ],
    
    init: function(Record) {
                  
          this.createPanel(Record);
          
          this.control({
            'tipologieEdit button[action=save]': {
                click: this.tipologiaEdit
            }
        });
                  
    },
        
    createPanel: function(Record)
    {        
        var panelId = 'idManage'+Record.get('tipologiaType');
        
        var arrayPanelById = Ext.ComponentQuery.query('#'+panelId);
        
        if (arrayPanelById.length > 0)
        {
            arrayPanelById[0].destroy( );
        }
        
        var view = Ext.ClassManager.instantiateByAlias('widget.tipologieManage', {
                                                                                    id: panelId,
                                                                                    title: 'Configurazione '+Record.get('tipologiaType')                                                                                  
                                                                                  });
    	var toolbar = this.createToolbar(Record);
    	view.addDocked(toolbar);
    	
    	var Panels = Ext.ComponentQuery.query('#mainPanel'); 
        Panels[0].add (view);
    	
    	view.show();
    },
    
    createToolbar : function (Record)
    {
      var toolbar = Ext.create('Ext.toolbar.Toolbar', {
                    dock: 'top',
                    items: [
                                {
                                    text: 'Aggiungi',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/add.png',
                                    cls: 'x-btn-text-icon',
                                    itemId: 'tipologiemanageaggiungi',
                                    handler: function (){
                                        this.aggiungi(Record)
                                    }
                                },
                                '-'
                            ]
                    });

      return toolbar;
        
    },
    
    aggiungi: function (Record)
    {
        var view = Ext.ClassManager.instantiateByAlias('widget.tipologieEdit', {
                                                                                    title: 'Tipologia '+Record.get('tipologiaType'),
                                                                                    record: Record                                                                                  
                                                                                  });
                
    },
    
    tipologiaEdit: function(button) {
        var win    = button.up('window'),
        form   = win.down('form'),
        values = form.getValues();
        
        console.log(values['name']);
    }
    
    
    
    
    
    
    
    
    
});