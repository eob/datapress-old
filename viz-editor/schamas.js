var schemas = [
  {
     'name':"Trip",
     'fields':[
        {'name':'Place', 'type':'string'},
        {'name':'Date', 'type':'string'},
     ]
  },
  {

  },
];


// For an object of type trip
var trip = {
  'name':'BMX Weekend Trip',
  'Date':'1/20/1999',
  'place':'Poor farm park'
};

function validate(schema, obj) {
 var trip_errors = {
   'name':['Must not be blank'],
 };
}

