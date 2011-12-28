Ext.define('Metadata.controller.Relation', {
    extend: 'Admin.controller.BaseCrudController',
    
    config: {
        owner: false,
        ownerType: false,
        relatedType: false,
        relationModel: false,
        relationType: 'one',
        setRelationFunction: false,
        getRelationFunction: false
    },
    
    getExtraParams: function ()
    {
        owner = this.getOwner ();
        extraParams = {};
        
        if (owner)
        {
           extraParams = {
               ownerType: this.getOwnerType(),
               ownerId: owner.get('id'),
               relatedType: this.getRelatedType(),
               relationType: this.getRelationType(),
               getRelationFunction: this.getGetRelationFunction(),
               setRelationFunction: this.getSetRelationFunction(),
                             
           }
        }
        return extraParams;
    },
    
    resizeWindow: function (window)
    {
        this.application.resizeWindow(window, 50, 1.7);
    },
    
    
    buildToolbar : function ()
    {
      var toolbar = Ext.create('Ext.toolbar.Toolbar', {
                    dock: 'top',
                    id: 'mainToolbar'+this.getControllerName(),
                    items: [
                                {
                                    text: 'Aggiungi relazione',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/add.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'aggiungi'+this.getControllerName(),
                                    handler: function (){
                                        this.searchRelatedObject()
                                    }
                                },
                                '-',
                                {
                                    text: 'Elimina',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/delete.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'removeRelation'+this.getControllerName(),
                                    handler: function (){
                                        this.removeRelation()
                                    }
                                },
                                '-'
                            ]
                    });

      return toolbar;
        
    },
    
    
    buildSearchWindowCenterToolbar : function ()
    {
      var toolbar = Ext.create('Ext.toolbar.Toolbar', {
                    dock: 'top',
                    id: 'searchToolbar'+this.getControllerName(),
                    items: [
                                {
                                    text: 'Scegli',
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/add.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'scegliFromSearch'+this.getControllerName(),
                                    handler: function (button){
                                        this.aggiungi(button)
                                    }
                                }
                            ]
                    });

      return toolbar;
        
    },
    
    aggiungi : function (button)
    {
        var searchResultPanel = button.up('panel');
        
        var selectedRow = this.getSelectedRow (searchResultPanel);
        
        if (selectedRow && this.getRelationType() == 'one')
        {
        
            selectedRow.setDirty();
        
            var grid = Ext.ComponentQuery.query('#'+this.getPanelId())[0];
            grid.getStore().insert(0, selectedRow);
            grid.getView().refresh();
            
            grid.getStore().sync();
        
        }
        
        
        if (selectedRow && this.getRelationType() == 'manyWithConfig')
        {
        
            var form = this.callParent(button);
            
            var record = form.getRecord();
            
            record.set ('relatedId', selectedRow.get ('id'));
            
            console.log (record);
        
        }
        
        
        
    },
    
    
    addSearchWindowCenterToolbar : function (panel)
    {
    
        var tootlbarSearch = this.buildSearchWindowCenterToolbar ();
        
        panel.addDocked(tootlbarSearch);
        
    
    
    },
    
    searchRelatedObject: function ()
    {        

            var controller = Ext.create('Metadata.controller.Search', {
                                                            namespace: 'searchWindow',
                                                            ownerType: this.getRelatedType(),
                                                            application: this.getApplication(),
                                                            callerController: this
                                                          });
            controller.init();                
    },
    
    
    getControllerName: function ()
    {
        var relatedModelOj = new String(this.getRelationModel());
        
        arrayRelatedModel = relatedModelOj.split ('__');        
        return arrayRelatedModel[1];
        
    },
    
    
    getRestUrl: function ()
    {
        return 'metadata/manageRelations';
    }  

});