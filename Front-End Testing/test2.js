// functions to test key 
function keyTest( target ) {
    this.target = target;
    // used to store key 
    this.log = [];
   
    var that = this;
    // makes click occur 
    this.target.off( "keydown" ).on( "keydown", function( event ) {
      // stimulates the key
      that.log.push( event.keyCode );
    });
  }

  // Runs test 
  QUnit.test( "Key Test", function( assert ) {
    var doc = $( document ),
    // stimulates key on testing document 
      keys = new keyTest( doc );
  
      // ensures key is pressed
    doc.trigger( $.Event( "keydown", { keyCode: 13 } ) );
   
    // ensures it occured, if so the the passed. 
    assert.deepEqual( keys.log, [ 13 ], "Enter is pressed" );
  });