import moment from 'moment'

Vue.filter('formatDate', function (value){
    if(value){
        return moment(String(value)).format('YYYY/MM/DD');
    }
});

Vue.filter('formatAsMoney', (value = 0) => {
    return value.toLocaleString(('en-US'), {
        style: 'currency',
        currency: 'USD'
    });
});
