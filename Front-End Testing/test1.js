// equals test 
// esnures a value equals what it is supppose to be
QUnit.test( "Numerical Test", function( assert ) {
  // stimulated  value is one 
    var number =1;
    // ensures value is what it should be 
    assert.equal( 1, number, "Value equals 1");
    var number =0;
    // ensures value is what it should be 
    assert.equal( 0, number, "Value equals 0");
  });