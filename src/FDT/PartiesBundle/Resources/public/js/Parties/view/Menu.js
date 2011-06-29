Ext.define('Parties.view.Menu',
{
    extend: 'Ext.tree.Panel',
    alias : 'widget.PartiesMenu',

    title : 'Parties',
    rootVisible: false,
    
    store: 'Parties.store.Menu'
});