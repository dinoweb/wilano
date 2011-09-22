Ext.define('Admin.model.Config',
{
    extend: 'Ext.data.Model',
    idProperty: 'name',
    fields: [
        {name: 'name', type: 'string'},
        {name: 'type', type: 'string'},
        {name: 'defaultValue'},
        {name: 'xtype', type: 'string'},
        {name: 'text', type: 'string'},
        {name: 'flex', type: 'int', defaultValue: 1},
        {name: 'sortable', type: 'boolean', defaultValue: false},
        {name: 'hidden', type: 'boolean', defaultValue: true},
        {name: 'useForColumn', type: 'boolean', defaultValue: true},
        {name: 'useForModel', type: 'boolean', defaultValue: true}
        
    ]
});