Ext.define('Metadata.controller.Search', {
    extend: 'Admin.controller.BaseCrudController',
    
    config: {
        application: false,
        owner: false,
        ownerModel: false,
        callerController: false
    },    
    
    getExtraParams: function ()
    {
        
        extraParams = {
               ownerModel: this.getOwnerModel(),
               filter: {}            
        }
        
        return extraParams;
    },

    
    getIdTargetPanel: function ()
    {   
        return  'searchWindowCenter';
    },
    
    buildTargetPanel: function ()
    {
        var window = Ext.create('Admin.view.BaseSearchWindow', {
            id: 'panelSearch'+this.getControllerName(),
            title: 'Cerca: '+this.getControllerName()
            
        }
        );
        this.application.resizeWindow(window);
        
    },
            
    getControllerName: function ()
    {
        var ownerTypeOj = new String(this.getOwnerModel());
        
        arrayOwnerType = ownerTypeOj.split ('__');        
        return arrayOwnerType[1];
        
    },
    
    buildToolbar : function ()
    {
      return {};
        
    },
    
    
    buildFormsButtons : function ()
    {
      var toolbar = Ext.create('Ext.toolbar.Toolbar', {
                    dock: 'bottom',
                    ui: 'footer',
                    id: 'searchToolbar'+this.getControllerName(),
                    items: [
                                '->',
                                {
                                    xtype: 'button',
                                    text: 'Cerca',
                                    scope: this,
                                    id: 'buttonCercaFromSearch'+this.getControllerName()
                                }
                            ]
                    });

      return toolbar;
        
    },
    
    addListenerToPanel: function (panel)
    {
        
        panel.addListener ('itemdblclick', this.getCallerController().creaAssociazione, this.getCallerController());
        this.addPanelListener (panel);
    
    },
    
    builfFormCerca: function ()
    {
    
        //INIZIALIZZO IL FORM
        var formBuilder = Ext.create ('Admin.FormBuilder', {
            idString: 'searchForm'+this.getControllerName(),
            configStore: this.getCampiStore()

        });
                
        var form = formBuilder.getForm ('search');
        
        var arrayPanelById = Ext.ComponentQuery.query('#searchWindowNorth');
        if (arrayPanelById.length > 0)
        {
             targetPanel = arrayPanelById[0];
             targetPanel.add(form);
             if (targetPanel.getXType() == 'tabpanel')
             {
                 targetPanel.setActiveTab(form);
             }
             
        }
        
        form.addDocked(this.buildFormsButtons());
        
        form.focusFirstField (true);
        
        form.getEl().on('keyup', this.onFormElKeyUp, this);
        
        this.getButtonForEnter().addListener ('click', this.searchAction, this);
    
    },
    
    getIdButtonForEnter: function ()
    {
        
        return 'buttonCercaFromSearch'+this.getControllerName();
    
    },

    
        
    postCreatePanel: function (panel)
    {
    
        if (this.getCallerController())
        {
            
            this.getCallerController().addSearchWindowCenterToolbar (panel);
        
        }

        this.builfFormCerca();

    },
    
    searchAction: function(button) {
        var win = button.up('window');
        if (win) {
            form   = win.down('form').getForm();
            var values = form.getValues();
            var store = Ext.data.StoreManager.lookup(this.getStoreBuilder().getIdStore());
            
            store.getProxy().extraParams.filter = Ext.JSON.encode (values);
            
            store.load();
        }

    },
    
    getTitle: function (title)
    {
    
        return 'Risultati ricerca';
    
    },   
    
    getRestUrl: function ()
    {
        return 'metadata/manageSearch';
    }  

});