<?php

use OpenSRS\domains\dnszone\DnsForce;
/**
 * @group dnszone
 * @group DnsForce
 */
class DnsForceTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'dnsForce';

    protected $validSubmission = array(
        'data' => array(
            /**
             * Required
             *
             * domain: domain whose nameservers
             *   you want to change to:
             *   (ns1|ns2|ns3).systemdns.com
             */
            'domain' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = 'phptest'.time().'.com';

        $ns = new DnsForce( 'array', $data );

        $this->assertTrue( $ns instanceof DnsForce );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );
        
        $data->data->domain = 'phptest'.time().'.com';

        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new DnsForce( 'array', $data );
    }
}
