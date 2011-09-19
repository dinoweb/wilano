Ext.define('Admin.StoreBuilder', {    
    config: {
        idString: 'Manca id',
        urlRead: 'read',
        urlUpdate: 'update',
        rootField: 'text',
        rootValue: 'contenuto',
        proxyParamName: 'type',
        proxyParam: 'tipo',
        proxyType: 'ajax'
    },
    
    constructor: function(config) {
        this.initConfig(config);

        return this;
    },
    
    getFields: function ()
    {
        var fields = 
        [
                {name: 'id', type: 'string'},
                {name: 'uniqueName', type: 'string'},
                {
                    name: 'uniqueSlug', type: 'string'
                },
                {
                    name: 'isActive', type: 'boolean', defaultValue: true
                },
                {
                    name: 'isPrivate', type: 'boolean', defaultValue: false
                },
                {
                    name: 'isConfigurable', type: 'boolean', defaultValue: false
                },
                {
                    name: 'hasPeriod', type: 'boolean', defaultValue: false
                },
                {
                    name: 'leaf', type: 'boolean', defaultValue: true
                },
                {
                    name: 'isNew', type: 'boolean', defaultValue: false
                },
                {
                    name: 'en_us-name', type: 'string', label: 'Palla'
                },
                {
                    name: 'it_it-name', type: 'string'
                }
        ];
        
        return fields;
    },
    
    // Generate a model dynamically, provide fields
    modelFactory: function (name, fields) {
        return Ext.define(name, {
            extend: 'Admin.model.BaseModel',
            fields: fields
        });
    },
    
    // Generate a model dynamically, provide fields
    treeStoreFactory: function (name) {
        var idStore = 'idStore'+this.getIdString();
        this.getIdStore = function ()
        {
            return idStore;
        }
        var idModel = 'idModel'+this.getIdString();
        var idRoot  = 'idRoot'+this.getIdString();
        var idProxy  = 'idProxy'+this.getIdString();
        
        var model = this.modelFactory(idModel, this.getFields());
        this.getModel = function ()
        {
            return model;
        }
        
        
        var store = Ext.define(name, {
            extend: 'Admin.store.BaseTreeStore',
            storeId: idStore,
            model: model,
            proxy:
                    {
                        id: idProxy,
                        type: this.getProxyType(),
                        api: {
                            read    : this.getUrlRead(),
                            update  : this.getUrlUpdate(),
                            create  : this.getUrlUpdate()
                        }
                    }
        });
        
        var store = Ext.create(store);
        var root = Ext.create(model, {
            id: idRoot,
            expanded: true,
            leaf: false
            
        });
        root.set(this.getRootField(), this.getRootValue());
        store.setRootNode(root);
        return store;
        
        
    },
    
    buildStore: function (name)
    {
        return this.treeStoreFactory(name);
        
    }
});