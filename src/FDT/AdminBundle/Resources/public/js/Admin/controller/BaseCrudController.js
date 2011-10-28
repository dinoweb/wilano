Ext.define('Admin.controller.BaseCrudController', {
    extend: 'Ext.app.Controller',

    refs: [
    {
        ref:'mainPanel',
        selector: '#mainPanel'
    }
    ],

    init: function() {

        this.loadConfigurationsAndPanel();

    },

    loadConfigurationsAndPanel: function ()
    {
        var storeModelConfigConstruct = Ext.create('Admin.ConfigBuilder', {
            extraParams: {
                configFor: this.getControllerName()
            },
            autoLoad: false,
            id: this.getControllerName()+'Config'
        });

        var store = storeModelConfigConstruct.getConfigStore();
        
        store.getProxy().extraParams = {
            configFor: this.getControllerName(),
        };
        
        store.load({
            scope: this,
            callback: function(records, operation, success) {
                this.loadCampi(store);
            }

        });
    },
    
    loadCampi: function (configStore)
    {
        var campiStore = configStore.getAt(0).campi();
        this.getCampiStore = function ()
        {
            return campiStore;
        }
        
        campiStore.getProxy().extraParams = {
                        configType: 'campi'
        };
        campiStore.load({
            scope: this,
            callback: function(records, operation, success) {
                this.createPanel(campiStore);
            }
            
        });
        this.getConfigStore = function ()
        {
            return configStore;
        }
        
    },
    

    createStore: function (id, campiStore)
    {
        //INIZIALIZZO COSTRUISCO LO STORE
        var storeBuilder = Ext.create ('Admin.StoreBuilder', {
            idString: id,
            urlRead: this.getRestUrl(),
            urlUpdate: this.getRestUrl(),
            urlCreate: this.getRestUrl(),
            configStore: campiStore

        });
        this.getStoreBuilder = function ()
        {
            return storeBuilder;
        }
        
        var storeType = 'store';
        //CREO LO STORE
        var controllerStore = storeBuilder.buildStore (id, this.getStoreType());
        return controllerStore;
        
    },
    
    getPanelBuilder: function (id, campiStore, plugins)
    {
        
        //INIZIALIZZO IL PANNELLO
        var panelBuilder = Ext.create ('Admin.PanelBuilder', {
            idString: id,
            title: 'Configurazione '+id,
            store:  this.createStore(id, campiStore),
            plugins: plugins,
            callerObject: this,
            configStore: campiStore

        });
        return panelBuilder;
    },
    
    createPanel: function(campiStore)
    {
        //CREO IL PANNELLO
        var plugins = { ptype: 'treeviewdragdrop', allowParentInserts: true, allowContainerDrop: true, enableDrag: true, expandDelay: 20000};
        var panelBuilder = this.getPanelBuilder(this.getControllerName(), campiStore, plugins);
        var panel = panelBuilder.buildPanel(this.getPanelType());
        this.addToolbarItems (panel);
        this.getPanelId = function ()
        {
            return panel.getId();
        };
        panel.addListener ('itemdblclick', this.aggiungi, this);

    },
    
    getPanelType: function ()
    {
        return 'gridPanel';
    },
    
    getStoreType: function ()
    {
        return 'store';
    },

    addToolbarItems: function (panel)
    {
        
    },

    aggiungi: function (grid, record)
    {

        //INIZIALIZZO IL PANNELLO
        var formBuilder = Ext.create ('Admin.FormBuilder', {
            idString: this.getControllerName(),
            configStore: this.getCampiStore()

        });
                
        var form = formBuilder.getForm ();
        var view = Ext.create('Admin.view.BaseWindow', {
            id: 'edit'+this.getControllerName(),
            title: this.getControllerName(),
            items: form
        }
        );

        if (Ext.typeOf(record) === 'undefined')
        {
            var record = Ext.create(this.getStoreBuilder().getModel());
            record.set('uniqueName', 'Palla new');
            record.set('uniqueSlug', 'Palla slug');
        }

        form.loadRecord(record);
        form.focusFirstField (true);

        this.application.resizeWindow(view);

        Ext.getCmp('buttonSave').addListener ('click', this.editAction, this);

    },

    salva: function ()
    {
        var store = Ext.data.StoreManager.lookup(this.getStoreBuilder().getIdStore());
        store.sync();
    },


    editAction: function(button) {
        var win    = button.up('window');
        if (win) {
            form   = win.down('form').getForm();
            if (form.isValid()){
                var values = form.getValues();
                var record = form.getRecord();
                record.set(values);

                if (record.phantom)
                {
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