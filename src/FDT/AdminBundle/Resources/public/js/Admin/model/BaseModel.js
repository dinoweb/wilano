Ext.define('Admin.model.BaseModel',
{
    extend: 'Ext.data.Model',
    idgen: 'uuid',
    refreshData: function (){
        console.log ('model refresh data')
    }
});