Ext.define('Admin.PanelBuilder', {    
    config: {
        idString: 'Manca id',
        title: 'Titolo',
        store:  null,
        plugins: null,
        idTargetPanel: 'mainPanel',
        isUnique: true,
        callerObject: null,
        configStore: null,
        columsCollection: null
    },
    
    constructor: function(config) {
        this.initConfig(config);

        return this;
    },
    
    addColumnToCollection: function (record)
    {
        if(record.get('useForColumn'))
        {
            this.getColumsCollection().add({
                    xtype: record.get('xtype'),
                    text: record.get('text'),
                    flex: record.get('flex'),
                    sortable: record.get('sortable'),
                    dataIndex: record.get('name'),
                    hidden: record.get('hidden')
            });
            
        }
        
        
    },
    
    getColumns: function ()
    {
        var configStore = this.getConfigStore();
        this.setColumsCollection(new Ext.util.MixedCollection(false, function(el){
                                                                        return el.dataIndex;
                                                                    }));
        configStore.each(this.addColumnToCollection, this);
        return this.getColumsCollection().items;
    },
    
    getPanelId: function ()
    {
        var panelId = 'manage'+this.getIdString();
        return panelId;
    },
    
    getViewId: function ()
    {
        var viewId = 'viewManage'+this.getIdString();
        return viewId;
    },
    
    
    generateTreePanel: function ()
    {        
        return Ext.define(this.getIdString(), {
            extend: 'Admin.view.BaseTreePanel',
            id: this.getPanelId(),
            columns: this.getColumns(),
            columnLines: true,
            title: this.getTitle(),
            store: this.getStore(),
            viewConfig: {
                    id: this.getViewId(),
                    stripeRows: true,
                    padding: '0 0 0 5',
                    loadMask: true,
                    plugins: this.getPlugins()
            }
        });
    
    },
    
    generateGridPanel: function ()
    {
        
        return Ext.define(this.getIdString(), {
            extend: 'Admin.view.BaseGridPanel',
            id: this.getPanelId(),
            columns: this.getColumns(),
            columnLines: true,
            title: this.getTitle(),
            store: this.getStore(),
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: this.getStore(),   // same store GridPanel is using
                dock: 'bottom',
                displayInfo: true
            }],
            viewConfig: {
                    id: this.getViewId(),
                    stripeRows: true,
                    loadMask: true,
                    plugins: this.getPlugins()
            }
        });
    
    },
    
    panelFactory: function (tipo) {
        this.removeSamePanel (this.getPanelId());    
        if (tipo == 'treePanel')
        {
            var panel = this.generateTreePanel ();
        }
        
        
        if (tipo == 'gridPanel')
        {
            var panel = this.generateGridPanel ();
        }
        
        return panel;
                
    },
    
    removeSamePanel: function (panelId)
    {
        if (this.getIsUnique())
        {
            
           var arrayPanelById = Ext.ComponentQuery.query('#'+panelId);
        
           if (arrayPanelById.length > 0)
           {
               arrayPanelById[0].destroy();
           } 
        }
        
        
    },
    
    insertPanel: function (panel)
    {
        var arrayPanelById = Ext.ComponentQuery.query('#'+this.getIdTargetPanel());
        if (arrayPanelById.length > 0)
        {
             targhetPanel = arrayPanelById[0];
             targhetPanel.add(panel);
             targhetPanel.setActiveTab(panel);
        }
        else
        {
            console.log('Il panel'+this.getIdTargetPanel()+'non esiste')
        }
    },
    
    buildToolbar : function ()
    {
      var toolbar = Ext.create('Ext.toolbar.Toolbar', {
                    dock: 'top',
                    items: [
                                {
                                    text: 'Aggiungi',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/add.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'aggiungi'+this.getIdString(),
                                    handler: function (){
                                        this.getCallerObject().aggiungi()
                                    }
                                },
                                '-',
                                {
                                    text: 'Salva',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/accept.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'salva'+this.getIdString(),
                                    handler: function (){
                                        this.getCallerObject().salva()
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
    
    buildPanel: function (tipo)
    {
        var panelConstruct = this.panelFactory(tipo);
        var panel = Ext.create(panelConstruct);
    	this.addToolbar(panel);
        this.insertPanel (panel);
        return panel;
    }
});