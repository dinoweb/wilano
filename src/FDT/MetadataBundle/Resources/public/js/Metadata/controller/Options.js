Ext.define('Metadata.controller.Options', {
    extend: 'Admin.controller.BaseRelatedController',
    
    getIdTargetPanel: function ()
    {   
        return  'relatedPanel';
    },
    
    getExtraParams: function ()
    {
        relatedRecord = this.getOwner();
        extraParams = {};
        
        if (relatedRecord)
        {
           extraParams = {
               ownerType: 'Attributi__DataSet',
               ownerId: relatedRecord.get('id'),
               relatedType: 'Attributi__Options',
               relatedGetFunction: 'getOptions'
           }
        }
        return extraParams;
    },
    
    resizeWindow: function (window)
    {
        this.application.resizeWindow(window, 50, 1.7);
    },
    
    getControllerName: function ()
    {
        return 'Options';
    },
    
    getRestUrl: function ()
    {
        return 'metadata/manageOptions';
    }

});