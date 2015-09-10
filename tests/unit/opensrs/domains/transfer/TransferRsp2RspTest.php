<?php

use OpenSRS\domains\transfer\TransferRsp2Rsp;
/**
 * @group transfer
 * @group TransferRsp2Rsp
 */
class TransferRsp2RspTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferRsp2Rsp';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required
             *
             * domain: fully qualified domain
             *   name in the transfer order
             * grsp: username of gaining reseller
             */
            "domain" => "",
            "grsp" => "",

            /**
             * Optional
             *
             * username: registrant username,
             *   if specified will be used for
             *   the new registration, otherwise
             *   original username will be used
             * password: registrant password,
             *   if specified will be used for
             *   the new registration, otherwise
             *   original password will be used
             */
            "username" => "",
            "password" => "",
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

        $data->data->domain = "phptest" . time() . ".com";

        $data->data->grsp = "phptest" . time();

        $ns = new TransferRsp2Rsp( 'array', $data );

        $this->assertTrue( $ns instanceof TransferRsp2Rsp );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing domain' => array('grsp'),
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

        $data->data->domain = "phptest" . time() . ".com";

        $data->data->grsp = "phptest" . time();

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

        $ns = new TransferRsp2Rsp( 'array', $data );
    }
}