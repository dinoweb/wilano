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