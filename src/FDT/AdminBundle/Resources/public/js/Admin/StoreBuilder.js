Ext.define('Admin.StoreBuilder', {    
    config: {
        idString: 'Manca id',
        urlRead: 'read',
        urlUpdate: 'update',
        urlCreate: 'create',
        rootField: 'text',
        rootValue: 'contenuto',
        proxyParamName: 'type',
        proxyParam: 'tipo',
        proxyType: 'rest',
        configFor: 'Tipologie',
        configStore: null,
        fieldsCollection: null
    },
    
    constructor: function(config) {
        this.initConfig(config);

        return this;
    },
    
    
    addFieldToCollection: function (record)
    {
        if(record.get('useForModel'))
        {
            this.getFieldsCollection().add({
                name: record.get('name'),
                type: record.get('type'),
                defaultValue: record.get('defaultValue')
            });
        }
        
    },
    
    getFields: function ()
    {
        var configStore = this.getConfigStore();
        this.setFieldsCollection(new Ext.util.MixedCollection(false, function(el){
                                                                        return el.name;
                                                                    }));
        configStore.each(this.addFieldToCollection, this);
        return this.getFieldsCollection().items;
    },
    
    // Generate a model dynamically, provide fields
    modelFactory: function (name, fields, root) {
        return Ext.define(name, {
            extend: 'Admin.model.BaseModel',
            fields: fields
        });
    },
    
    // Generate a model dynamically, provide fields
    proxyFactory: function () {
        return Ext.define('MyProxy', {
            extend: 'Ext.data.proxy.Rest',
            config: {
                builderObject: this
            }
        });
    },
    
    // Generate a model dynamically, provide fields
    treeStoreFactory: function (name) {
        
        var builderClass = this;
        var idStore = 'idStore'+this.getIdString();
        this.getIdStore = function ()
        {
            return idStore;
        }
                
        var idModel = 'idModel'+this.getIdString();
        var idRoot  = 'idRoot'+this.getIdString();
        var idProxy  = 'idProxy'+this.getIdString();
        var idReader  = 'idReader'+this.getIdString();
        var idWriter  = 'idWriter'+this.getIdString();
        
        var model = this.modelFactory(idModel, this.getFields());

        this.getModel = function ()
        {
            return model;
        }
        
        var proxyConstructor = this.proxyFactory();
        
        var proxy = Ext.create(proxyConstructor, {
                id: idProxy,
                builderObject: this,
                reader: {
    			    id: idReader,
    			    type: 'json'
                },
                writer: {
                    id: idWriter,
                    type: 'json'
                },
                afterRequest: this.manageResponse,
                api: {
                    read    : this.getUrlRead(),
                    update  : this.getUrlUpdate(),
                    create  : this.getUrlCreate(),
                    destroy : this.getUrlUpdate()
                }      
        
        });
                 
        var store = Ext.define(name, {
            extend: 'Admin.store.BaseTreeStore',
            storeId: idStore,
            clearOnLoad: true,
            model: model,
            root: {
                id: idRoot,
                checked: null,
                expanded: false,
                isFirst: true,
                leaf: false
            },
            myReload: function (){
                var updatedRecords = store.getUpdatedRecords();
                var newRecords = store.getNewRecords();
                var recordsToBeManaged = Ext.Array.merge (updatedRecords, newRecords);
                console.log (recordsToBeManaged);
            },
            proxy: proxy
                    
        });
        
       
        
        var store = Ext.create(store);
        this.getStore = function(){
            return store;
        }
        return store;
        
        
    },
    
    refreshData: function ()
    {
        var updatedRecords = this.getStore().getUpdatedRecords();
        var newRecords = this.getStore().getNewRecords();
        var recordsToBeManaged = Ext.Array.merge (updatedRecords, newRecords);
        if (recordsToBeManaged.length)
        {
            
            lastRecord = recordsToBeManaged.pop();
            node = this.getStore().getNodeById (lastRecord.getId( ));
            if (node.parentNode)
            {
                this.getStore().load({ 
                            action: 'read',
                            scope: this,
                            node: node.parentNode, 
                            callback: function (){
                                //console.log ('refresh');
                            }
                });    
            }
        }
    },
    
    manageResponse: function(request,success){
        
        if(request.method == 'PUT' && success){
             this.getBuilderObject ().refreshData();
             Ext.Msg.alert('OK', this.getReader().jsonData['message']);
        }
        if(request.method == 'POST' && success){
             this.getBuilderObject ().refreshData();
             Ext.Msg.alert('OK', this.getReader().jsonData['message']);
        }
        if (!success){
            Ext.Msg.alert('KO', 'Il server non risponde correttamente');
        }
        
    },
    
    
    buildStore: function (name)
    {

        return this.treeStoreFactory(name);
        
    }
});