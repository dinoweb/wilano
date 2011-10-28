Ext.define('Admin.model.Campi',
{
    extend: 'Ext.data.Model',
    idProperty: 'name',
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
            },
    fields: [
        {name: 'document', type: 'string'},
        {name: 'name', type: 'string'},
        {name: 'type', type: 'string'},
        {name: 'defaultValue'},
        {name: 'xtype', type: 'string'},
        {name: 'text', type: 'string'},
        {name: 'flex', type: 'int', defaultValue: 1},
        {name: 'sortable', type: 'boolean', defaultValue: false},
        {name: 'hidden', type: 'boolean', defaultValue: true},
        {name: 'fieldXtype', type: 'string', defaultValue: 'textfield'},
        {name: 'allowBlank', type: 'boolean', defaultValue: false},
        {name: 'anchor', type: 'string', defaultValue: '100%'},
        {name: 'store', type: 'string', defaultValue: null},
        {name: 'isTranslated', type: 'boolean', defaultValue: false},
        {name: 'queryMode', type: 'string', defaultValue: 'local'},
        {name: 'useForColumn', type: 'boolean', defaultValue: true},
        {name: 'useForModel', type: 'boolean', defaultValue: true},
        {name: 'useForForm', type: 'boolean', defaultValue: false}
        
    ]
});