Ext.define('Admin.model.Associazioni',
{
    extend: 'Ext.data.Model',
    idProperty: 'name',
    fields: [
        {name: 'name', type: 'string'},
        {name: 'type', type: 'string'},
        {name: 'document', type: 'string'}        
    ]
});