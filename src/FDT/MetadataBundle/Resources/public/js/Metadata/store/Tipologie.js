Ext.define('Metadata.store.Tipologie',
{
    extend: 'Ext.data.TreeStore',
    alias: 'widget.tipologieStore',
    
    
    config: {
        tipologiaType: null
    },
    autoLoad: true,
    autoSync: true,
    //model: 'Metadata.model.Tipologie',
    root: 
	{
	   text: "Metadata",
	   expanded: false
	},
	proxy:
	{
            type:'rest',            
            reader: {
            			type: 'json'
                    }
    }

});