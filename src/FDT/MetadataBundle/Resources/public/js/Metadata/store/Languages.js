Ext.define('Metadata.store.Languages',
{
    extend: 'Ext.data.Store',
    storeId: 'Languages',
    fields: ['name', 'value'],
    autoLoad: true,
	proxy:
	{
        type: 'ajax',
        url: 'metadata/getLanguages'
    }
});