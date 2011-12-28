Ext.define('Admin.ConfigBuilder', {    
    config: {
        extraParams: null,
        autoLoad: true,
        idString: false
    },
    
    
    constructor: function(config) {
        this.initConfig(config);
        return this;
    },
    
    modelFactory: function (extraParams) {
        return Ext.define('ConfigurazioneModel', {
            extend: 'Admin.model.Config',
            id: 'ConfigurazioneModel',
            proxy: {
                type: 'ajax',
                api: {
                    read: 'getConfig'
                },
                reader: {
			        type: 'json'
                },
                writer: {
                    type: 'json',
                }
            }
        });
    },
    
    getConfigStore: function ()
    {
        var model = this.modelFactory(this.getExtraParams());
        //var modelInstance = Ext.create(model);
        //console.log(modelInstance.fields);
        
        var storeConfig = Ext.define('ConfigurazioneStore', {
            extend: 'Admin.store.Config',
            model: model,
            id: this.getIdString(),
            autoLoad: this.getAutoLoad()
        });
        
        var store = Ext.create(storeConfig);
        return store;
        
    }
});