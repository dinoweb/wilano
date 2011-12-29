Ext.define('Metadata.controller.Tipologie', {
    extend: 'Admin.controller.BaseCrudController',
    
    config: {
        tipologia: null
    },
    
    getTipologiaType: function ()
    {
        
        return this.getTipologia().get('tipologiaType');
    
    },
    
    getControllerName: function ()
    {
        return 'Tipologie';
    },
    
    getRestUrl: function ()
    {
        return 'metadata/'+this.getTipologiaType()+'/manageTipologie';
    },
    
    getPanelType: function ()
    {
        return 'treePanel';
    },
    
    getStoreType: function ()
    {
        return 'treeStore';
    },
    
    addToolbarItems: function (panel)
    {
       var toolbar = panel.getDockedComponent('mainToolbar'+this.getControllerName());
       
       toolbar.add (
            {
                text: 'Attributi',
                tooltip: 'Relaziona attributi',
                scope: this,
                icon: '/bundles/fdtadmin/images/icons/arrow_divide.png',
                cls: 'x-btn-text-icon',
                handler: function (){
                    this.manageAttributi(panel)
                }
            }
       
       )
    },
    
    
    manageAttributi: function (panel)
    {
        var selectedRow = this.getSelectedRow (panel); 

        var controller = Ext.create('Metadata.controller.Relation', {
                                                        application: this.getApplication(),
                                                        owner: selectedRow,
                                                        ownerModel: 'Tipologie__'+this.getTipologiaType(),
                                                        relatedModel: 'Attributi__Attributo',
                                                        relationModel: 'Attributi__Config',
                                                        relationType: 'manyWithConfig',
                                                        setRelationFunction: 'addAttributi',
                                                        getRelationFunction: 'getAttributiTree',
                                                        setRelationToConfigFunction: 'addAttributo',
                                                        getRelationToConfigFunction: 'getAttributo'
                                                      });
        controller.init();
   
    },
    
    addPanelListener: function (panel)
    {
        panel.addListener('itemmove', this.salva , this);
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
                   record.set ('leaf', false);
                   record.set ('expanded', true);
                   record.set ('loaded', true);
                                      
                    
                   var tree = Ext.ComponentQuery.query('#'+this.getPanelId())[0];
                   var selModel = tree.getSelectionModel();
                   var node = selModel.getLastSelected();
                   if (!node) {
                    var node = tree.getRootNode();
                   }
                   node.set('leaf', false);
                   node.appendChild(record);
                   record.phantom = true;
                   tree.getView().refresh();
                   node.expand();
                   selModel.select(record);

               };

               win.destroy();
               this.salva();
            } else {
                win.down('form').focusFirstField (true);
            }
            
        
            
            
        }
        
    }

});