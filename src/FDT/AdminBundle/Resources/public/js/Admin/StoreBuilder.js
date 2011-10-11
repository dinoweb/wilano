Ext.define('Admin.StoreBuilder', {    
    config: {
        idString: 'Manca id',
        urlRead: 'read',
        urlUpdate: 'update',
        urlCreate: 'create',
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
    
    generateModel: function ()
    {
        var idModel = 'idModel'+this.getIdString();
        var model = this.modelFactory(idModel, this.getFields());
        this.getModel = function ()
        {
            return model;
        }
        return model;
    },
    
    generateProxy: function ()
    {
        var idProxy  = 'idProxy'+this.getIdString();
        var idReader  = 'idReader'+this.getIdString();
        var idWriter  = 'idWriter'+this.getIdString();
        
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
        
        return proxy;
    
    },
    
    getIdStore: function ()
    {
         var idStore = 'idStore'+this.getIdString();
         return idStore;
    
    },
    
    getIdRoot: function ()
    {
         var idRoot  = 'idRoot'+this.getIdString();
         return idRoot;
    
    },
    
    generateTreeStoreConstruct: function (name)
    {
    
        var store = Ext.define(name, {
            extend: 'Admin.store.BaseTreeStore',
            storeId: this.getIdStore(),
            clearOnLoad: true,
            model: this.generateModel(),
            root: {
                id: this.getIdRoot(),
                checked: null,
                expanded: false,
                isFirst: true,
                leaf: false
            },
            proxy: this.generateProxy ()
                    
        });
        
        return store;
    
    },
    
    generateStoreConstruct: function (name)
    {
        var store = Ext.define(name, {
            extend: 'Admin.store.BaseStore',
            storeId: this.getIdStore(),
            model: this.generateModel(),
            proxy: this.generateProxy ()
                    
        });
        return store;
    
    },
    
    // Generate a model dynamically, provide fields
    storeFactory: function (name, tipo) {
                         
        if (tipo == 'treeStore')
        {
            var store = this.generateTreeStoreConstruct (name);
        }
        
        if (tipo == 'store')
        {
            var store = this.generateStoreConstruct (name);
        }
        
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
    
    
    buildStore: function (name, tipo)
    {
        return this.storeFactory(name, tipo);
        
    }
});