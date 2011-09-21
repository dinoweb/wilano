Ext.define('Admin.PanelBuilder', {    
    config: {
        idString: 'Manca id',
        title: 'Titolo',
        store:  null,
        plugins: null,
        idTargetPanel: 'mainPanel',
        isUnique: true,
        callerObject: null
    },
    
    constructor: function(config) {
        this.initConfig(config);

        return this;
    },
    
    getColumns: function ()
    {
        var columns = [
	    	{xtype: 'treecolumn', text: 'Tipologia', flex: 2, sortable: false, dataIndex: 'uniqueName'},
		    {text: 'Attivo', flex: 1, sortable: false, dataIndex: 'isActive'},
		    {text: 'Privato', flex: 1, sortable: false, dataIndex: 'isPrivate'},
		    {text: 'Configurabile', flex: 1, sortable: false, dataIndex: 'isConfigurable'},
		    {text: 'Ha Periodo', flex: 1, sortable: false, dataIndex: 'hasPeriod'}
		];
        
        return columns;
    },
    
    // Generate a model dynamically, provide fields
    panelFactory: function () {
            
        var panelId = 'manage'+this.getIdString();
        var viewId = 'viewManage'+this.getIdString();
        
        this.removeSamePanel (panelId);
        
        return Ext.define(this.getIdString(), {
            extend: 'Admin.view.BaseTreePanel',
            id: panelId,
            title: this.getTitle(),
            store: this.getStore(),
            viewConfig: {
                id: viewId,
                plugins: this.getPlugins()
                }
            } 
        );
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
    
    buildTreePanel: function ()
    {
        var panelConstruct = this.panelFactory();
        var panel = Ext.create(panelConstruct);
    	this.addToolbar(panel);
        this.insertPanel (panel);
        return panel;
    }
});