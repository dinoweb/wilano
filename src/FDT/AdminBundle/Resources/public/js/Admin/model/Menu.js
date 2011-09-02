Ext.define('Admin.model.Menu',
{
    extend: 'Ext.data.Model',
    fields: ['id', 'text', 'leaf', 'tipologiaType', 'controller', 'children']
});