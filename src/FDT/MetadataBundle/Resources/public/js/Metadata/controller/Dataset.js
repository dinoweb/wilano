Ext.define('Metadata.controller.Dataset', {
    extend: 'Admin.controller.BaseCrudController',
    
    addToolbarItems: function (panel)
    {
       var toolbar = panel.getDockedComponent('mainToolbar'+this.getControllerName());
       
       toolbar.add (
            {
                text: 'Options',
                scope: this,
                icon: '/bundles/fdtadmin/images/icons/arrow_divide.png',
                cls: 'x-btn-text-icon',
                handler: function (){
                    this.manageOptions(panel)
                }
            }
       
       )
    },
    
    getSelectedRow: function (panel)
    {
        var selModel = panel.getSelectionModel();
        return selModel.getLastSelected();        
    },
    
    manageOptions: function (panel)
    {
        var selectedRow = this.getSelectedRow (panel);
        
        if (selectedRow)
        {
            var controller = Ext.create('Metadata.controller.Options', {
                                                            application: this.application,
                                                          });
            controller.init();
        }
                
    },
    
    
    getControllerName: function ()
    {
        return 'Dataset';
    },
    
    getRestUrl: function ()
    {
        return 'metadata/manageDataset';
    }

});