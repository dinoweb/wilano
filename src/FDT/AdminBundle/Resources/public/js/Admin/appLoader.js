Ext.Loader.setConfig ({ enabled: true});

Ext.define('appLoader',
{

    setBundlesPath: function()
    {
        
        var store = Ext.create ('appLoaderStore');
        //store.each (this.aggiungiPath);
        store.load({
                        scope   : this,
                        callback: function (records, operation, success)
                        {
                           if (success == true)
                           {
                            store.each (this.aggiungiPath);
                           } 
                            
                                                        
                        }
                  
                  });
        
    },
 
    aggiungiPath: function (Record)
    {
        Ext.Loader.setPath (Record.get('name'), Record.get('path'));
            
    },
    
});

Ext.define('appLoaderModel',
{
    extend: 'Ext.data.Model',
    fields: ['name', 'path']
});

Ext.define('appLoaderStore',
{
    extend: 'Ext.data.Store',
    model: 'appLoaderModel',
    storeId: 'bundlesStore',
	proxy:
	{
            type:'ajax',            
            url:'getBundlesConfig',
            reader: {
            			type: 'json',
            			root: 'paths'
                    }
    }
});

   
   Ext.create ('appLoader').setBundlesPath();
   
   //sleep (100);
   
   function sleep(milliSeconds)
   {
        var startTime = new Date().getTime(); // get the current time
        while (new Date().getTime() < startTime + milliSeconds); // hog cpu
    }
   
    


//Ext.onReady(Ext.application.init, Ext.application);
