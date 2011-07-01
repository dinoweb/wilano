Ext.Loader.setConfig ({
                        enabled: true,
                        paths : {'Admin': '/bundles/fdtadmin/js/Admin'}
                     });

Ext.require ('Admin.model.Paths');
Ext.require ('Admin.store.Paths');


Ext.define('appLoader',
{

    setBundlesPath: function()
    {
        Ext.require ('Admin.app');
        
        var store = Ext.create ('Admin.store.Paths');

        store.load({
                        scope   : this,
                        callback: function (records, operation, success)
                        {
                           if (success == true)
                           {
                            store.each (this.aggiungiPath);
                            
                            Ext.create('Admin.app').init(store);
                            
                            
                           } 
                                                        
                        }
                  
                  });
        
    },
 
    aggiungiPath: function (Record)
    {
        Ext.Loader.setPath (Record.get('name'), Record.get('path'));
        
        var appBundleName = Record.get('name')+'.app';
                            
    }
    
    
    
});

Ext.onReady (function ()
            {
            
                

                Ext.create ('appLoader').setBundlesPath();

            
            }   
)
