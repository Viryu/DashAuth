function datecontroller(day){
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+(today.getDate()-day);
    return date;
}
$(function() {
        Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: datecontroller(6),
            a: transactionday7,
            b: transactioncountday7,
        },{
            y: datecontroller(5),
            a: transactionday6,
            b: transactioncountday6,
        },{
            y: datecontroller(4),
            a: transactionday5,
            b: transactioncountday5,
        },{
            y: datecontroller(3),
            a: transactionday4,
            b: transactioncountday4,
        },{
            y: datecontroller(2),
            a: transactionday3,
            b: transactioncountday3,
        },{
            y: datecontroller(1),
            a: transactionday2,
            b: transactioncountday2,
        },{
            y: datecontroller(0),
            a: transactionday1,
            b: transactioncountday1,
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Total Sales (RP)', 'Total Sales'],
        hideHover: 'auto',
        resize: true
    });

});

$(function() {
    Morris.Bar({
        element: 'Finance-Projection-Chart-Month',
        data: [{
            y: "Q1",
            a: Q1,
            b: q1dana,
        },{
            y: "Q2",
            a: Q2,
            b: q2dana,
        },{
            y: "Q3",
            a: Q3,
            b: q3dana,
        },{
            y: "Q4",
            a: Q4,
            b: q4dana,
        }




        ],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Target / Year', 'Total Sales'],
        hideHover: 'auto',
        resize: true
    });

});

var data = [
    // {
    //     y: year,
    //     a: sales,
    //     b: target,
    // }
];

if(duration == null || duration == 0 ){
    data.push({
        'y':year,
        'a':sales[0],
        'b':target
    })
}
else{
    for ( var i = 0 ; i < duration ; i++){
        data.push({'y':year,'a':sales[i],'b':target})
        year++;
    }
}

$(function() {
    Morris.Bar({
        element: 'Finance-Projection-Chart-Year',
        data: data,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Total Sales','Target / Year'],
        hideHover: 'auto',
        resize: true
    });
});
