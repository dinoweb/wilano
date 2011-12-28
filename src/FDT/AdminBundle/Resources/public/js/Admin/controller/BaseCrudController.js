Ext.define('Admin.controller.BaseCrudController', {
    extend: 'Ext.app.Controller',
    
    config: {
        namespace: false,
        application: false
    },
    
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
            configStore: campiStore,
            extraParams: this.getExtraParams()

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
            idString: this.getNamespace()+id,
            title: 'Configurazione '+id,
            store:  this.createStore(id, campiStore),
            idTargetPanel: this.getIdTargetPanel(),
            plugins: plugins,
            callerObject: this,
            configStore: campiStore

        });
        return panelBuilder;
    },
    
    addListenerToPanel: function (panel)
    {
        
        panel.addListener ('itemdblclick', this.aggiungi, this);
        this.addPanelListener (panel);
    
    },
    
    createPanel: function(campiStore)
    {
        //CREO IL PANNELLO
        var targetPanel = this.buildTargetPanel();
        var plugins = { ptype: 'treeviewdragdrop', allowParentInserts: true, allowContainerDrop: true, enableDrag: true, expandDelay: 20000};
        var panelBuilder = this.getPanelBuilder(this.getControllerName(), campiStore, plugins);
        var panel = panelBuilder.buildPanel(this.getPanelType());
        this.addToolbar (panel);
        this.addToolbarItems (panel);
        this.getPanelId = function ()
        {
            return panel.getId();
        };
        this.addListenerToPanel (panel);
        
        this.postCreatePanel (panel);

    },
    
    buildToolbar : function ()
    {
      var toolbar = Ext.create('Ext.toolbar.Toolbar', {
                    dock: 'top',
                    id: 'mainToolbar'+this.getControllerName(),
                    items: [
                                {
                                    text: 'Aggiungi',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/add.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'aggiungi'+this.getControllerName(),
                                    handler: function (){
                                        this.aggiungi()
                                    }
                                },
                                '-',
                                {
                                    text: 'Salva',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/accept.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'salva'+this.getControllerName(),
                                    handler: function (){
                                        this.salva()
                                    }
                                },
                                '-'
                            ]
                    });

      return toolbar;
        
    },
    
    addToolbar: function (panel)
    {
        var toolbar = this.buildToolbar();
        panel.addDocked(toolbar);
        
    },
    
    buildTargetPanel: function ()
    {
        
    },
    
    getExtraParams: function ()
    {
        return  {};
    },
    
    getIdTargetPanel: function ()
    {
        return  'mainPanel';
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
    
    addPanelListener: function (panel)
    {
        
    },
    
    postCreatePanel: function (panel)
    {
        return false;
    },
    
    getSelectedRow: function (panel)
    {
        var selModel = panel.getSelectionModel();
        return selModel.getLastSelected();        
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
        
        this.resizeWindow(view);

        if (Ext.typeOf(record) === 'undefined')
        {
            var record = Ext.create(this.getStoreBuilder().getModel());
        }

        form.loadRecord(record);
        form.getEl().on('keyup', this.onFormElKeyUp, this);
        this.getButtonForEnter().addListener ('click', this.editAction, this);
        
        form.focusFirstField (true);
        
        return form;

    },
    
    getIdButtonForEnter: function ()
    {
        
        return 'buttonSave';
    
    },
    
    getButtonForEnter: function ()
    {
        
        return Ext.getCmp(this.getIdButtonForEnter());
    
    },
    
    
    fireEventOnFormEnter: function ()
    {
        this.getButtonForEnter().fireEvent('click', this.getButtonForEnter());
    },
    
    onFormElKeyUp: function(e, el)
	{
		if (e.getKey() === e.ENTER) {
			this.fireEventOnFormEnter ();
		}
	},
    
    resizeWindow: function (window)
    {
        this.application.resizeWindow(window);
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


                };

                win.destroy();
                this.salva();
            } else {
                win.down('form').focusFirstField (true);
            }




        }

    }









});