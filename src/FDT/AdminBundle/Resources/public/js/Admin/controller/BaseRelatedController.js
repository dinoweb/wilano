Ext.define('Admin.controller.BaseRelatedController', {
    extend: 'Admin.controller.BaseCrudController',
    
    config: {
        application: false,
        owner: false,
        ownerType: false,
        relatedType: false,
        setRelationFunction: false,
        getRelationFunction: false
    },
    
    buildTargetPanel: function ()
    {
        var window = Ext.create('Admin.view.BaseRelationsWindow', {
            id: 'panel'+this.getControllerName(),
            title: this.getControllerName()
        }
        );
        this.application.resizeWindow(window);
        
    },
         
    resizeWindow: function (window)
    {
        this.application.resizeWindow(window, 50, 1.7);
    }

});