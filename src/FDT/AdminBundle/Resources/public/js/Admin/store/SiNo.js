Ext.define('Admin.store.SiNo', {
    extend: 'Ext.data.Store',
    alias : 'widget.SiNo',
    fields: ['name', 'value'],
    data: [
        {name: 'Si',    value: true},
        {name: 'No',    value: false}
    ]
});