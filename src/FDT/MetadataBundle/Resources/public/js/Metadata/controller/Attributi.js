Ext.define('Metadata.controller.Attributi', {
    extend: 'Admin.controller.BaseCrudController',
    
    stores:
    [
    'Metadata.store.Attributi.Tipo'
    ],
    
    
    getControllerName: function ()
    {
        return 'Attributi';
    },
    
    getRestUrl: function ()
    {
        return 'metadata/manageAttributi';
    }

});