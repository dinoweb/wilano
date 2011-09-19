Ext.define('Metadata.model.Tipologie',
{
    extend: 'Ext.data.Model',
    idgen: 'sequential',
    
    
    addTranslationField: function ()
    {
      this.getLanguagesStore().each(this.buildField, this);
        
        
    },
    
    buildField: function (Language)
    {
       var lang = Language.get('value');
       this.fields.addAll([{name: lang+'-name', type: 'string'}]);
        
    },
    
    getLanguagesStore: function ()
    {
        
        var storeLanguages = Ext.data.StoreManager.lookup('Metadata.store.Languages');
        return storeLanguages;
        
    },
    
    addBaseField : function ()
    {
        var fields = [
                        
                        {
                            name: 'uniqueName', type: 'string'
                        },
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
                        }
                    ];
        
        this.fields.addAll(fields);
        
    }
    
    
});