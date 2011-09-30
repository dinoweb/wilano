Ext.define('Admin.FormBuilder', {    
    config: {
        idString: false,
        configStore: null,
        fieldsCollection: null,
        fieldsTranslationCollection: null
    },
    
    
    constructor: function(config) {
        this.initConfig(config);
        return this;
    },
    
    addComboToCollection: function (collection, record)
    {
        collection.add({
                name: record.get('name'),
                xtype: record.get('fieldXtype'),
                fieldLabel: record.get('text'),
                allowBlank: record.get('allowBlank'),
                store: record.get('store'),
                anchor: record.get('anchor'),
                queryMode: record.get('queryMode'),
                hiddenName: record.get('name'),
                autoSelect: true,
                forceSelection: true,
                typeAhead: true,
                displayField:'name',
				valueField:'value',
				selectOnFocus:true
            });
    },
    
    addNormalFieldsToCollection: function (collection, record)
    {
        collection.add({
            name: record.get('name'),
            xtype: record.get('fieldXtype'),
            fieldLabel: record.get('text'),
            allowBlank: record.get('allowBlank'),
            anchor: record.get('anchor')
        });
        
        
    },
    
    
    addFieldToCollection: function (record)
    {
        var collection = this.getFieldsCollection();
        
        if (record.get('isTranslated'))
        {
           var collection = this.getFieldsTranslationCollection(); 
        }
                
        if (record.get('fieldXtype') == 'combo'){
            this.addComboToCollection (collection, record);
        }
        else{
            this.addNormalFieldsToCollection (collection, record);
        }
    },
    
    getPanelTraduzioni: function ()
    {
        var panel = {
            xtype: 'form',
            title: 'Traduzioni',
            collapsible: false,
            defaults: {autoHeight:true, bodyStyle:'padding:5px'},
	        anchor: '100%',
	        defaults: { 
	            listeners:{
                    specialKey: function(field, el)
                    {
                        if(el.getKey() == Ext.EventObject.ENTER)
                        {
                            Ext.getCmp('buttonSave').fireEvent('click', Ext.getCmp('buttonSave'));
                        }
                    }
                }
            },
            items: this.getFieldsTranslationCollection().items
            
        }
        return panel;
    },
    
    buildTranslation: function (configStore)
    {
        this.setFieldsTranslationCollection(new Ext.util.MixedCollection(false, function(el){
                                                                        return el.name;
                                                                    }));
            
        configStore.filter('useForForm', true);
        configStore.filter('isTranslated', true);
        configStore.each(this.addFieldToCollection, this);
            
        this.getFieldsCollection().add ('traduzioni', this.getPanelTraduzioni());
        
        configStore.clearFilter();
    },
    
    buildBaseFields: function (configStore)
    {
        configStore.filter('useForForm', true);
        this.setFieldsCollection(new Ext.util.MixedCollection(false, function(el){
                                                                        return el.name;
                                                                    }));
        configStore.filter('isTranslated', false);
        configStore.each(this.addFieldToCollection, this);
        
        configStore.clearFilter();
    },
    
    getItems: function ()
    {
        
        var configStore = this.getConfigStore();
        this.buildBaseFields(configStore);
        
        if (configStore.hasTranslation())
        {
            this.buildTranslation(configStore);
            
        }
        
        configStore.clearFilter();
        
        return this.getFieldsCollection().items;

        
        
    },
    
    formFactory: function () {
        return Ext.define(this.getIdString(), {
            extend: 'Admin.view.BaseFormPanel',
            id: this.getIdString(),
            items: this.getItems()
        });
    },
    
    getForm: function ()
    {
        var baseForm = this.formFactory();
        
        var form = Ext.create(baseForm);
        return form;
        
    }
});