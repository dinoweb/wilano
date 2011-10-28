Ext.define('Admin.model.Config',
{
    extend: 'Ext.data.Model',
    fields: [
        {name: 'document', type: 'string'}
    ],
    associations: [
        {type: 'hasMany', model: 'Admin.model.Campi', name: 'campi', primaryKey: 'document', foreignKey: 'document'},
        {type: 'hasMany', model: 'Admin.model.Associazioni', name: 'associazioni'}
    ]
    
});