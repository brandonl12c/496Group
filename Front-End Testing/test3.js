//click test 
QUnit.test( "Click Test", function( assert ) {
   
   // variable to be clicked 
    var $a = $( "a" );
   
    // stimulated click for openNav and CloseNav option in our front-end 
    $a.on( "click", function() {
      // stimulant is set to true, and prints message 
      assert.ok( true, "Button Clicked" );
    });
   // clicks occurs
    $a.trigger( "click" );
    assert.expect( 2 );
  });