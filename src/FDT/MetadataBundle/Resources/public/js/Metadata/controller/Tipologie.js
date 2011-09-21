Ext.define('Metadata.controller.Tipologie', {
    extend: 'Ext.app.Controller',
    
    config: {
        tipologia: null
    },
    
    refs: [     
        {ref:'mainPanel', selector: '#mainPanel'}
    ],
    
    views:
    [
        'Tipologie.Manage',
        'Tipologie.Edit',
        'Tipologie.EditTranslation'
    ],
        
    init: function() {
                  
          this.loadConfigurationsAndPanel();
                   
    },
    
    loadConfigurationsAndPanel: function ()
    {
        var storeModelConfigConstruct = Ext.create('Admin.ConfigBuilder', {
            extraParams: {configFor: 'Tipologie'},
            autoLoad: false,
            id: 'Tiplogie'
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
        var tipologiaType = this.getTipologia().get('tipologiaType');
        
        //INIZIALIZZO COSTRUISCO LO STORE
        var storeBuilder = Ext.create ('Admin.StoreBuilder', {
            idString: tipologiaType,
            urlRead: 'metadata/'+tipologiaType+'/getTipologie',
            urlUpdate: 'metadata/'+tipologiaType+'/updateTipologie',
            rootField: 'uniqueName',
            rootValue: tipologiaType,
            configFor: 'Tipologie',
            modelStore: modelStore
        
        });
        this.getStoreBuilder = function ()
        {
            return storeBuilder;
        }
        //CREO LO STORE        
        var tipologieStore = storeBuilder.buildStore (tipologiaType);
        
        //INIZIALIZZO IL PANNELLO
        var panelBuilder = Ext.create ('Admin.PanelBuilder', {
            idString: tipologiaType,
            title: 'Configurazione '+tipologiaType,
            store:  tipologieStore,
            plugins: { ptype: 'treeviewdragdrop', allowParentInserts: true},
            callerObject: this

        });
        //CREO IL PANNELLO
        var panel = panelBuilder.buildTreePanel();
        this.getPanelId = function ()
        {
            return panel.getId();
        };
        panel.addListener ('itemdblclick', this.aggiungi, this);
        
    	
    	
    },
    
    
    
    aggiungi: function (grid, record)
    {
        var view = Ext.ClassManager.instantiateByAlias('widget.tipologieEdit', {
                                                                                    id: 'editTipologia'+this.getTipologia().get('tipologiaType'),
                                                                                    title: 'Tipologia '+this.getTipologia().get('tipologiaType'),
                                                                                    tipologia: this.getTipologia()                                                                                  
                                                                                  });
        
        if (Ext.typeOf(record) === 'undefined')
        {
           var record = Ext.create(this.getStoreBuilder().getModel());
           record.set('uniqueName', 'Palla new');
        }
        
        view.down('form').loadRecord(record);
        
        this.application.resizeWindow(view);
        
        view.query('#buttonSave')[0].addListener ('click', this.tipologiaEdit, this);
                                
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
                   var tree = Ext.ComponentQuery.query('#'+this.getPanelId())[0];
                   var selModel = tree.getSelectionModel();
                   var node = selModel.getLastSelected();
                   if (!node) {
                    var node = tree.getRootNode();
                   }
                   node.set('leaf', false);
                   node.appendChild(record);
                   tree.getView().refresh();
                   node.expand();

               };

               win.destroy();
               this.salva();
            } else {
                console.log('invalid');
            }
            
        
            
            
        }
        
    }
    
    
    
    
    
    
    
    
    
});