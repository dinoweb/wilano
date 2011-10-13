Ext.define('Metadata.controller.Attributi', {
    extend: 'Ext.app.Controller',
    
    stores:
    [
        'Metadata.store.Attributi.Tipo'
    ],
        
    refs: [     
        {ref:'mainPanel', selector: '#mainPanel'}
    ],
        
    init: function() {
                  
          this.loadConfigurationsAndPanel();
                   
    },
    
    loadConfigurationsAndPanel: function ()
    {
        var storeModelConfigConstruct = Ext.create('Admin.ConfigBuilder', {
            extraParams: {configFor: 'Attributi'},
            autoLoad: false,
            id: 'attributiConfig'
        });
        
        var store = storeModelConfigConstruct.getConfigStore();
        store.load({
            scope: this,
            callback: function(records, operation, success) {
                this.createPanel(store);
            }
            
        });  
    },
    
    
        
    createPanel: function(modelStore)
    {  
        var tipologiaType = 'Attributi';
        
        this.getModelStore = function ()
        {
            return modelStore;
        }
        
        
        //INIZIALIZZO COSTRUISCO LO STORE
        var storeBuilder = Ext.create ('Admin.StoreBuilder', {
            idString: tipologiaType,
            urlRead: 'metadata/manageAttributi',
            urlUpdate: 'metadata/manageAttributi',
            urlCreate: 'metadata/manageAttributi',
            proxyType: 'rest',
            configFor: 'Attributi',
            configStore: modelStore
        
        });
        this.getStoreBuilder = function ()
        {
            return storeBuilder;
        }

        //CREO LO STORE        
        var attributiStore = storeBuilder.buildStore (tipologiaType, 'store');
        
        //INIZIALIZZO IL PANNELLO
        var panelBuilder = Ext.create ('Admin.PanelBuilder', {
            idString: tipologiaType,
            title: 'Configurazione '+tipologiaType,
            store:  attributiStore,
            callerObject: this,
            configStore: modelStore

        });
        
        //CREO IL PANNELLO
        var panel = panelBuilder.buildPanel('gridPanel');
        this.getPanelId = function ()
        {
            return panel.getId();
        };
        panel.addListener ('itemdblclick', this.aggiungi, this);        
    	
    	
    },
    
    
    
    aggiungi: function (grid, record)
    {
        
        //INIZIALIZZO IL PANNELLO
        var formBuilder = Ext.create ('Admin.FormBuilder', {
            idString: 'Attributi',
            configStore: this.getModelStore()

        });
        var form = formBuilder.getForm ();
        
        var view = Ext.create('Admin.view.BaseWindow', {
                                                            id: 'editAttributi',
                                                            title: 'Attributi',
                                                            items: form                                                                               
                                                           }
                                           );
        
        if (Ext.typeOf(record) === 'undefined')
        {
           var record = Ext.create(this.getStoreBuilder().getModel());
           record.set('uniqueName', 'Palla new');
        }
        
        form.loadRecord(record);
        form.focusFirstField (true);
        
        this.application.resizeWindow(view);
        
        Ext.getCmp('buttonSave').addListener ('click', this.tipologiaEdit, this);
                                
    },
    
    
    salva: function ()
    {
        var store = Ext.data.StoreManager.lookup(this.getStoreBuilder().getIdStore());
        store.sync();        
                
        
    },
    
        
    tipologiaEdit: function(button) {
        var win    = button.up('window');
        if (win) {
            form   = win.down('form').getForm();
            if (form.isValid()){
               var values = form.getValues();
               var record = form.getRecord();
               record.set(values);
               
               if (record.getId() === '')
               {
                   record.setId (this.application.generateUniqid());
                   record.set ('isNew', true);
                    
                   var grid = Ext.ComponentQuery.query('#'+this.getPanelId())[0];
                   grid.getStore().insert(0, record);
                   grid.getView().refresh();
                   console.log('salva');
                   

               };

               win.destroy();
               this.salva();
            } else {
                win.down('form').focusFirstField (true);
            }
            
        
            
            
        }
        
    }
    
    
    
    
    
    
    
    
    
});