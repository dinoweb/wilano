Ext.define('Metadata.controller.Relation', {
    extend: 'Admin.controller.BaseCrudController',
    
    config: {
        owner: false,
        ownerModel: false,
        relatedModel: false,
        relationModel: false,
        relationType: 'one',
        setRelationFunction: false,
        getRelationFunction: false,
        setRelationToConfigFunction: false,
        getRelationToConfigFunction: false
    },
    
    getExtraParams: function ()
    {
        owner = this.getOwner ();
        extraParams = {};
        
        if (owner)
        {
           extraParams = {
               ownerModel: this.getOwnerModel(),
               ownerId: owner.get('id'),
               relatedModel: this.getRelatedModel(),
               relationModel: this.getRelationModel(),
               relationType: this.getRelationType(),
               setRelationFunction: this.getSetRelationFunction(),
               getRelationFunction: this.getGetRelationFunction(),
               setRelationToConfigFunction: this.getSetRelationToConfigFunction(),
               getRelationToConfigFunction: this.getGetRelationToConfigFunction()
                             
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
                                    tooltip: 'Relaziona '+this.getRelatedName()+' a '+this.getOwnerName(),
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
                                    tooltip: 'Relaziona il '+this.getRelatedName()+' selezionato a '+this.getOwnerName(),
                                    scope: this,
                                    icon: '/bundles/fdtadmin/images/icons/add.png',
                                    cls: 'x-btn-text-icon',
                                    id: 'scegliFromSearch'+this.getControllerName(),
                                    handler: function (button){
                                        this.creaAssociazione(button)
                                    }
                                }
                            ]
                    });

      return toolbar;
        
    },
    
    creaAssociazione : function (button)
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
            var form = this.aggiungi(button);
            var record = form.getRecord();
            
            record.set ('relatedId', selectedRow.get ('id'));
                    
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
                                                            ownerModel: this.getRelatedModel(),
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
    
    getOwnerName: function ()
    {
        var ownerModelOj = new String(this.getOwnerModel());
        
        arrayOwnerModel = ownerModelOj.split ('__');        
        return arrayOwnerModel[1];
        
    },
    
    
    getRelatedName: function ()
    {
        var modelOj = new String(this.getRelatedModel());
        
        arrayModel = modelOj.split ('__');        
        return arrayModel[1];
        
    },
    
    
    getRestUrl: function ()
    {
        return 'metadata/manageRelations';
    },
    
    getTitle: function (title)
    {
    
        return 'Relazioni: '+this.getOwner().get('uniqueName')+' > '+this.getRelatedName();
    
    }  

});