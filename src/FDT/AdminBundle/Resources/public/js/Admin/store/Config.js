Ext.define('Admin.store.Config',
{
    extend: 'Ext.data.Store',
    
    autoLoad: false,
	proxy:
	{
        type: 'ajax',
        url: 'getConfig'
    },
    
    hasTranslation: function ()
    {
        var index = this.find('isTranslated', true);
        if (index >= 0)
        {
            return true
        }
        else
        {
            return false
        }
    }
});