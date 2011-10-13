Ext.define('Metadata.store.Attributi.Tipo',
{
    extend: 'Ext.data.Store',
    storeId: 'AttributiTipo',
    fields: ['name', 'value'],
    autoLoad: true,
	proxy:
	{
        type: 'ajax',
        url: 'metadata/getAttributiTipo'
    }
});