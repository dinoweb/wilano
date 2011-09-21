Ext.define('Admin.StoreBuilder', {    
    config: {
        idString: 'Manca id',
        urlRead: 'read',
        urlUpdate: 'update',
        rootField: 'text',
        rootValue: 'contenuto',
        proxyParamName: 'type',
        proxyParam: 'tipo',
        proxyType: 'ajax',
        configFor: 'Tipologie',
        modelStore: null
    },
    
    constructor: function(config) {
        this.initConfig(config);

        return this;
    },
    
    getConfig: function (typeOfConfig)
    {
        var storeConfig = Ext.create('Admin.ConfigBuilder', {
            extraParams: {configFor: this.getConfigFor(), configType: typeOfConfig},
            autoLoad: false,
            id: this.getConfigFor()+'-'+typeOfConfig
        });
        
        var store = storeConfig.getConfigStore();
        store.load({
            scope: this,
            callback: function(records, operation, success) {
                store.each(this.addField);
            }
            
        });        
        
    },
    
    addField: function (record)
    {
        this.getMyFields().addAll(record.raw);
        console.log(record.raw);
        
    },
    
    getFields: function ()
    {
        var configStore = this.getModelStore();
        console.log(configStore.count());
        configStore.getProxy().getReader().rawData;
        
        
        var fields = configStore.getProxy().getReader().rawData;
        /**[
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
        ];**/
        
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
        var idReader  = 'idReader'+this.getIdString();
        var idWriter  = 'idWriter'+this.getIdString();
        
        var model = this.modelFactory(idModel, this.getFields());

        this.getModel = function ()
        {
            return model;
        }
        
        var myRoot = Ext.create(model, {
            id: idRoot,
            checked: null,
            expanded: true,
            root: true,
            isFirst: true,
            leaf: false
            
        });

        myRoot.set(this.getRootField(), this.getRootValue());
        
         

        var store = Ext.define(name, {
            extend: 'Admin.store.BaseTreeStore',
            storeId: idStore,
            model: model,
            //root: myRoot,
            proxy:
                    {
                        id: idProxy,
                        type: this.getProxyType(),
                        reader: {
            			    id: idReader,
            			    type: 'json'
                        },
                        writer: {
                            id: idWriter,
                            type: 'json'
                        },
                        api: {
                            read    : this.getUrlRead(),
                            update  : this.getUrlUpdate(),
                            create  : this.getUrlUpdate()
                        }
                    }
        });
        
       
        
        var store = Ext.create(store);
        store.setRootNode(myRoot);
        return store;
        
        
    },
    
    buildStore: function (name)
    {

        return this.treeStoreFactory(name);
        
    }
});