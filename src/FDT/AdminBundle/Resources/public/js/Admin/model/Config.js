Ext.define('Admin.model.Config',
{
    extend: 'Ext.data.Model',
    idProperty: 'name',
    fields: [
        {name: 'name', type: 'string'},
        {name: 'type', type: 'string'},
        {name: 'defaultValue'}
    ]
});