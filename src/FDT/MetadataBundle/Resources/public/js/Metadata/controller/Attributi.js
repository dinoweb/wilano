Ext.define('Metadata.controller.Attributi', {
    extend: 'Admin.controller.BaseCrudController',
    
    stores:
    [
    'Metadata.store.Attributi.Tipo'
    ],
    
    addToolbarItems: function (panel)
    {
       var toolbar = panel.getDockedComponent('mainToolbar'+this.getControllerName());
       
       toolbar.add (
            {
                text: 'Dataset',
                tooltip: 'Aggiungi un dataset',
                scope: this,
                icon: '/bundles/fdtadmin/images/icons/arrow_divide.png',
                cls: 'x-btn-text-icon',
                handler: function (){
                    this.manageDataset(panel)
                }
            }
       
       )
    },
    
    
    manageDataset: function (panel)
    {
        var selectedRow = this.getSelectedRow (panel); 
        
        if (selectedRow && (selectedRow.get('tipo') == 'singleSelect' || selectedRow.get('tipo') == 'multipleSelect'))
        {
            var controller = Ext.create('Metadata.controller.Relation', {
                                                            application: this.application,
                                                            owner: selectedRow,
                                                            ownerType: 'Attributi__Attributo',
                                                            relatedType: 'Attributi__DataSet',
                                                            relationModel: 'Attributi__DataSet',
                                                            relationType: 'one',
                                                            setRelationFunction: 'addDataset',
                                                            getRelationFunction: 'getDataset'
                                                          });
            controller.init();
        }
        else
        {
        
            Ext.Msg.alert('Attenzione', 'Attributo slezionato deve essere singleSelect o multipleSelect');
            
        }
        
        
                
    },

    
    getControllerName: function ()
    {
        return 'Attributo';
    },
    
    getRestUrl: function ()
    {
        return 'metadata/manageAttributi';
    }

});