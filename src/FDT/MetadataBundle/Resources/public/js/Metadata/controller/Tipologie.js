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
                  
          this.createPanel();
                   
    },
    
    
        
    createPanel: function()
    {  
        var tipologiaType = this.getTipologia().get('tipologiaType');
        
        var storeBuilder = Ext.create ('Admin.StoreBuilder', {
            idString: tipologiaType,
            urlRead: 'metadata/'+tipologiaType+'/getTipologie',
            urlUpdate: 'metadata/'+tipologiaType+'/updateTipologie',
            rootField: 'uniqueName',
            rootValue: tipologiaType
        
        });
        this.getStoreBuilder = function ()
        {
            return storeBuilder;
        }
              
        
        var panelId = 'idManage'+tipologiaType;
        var viewId = 'idView'+tipologiaType;
        
        this.getPanelId = function ()
        {
            return panelId;
        }
        
        
        
        
        var arrayPanelById = Ext.ComponentQuery.query('#'+panelId);
        
        if (arrayPanelById.length > 0)
        {
            arrayPanelById[0].destroy();
        }
        
        
        var tipologieStore = storeBuilder.buildStore (tipologiaType);
                                
        
        var view = Ext.widget('tipologieManage', {
                                                    itemId: panelId,
                                                    title: 'Configurazione '+tipologiaType,
                                                    store: tipologieStore,
                                                    viewConfig: {
                                                                    id: viewId,
                                                                    plugins: { ptype: 'treeviewdragdrop', allowParentInserts: true},
                                                                    listeners: {
                                                                                    drop: function(nodeEl, data) {
                                                                                        //this.getTreeStore().sync() //DA ATTIVARE SE STORE TYPE rest
                                                                                    }
                                                                                }
                                                                }                                                                                 
                                                  });
        
        view.addListener ('itemdblclick', this.aggiungi, this);
        
        
    	var toolbar = this.createToolbar();
    	view.addDocked(toolbar);
    	
    	view.getView( )
    	
        this.getMainPanel().add(view);
        this.getMainPanel().setActiveTab(view);
    	
    	
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
                                    id: 'aggiungi'+this.getTipologia().get('tipologiaType'),
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
                                    id: 'salva'+this.getTipologia().get('tipologiaType'),
                                    handler: function (){
                                        this.salva()
                                    }
                                },
                                '-'
                            ]
                    });

      return toolbar;
        
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