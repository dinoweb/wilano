Ext.define('Metadata.controller.Tipologie', {
    extend: 'Ext.app.Controller',
    
    config: {
        tipologia: null
    },
    
    views:
    [
        'Tipologie.Manage',
        'Tipologie.Edit',
        'Tipologie.EditTranslation'
    ],
    
    init: function() {
                  
          this.createPanel();
          
          this.control({
            'tipologieEdit button[action=save]': {
                click: this.tipologiaEdit
            }
        });
                  
    },
        
    createPanel: function()
    {        
        var panelId = 'idManage'+this.getTipologia().get('tipologiaType');
        
        var arrayPanelById = Ext.ComponentQuery.query('#'+panelId);
        
        if (arrayPanelById.length > 0)
        {
            arrayPanelById[0].destroy( );
        }
        
        var view = Ext.ClassManager.instantiateByAlias('widget.tipologieManage', {
                                                                                    id: panelId,
                                                                                    title: 'Configurazione '+this.getTipologia().get('tipologiaType')                                                                                  
                                                                                  });
    	var toolbar = this.createToolbar();
    	view.addDocked(toolbar);
    	
    	var Panels = Ext.ComponentQuery.query('#mainPanel'); 
        Panels[0].add (view);
    	
    	view.show();
    },
    
    createToolbar : function ()
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
                                        this.aggiungi()
                                    }
                                },
                                '-'
                            ]
                    });

      return toolbar;
        
    },
    
    aggiungi: function ()
    {
        var view = Ext.ClassManager.instantiateByAlias('widget.tipologieEdit', {
                                                                                    title: 'Tipologia '+this.getTipologia().get('tipologiaType'),
                                                                                    tipologia: this.getTipologia()                                                                                  
                                                                                  });
        
        this.application.resizeWindow(view);
                
    },
    
    
    tipologiaEdit: function(button) {
        var win    = button.up('window');
        if (win) {
            form   = win.down('form').getForm();
            if (form.isValid()){
               values = form.getValues(); 
               console.log(values);
               win.destroy();
            } else {
                console.log('invalid');
            }
            
        
            
            
        }
        
    }
    
    
    
    
    
    
    
    
    
});