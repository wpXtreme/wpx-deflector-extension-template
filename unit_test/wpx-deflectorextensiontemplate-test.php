<?php
/**
 * This class is a template of unit testing in a wpXtreme environment. All PHP tests in wpXtreme environment are executed
 * within Sonda, a wpXtreme framework that executes tests on PHP plugins for WordPress setting on fly PHP version and
 * WordPress version to use.
 *
 * Sonda uses PHPUnit as standard unit tester. Thus, this template and in general all unit tests follow PHPUnit guidelines.
 *
 * Any important part of this template is properly commented, in order to simplify the creation of unit test in any part of
 * your plugin code.
 *
 * ## FILENAME PATTERN
 *
 * When a test session is started, the wpXtreme Sonda framework scans any file in your plugin in searching for files to pass
 * to PHPUnit in order to execute a test case with them. The pattern that Sonda recognizes as test file in a file path
 * is this:
 *
 * [1] - the file has extension = `.php`.
 * [2] - the file has final part of its basename, without extension, = `-test`
 * [3] - the file is stored in a folder named `test/`.
 *
 * ALL THESE CONDITIONS HAS TO BE VERIFIED IN A FILE PATH, IN ORDER TO ACTIVATE UNIT TESTING WITH THIS FILE.
 *
 * Thus, `/path/to/myplugin/classes/test/mypersonal-test.php` is a valid pattern, and Sonda take this file and passes it
 * to PHPUnit for execution of a test case.
 * But   `/path/to/myplugin/classes/myotherfiletest.php`      is NOT a valid pattern, because conditions [2] and [3] are
 * not matched.
 *
 * Your plugin can have any `/test/(.+)-test.php` files as you wish, and a folder `test/` can contain any test files as
 * you wish. So, in your plugin you can have something like this:
 *
 * `/path/to/myplugin/classes/test/mypersonal-test.php`
 * `/path/to/myplugin/classes/test/myother-test.php`
 * `/path/to/myplugin/classes/test/another-test.php`
 * `/path/to/myplugin/test/first-test.php`
 * `/path/to/myplugin/test/second-test.php`
 *
 * Any of these file will be taken by Sonda, and then automa(t|g)ically passed to PHPUnit for testing.
 *
 * @author             yuma <info@wpxtre.me>
 * @copyright          Copyright (C) 2012 wpXtreme Inc. All Rights Reserved.
 * @date               2012-11-30
 * @version            0.1.0
 *
 */

//--------------------------------------------------
// DO NOT INSERT ANY PHP INCLUDE OR REQUIRE HERE. Sonda framework takes care of including all necessary files for this test.
// THIS MUST BE A PURE CLASS, WITHOUT ANY definition of an instance with 'new' keyword. All these things are performed
// internally by PHPUnit.
//--------------------------------------------------

class WPXDeflectorExtensionTemplateTest extends PHPUnit_Framework_TestCase {

  /**
   * The instance of a class that has to be tested
   *
   * @brief Class instance to test
   *
   * @var string $_classToTest
   *
   * @since 0.1.0
   */
  protected $_classToTest;



  /**
   * The method set up the test environment related to your class. Put here any initializations that your class needs in
   * this Unit Test in order to properly execute it. The setUp() template methods is run once for each test method
   * ( and on fresh instances ) of this test case class.
   *
   * @brief Set up test environment
   *
   * @since 0.1.0
   *
   */
  protected function setUp() {

    //--------------------------------------------------
    // Re-create every time a brand new class instance for testing
    //--------------------------------------------------

    $this->_classToTest = new WPXDeflectorExtensionTemplate() ;

    //--------------------------------------------------
    // Add your code here, if necessary
    //--------------------------------------------------

  }



  /**
   * This template method is called before the first test of this test case class is run.
   *
   * @brief Set up test environment before the class is run
   *
   * @since 0.1.0
   *
   */
  public static function setUpBeforeClass() {

    //--------------------------------------------------
    // Add your code here, if necessary
    //--------------------------------------------------

  }



  /**
   * The method is where you clean up the objects against which you tested, if it is needed. The tearDown() template method
   * is run once for each test method ( and on fresh instances ) of this test case class, and it is executed once the test
   * method has finished running, whether it succeeded or failed.
   *
   * @brief Tear down test environment
   *
   * @since 0.1.0
   *
   */
  protected function tearDown() {

    //--------------------------------------------------
    // Add your code here, if necessary
    //--------------------------------------------------

  }



  /**
   * This template method is called after the last test of this test case class is run.
   *
   * @brief Tear down test environment after the last test
   *
   * @since 0.1.0
   *
   */
  public static function tearDownAfterClass() {

    //--------------------------------------------------
    // Add your code here, if necessary
    //--------------------------------------------------

  }


  /**
   * This is the first test example related to this class. Test is executed really checking some behaviours of class to test.
   *
   * @brief First text example
   *
   * @since 0.1.0
   *
   */
  public function testSomeProperties() {

    //--------------------------------------------------
    // Check if a property is not empty : THIS TEST PASS!
    //--------------------------------------------------

    $this->assertNotEmpty( $this->_classToTest->url );

    //--------------------------------------------------
    // Check if a property as a specific value : THIS TEST FAILS!
    //--------------------------------------------------

    $sExpected = "Hello world is not the plugin basename!";
    $sActual   = $this->_classToTest->pluginBasename;
    $this->assertEquals( $sExpected, $sActual );

  }



  /**
   * This is the second test example related to this class. Test is executed really checking some behaviours of class to test.
   *
   * @brief Second text example
   *
   * @since 0.1.0
   *
   */
  public function testSomeOtherThings() {

    //--------------------------------------------------
    // Check if a property is of a specific type : THIS TEST PASS!
    //--------------------------------------------------

    $this->assertTRUE( $this->_classToTest->log instanceof WPDKWatchDog );

    //--------------------------------------------------
    // You can stop here and mark this test as incomplete in this way
    //--------------------------------------------------

    $this->markTestIncomplete( 'This test has not been implemented yet.' );

  }



}
