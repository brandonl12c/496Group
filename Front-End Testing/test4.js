

const { test } = QUnit;
//ok used for for checking states 

//since it only takes a single argument 
QUnit.module( "True Boolean", () => {
  // set to true and only needs one parameter 
  test( "One", t => {
    t.ok( true, "True" );
  });
});
//an exmaple when it to false 
QUnit.module( "False Boolean", () => {
  test( "two", t => {
    t.ok( true, "False" );
  });

 
});


