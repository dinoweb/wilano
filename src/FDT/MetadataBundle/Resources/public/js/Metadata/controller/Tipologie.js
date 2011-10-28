Ext.define('Metadata.controller.Tipologie', {
    extend: 'Admin.controller.BaseCrudController',
    
    config: {
        tipologia: null
    },
    
    getControllerName: function ()
    {
        return 'Tipologie';
    },
    
    getRestUrl: function ()
    {
        return 'metadata/'+this.getTipologia().get('tipologiaType')+'/manageTipologie';
    },
    
    getPanelType: function ()
    {
        return 'treePanel';
    },
    
    getStoreType: function ()
    {
        return 'treeStore';
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
                   node.appendChild(record);
                   node.expand();
                   selModel.select(record);

               };

               win.destroy();
               this.salva();
               tree.getView().refresh();
            } else {
                win.down('form').focusFirstField (true);
            }
            
        
            
            
        }
        
    }

});