Ext.define('Metadata.view.Menu',
{
    extend: 'Ext.tree.Panel',
    alias : 'widget.MetadataMenu',

    title : 'Metadata',
    rootVisible: false,
    
    store: 'Metadata.store.Menu'
});